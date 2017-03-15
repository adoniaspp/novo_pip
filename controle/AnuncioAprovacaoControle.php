<?php

include_once 'modelo/Anuncio.php';
include_once 'modelo/AnuncioAprovacao.php';
include_once 'modelo/Apartamento.php';
include_once 'modelo/ApartamentoPlanta.php';
include_once 'modelo/Casa.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Imovel.php';
include_once 'modelo/Planta.php';
include_once 'modelo/Plano.php';
include_once 'modelo/Imagem.php';
include_once 'modelo/ImagemAprovacao.php';
include_once 'modelo/HistoricoAluguelVenda.php';
include_once 'modelo/UsuarioPlano.php';
include_once 'modelo/Usuario.php';
include_once 'modelo/Telefone.php';
include_once 'modelo/Empresa.php';
include_once 'modelo/Estado.php';
include_once 'modelo/Cidade.php';
include_once 'modelo/Bairro.php';
include_once 'DAO/GenericoDAO.php';
include_once 'DAO/ConsultasAdHoc.php';
include_once 'modelo/Mensagem.php';
include_once 'modelo/RespostaMensagem.php';
include_once 'modelo/AnuncioClique.php';
include_once 'modelo/EmailAnuncio.php';
include_once 'modelo/SalaComercial.php';
include_once 'modelo/PredioComercial.php';
include_once 'modelo/Terreno.php';
include_once 'modelo/TipoImovel.php';
include_once 'modelo/Valor.php';
include_once 'modelo/ImovelDiferencial.php';
include_once 'modelo/ImovelDiferencialPlanta.php';
include_once 'modelo/Diferencial.php';
include_once 'modelo/NovoValorAnuncio.php';
include_once 'modelo/MapaImovel.php';
include_once 'modelo/MapaImovelAprovacao.php';
include_once 'modelo/FuncoesAuxiliares.php';

class AnuncioAprovacaoControle {
    
        function listarPendente() {
        if (Sessao::verificarSessaoUsuario()) {
            $anuncio = new Anuncio();
            $genericoDAO = new GenericoDAO();
            $consultasAdHoc = new ConsultasAdHoc();
            
            $administrador = false;     
            
            if(($_SESSION['login'] === "pipdiministrador")){
                $administrador = true; 
            }    
            
                $listaAnuncio = $consultasAdHoc->ConsultarAnunciosPendentesPorUsuario($_SESSION['idusuario'], $administrador, array('pendenteaprovacao', 'emanalise'));
                foreach ($listaAnuncio as $anuncio) {
                    $imovel = $genericoDAO->consultar(new Imovel(), false, array("id" => $anuncio->getIdImovel()));
                    $anuncio->setImovel($imovel[0]);
                    $listarAnuncios[] = $anuncio;
                }
            
            $visao = new Template();
            $item["listaAnuncio"] = $listarAnuncios;
            $visao->setItem($item);
            $visao->exibir('AnuncioVisaoListagemPendente.php');
        }
    }

