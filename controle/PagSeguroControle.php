<?php

include_once 'DAO/GenericoDAO.php';
include_once 'configuracao/PagSeguroLibrary.php';
include_once 'modelo/UsuarioPlano.php';
include_once 'assets/libs/log4php/Logger.php';
include_once 'configuracao/Log.php';

class PagSeguroControle {

    use Log;

    function transactionNotification($notificationCode) {
        LogPagSeguro::info('Nova notificação retornada do PagSeguro');
        $credentials = PagSeguroConfig::getAccountCredentials();
        try {
            $transaction = PagSeguroNotificationService::checkTransaction($credentials, $notificationCode);
            // Do something with $transaction

            $status = $transaction->getStatus();
            $requestId = $transaction->getReference();
            //identificar os registros 
            $referencias = $this->trataReferenciaPagSeguro($requestId);
            //verifica situacoes possiveis            
            switch ($status->getTypeFromValue()) {
                case 'WAITING_PAYMENT' :
                    //echo "Aguardando pagamento: o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.";  
                    $mensagem = 'Pedido "' . $requestId . '" recebido aguardando pagamento!';
                    $statusPagseguro = "pagamento pendente";
                    break;

                case 'IN_ANALYSIS' :
                    //echo "Em análise: o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.";
                    $mensagem = 'Pedido "' . $requestId . '" aguardando analise do cartao de credito!';
                    $statusPagseguro = "pagamento pendente";
                    break;

                case 'PAID' :
                    //echo "Paga: a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.";
                    $mensagem = 'Pedido "' . $requestId . '" foi pago. Ativando o plano!';
                    $statusPagseguro = "pago";
                    break;

                case 'AVAILABLE' :
                    //echo "Disponível: a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.";
                    $mensagem = 'Pedido "' . $requestId . '" se ainda não estiver ativo. Vamos ativar!';
                    $statusPagseguro = "pago";
                    break;

                case 'IN_DISPUTE' :
                    //echo "Em disputa: o comprador, dentro do prazo de liberação da transação, abriu uma disputa.";
                    $mensagem = 'Pedido "' . $requestId . '" em disputa!';
                    $statusPagseguro = "pago";
                    break;

                case 'REFUNDED' :
                    //echo "Devolvida: o valor da transação foi devolvido para o comprador.";
                    $mensagem = 'Pedido "' . $requestId . '" devolvido!';
                    $statusPagseguro = "cancelado";
                    break;

                case 'CANCELLED' :
                    //echo "Cancelada: a transação foi cancelada sem ter sido finalizada.";
                    $mensagem = 'Pedido "' . $requestId . '" cancelado!';
                    $statusPagseguro = "cancelado";
                    break;

                default:
                    echo "nenhum";
            }
            LogPagSeguro::info($mensagem);
            $this->atualizarUsuarioPlano($referencias, $statusPagseguro);
        } catch (PagSeguroServiceException $e) {
            die($e->getMessage());
        }
    }

    function authorizationNotification($notificationCode) {
        $credentials = PagSeguroConfig::getApplicationCredentials();
        try {
            $authorization = PagSeguroNotificationService::checkAuthorization($credentials, $notificationCode);
            // Do something with $authorization
        } catch (PagSeguroServiceException $e) {
            die($e->getMessage());
        }
    }

    function preApprovalNotification($preApprovalCode) {
        $credentials = PagSeguroConfig::getAccountCredentials();
        try {
            $preApproval = PagSeguroNotificationService::checkPreApproval($credentials, $preApprovalCode);
            // Do something with $preApproval
        } catch (PagSeguroServiceException $e) {
            die($e->getMessage());
        }
    }

    function paymentRequest() {
        LogPagSeguro::info('Gerando Pedido para: ' . $SESSION["login"]);
        $paymentRequest = new PagSeguroPaymentRequest();
        $paymentRequest->setCurrency("BRL");
        $paymentRequest->setShippingType(3); //nao especificar
        $paymentRequest->setMaxAge(172800); // 2 dias 
        $paymentRequest->setMaxUses(15); // 15 vezes
        //$paymentRequest->setRedirectURL("http://www.pipbeta.com.br");
        $paymentRequest->setRedirectURL(PIPURL);
        return $paymentRequest;
    }

    function trataReferenciaPagSeguro($referencia) {
        $referencias = array();
        if ($referencia != "") {
            $referencia = str_replace("PIPCODE", "", $referencia);
            $referencias = explode(".", $referencia);
            array_shift($referencias);
        }
        return $referencias;
    }

    function atualizarUsuarioPlano($referencias, $statusPagSeguro) {
        $this->log("Inicio da Operação: Atualização do UsuarioPlano pelo retorno do PAGSEGURO");
        if (is_array($referencias) && count($referencias) > 0) {
            foreach ($referencias as $referencia) {
                $genericoDAO = new GenericoDAO();
                $referencia = (int) $referencia;
                $this->log("Atualização do UsuarioPlano: referência = " . $referencia);
                $entidadeUsuarioPlano = $genericoDAO->consultar(new UsuarioPlano(), false, array("id" => $referencia));
                $entidadeUsuarioPlano = $entidadeUsuarioPlano[0];

                $atualizacao = true;
                $mensagemLog = "referencia = " . $referencia . " atualizada com sucesso.";
                $statusAtualPIP = $entidadeUsuarioPlano->getStatus();

                if ($statusAtualPIP == "pagamento pendente" && $statusPagSeguro == "pago") {
                    $entidadeUsuarioPlano->setStatus("pago");
                }

                if ($statusAtualPIP == "pagamento pendente" && $statusPagSeguro == "cancelado") {
                    $entidadeUsuarioPlano->setStatus("cancelado");
                }
                
                if ($statusAtualPIP == $statusPagSeguro) {
                    $atualizacao = false;
                    $mensagemLog = "referência = " . $referencia . " - não atualizada por estar com a mesma situação: " . $statusAtualPIP;
                }

                if ($statusAtualPIP == "pago" && $statusPagSeguro != "pago") {
                    $atualizacao = false;
                    $mensagemLog = "referência = " . $referencia . " não foi atualizada por ja estar ativa. status da referência no pagseguro = " . $statusPagSeguro;
                }

                if ($statusAtualPIP == "desativado") {
                    $atualizacao = false;
                    $mensagemLog = "referência = " . $referencia . " não foi atualizada por ja estar desativado. status da referência no pagseguro = " . $statusPagSeguro;
                }

                if ($statusAtualPIP == "expirado") {
                    $atualizacao = false;
                    $mensagemLog = "referência = " . $referencia . " não foi atualizada por ja estar expirado. status da referência no pagseguro = " . $statusPagSeguro;
                }

                if ($atualizacao) {
                    $genericoDAO->iniciarTransacao();
                    $genericoDAO->editar($entidadeUsuarioPlano);
                    $genericoDAO->commit();
                }
                $this->log($mensagemLog);
            }
        }
        $this->log("Fim da Operação: Atualização do UsuarioPlano pelo retorno do PAGSEGURO");
    }

}
