<?php

include_once 'modelo/Usuario.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Telefone.php';
include_once 'modelo/Empresa.php';
include_once 'modelo/Estado.php';
include_once 'modelo/Cidade.php';
include_once 'modelo/Bairro.php';
include_once 'modelo/RecuperaSenha.php';
include_once 'controle/UsuarioPlanoControle.php';
include_once 'DAO/GenericoDAO.php';
include_once 'configuracao/ConsultaUrl.php';
include_once 'DAO/ConsultasAdHoc.php';
include_once 'modelo/Mensagem.php';
include_once 'modelo/Anuncio.php';
include_once 'assets/pager/Pager.php';
include_once 'modelo/Imovel.php';
include_once 'modelo/Imagem.php';
include_once 'modelo/RespostaMensagem.php';
include_once 'modelo/HistoricoAluguelVenda.php';
include_once 'modelo/Casa.php';
include_once 'modelo/Apartamento.php';
include_once 'modelo/ApartamentoPlanta.php';
include_once 'modelo/SalaComercial.php';
include_once 'modelo/PredioComercial.php';
include_once 'modelo/Terreno.php';
include_once 'modelo/Planta.php';
include_once 'modelo/TipoImovel.php';
include_once 'modelo/ImovelDiferencial.php';
include_once 'modelo/ImovelDiferencialPlanta.php';
include_once 'modelo/Diferencial.php';
include_once 'modelo/Chamado.php';
include_once 'modelo/ChamadoTitulo.php';
include_once 'modelo/ChamadoAssunto.php';
include_once 'modelo/ChamadoResposta.php';
include_once 'modelo/FuncoesAuxiliares.php';
include_once 'assets/libs/captcha/securimage/securimage.php';
include_once 'assets/libs/log4php/Logger.php';
include_once 'configuracao/Log.php';
include_once 'modelo/Denuncia.php';
include_once 'modelo/DenunciaTipo.php';

class UsuarioControle {

    use Log;

    function form($parametros) {

        $visao = new Template();
        switch ($parametros['tipo']) {
            case "cadastro":
                $visao->exibir('UsuarioVisaoCadastro.php');
                break;

            case "login":
                $visao->exibir('UsuarioVisaoLogin.php');
                break;

            case "esquecisenha":
                $visao->exibir('UsuarioVisaoEsqueciSenha.php');
                break;

            case "alterarsenha":
                $recuperasenha = new RecuperaSenha();
                $genericoDAO = new GenericoDAO();
                $selecionarRecuperaSenha = $genericoDAO->consultar($recuperasenha, false, array("hash" => $parametros["id"]));

                if ($selecionarRecuperaSenha && $selecionarRecuperaSenha[0]->getStatus() == "ativo") {
                    $_SESSION['idRecuperaSenhaUsuario'] = $selecionarRecuperaSenha[0]->getIdusuario();
                    $_SESSION['idRecuperaSenha'] = $selecionarRecuperaSenha[0]->getId();
                    $visao->exibir('UsuarioVisaoAlterarSenha.php');
                } else {
                    $visao->setItem("errolink");
                    $visao->exibir('VisaoErrosGenerico.php');
                }

                break;

            case "faleconosco":
                $visao->exibir('UsuarioVisaoFaleConosco.php');
                break;
            
            case "duvidaAnuncio":
                $genericoDAO = new GenericoDAO();
                $anuncio = $genericoDAO->consultar(new Anuncio(), false, array("id" => $parametros["idAnuncio"]));
                $visao->setItem($anuncio);
                $visao->exibir('AnuncioVisaoDuvida.php');
                break;

            case "trocarsenha":
                $visao->exibir('UsuarioVisaoTrocarSenha.php');
                break;

            case "trocarimagem":
                if (Sessao::verificarSessaoUsuario()) {
                    $genericoDAO = new GenericoDAO();
                    $selecionarUsuario = $genericoDAO->consultar(new Usuario(), false, array("id" => $_SESSION["idusuario"]));
                    $visao->setItem($selecionarUsuario[0]);
                    $visao->exibir('UsuarioVisaoTrocarImagem.php');
                    break;
                } else {
                    $visao = new Template();
                    $visao->exibir('UsuarioVisaoLogin.php');
                }
        }
    }