    function detalharPendente($parametros) {
        $funcoesAuxiliares = new FuncoesAuxiliares();
        $genericoDAO = new GenericoDAO();
        $parametros["idanuncio"] = $parametros["hdnCodAnuncio"];
        unset($parametros["hdnCodAnuncio"]);
        $parametros["tabela"] = $parametros["hdnTipoImovel"];
        unset($parametros["hdnTipoImovel"]);

        $visao = new Template();
        $consultasAdHoc = new ConsultasAdHoc();

        $parametros["atributos"] = "*";
        unset($parametros["hdnEntidade"]);
        unset($parametros["hdnAcao"]);
        unset($parametros["tabela_length"]);
        unset($parametros["selecionarAnuncio"]);
        unset($parametros["listaAnuncio"]);
        unset($parametros["hdnCodAnuncioFormatado"]);
        unset($parametros["chkAnuncio"]);

        $parametros["predicados"] = $parametros;

        $parametros["sessaoUsuario"] = $_SESSION["idusuario"];

        $administrador = false;

        if (($_SESSION['login'] === "pipdiministrador")) {
            $administrador = true;
        }

        $anuncio = $genericoDAO->consultar(new AnuncioAprovacao(), true, array("id" => $parametros["idanuncio"]));
        $anuncio = $anuncio[0];
        
        if (($anuncio->getUsuarioplano()->getIdUsuario() == $parametros["sessaoUsuario"] && $anuncio->getStatus() != "emanalise" && $anuncio->getStatus() != "pendenteaprovacao" && $anuncio->getStatus() != "aprovacaonegada") || ($anuncio->getUsuarioplano()->getIdUsuario() != $parametros["sessaoUsuario"] && !$administrador)) {
            $item = "errousuarioouanuncio";
            $pagina = "VisaoErrosGenerico.php";
            $visao = new Template();
            $visao->setItem($item);
            $visao->exibir($pagina);
        } else {
            $endereco = $genericoDAO->consultar(new Endereco(), true, array("id" => $anuncio->getImovel()->getIdendereco()));
            $anuncio->getImovel()->setEndereco($endereco[0]);

            $diferencial = $genericoDAO->consultar(new ImovelDiferencial(), true, array("idimovel" => $anuncio->getIdimovel()));
            $anuncio->getImovel()->setImoveldiferencial($diferencial);

            $usuarioPlano = $genericoDAO->consultar(new UsuarioPlano(), false, array("id" => $anuncio->getIdusuarioplano()));
            $listarAnuncio["contato"] = $genericoDAO->consultar(new Usuario(), true, array("id" => $usuarioPlano[0]->getIdusuario()));

            //$listarAnuncio["loginUsuario"] = $parametros["idUsuario"];

            if ($anuncio->getMapaimovelaprovacao() != null) {
                $listarAnuncio["mapaImovel"] = $anuncio->getMapaimovelaprovacao();
            }

            if ($anuncio->getImovel()->getIdtipoimovel() == '1') {
                $sth = $genericoDAO->consultar(new Casa(), false, array("idimovel" => $anuncio->getIdimovel()));
                $sth = (array) $sth[0];
                foreach ($sth as $key => $value) {
                    $listarAnuncio["dados"][trim(str_replace("Casa", "", $key))] = $value;
                }
            }
            if ($anuncio->getImovel()->getIdtipoimovel() == '2') {
                $sth = $genericoDAO->consultar(new ApartamentoPlanta(), false, array("idimovel" => $anuncio->getIdimovel()));
                $sth = (array) $sth[0];
                foreach ($sth as $key => $value) {
                    $listarAnuncio["dados"][trim(str_replace("ApartamentoPlanta", "", $key))] = $value;
                }
            }
            if ($anuncio->getImovel()->getIdtipoimovel() == '3') {
                $sth = $genericoDAO->consultar(new Apartamento(), false, array("idimovel" => $anuncio->getIdimovel()));
                $sth = (array) $sth[0];
                foreach ($sth as $key => $value) {
                    $listarAnuncio["dados"][trim(str_replace("Apartamento", "", $key))] = $value;
                }
            }
            if ($anuncio->getImovel()->getIdtipoimovel() == '4') {
                $sth = $genericoDAO->consultar(new SalaComercial(), false, array("idimovel" => $anuncio->getIdimovel()));
                $sth = (array) $sth[0];
                foreach ($sth as $key => $value) {
                    $listarAnuncio["dados"][trim(str_replace("SalaComercial", "", $key))] = $value;
                }
            }
            if ($anuncio->getImovel()->getIdtipoimovel() == '5') {
                $sth = $genericoDAO->consultar(new PredioComercial(), false, array("idimovel" => $anuncio->getIdimovel()));
                $sth = (array) $sth[0];
                foreach ($sth as $key => $value) {
                    $listarAnuncio["dados"][trim(str_replace("PredioComercial", "", $key))] = $value;
                }
            }
            if ($anuncio->getImovel()->getIdtipoimovel() == '6') {
                $sth = $genericoDAO->consultar(new Terreno(), false, array("idimovel" => $anuncio->getIdimovel()));
                $sth = (array) $sth[0];
                foreach ($sth as $key => $value) {
                    $listarAnuncio["dados"][trim(str_replace("Terreno", "", $key))] = $value;
                }
            }

            /* TODO:fazer aprovação de plantas
              $numeroPlantas = count($listarAnuncio["anuncio"][0]["plantas"]);

              //trazer os diferenciais da planta
              for ($x = 0; $x < $numeroPlantas; $x++) {

              $dif[$listarAnuncio["anuncio"][0]["plantas"][$x]["id"]] = $genericoDAO->consultar(new ImovelDiferencialPlanta(), true, array("idplanta" => $listarAnuncio["anuncio"][0]["plantas"][$x]["id"]));
              }

              $listarAnuncio["difPlantas"] = $dif;
             */

            $listarAnuncio["anuncio"] = $anuncio;
            $visao->setItem($listarAnuncio);

            $visao->exibir('AnuncioAprovacaoVisaoDetalhePendente.php');
        }
    }

