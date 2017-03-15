<?php

include_once 'modelo/ChamadoResposta.php';
include_once 'modelo/Chamado.php';
include_once 'modelo/Chamado.php';
include_once 'DAO/GenericoDAO.php';
include_once 'assets/libs/log4php/Logger.php';
include_once 'configuracao/Log.php';

class ChamadoRespostaControle {
    
    use Log;
    
    function responderChamado($parametros){
        
        $this->log("Inicio da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));

        if (Sessao::verificarToken($parametros)) {
        
        $genericoDAO = new GenericoDAO();

        $chamadoResposta = new ChamadoResposta();
        
        $chamado = new Chamado();
        
        $entidadeChamado = $chamado->alterarStatus($parametros);
        
        $dadosChamado = $genericoDAO->consultar($chamado, false, array("id" => $parametros["hdnChamado"]));
        
        $idChamado = $genericoDAO->editar($entidadeChamado);

        $entidadeChamadoResposta = $chamadoResposta->cadastrar($parametros);
        
        $genericoDAO->iniciarTransacao();
        
        $idChamadoResposta = $genericoDAO->cadastrar($entidadeChamadoResposta);
        
        if($idChamadoResposta && $idChamado){
            
            $this->enviarEmailGenerico($parametros, "Seu chamado ".$dadosChamado[0]->getCodigochamado()." foi respondido. <br>Sua Pergunta: ".$dadosChamado[0]->getMensagem()."<br>Resposta: ".$parametros['txtRespostaChamado']);
            
            $genericoDAO->commit();

            $genericoDAO->fecharConexao();

            echo json_encode(array("resultado" => 1)); //resposta cadastrada
                
        } else {
        
        $genericoDAO->rollback();    
            
        echo json_encode(array("resultado" => 0));    
            
        }
        
        }
        
    }
    
    function usuarioRespondeChamado($parametros){
        
        $this->log("Inicio da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));

        if (Sessao::verificarToken($parametros)) {
        
        $genericoDAO = new GenericoDAO();

        $chamadoResposta = new ChamadoResposta();
        
        $chamado = new Chamado();
        
        $entidadeChamado = $chamado->alterarStatus($parametros);
        
        $idChamado = $genericoDAO->editar($entidadeChamado);

        $entidadeChamadoResposta = $chamadoResposta->cadastrar($parametros);
        
        $genericoDAO->iniciarTransacao();
        
        $idChamadoResposta = $genericoDAO->cadastrar($entidadeChamadoResposta);
        
        if($idChamadoResposta && $idChamado){
            
            $this->enviarEmailGenerico($parametros, "Seu chamado ".$entidadeChamado->getCodigochamado()." foi cadastrado e em breve será respondido. <br>Sua Mensagem: ".$parametros['txtMsgChamado']);
            
            $genericoDAO->commit();

            $genericoDAO->fecharConexao();

            echo json_encode(array("resultado" => 1)); //resposta cadastrada
                
        } else {
        
        $genericoDAO->rollback();    
            
        echo json_encode(array("resultado" => 0));    
            
        }
        
        }
        
    }
    
    function enviarEmailGenerico($parametros, $mensagem) {

        $genericoDAO = new GenericoDAO();
        
        $usuario = new Usuario();
        
        $destino = $genericoDAO->consultar($usuario, false, array("id" => $parametros['hdnUsuario']));
        
        $nomeUsuario = explode(" ", $destino[0]->getNome());
        
        $nome = ucfirst(strtolower($nomeUsuario[0]));
        
        $dadosEmail['destino'] = $destino[0]->getEmail();
        $dadosEmail['contato'] = "PIP-Online";
        $dadosEmail['assunto'] = $parametros['hdnEmailAssunto'];
        
        $emailEnviadoPor = $parametros['hdnEnviadoPor'];
        
        $mensagemEmail = $mensagem;

        $dadosEmail['msg'] .=
                "<!DOCTYPE html>
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
                      " . $emailEnviadoPor . "
                      <br>
                      ".$nome.", " . $mensagemEmail . "
                    </td>
                    </tr>";

        $dadosEmail['msg'] .= "
                                <tr>
                                <td colspan = '2' class='container-padding footer-text' align='left' 
                                style='font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:16px;color:#000000;
                                padding-left:24px;padding-right:24px'>
                                <br><br>
                                <font style='text-decoration: underline;'>ATENÇÃO: Este é um email automático. Favor, não responder</font>
                                <br><br>

                                <strong>PIP On-Line 2016. Todos os Direitos Reservados</strong><br>

                                <a href='http://www.pipbeta.com.br' style='color:#aaaaaa'>http://www.pipbeta.com.br</a><br>

                                <br><br>

                                </td>
                                </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>
            </html>";

        if (Email::enviarEmail($dadosEmail)) {
            return true;
        } else {
            return false;
        }
    }
    
}
