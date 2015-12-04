<?php

include_once 'DAO/GenericoDAO.php';
include_once 'configuracao/PagSeguroLibrary.php';

class PagSeguroControle {

    function transactionNotification($notificationCode) {
        LogPagSeguro::info('Nova notificação retornada do PagSeguro');
        $credentials = PagSeguroConfig::getAccountCredentials();
        try {
            $transaction = PagSeguroNotificationService::checkTransaction($credentials, $notificationCode);
            // Do something with $transaction

            $status = $transaction->getStatus();
            $requestId = $transaction->getReference();
            switch ($status->getTypeFromValue()) {
                case 'WAITING_PAYMENT' :
                    //echo "Aguardando pagamento: o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.";  
                    $mensagem = 'Pedido "' . $requestId . '" recebido aguardando pagamento!';
                    break;

                case 'IN_ANALYSIS' :
                    //echo "Em análise: o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.";
                    $mensagem = 'Pedido "' . $requestId . '" aguardando analise do cartao de credito!';
                    break;

                case 'PAID' :
                    //echo "Paga: a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.";
                    $mensagem = 'Pedido "' . $requestId . '" foi pago. Ativando o plano!';
                    break;

                case 'AVAILABLE' :
                    //echo "Disponível: a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.";
                    $mensagem = 'Pedido "' . $requestId . '" se ainda não estiver ativo. Vamos ativar!';
                    break;

                case 'IN_DISPUTE' :
                    //echo "Em disputa: o comprador, dentro do prazo de liberação da transação, abriu uma disputa.";
                    $mensagem = 'Pedido "' . $requestId . '" em disputa!';
                    break;

                case 'REFUNDED' :
                    //echo "Devolvida: o valor da transação foi devolvido para o comprador.";
                    $mensagem = 'Pedido "' . $requestId . '" devolvido!';
                    break;

                case 'CANCELLED' :
                    //echo "Cancelada: a transação foi cancelada sem ter sido finalizada.";
                    $mensagem = 'Pedido "' . $requestId . '" cancelado!';
                    break;

                default:
                    echo "nenhum";
            }
            LogPagSeguro::info($mensagem);
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

}