    function enviarEmailGenerico($parametros) {

        $genericoDAO = new GenericoDAO();

        switch ($parametros['hdnTipoImovel']) {
            case "casa": $tipoImovelEmail = "Casa";
                break;
            case "apartamento": $tipoImovelEmail = "Apartamento";
                break;
            case "apartamentoplanta": $tipoImovelEmail = "Apartamento na Planta";
                break;
            case "salacomercial": $tipoImovelEmail = "Sala Comercial";
                break;
            case "prediocomercial": $tipoImovelEmail = "Prédio Comercial";
                break;
            case "terreno": $tipoImovelEmail = "Terreno";
                break;
        }

        $usuario = new Usuario();

        $destino = $genericoDAO->consultar($usuario, false, array("id" => $parametros['hdnUsuario']));

        $nomeUsuario = explode(" ", $destino[0]->getNome());

        $nome = ucfirst(strtolower($nomeUsuario[0]));

        $dadosEmail['destino'] = $destino[0]->getEmail();
        $dadosEmail['contato'] = "PIP-Online";
        $dadosEmail['assunto'] = $tipoImovelEmail . " - " . $parametros['hdnEmailAssunto'];

        $emailEnviadoPor = $parametros['hdnEnviadoPor'];

        if ($parametros['sltStatusAnuncio'] == 'emanalise') {
            $mensagemEmail = $parametros['hdnMsgEmailEmAnalise'];
        }

        if ($parametros['sltStatusAnuncio'] == 'aprovado') {
            $mensagemEmail = $parametros['hdnMsgEmailAprovado'];
        }

        if ($parametros['sltStatusAnuncio'] == 'aprovacaonegada') {
            $mensagemEmail = $parametros['hdnMsgEmailAprovacaoNegada'];
        }

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
                      " . $nome . ", " . $mensagemEmail . "
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

    function alterarStatus($parametros) {

        if (Sessao::verificarSessaoUsuario()) {
            $anuncioAprovacao = new AnuncioAprovacao();
            $genericoDAO = new GenericoDAO();

            //verifica se existe o id do anuncioaprovacao
            $anuncioSelecionado = $genericoDAO->consultar($anuncioAprovacao, true, array("id" => $parametros["hdnAnuncio"]));
            $anuncioSelecionado = $anuncioSelecionado[0];

            if ($anuncioSelecionado) {
                //setar apenas os campos que se quer editar
                $anuncioSelecionado->alterarStatus($parametros);

                $genericoDAO->iniciarTransacao();

                //passar o objeto para edição
                $novoStatus = $genericoDAO->editar($anuncioSelecionado);

                //se for negado reativa o plano
                if ($parametros["sltStatusAnuncio"] == "aprovacaonegada") {
                    $usuarioPlano = $anuncioSelecionado->getUsuarioplano();
                    $usuarioPlano->reativarPlano();
                    $genericoDAO->editar($usuarioPlano);
                }

                //se for aprovado cria anuncio
                if ($parametros["sltStatusAnuncio"] == "aprovado") {
                    $anuncioAprovado = $anuncioSelecionado->anuncioAprovado(new Anuncio());
                    $idAnuncio = $genericoDAO->cadastrar($anuncioAprovado);
                    if ($anuncioSelecionado->getImagemaprovacao()) {
                        foreach ($anuncioSelecionado->getImagemaprovacao() as $imagem) {
                            $imagemAprovado = $imagem->imagemAprovado(new Imagem(),$idAnuncio);
                            $genericoDAO->cadastrar($imagemAprovado);
                        }
                    }
                    $mapaImovelAprovacao = $anuncioSelecionado->getMapaimovelaprovacao();
                    if ($mapaImovelAprovacao != null) {
                        $mapaImovelAprovado = $mapaImovelAprovacao->mapaImovelAprovado(new MapaImovel(),$idAnuncio);
                        $genericoDAO->cadastrar($mapaImovelAprovado);
                    }
                    ###TODO:aprovacao apartamento na planta
                }


                //enviar email ao usuário, avisando sobre a mudança de status
                //$email = $this->enviarEmailGenerico($parametros);
                $email = 1;

                if ($novoStatus && $email) {
                    $genericoDAO->commit();
                    echo json_encode(array("resultado" => 1, "novoValor" => $parametros["sltStatusAnuncio"]));
                } else {
                    echo json_encode(array("resultado" => 0));
                    $genericoDAO->rollback();
                }
            }
        } else {
            echo json_encode(array("resultado" => 0));
            $genericoDAO->rollback();
        }
    }

    function fimCadastroAnuncio($parametros) {
        $this->detalharPendente(array("hdnTipoImovel" => $parametros["hdnTipo"], "hdnCodAnuncio" => $parametros["hdnCodAnuncio"]));
    }
    
    
    function listarNegado() {
        if (Sessao::verificarSessaoUsuario()) {
            $anuncioAprovacao = new AnuncioAprovacao();
            $genericoDAO = new GenericoDAO();
            $consultasAdHoc = new ConsultasAdHoc();
            
            $administrador = false;     
            
            if(($_SESSION['login'] === "pipdiministrador")){
                $administrador = true; 
            }    
            
                $listaAnuncio = $consultasAdHoc->ConsultarAnunciosPendentesPorUsuario($_SESSION['idusuario'], $administrador, array('aprovacaonegada'));
                foreach ($listaAnuncio as $anuncioAprovacao) {
                    $imovel = $genericoDAO->consultar(new Imovel(), false, array("id" => $anuncioAprovacao->getIdImovel()));
                    $anuncioAprovacao->setImovel($imovel[0]);

                    $usuarioplano = $genericoDAO->consultar(new UsuarioPlano(), true, array("id" => $anuncioAprovacao->getIdusuarioplano()));
                    $anuncioAprovacao->setUsuarioplano($usuarioplano[0]);

//                    $novoValor = $genericoDAO->consultar(new NovoValorAnuncio(), false, array("idanuncio" => $anuncioAprovacao->getId()));
//                    $anuncioAprovacao->setNovovaloranuncio($novoValor );

                    $listarAnuncios[] = $anuncioAprovacao;
                }
            
            $visao = new Template();
            $item["listaAnuncio"] = $listarAnuncios;
            $visao->setItem($item);
            $visao->exibir('AnuncioVisaoListagemNegado.php');
        }
    }

}
