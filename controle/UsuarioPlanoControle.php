<?php

include_once 'modelo/Usuario.php';
include_once 'modelo/UsuarioPlano.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Plano.php';
include_once 'modelo/Telefone.php';
include_once 'modelo/Estado.php';
include_once 'modelo/Cidade.php';
include_once 'modelo/Bairro.php';
include_once 'modelo/Empresa.php';
include_once 'DAO/GenericoDAO.php';
include_once 'DAO/ConsultasAdHoc.php';

class UsuarioPlanoControle {

    public function listar() { //lista os planos disponíveis para compra. Os gratuitos não aparecem na listagem
                               // do arquivo UsuarioPlanoVisaoListagem.php
        if (Sessao::verificarSessaoUsuario()) {
            //modelo
            $usuarioPlano = new UsuarioPlano();
            $plano = new Plano();
            $genericoDAO = new GenericoDAO();

            $listarUsuarioPlano = $genericoDAO->consultar($usuarioPlano, true, array("idusuario" => $_SESSION["idusuario"]));
            $condicoes["status"] = "pago"; //status do plano
            if ($_SESSION["tipopessoa"] == "pf") {
                $condicoes["tipo"] = "pf";
            }
            $listarPlano = $genericoDAO->consultar($plano, true, array("status" => "ativo", "gratuito" => "NAO"));
            
            $formUsuarioPlano = array();
            $formUsuarioPlano["usuarioPlano"] = $listarUsuarioPlano;
            $formUsuarioPlano["plano"] = $listarPlano;
            //visao
            $visao = new Template();
            $visao->setItem($formUsuarioPlano);
            $visao->exibir('UsuarioPlanoVisaoListagem.php');
        } else {
            $visao = new Template();
            $visao->exibir('UsuarioVisaoLogin.php');
        }
    }

    public function confirmar($parametros) {
        if (Sessao::verificarSessaoUsuario() & Sessao::verificarToken($parametros)) {
            if ($parametros["spnPlano"]) {
                $total = 0;
                foreach ($parametros["spnPlano"] as $id => $qtd) {
                    $total += $parametros["txtPreco"][$id] * $qtd;
                    if ($qtd > 0) {
                        $confirmacao["planos"][$id] = $qtd;
                    }
                }
                $total = number_format($total, 2, '.', '');
                if ($total <> $parametros["txtTotalPreco"]) {
                    die("erro no total informado");
                } else {
                    $confirmacao["total"] = $total;
                    $confirmacao["totalQtd"] = $parametros["txtTotalQtd"];
                    $confirmacao["tokenPlano"] = $parametros["hdnToken"];
                    Sessao::configurarSessaoUsuarioPlanoConfirmacao($confirmacao);

                    $condicoesAdHoc = new ConsultasAdHoc();
                    $selecionarPlanos = $condicoesAdHoc->ConsultarPlanosComprados(array_keys($confirmacao["planos"]));

                    $resultado["planosSelecionados"] = $selecionarPlanos;
                    $resultado["confirmacao"] = $confirmacao;

                    $visao = new Template();
                    $visao->setItem($resultado);
                    $visao->exibir('UsuarioPlanoVisaoConfirmar.php');
                }
            }
        }
    }

    public function comprar($parametros) {
        if (Sessao::verificarSessaoUsuario() & Sessao::verificarToken($parametros)) {

            if ($parametros["hdnPlano"] == $_SESSION["usuarioPlano"]["tokenPlano"] & $_SESSION["usuarioPlano"]["planos"]) {
                $genericoDAO = new GenericoDAO();
                $genericoDAO->iniciarTransacao();
                //echo "<pre>"; print_r($_SESSION); //die();
                require_once 'PagSeguroControle.php';
                $pagSeguroControle = new PagSeguroControle();
                $paymentRequest = $pagSeguroControle->paymentRequest();
                foreach ($_SESSION["usuarioPlano"]["planos"] as $id => $qtd) {
                    $usuarioPlano = new UsuarioPlano();
                    $usuarioPlano->cadastrar($id);

                    $plano = array_shift($genericoDAO->consultar(new Plano(), false, array("id" => $usuarioPlano->getIdplano())));
                    //$id,$description,$quantity,$amount,$weight,$shippingCost     
                    $paymentRequest->addItem($plano->getId(), $plano->getTitulo() . " - " . $plano->getDescricao(), $qtd, $plano->getPreco());

                    while ($qtd > 0) {
                        $arrayCadastroReferencia[] = str_pad($genericoDAO->cadastrar($usuarioPlano), 3, "0", STR_PAD_LEFT);
                        $qtd--;
                    }
                }

                $usuario = array_shift($genericoDAO->consultar(new Usuario(), true, array("id" => $_SESSION["idusuario"])));

                if ($usuario->getTipousuario() == "pf") {
                    $nomeUsuario = $usuario->getNome();
                    $cpfUsuario = $usuario->getCpfcnpj();
                } else {
                    $nomeUsuario = $usuario->getEmpresa()->getResponsavel();
                    $cpfUsuario = $usuario->getEmpresa()->getCpfresponsavel();
                }

                if (count($usuario->getTelefone()) == 1) {
                    $telefone = $usuario->getTelefone();
                    $ddd = substr($telefone->getNumero(), 1, 2);
                    $numero = trim(str_replace("-", "", substr($telefone->getNumero(), 4, 12)));
                } elseif (count($usuario->getTelefone()) > 1) {
                    $telefone = array_shift($usuario->getTelefone());
                    $ddd = substr($telefone->getNumero(), 1, 2);
                    $numero = trim(str_replace("-", "", substr($telefone->getNumero(), 4, 12)));
                } else {
                    $ddd = "";
                    $numero = "";
                }
                //$name,$email,$areaCode,$number,$documentType,$documentValue
                $paymentRequest->setSender($nomeUsuario, $usuario->getEmail(), $ddd, $numero, "CPF", $cpfUsuario);
                //$postalCode,$street,$number,$complement,$district,$city,$state,$country
                $endereco = array_shift($genericoDAO->consultar(new Endereco(), true, array("id" => $usuario->getIdendereco())));
                $paymentRequest->setShippingAddress($endereco->getCep(), $endereco->getLogradouro(), $endereco->getNumero(), $endereco->getComplemento(), $endereco->getBairro()->getNome(), $endereco->getCidade()->getNome(), $endereco->getEstado()->getUf(), "BRA");
                //codigo de referencia para poder recuperar o pedido
                $referenciaDoPedido = "#PIPCODE." . implode(".", $arrayCadastroReferencia);
                $paymentRequest->setReference($referenciaDoPedido);

                $genericoDAO->commit();
                LogPagSeguro::info('Pedido '. $referenciaDoPedido . ' gerado com sucesso!');
                $credentials = PagSeguroConfig::getAccountCredentials();
                // fazendo a requisição a API do PagSeguro pra obter a URL de pagamento  
                $redirecionamento = $paymentRequest->register($credentials);
                //echo "<pre>";print_r($redirecionamento);die();
                Sessao::desconfigurarVariavelSessao("usuarioPlano");
                //$redirecionamento = new UsuarioPlanoControle();
                //$redirecionamento->listar();
                //$visao = new Template();
                //$visao->exibir('UsuarioPlanoVisaoCompra.php');
                header("Location: $redirecionamento");
            } else {
                die("erro no token do plano");
            }
        }
    }

}