    function cadastrar($parametros) {
        $this->log("Inicio da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
        //Endereço
        $visao = new Template();
        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            //consultar existencia de estado, se não existir gravar no banco
            /*$estado = new Estado();
            $selecionarEstado = $genericoDAO->consultar($estado, false, array("uf" => $parametros['txtEstado']));
            if (!count($selecionarEstado) > 0) {
                $entidadeEstado = $estado->cadastrar($parametros);
                $idEstado = $genericoDAO->cadastrar($entidadeEstado);
            } else {
                $idEstado = $selecionarEstado[0]->getId();
            }
            //consultar existencia de cidade, se não existir gravar no banco e utilizar idestado
            $cidade = new Cidade();
            $selecionarCidade = $genericoDAO->consultar($cidade, false, array("nome" => $parametros['txtCidade'], "idestado" => $idEstado));
            if (!count($selecionarCidade) > 0) {
                $entidadeCidade = $cidade->cadastrar($parametros, $idEstado);
                $idCidade = $genericoDAO->cadastrar($entidadeCidade);
            } else {
                $idCidade = $selecionarCidade[0]->getId();
            }
            //consultar existencia de bairro, se não existir gravar no banco e utilizar idcidade
            $bairro = new Bairro();
            $selecionarBairro = $genericoDAO->consultar($bairro, false, array("id" => $parametros['itensBairro'][0]));
            if (!count($selecionarBairro) > 0) {
                $entidadeBairro = $bairro->cadastrar($selecionarBairro, $idCidade);
                $idBairro = $genericoDAO->cadastrar($entidadeBairro);
            } else {
                $idBairro = $selecionarBairro[0]->getId();
            }
            //gravar endereço e utilizar idestado, idcdidade e idbairro
            $endereco = new Endereco();
            $entidadeEndereco = $endereco->cadastrar($parametros, $idEstado, $idCidade, $idBairro);
            $idEndereco = $genericoDAO->cadastrar($entidadeEndereco);*/
            //Usuário
            $usuario = new Usuario();
            $entidadeUsuario = $usuario->cadastrar($parametros, $idEndereco);
            $idUsuario = $genericoDAO->cadastrar($entidadeUsuario);
            //Empresa
            $idEmpresa = false;
            if ($entidadeUsuario->getTipousuario() == "pj") {
                $empresa = new Empresa();
                $entidadeEmpresa = $empresa->cadastrar($parametros, $idUsuario);
                $idEmpresa = $genericoDAO->cadastrar($entidadeEmpresa);
            } else {
                $idEmpresa = true;
            }
            //Telefone
            $quantidadeTelefone = count($parametros['sltOperadora']);
            $resultadoTelefone = true;
            for ($indiceTelefone = 0; $indiceTelefone < $quantidadeTelefone; $indiceTelefone++) {
                $telefone = new Telefone();
                $entidadeTelefone = $telefone->cadastrar($parametros, $idUsuario, $indiceTelefone);
                $idTelefone = $genericoDAO->cadastrar($entidadeTelefone);
                if (!($idTelefone)) {
                    $resultadoTelefone = false;
                    break;
                }
            }
            
            //if ($idEndereco && $idUsuario && $idEmpresa && $resultadoTelefone) {
            if ($idUsuario && $idEmpresa && $resultadoTelefone) {
                
                $entidadeUsuarioPlano = new UsuarioPlano();
                
                $entidadeUsuarioPlano->cadastrar(5);
                $entidadeUsuarioPlano->setStatus("pago");
                $entidadeUsuarioPlano->setIdusuario($idUsuario);
                $genericoDAO->cadastrar($entidadeUsuarioPlano);
                
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                $this->log("Término da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
//$visao->setItem("sucessocadastrousuario");
//$visao->exibir('VisaoErrosGenerico.php'); 
                $_SESSION["confirmarOperacao"] = "sucesso";
                header("Location: index.php?entidade=Usuario&acao=form&tipo=login");
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                $_SESSION["confirmarOperacao"] = "erroGenerico";
                header("Location: index.php?entidade=Usuario&acao=form&tipo=login");
//$visao->setItem("errobanco");
//$visao->exibir('VisaoErrosGenerico.php');
            }
        } else {
            $this->log("Término da Operação por Erro no Token");
            $_SESSION["confirmarOperacao"] = "erroToken";
            header("Location: index.php?entidade=Usuario&acao=form&tipo=login");
//$visao->setItem("errotoken");
//$visao->exibir('VisaoErrosGenerico.php');
        }
    }

    function validarCaptcha($parametros) {
        $captcha = new Securimage();
        if ($captcha->check($parametros["captcha_code"])) {
            echo "true";
        } else
            echo "false";
    }

    function selecionar($parametro) {
        //modelo
        if (Sessao::verificarSessaoUsuario()) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, true, array("id" => $_SESSION["idusuario"]));
            #verificar a melhor forma de tratar o blindado recursivo
            $selecionarEndereco = $genericoDAO->consultar(new Endereco(), true, array("id" => $selecionarUsuario[0]->getIdEndereco()));
            $selecionarUsuario[0]->setEndereco($selecionarEndereco[0]);
            //visao
            $visao = new Template();
            $visao->setItem($selecionarUsuario);
            $visao->exibir('UsuarioVisaoEdicao.php');
        } else {
            $visao = new Template();
            $visao->exibir('UsuarioVisaoLogin.php');
        }
    }

    function alterar($parametros) {
        $this->log("Inicio da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
        $visao = new Template();
        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            //consultar existencia de estado, se não existir gravar no banco
            /*
            $estado = new Estado();
            $selecionarEstado = $genericoDAO->consultar($estado, false, array("uf" => $parametros['txtEstado']));
            if (!count($selecionarEstado) > 0) {
                $entidadeEstado = $estado->cadastrar($parametros);
                $idEstado = $genericoDAO->cadastrar($entidadeEstado);
            } else {
                $idEstado = $selecionarEstado[0]->getId();
            }

            //consultar existencia de cidade, se não existir gravar no banco e utilizar idestado
            $cidade = new Cidade();

            //$genericoDAO = new GenericoDAO();
            $selecionarCidade = $genericoDAO->consultar($cidade, false, array("nome" => $parametros['txtCidade'], "idestado" => $idEstado));
            if (!count($selecionarCidade) > 0) {
                $entidadeCidade = $cidade->cadastrar($parametros, $idEstado);
                $idCidade = $genericoDAO->cadastrar($entidadeCidade);
            } else {
                $idCidade = $selecionarCidade[0]->getId();
            }

            //consultar existencia de bairro, se não existir gravar no banco e utilizar idcidade
            $bairro = new Bairro();
            $selecionarBairro = $genericoDAO->consultar($bairro, false, array("id" => $parametros['itensBairro'][0]));
            if (!count($selecionarBairro) > 0) {
                $entidadeBairro = $bairro->cadastrar($selecionarBairro, $idCidade);
                $idBairro = $genericoDAO->cadastrar($entidadeBairro);
            } else {
                $idBairro = $selecionarBairro[0]->getId();
            }
            //gravar endereço e utilizar idestado, idcdidade e idbairro
            $endereco = new Endereco();
            $entidadeEndereco = $endereco->editar($parametros, $_SESSION["idendereco"], $idEstado, $idCidade, $idBairro);
            $editarEndereco = $genericoDAO->editar($entidadeEndereco);
            */
            //telefone excluir
            $telefone = new Telefone();
            $listaTelefone = $genericoDAO->consultar($telefone, false, array("idusuario" => $_SESSION["idusuario"]));
            $quantidadeTelefoneExcluir = count($listaTelefone);
            $resultadoTelefoneFinalExcluir = true;
            for ($indiceTelefone = 0; $indiceTelefone < $quantidadeTelefoneExcluir; $indiceTelefone++) {
                $resultadoExcluirTelefone = $genericoDAO->excluir($telefone, $listaTelefone[$indiceTelefone]->getId());
                if (!($resultadoExcluirTelefone)) {
                    $resultadoTelefoneFinalExcluir = false;
                    break;
                }
            }
            //Telefone cadastrar
            //$quantidadeTelefone = count($parametros['hdnTipoTelefone']);
            $quantidadeTelefone = count($parametros['hdnOperadora']);  
            
            //var_dump($parametros['hdnOperadora']); die();
            
            $resultadoTelefone = true;
            for ($indiceTelefone = 0; $indiceTelefone < $quantidadeTelefone; $indiceTelefone++) {
                $telefone = new Telefone();
                $entidadeTelefone = $telefone->cadastrar($parametros, $_SESSION["idusuario"], $indiceTelefone);
                $idTelefone = $genericoDAO->cadastrar($entidadeTelefone);
                if (!($idTelefone)) {
                    $resultadoTelefone = false;
                    break;
                }
            }

            $usuario = new Usuario();
            $entidadeUsuario = $usuario->editar($parametros);
            $editarUsuario = $genericoDAO->editar($entidadeUsuario);
            //visao
            //if ($editarUsuario & $editarEndereco & $resultadoTelefoneFinalExcluir & $resultadoTelefone) {
            if ($editarUsuario & $resultadoTelefoneFinalExcluir & $resultadoTelefone) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                $this->log("Término da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
                Sessao::desconfigurarVariavelSessao("usuario");
                //$visao->setItem("sucessoedicaousuario");
                $_SESSION["confirmarOperacao"] = "sucesso";
                //echo json_encode(array("resultado" => 1));
                //$visao->exibir('UsuarioVisaoMeuPIP.php');
                header("Location: index.php?entidade=Usuario&acao=MeuPIP");
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                //$visao->setItem("errobanco");
                $_SESSION["confirmarOperacao"] = "erroGenerico";
                $visao->exibir('UsuarioVisaoMeuPIP.php');
            }
        } else {
            $this->log("Término da Operação por Erro no Token");
            $_SESSION["confirmarOperacao"] = "erroToken";
            header("Location: index.php?entidade=Usuario&acao=MeuPIP");
            //$visao->setItem("errotoken");
            //$visao->exibir('VisaoErrosGenerico.php');
        }
    }

    function buscarLogin($parametros) {
        $visao = new Template();
        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("login" => $parametros['txtLogin']));
            if (count($selecionarUsuario) > 0)
                echo "false";
            else
                echo "true";
        }else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErrosGenerico.php');
        }
    }

    function buscarEmail($parametros) {
        $visao = new Template();
        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("email" => $parametros['txtEmail']));
            if (count($selecionarUsuario) > 0) {
                if ($selecionarUsuario[0]->getId() == $_SESSION["idusuario"]) {
                    echo "true";
                } else {
                    echo "false";
                }
            } else {
                echo "true";
            }
        } else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErrosGenerico.php');
        }
    }

    function buscarCpf($parametros) {
        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("cpfcnpj" => $parametros['txtCPF']));
            if (count($selecionarUsuario) > 0)
                echo "false";
            else
                echo "true";
        }else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErrosGenerico.php');
        }
    }

    function buscarCnpj($parametros) {
        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("cpfcnpj" => $parametros['txtCNPJ']));
            if (count($selecionarUsuario) > 0)
                echo "false";
            else
                echo "true";
        }else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErrosGenerico.php');
        }
    }

    function autenticar($parametros) {
        $usuario = new Usuario();
        $genericoDAO = new GenericoDAO();
        $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("login" => $parametros['txtLogin']));
        if ((count($selecionarUsuario) > 0) && (password_verify($parametros['txtSenha'], $selecionarUsuario[0]->getSenha()))) {
            Sessao::configurarSessaoUsuario($selecionarUsuario);
            $redirecionamento = ConsultaUrl::consulta($_SERVER['HTTP_REFERER']);
            echo json_encode(array("resultado" => 1, "nome" => $_SESSION['nome'],
                "redirecionamento" => $redirecionamento));
        } else {
            echo json_encode(array("resultado" => 2)); //usuario ou senha invalido
        }

        $this->log("login");
    }

    function logout($parametros) {
        if (Sessao::encerrarSessaoUsuario()) {
            echo json_encode(array("resultado" => 1));
            $this->log("logout");
        } else {
            echo json_encode(array("resultado" => 0));
            $this->log("Falha no Logout");
        }
    }

    public function renovarSessao($parametros) {
        Sessao::renovarSessao();
        echo json_encode(array("resultado" => 1));
    }

    function esquecerSenha($parametros) {
        $this->log("Inicio da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
        $visao = new Template();
        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $recuperaSenha = new RecuperaSenha();
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $avisoRecuperaSenha = false;
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("email" => $parametros['txtEmail']));
            if ($selecionarUsuario) {
                $consultasAdHoc = new ConsultasAdHoc();
                $selecionarRegistroRecuperaSenha = $consultasAdHoc->ConsultarRegistroAtivoDeRecuperarSenha($selecionarUsuario[0]->getId());
                if ($selecionarRegistroRecuperaSenha) {
                    $resultadoExcluirRecuperaSenha = $genericoDAO->excluir($recuperaSenha, $selecionarRegistroRecuperaSenha[0]->getId());
                    $avisoRecuperaSenha = true;
                    if (!$resultadoExcluirRecuperaSenha) { //apagar token já cadastrado - 002
                        $genericoDAO->rollback();
                        $genericoDAO->fecharConexao();
                        echo json_encode(array("resultado" => 2));
                    }
                }

                //gravar registro no banco
                $recuperasenha = new RecuperaSenha();
                $entidadeRecuperaSenha = $recuperasenha->cadastrar($selecionarUsuario[0]->getId());
                $idResuperaSenha = $genericoDAO->cadastrar($entidadeRecuperaSenha);
                if ($idResuperaSenha) {
                    //enviar email
                    $dadosEmail['destino'] = $selecionarUsuario[0]->getEmail(); //$parametros["email"];  
                    $dadosEmail['nome'] = $selecionarUsuario[0]->getNome(); //$parametros["nome"];
                    $dadosEmail['msg'] .= "<!DOCTYPE html>
            <html>
            <head>
              <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1'> 
              <meta http-equiv='X-UA-Compatible' content='IE=edge'> 
              <meta name='format-detection' content='telephone=no'> 

            <style type='text/css'>
            body {
              margin: 0;
              padding: 0;
              -ms-text-size-adjust: 100%;
              -webkit-text-size-adjust: 100%;
            }
            
            .btn {
            text-decoration:none;
            color: #FFF;
            background-color: #666;
            padding:10px 16px;
            font-weight:bold;
            margin-right:10px;
            text-align:center;
            cursor:pointer;
            display: inline-block;
            }


            table {
              border-spacing: 0;
            }
            table td {
              border-collapse: collapse;
            }
            .ExternalClass {
              width: 100%;
            }
            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
              line-height: 100%;
            }
            .ReadMsgBody {
              width: 100%;
              background-color: #ebebeb;
            }
            table {
              mso-table-lspace: 0pt;
              mso-table-rspace: 0pt;
            }
            img {
              -ms-interpolation-mode: bicubic;
            }
            .yshortcuts a {
              border-bottom: none !important;
            }
            @media screen and (max-width: 599px) {
              .force-row,
              .container {
                width: 100% !important;
                max-width: 100% !important;
              }
            }
            @media screen and (max-width: 400px) {
              .container-padding {
                padding-left: 12px !important;
                padding-right: 12px !important;
              }
            }
            .ios-footer a {
              color: #aaaaaa !important;
              text-decoration: underline;
            }
            </style>
            </head>

            <body style='margin:0; padding:0;' bgcolor='#F0F0F0' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>

            <table border='0' width='100%' height='100%' cellpadding='0' cellspacing='0' bgcolor='#F0F0F0'>
              <tr>
                <td align='center' valign='top' bgcolor='#F0F0F0' style='background-color: #F0F0F0;'>

                  <br>

                  <table border='0' width='600' cellpadding='0' cellspacing='0' class='container' style='width:600px;max-width:600px'>
                   <tr> 
                    <td colspan = '2' class='container-padding footer-text' align='left' style='font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:16px;color:#000000;padding-left:24px;padding-right:24px'>                     
                      <br><br>  
                        <font style='text-decoration: underline;'>ATEN&Ccedil;&Atilde;O: Este é um email automático. Favor, não responder</font>
                      <br><br>
                    </td>
                    </tr>
                    <tr>
                    <td>
                    ";

                    if ($avisoRecuperaSenha) {
                        $dadosEmail['msg'] = "
                        <br> 
                        <h4>Você já solicitou uma troca de senha no PIP Imóveis. Desconsidere o email já enviado e clique no link abaixo para processar a troca:</h4><br>
                        <a href=https://www.pipbeta.com.br/index.php?entidade=Usuario&acao=form&tipo=alterarsenha&id=" . $entidadeRecuperaSenha->getHash() . ">https://www.pipbeta.com.br/index.php?entidade=Usuario&acao=form&tipo=alterarsenha&id=" . $entidadeRecuperaSenha->getHash() . "</a>";
                    } else {
                        $dadosEmail['msg'] = "PIP Imóveis - Clique abaixo para recuperar sua senha. Este é um email automático. Não responda.
                        <br> 
                        <a href=https://www.pipbeta.com.br/index.php?entidade=Usuario&acao=form&tipo=alterarsenha&id=" . $entidadeRecuperaSenha->getHash() . ">https://www.pipbeta.com.br/index.php?entidade=Usuario&acao=form&tipo=alterarsenha&id=" . $entidadeRecuperaSenha->getHash() . "</a>";
                    }

                    $dadosEmail['msg'] .= " </td>
                                </tr>
                                <tr>
                                <td colspan = '2' class='container-padding footer-text' align='left' 
                                style='font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:16px;color:#000000;
                                padding-left:24px;padding-right:24px'>
                                <br><br>
                                <font style='text-decoration: underline;'>ATENÇÃO: Este é um email automático. Favor, não responder</font>
                                <br><br>

                                <strong>PIP On-Line 2017. Todos os Direitos Reservados</strong><br>

                                <a href='https://www.pipbeta.com.br' style='color:#aaaaaa'>https://www.pipbeta.com.br</a><br>

                                <br><br>

                                </td>
                                </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>
            </html>";

                    $dadosEmail['contato'] = $_SESSION["nome"];
                    $dadosEmail['assunto'] = "Recuperação de Senha - PIP";
                    if (Email::enviarEmail($dadosEmail)) { //email enviado com sucesso
                        $genericoDAO->commit();
                        $genericoDAO->fecharConexao();
                        echo json_encode(array("resultado" => 1));
                    } else { //erro no envio do email
                        $genericoDAO->rollback();
                        $genericoDAO->fecharConexao();
                        echo json_encode(array("resultado" => 3));
                    }
                    $this->log("Término da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
                } else { //erro ao cadastrar token no banco - 004
                    $genericoDAO->rollback();
                    $genericoDAO->fecharConexao();
                    echo json_encode(array("resultado" => 4));
                }
            } else { //email não encontrado
                echo json_encode(array("resultado" => 0));
            }
        } else { //erro de sessão do token - 005
            echo json_encode(array("resultado" => 5));
            $this->log("Término da Operação por Erro no Token");
        }
    }

    function alterarSenha($parametros) { //Usuário Esqueceu a Senha
        $this->log("Inicio da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
        $visao = new Template();
        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $usuario = new Usuario();
            $entidadeUsuario = $usuario->alterarSenha($parametros);
            $resultadoUsuario = $genericoDAO->editar($entidadeUsuario);
            $recuperasenha = new RecuperaSenha();
            $entidadeRecuperaSenha = $recuperasenha->editar($parametros);
            $resultadoAlterarSenha = $genericoDAO->editar($entidadeRecuperaSenha);
            if ($resultadoUsuario && $resultadoAlterarSenha) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 1));
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 0)); //erro de banco de dados - 000
            }
        } else {
            echo json_encode(array("resultado" => 5)); //erro de sessão do token - 005
        }
    }

    function trocarSenha($parametros) { //Usuário Deseja Alterar Senha
        $visao = new Template();
        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $usuario = new Usuario();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("id" => $_SESSION["idusuario"]));
            if (password_verify($parametros['txtSenhaAtual'], $selecionarUsuario[0]->getSenha())) {
                $entidadeUsuario = $usuario->trocarSenha($parametros);
                $resultadoUsuario = $genericoDAO->editar($entidadeUsuario);
                //sucesso
                if ($resultadoUsuario) {
                    $genericoDAO->commit();
                    $genericoDAO->fecharConexao();
                    $_SESSION["confirmarOperacao"] = "sucesso";
                    echo json_encode(array("resultado" => 1));
                    //banco
                } else {
                    $genericoDAO->rollback();
                    $genericoDAO->fecharConexao();
                    $_SESSION["confirmarOperacao"] = "erroGenerico";
                    echo json_encode(array("resultado" => 0));
                }
                //A Senha atual está incorreta.
            } else {
                echo json_encode(array("resultado" => 2));
            }
            //token
        } else {
            $_SESSION["confirmarOperacao"] = "erroToken";
            echo json_encode(array("resultado" => 3));
        }
    }

    public function meuPIP() {
        if (Sessao::verificarSessaoUsuario()) {
            //modelo
            $chamadosPIP = new Chamado();
            $usuarioPlano = new UsuarioPlano();
            $genericoDAO = new GenericoDAO();
            $consultasAdHoc = new ConsultasAdHoc();
            $listarUsuarioPlano = $genericoDAO->consultar($usuarioPlano, true, array("idusuario" => $_SESSION["idusuario"]));
            $usuario = $genericoDAO->consultar(new Usuario, true, array("id" => $_SESSION["idusuario"]));
            //$bairroUsuario = $genericoDAO->consultar(new Bairro(), false, array("id" => $usuario[0]->getEndereco()->getIdBairro()));
            $planosUsuario = $consultasAdHoc->verificarPlanoGratuito($_SESSION["idusuario"]);
            $dadosPlano = $consultasAdHoc->consultarAnunciosAprovados($_SESSION["idusuario"]);
            $itemMeuPIP = array();
            $itemMeuPIP["usuarioPlano"] = $listarUsuarioPlano;
            $itemMeuPIP["usuario"] = $usuario;
            $itemMeuPIP["usuarioBairro"] = $bairroUsuario;
            $itemMeuPIP["planosUsuarioGratis"] = $planosUsuario;
            $itemMeuPIP["imovelCadastrado"] = $genericoDAO->consultar(new Imovel(), true, array("idusuario" => $_SESSION['idusuario'], "status" => "cadastrado"));
            $itemMeuPIP["imovel"] = is_array($itemMeuPIP["imovelCadastrado"]);
            $itemMeuPIP["anuncio"] = count($consultasAdHoc->ConsultarAnunciosPorUsuario($_SESSION['idusuario'], null)) > 0 || count($consultasAdHoc->ConsultarAnunciosPendentesPorUsuario($_SESSION['idusuario'], null)) > 0;
            $itemMeuPIP["mensagem"] = $genericoDAO->consultar(new Mensagem(), false, array("idusuario" => $_SESSION['idusuario']));
            $itemMeuPIP["chamados"] = $genericoDAO->consultar($chamadosPIP, true, array("idusuario" => $_SESSION['idusuario']));
            $itemMeuPIP["anuncioPendente"] = $consultasAdHoc->consultarAnunciosPendentesAprovacaoPorUsuario($_SESSION['idusuario']);
            $itemMeuPIP["dadosPlano"] = $dadosPlano;
            $visao = new Template();
            $visao->setItem($itemMeuPIP);
            $visao->exibir('UsuarioVisaoMeuPIP.php');
        } else {
            $visao = new Template();
            $visao->exibir('UsuarioVisaoLogin.php');
        }
    }

    public function listarMensagem($parametros) {
        if (Sessao::verificarSessaoUsuario()) {
            unset($_SESSION["mensagem"]);
            $mensagem = new Mensagem();
            $genericoDAO = new GenericoDAO();
            $listaMensagens = $genericoDAO->consultar($mensagem, true, array("idusuario" => $_SESSION["idusuario"]));
            foreach ($listaMensagens as $selecionarMensagem) {
                $selecionarAnuncio = $genericoDAO->consultar(new Anuncio(), true, array("id" => $selecionarMensagem->getIdAnuncio()));
                $selecionarResposta = $genericoDAO->consultar(new RespostaMensagem(), false, array("idmensagem" => $selecionarMensagem->getId()));
                $idMensagem = rand();
                $_SESSION["mensagem"][$idMensagem] = $selecionarMensagem->getId();
                $selecionarMensagem->setId($idMensagem);
                $selecionarMensagem->setRespostamensagem($selecionarResposta);
                $selecionarMensagem->setAnuncio($selecionarAnuncio[0]);
                $listarMensagens[] = $selecionarMensagem;
            }
            //$listarMensagens['filtro'] = "NAO";
            if ($parametros["type"] == "face") {
                echo json_encode(array("resultado" => $listarMensagens));
            } else {
                if (count($listaMensagens) > 0) {
                    $visao = new Template();
                    $visao->setItem($listarMensagens);
                } else {
                    $visao = new Template();
                    $visao->setItem(false);
                }
                $visao->exibir('UsuarioVisaoMinhasMensagens.php');
            }
        } else {
            $visao = new Template();
            $visao->exibir('UsuarioVisaoLogin.php');
        }
    }

    public function filtrarMensagens($parametros) {
        unset($_SESSION["mensagem"]);
        $mensagem = new Mensagem();
        $genericoDAO = new GenericoDAO();
        if ($parametros['sltStatusMensagem'] == 'NOVA' || $parametros['sltStatusMensagem'] == 'RESPONDIDO') {
            $listaMensagens = $genericoDAO->consultar($mensagem, true, array("idusuario" => $_SESSION["idusuario"], "status" => $parametros['sltStatusMensagem']));
        } else {
            $listaMensagens = $genericoDAO->consultar($mensagem, true, array("idusuario" => $_SESSION["idusuario"]));
        }
        foreach ($listaMensagens as $selecionarMensagem) {
            $selecionarAnuncio = $genericoDAO->consultar(new Anuncio(), true, array("id" => $selecionarMensagem->getIdAnuncio()));
            $selecionarResposta = $genericoDAO->consultar(new RespostaMensagem(), false, array("idmensagem" => $selecionarMensagem->getId()));
            $idMensagem = rand();
            $_SESSION["mensagem"][$idMensagem] = $selecionarMensagem->getId();
            $selecionarMensagem->setId($idMensagem);
            $selecionarMensagem->setRespostamensagem($selecionarResposta);
            $selecionarMensagem->setAnuncio($selecionarAnuncio[0]);
            $listarMensagens[] = $selecionarMensagem;
        }

        if ($listarMensagens == null) {
            $listarMensagens = 'nenhuma';
        }

        $visao = new Template();
        $visao->setItem($listarMensagens);
        $visao->exibir('UsuarioVisaoMinhasMensagens.php');
    }

    public function responderMensagem($parametros) {
        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();
        $respostaMensagem = new RespostaMensagem();
        $entidadeRespostaMensagem = $respostaMensagem->cadastrar($parametros);
        $resultadoRespostaMensagem = $genericoDAO->cadastrar($entidadeRespostaMensagem);
        $entidadeMensagem = $genericoDAO->consultar(new Mensagem(), true, array("id" => $_SESSION["mensagem"][$parametros["hdnMensagem"]]));
        $entidadeMensagem = $entidadeMensagem[0];
        $entidadeMensagem->setStatus("RESPONDIDO"); //alterar o status da mensagem para Respondido
        $statusRespondido = $genericoDAO->editar($entidadeMensagem);
        if ($resultadoRespostaMensagem && $statusRespondido) {
            //Enviar email para o usuário
            $selecionarMensagem = $genericoDAO->consultar(new Mensagem(), false, array("id" => $entidadeRespostaMensagem->getIdMensagem()));
            $selecionarAnuncio = $genericoDAO->consultar(new Anuncio(), false, array("id" => $selecionarMensagem[0]->getIdAnuncio()));
            $dadosEmail['destino'] = $selecionarMensagem[0]->getEmail(); //$parametros["email"];  
            $dadosEmail['nome'] = $selecionarMensagem[0]->getNome(); //$parametros["nome"]; 
            $dadosEmail['msg'] = "O vendedor respondeu sua mensagem: <br><br>Resposta: " . $parametros["txtResposta"] . "<br><br>Este é um e-mail automático. Favor, não responder";
            $dadosEmail['contato'] = $_SESSION["nome"];
            $dadosEmail['assunto'] = "PIP Online - Resposta do vendedor sobre o anuncio " . $selecionarAnuncio[0]->getTituloAnuncio();
            if (Email::enviarEmail($dadosEmail)) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 1));
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 0));
            }
        } else {
            $genericoDAO->rollback();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 0));
        }
    }

    public function arquivarMensagem($parametros) {
        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();
        for ($i = 0; $i < sizeof($parametros["msgs"]); $i++) {
            $mensagem = new Mensagem();
            $entidadeMensagem = $mensagem->editar($parametros, "EXCLUIDA", $i);
            $resultado = $genericoDAO->editar($entidadeMensagem);
            if (!$resultado) {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 0));
                break;
            }
        }

        $genericoDAO->commit();
        $genericoDAO->fecharConexao();
        echo json_encode(array("resultado" => 1));
    }

    public function lerMensagem($parametros) {
        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();
        $mensagem = new Mensagem();
        $entidadeMensagem = $mensagem->editar($parametros, "LIDA");
        $resultado = $genericoDAO->editar($entidadeMensagem);
        if (!$resultado) {
            $genericoDAO->rollback();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 0));
        }
        $genericoDAO->commit();
        $genericoDAO->fecharConexao();
        echo json_encode(array("resultado" => 1));
    }

    public function trocarImagem($parametros) {
        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();
        $selecionarUsuario = $genericoDAO->consultar(new Usuario, false, array("id" => $_SESSION["idusuario"]));
        $usuario = $selecionarUsuario[0];
        //excluir foto antiga se houver
        $deletar = true;
        if ($usuario->getFoto() != "") {
            $fotoAntiga = PIPROOT . '/fotos/usuarios/' . $usuario->getFoto();
            if (is_file($fotoAntiga)) {
                $deletar = unlink($fotoAntiga);
            }
        }
        $usuario->setFoto("");
        //se nao for exclusao de foto
        if ($parametros["hdnExcluir"] == 0) {
            $arquivo_tmp = $_FILES['attachmentName']['tmp_name'];
            $nome = $_FILES['attachmentName']['name'];
            $extensao = strrchr($nome, '.');
            $extensao = strtolower($extensao);
            $novoNome = md5(microtime()) . $extensao;
            $destino = PIPROOT . '/fotos/usuarios/' . $novoNome;
            if (move_uploaded_file($_FILES['attachmentName']['tmp_name'], $destino)) {
                $usuario->setFoto($novoNome);
            }
        }
        $resultado = $genericoDAO->editar($usuario);

        if ($deletar && $resultado) {
            $genericoDAO->commit();
            $genericoDAO->fecharConexao();
            $_SESSION["confirmarOperacao"] = "sucesso";
            header("Location: index.php?entidade=Usuario&acao=MeuPIP");
        } else {
            $genericoDAO->rollback();
            $genericoDAO->fecharConexao();
            $_SESSION["confirmarOperacao"] = "erroGenerico";
            header("Location: index.php?entidade=Usuario&acao=MeuPIP");
        }
    }

    public function configuracoes($parametros) {
        $visao = new Template();
        $usuario = new Usuario();
        $genericoDAO = new GenericoDAO();
        $consultasAdHoc = new ConsultasAdHoc();
        $item = $genericoDAO->consultar($usuario, true, array("id" => $_SESSION['idusuario']));
        $visao->setItem($item);
        $visao->exibir('UsuarioVisaoConfiguracoes.php');
    }

    public function editarConfiguracoes($parametros) {
        $visao = new Template();
        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $usuario = new Usuario();
            $entidadeUsuario = $usuario->configuracoes($parametros);
            $resultadoUsuario = $genericoDAO->editar($entidadeUsuario);
            if ($resultadoUsuario) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                $_SESSION["confirmarOperacao"] = "sucesso";
                echo json_encode(array("resultado" => 1));
                //banco
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                $_SESSION["confirmarOperacao"] = "erroGenerico";
                echo json_encode(array("resultado" => 0));
            }
        }
    }

    function faleConosco($parametros) {
        $dadosEmail['destino'] = "duvidas@pipbeta.com.br";
        $dadosEmail['assunto'] = $parametros['txtTituloDuvida'];
        $dadosEmail['msg'] = "Enviado por: " . $parametros['txtNomeDuvida'] . "<br>" . $parametros['txtMsgDuvida'];
        $dadosEmail['contato'] = $parametros['txtEmailDuvida'];
        if (Email::enviarEmail($dadosEmail)) {
            echo json_encode(array("resultado" => 1)); //email enviado
        } else {
            echo json_encode(array("resultado" => 0)); //erro ao enviar email
        }
    }

    function abrirChamado() {
        $visao = new Template();
        $visao->exibir('UsuarioVisaoAbrirChamado.php');
    }

    function cadastrarChamadoUsuario($parametros) {
        $this->log("Inicio da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
        $visao = new Template();
        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $chamado = new Chamado();
            $maiorId = $genericoDAO->trazerMaxId($chamado, null);
            $entidadeChamado = $chamado->cadastrar($parametros, $maiorId[0]);
            $idChamado = $genericoDAO->cadastrar($entidadeChamado);
            if ($idChamado) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 1, "numeroChamado" => $entidadeChamado->getCodigochamado())); //chamado cadastrado
                if ($parametros['txtAssuntoChamado'] != null) {
                    $genericoDAO = new GenericoDAO();
                    $genericoDAO->iniciarTransacao();
                    $chamadoTitulo = new ChamadoTitulo();
                    $idChamado = $genericoDAO->consultar($chamado, null, array("codigochamado" => $entidadeChamado->getCodigochamado()));
                    $entidadeChamadoTitulo = $chamadoTitulo->cadastrar($idChamado[0]->getId(), $parametros);
                    $genericoDAO->cadastrar($entidadeChamadoTitulo);
                    $genericoDAO->commit();
                    $genericoDAO->fecharConexao();
                }
            } else {
                $genericoDAO->rollback();
                echo json_encode(array("resultado" => 0)); //erro ao cadastrar chamado
            }
        }
    }

    function cancelarChamadoUsuario($parametros) {
        $this->log("Inicio da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
        $visao = new Template();
        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $chamado = new Chamado();
            $entidadeChamado = $chamado->cancelar($parametros);
            $idChamado = $genericoDAO->editar($entidadeChamado);
            if ($idChamado) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 1)); //chamado cancelado
            } else {
                $genericoDAO->rollback();
                echo json_encode(array("resultado" => 0)); //erro ao cancelar chamado
            }
        }
    }

    function responderChamadoUsuario($parametros) {
        $this->log("Inicio da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
        $visao = new Template();
        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $chamado = new Chamado();
            $entidadeChamado = $chamado->cancelar($parametros);
            $idChamado = $genericoDAO->editar($entidadeChamado);
            if ($idChamado) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 1)); //chamado cancelado
            } else {
                $genericoDAO->rollback();
                echo json_encode(array("resultado" => 0)); //erro ao cancelar chamado
            }
        }
    }

    function listarUsuarios() {
        if (Sessao::verificarSessaoUsuario()) {
            $usuario = new Usuario();
            $denuncia = new Denuncia();
            $genericoDAO = new GenericoDAO();
            $administrador = false;
            if (($_SESSION['login'] === "pipdiministrador")) {
                $administrador = true;
            }
            $consultasAdHoc = new ConsultasAdHoc();
            $listaUsuarios = $consultasAdHoc->consultaUsuarioDenuncia();
            $listaDenuncias = $consultasAdHoc->consultarDenuncia();
            for ($indice = 0; $indice < count($listaUsuarios); $indice++) {
                $indiceArrayDenuncia = 0;
                $indiceDenuncia = 0;
                while ($indiceArrayDenuncia < count($listaDenuncias)) {
                    if ($listaUsuarios[$indice]["id"] == $listaDenuncias[$indiceArrayDenuncia]["idusuario"]) {
                        $listaUsuarios[$indice][$indiceDenuncia] = $listaDenuncias[$indiceArrayDenuncia];
                        $indiceDenuncia++;
                    }
                    $indiceArrayDenuncia++;
                }
            }
            $visao = new Template();
            $item["listaUsuarios"] = $listaUsuarios;
            $visao->setItem($item);
            $visao->exibir('UsuarioVisaoDesativar.php');
        }
    }

    function inativarUsuario($parametros) {
        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $usuario = new Usuario();
            $entidadeUsuario = $usuario->inativar($parametros);
            $resultadoUsuario = $genericoDAO->editar($entidadeUsuario);
            if ($resultadoUsuario) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                $_SESSION["confirmarOperacao"] = "sucesso";
                echo json_encode(array("resultado" => 1));
                //banco
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                $_SESSION["confirmarOperacao"] = "erroGenerico";
                echo json_encode(array("resultado" => 0));
            }
        }
    }

    function ativarUsuario($parametros) {
        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $usuario = new Usuario();
            $entidadeUsuario = $usuario->ativar($parametros);
            $resultadoUsuario = $genericoDAO->editar($entidadeUsuario);
            if ($resultadoUsuario) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                $_SESSION["confirmarOperacao"] = "sucesso";
                echo json_encode(array("resultado" => 1));
                //banco
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                $_SESSION["confirmarOperacao"] = "erroGenerico";
                echo json_encode(array("resultado" => 0));
            }
        }
    }

    function listarUsuarioDesativado() {
        if (Sessao::verificarSessaoUsuario()) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $administrador = false;
            if (($_SESSION['login'] === "pipdiministrador")) {
                $administrador = true;
            }
            $listaUsuarios = $genericoDAO->consultar($usuario, false, array("status" => "inativo"));
            $visao = new Template();
            $item["listaUsuarios"] = $listaUsuarios;
            $visao->setItem($item);
            $visao->exibir('UsuarioVisaoAtivar.php');
        }
    }

    function exibirListaUsuario($parametros) {
        $usuario = new Usuario();
        $genericoDAO = new GenericoDAO();
        $listarUsuario = $genericoDAO->consultar($usuario, false, array("status" => "ativo"));
        if ($parametros["usuarios"] != "") {
            $chavesRemover = array();
            $usuariosSelecionados = explode(",", $parametros["usuarios"]);
            foreach ($listarUsuario as $key => $value) {
                if (in_array($value->getId(), $usuariosSelecionados)) {
                    $chavesRemover[$key] = $value;
                }
            }
            $listarUsuario = array_diff_key($listarUsuario, $chavesRemover);
        }
        $nomeOrdenado = $listarUsuario;
        usort($nomeOrdenado, function( $a, $b ) { //ordenar por ordem alfabética
            return ( $a->getNome() > $b->getNome() );
        });
        $usuarioPlano = new UsuarioPlano();
        $vetorIdsUsuarioPlano[] = array();
        $todosUsuariosPlanos = $genericoDAO->consultar($usuarioPlano, false);
        //todos os ids usuarioplano
        foreach ($todosUsuariosPlanos as $ids) {
            $vetorIdsUsuarioPlano[] = $ids->getId();
        };
        $anuncios = new Anuncio();
        //anuncios ativos
        $anunciosAtivos = $genericoDAO->consultar($anuncios, false, array("status" => "cadastrado"));
        $anunciosA[] = array();
        //ids usuarioplano dos anuncios ativos
        foreach ($anunciosAtivos as $aAtivos) {
            $anunciosA[] = $aAtivos->getIdUsuarioPlano();
        };
        $vetorFinalUsuarios[] = array();
        //verificar quais usuarioplanos possuem anuncios ativos
        foreach ($todosUsuariosPlanos as $uPlanos) {
            if (in_array($uPlanos->getId(), $anunciosA)) {
                $uVetorAnuncio[] = $uPlanos->getIdUsuario();
            }
        }
        array_unique($testeVetor);

        foreach ($nomeOrdenado as $retirarAdministrador) {
            //não pode ser o administrador e o ID do usuário deve ter um anuncio ativo
            if ($retirarAdministrador->getLogin() != "pipdiministrador" && in_array($retirarAdministrador->getId(), $uVetorAnuncio)) { //não exibir o administrador
                $nomeOrdenadoSemAdmin[] = $retirarAdministrador;
            }
        }

        foreach ($nomeOrdenadoSemAdmin as $valor) {
            if ($valor->getFoto()) {
                $foto = PIPURL . "/fotos/usuarios/" . $valor->getFoto();
            } else {
                $foto = PIPURL . "/assets/imagens/usuarioSemFoto.jpg";
            }

            echo '<div class="item" data-value="' . $valor->getId() . '"> <img class="ui avatar image" src="' . $foto . '">' . $valor->getNome() . "</div>";
        }
    }

}
