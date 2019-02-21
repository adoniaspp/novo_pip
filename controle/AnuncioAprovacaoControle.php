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
include_once 'modelo/HistoricoReativacao.php';

class AnuncioAprovacaoControle {

    function listarPendente() {
        if (Sessao::verificarSessaoUsuario()) {
            $anuncio = new Anuncio();
            $genericoDAO = new GenericoDAO();
            $consultasAdHoc = new ConsultasAdHoc();

            $administrador = false;

            if (($_SESSION['login'] === "pipdiministrador")) {
                $administrador = true;
            }

            $listaAnuncio = $consultasAdHoc->ConsultarAnunciosPendentesPorUsuario($_SESSION['idusuario'], $administrador, array('pendenteanalise', 'emanalise'));

            foreach ($listaAnuncio as $anuncio) {
                $imovel = $genericoDAO->consultar(new Imovel(), false, array("id" => $anuncio["idimovel"]));
                $anuncio["imovel"] = $imovel[0];
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

        if (($anuncio->getUsuarioplano()->getIdUsuario() == $parametros["sessaoUsuario"] && $anuncio->getStatus() != "emanalise" && $anuncio->getStatus() != "pendenteanalise" && $anuncio->getStatus() != "aprovacaonegada") || ($anuncio->getUsuarioplano()->getIdUsuario() != $parametros["sessaoUsuario"] && !$administrador)) {
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

                //traz os dados do apartamento na planta
                $sth = $genericoDAO->consultar(new ApartamentoPlanta(), false, array("idimovel" => $anuncio->getIdimovel()));
                $sth = (array) $sth[0];
                foreach ($sth as $key => $value) {
                    $listarAnuncio["dados"][trim(str_replace("ApartamentoPlanta", "", $key))] = $value;
                }

                //traz os dados da planta
                $sth = $genericoDAO->consultar(new Planta(), false, array("idimovel" => $anuncio->getIdimovel()));
                if (!is_array($sth)) {
                    $sth = (array) $sth[0];
                }
                //como a exibição de detalhes requer um array então monta array de plantas
                foreach ($sth as $key => $value) {
                    $arrayPlantas = null;
                    $arrayPlantas[] = $value;

                    //traz dados dos valores da planta
                    $substh = $genericoDAO->consultar(new ValorAprovacao(), false, array("idplanta" => $value->getId(), "idanuncioaprovacao" => $anuncio->getId()));
                    if (!is_array($substh)) {
                        $substh = (array) $substh[0];
                    }
                    //monta array dos valores da planta
                    $arrayValores = null;
                    foreach ($substh as $subkey => $subvalue) {
                        $arrayValores[] = $subvalue;
                    }
                    $arrayPlantas["valores"] = $arrayValores;

                    //traz dados dos diferenciais da planta
                    $substh = $genericoDAO->consultar(new ImovelDiferencialPlanta(), true, array("idplanta" => $value->getId()));
                    if (!is_array($substh)) {
                        $substh = (array) $substh[0];
                    }
                    //monta array dos diferenciais da planta
                    $arrayDiferenciais = null;
                    foreach ($substh as $subkey => $subvalue) {
                        $arrayDiferenciais[] = $subvalue;
                    }
                    $arrayPlantas["diferenciais"] = $arrayDiferenciais;

                    $listarAnuncio["plantas"][trim(str_replace("Planta", "", $key))] = array($arrayPlantas);
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

            if ($anuncioSelecionado && $this->permiteAlterarStatus($anuncioSelecionado)) {
                //setar apenas os campos que se quer editar
                $anuncioSelecionado->alterarStatus($parametros);

                $genericoDAO->iniciarTransacao();

                //passar o objeto para edição
                $novoStatus = $genericoDAO->editar($anuncioSelecionado);

                //verifica qual o status para dar tratamento ao anuncio
                switch ($parametros["sltStatusAnuncio"]) {
                    case "aprovacaonegada":
                        //se for NEGADO reativa o plano
                        $this->negarAnuncio($anuncioSelecionado, $genericoDAO);
                        break;

                    case "aprovado":
                        //se for APROVADO cria anuncio
                        $this->aprovarAnuncio($anuncioSelecionado, $genericoDAO);
                        break;

                    default:
                        //nao faz nada com o anuncio
                        break;
                }
                //enviar email ao usuário, avisando sobre a mudança de status
                $email = $this->enviarEmailGenerico($parametros);

                if ($novoStatus && $email) {
                    $genericoDAO->commit();
                    echo json_encode(array("resultado" => 1, "novoValor" => $parametros["sltStatusAnuncio"]));
                } else {
                    echo json_encode(array("resultado" => 0));
                    $genericoDAO->rollback();
                }
            } else {
                echo json_encode(array("resultado" => 0));
            }
        } else {
            echo json_encode(array("resultado" => 0));
        }
    }

    private function permiteAlterarStatus($anuncio) {
        $genericoDAO = new GenericoDAO();
        $verificaExisteCadastrado = $genericoDAO->consultar(new Anuncio(), false, array("idanuncio" => $anuncio->getIdAnuncio(), "status" => "cadastrado"));
        $verificaSeNaoExiste = $genericoDAO->consultar(new Anuncio(), false, array("idanuncio" => $anuncio->getIdAnuncio()));
        $verificaAluguelExpirado = $genericoDAO->consultar(new Anuncio(), false, array("idanuncio" => $anuncio->getIdAnuncio(), "status" => "expirado", "finalidade" => "Aluguel" ));
        $verificaAluguelFinalizado = $genericoDAO->consultar(new Anuncio(), false, array("idanuncio" => $anuncio->getIdAnuncio(), "status" => "finalizado", "finalidade" => "Aluguel"));        
        $permite = ($verificaExisteCadastrado || !$verificaSeNaoExiste || $verificaAluguelExpirado || $verificaAluguelFinalizado);
        return $permite;
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

            if (($_SESSION['login'] === "pipdiministrador")) {
                $administrador = true;
            }

            $listaAnuncio = $consultasAdHoc->ConsultarAnunciosPendentesPorUsuario($_SESSION['idusuario'], $administrador, array('aprovacaonegada'));
            foreach ($listaAnuncio as $consulta) {
                $anuncioAprovacao = $genericoDAO->consultar(new AnuncioAprovacao(), true, array("id" => $consulta["id"]));
                $listarAnuncios[] = $anuncioAprovacao[0];
            }

            $visao = new Template();
            $item["listaAnuncio"] = $listarAnuncios;
            $visao->setItem($item);
            $visao->exibir('AnuncioVisaoListagemNegado.php');
        }
    }

    private function negarAnuncio($anuncioAprovacao, $genericoDAO) {
        //verifica se existe anuncio cadastrado com o mesmo codigo de anuncio
        $verificaAnuncio = $genericoDAO->consultar(new Anuncio(), true, array("idanuncio" => $anuncioAprovacao->getIdAnuncio(), "status" => "cadastrado"));
        if ($verificaAnuncio == null) {
            $usuarioPlano = $anuncioAprovacao->getUsuarioplano();
            //reativa o plano (somente se for um anuncio novo)
            $usuarioPlano->reativarPlano();
            $genericoDAO->editar($usuarioPlano);
        }
    }

    private function aprovarAnuncio($anuncioAprovacao, $genericoDAO) {
        //echo "<pre>";        print_r($anuncioAprovacao);        die();
        //verifica se existe anuncio cadastrado com o mesmo codigo de anuncio
        $novoAnuncio = true;
        $reativarAnuncio = false;
        
        $verificaAnuncioEditado = $genericoDAO->consultar(new Anuncio(), true, array("idanuncio" => $anuncioAprovacao->getIdAnuncio(), "status" => "cadastrado"));
        if ($verificaAnuncioEditado != null) {
            $novoAnuncio = false;
            $anuncioEditado = $verificaAnuncioEditado[0];
        } else {
            $selecionarAnuncioExpirado = $genericoDAO->consultar(new Anuncio(), true, array("idanuncio" => $anuncioAprovacao->getIdAnuncio(), "status" => "expirado", "finalidade" => "Aluguel"));
            if($selecionarAnuncioExpirado != null){
                $novoAnuncio = false;
                $reativarAnuncio = true;
                $anuncioEditado = $selecionarAnuncioExpirado[0];
            } else {
                $selecionarAnuncioFinalizado = $genericoDAO->consultar(new Anuncio(), true, array("idanuncio" => $anuncioAprovacao->getIdAnuncio(), "status" => "finalizado", "finalidade" => "Aluguel"));    
                if($selecionarAnuncioFinalizado != null){
                    $novoAnuncio = false;
                    $reativarAnuncio = true;    
                    $anuncioEditado = $selecionarAnuncioFinalizado[0];
                } 
            }
        }
        //verifica se eh APARTAMENTO NA PLANTA
        $apartamentoNaPlanta = false;
        if ($anuncioAprovacao->getImovel()->getIdtipoimovel() == 2) {
            $apartamentoNaPlanta = true;
        }
        $idAnuncio = 0;
        //se for um anuncio novo
        if ($novoAnuncio) {
            $anuncioAprovado = $anuncioAprovacao->anuncioAprovado(new Anuncio());
            $idAnuncio = $genericoDAO->cadastrar($anuncioAprovado);
        } else {
            $anuncioEditadoStatus = $anuncioEditado->getStatus();
            $anuncioEditadoDatahoracadastro = $anuncioEditado->getDatahoracadastro();
            if($anuncioEditadoStatus=="finalizado"){
            $anuncioEditadoDatahoradesativacao = $anuncioEditado->getDatahoraalteracao();
            } else {
            $anuncioEditadoDatahoradesativacao = $anuncioEditado->getDatahoradesativacao();                
            }
            $anuncioAprovadoEdicao = $anuncioAprovacao->anuncioAprovadoEdicao($anuncioEditado);
            if($reativarAnuncio){
               $anuncioAprovadoEdicao->setStatus('cadastrado');
               $anuncioAprovadoEdicao->setDatahoraalteracao('');               
               $anuncioAprovadoEdicao->setDatahoradesativacao('');               
               $anuncioAprovadoEdicao->setDatahoracadastro(date("Y/m/d H:i:s"));
               $historicoReativacao = new HistoricoReativacao();
               $historicoReativacao->setIdanuncio($anuncioEditado->getIdanuncio());
               $historicoReativacao->setIdusuarioplano($anuncioEditado->getIdusuarioplano());
               $historicoReativacao->setStatus($anuncioEditadoStatus);
               $historicoReativacao->setDatacadastro($anuncioEditadoDatahoracadastro);
               $historicoReativacao->setDataexpiracaofinalizacao($anuncioEditadoDatahoradesativacao);
               $historicoReativacao->setDatareativacao(date("Y/m/d H:i:s"));
               $genericoDAO->cadastrar($historicoReativacao);
            }
            $genericoDAO->editar($anuncioAprovadoEdicao);
            $idAnuncio = $anuncioAprovadoEdicao->getId();
            //EXCLUI todas as FOTOS, se houver
            $this->excluirImagem($genericoDAO, $anuncioEditado);
            //EXCLUI a mudança no mapa se houver
            if ($anuncioEditado->getMapaimovel() != null) {
                $genericoDAO->excluir(new MapaImovel(), $anuncioEditado->getMapaimovel()->getId());
            }
            //EXCLUI todos os valores das plantas se houver
            if ($apartamentoNaPlanta) {
                $this->excluirValorPlanta($genericoDAO, $idAnuncio);
            }
        }
        //CADASTRA todas as fotos se houver
        $this->aprovarImagem($genericoDAO, $anuncioAprovacao, $idAnuncio);
        //CADASTRA novo mapa se houver
        $this->aprovarMapa($genericoDAO, $anuncioAprovacao, $idAnuncio);
        //CADASTRA novos valores e imagens das plantas
        if ($apartamentoNaPlanta) {
            $this->aprovarValorEImagemPlanta($genericoDAO, $anuncioAprovacao, $idAnuncio);
        }
    }

    private function excluirImagem($genericoDAO, $anuncioEditado) {
        if ($anuncioEditado->getImagem() != null) {
            if (is_array($anuncioEditado->getImagem())) {
                foreach ($anuncioEditado->getImagem() as $imagemExclusao) {
                    $genericoDAO->excluir(new Imagem(), $imagemExclusao->getId());
                }
            } else {
                $genericoDAO->excluir(new Imagem(), $anuncioEditado->getImagem()->getId());
            }
        }
    }

    private function excluirValorPlanta($genericoDAO, $idAnuncio) {
        //verifica se existe valores cadastrados para plantas
        $verificaValoresPlanta = $genericoDAO->consultar(new Valor(), false, array("idanuncio" => $idAnuncio));
        //EXCLUI todos os valores das plantas se houver
        if ($verificaValoresPlanta != null) {
            if (!is_array($verificaValoresPlanta)) {
                $verificaValoresPlanta = (array) $verificaValoresPlanta[0];
            }
            foreach ($verificaValoresPlanta as $valorExclusao) {
                $genericoDAO->excluir(new Valor(), $valorExclusao->getId());
            }
        }
    }

    private function aprovarImagem($genericoDAO, $anuncioAprovacao, $idAnuncio) {
        if ($anuncioAprovacao->getImagemaprovacao()) {
            if (is_array($anuncioAprovacao->getImagemaprovacao())) {
                foreach ($anuncioAprovacao->getImagemaprovacao() as $imagem) {
                    $imagemAprovado = $imagem->imagemAprovado(new Imagem(), $idAnuncio);
                    $genericoDAO->cadastrar($imagemAprovado);
                }
            } else {
                $imagemAprovado = $anuncioAprovacao->getImagemaprovacao()->imagemAprovado(new Imagem(), $idAnuncio);
                $genericoDAO->cadastrar($imagemAprovado);
            }
        }
    }

    private function aprovarMapa($genericoDAO, $anuncioAprovacao, $idAnuncio) {
        $mapaImovelAprovacao = $anuncioAprovacao->getMapaimovelaprovacao();
        if ($mapaImovelAprovacao != null) {
            $mapaImovelAprovado = $mapaImovelAprovacao->mapaImovelAprovado(new MapaImovel(), $idAnuncio);
            $genericoDAO->cadastrar($mapaImovelAprovado);
        }
    }

    private function aprovarValorEImagemPlanta($genericoDAO, $anuncioAprovacao, $idAnuncio) {
        $verificaValoresPlanta = $genericoDAO->consultar(new ValorAprovacao(), false, array("idanuncioaprovacao" => $anuncioAprovacao->getId()));
        if ($verificaValoresPlanta != null) {
            if (!is_array($verificaValoresPlanta)) {
                $verificaValoresPlanta = (array) $verificaValoresPlanta[0];
            }
            foreach ($verificaValoresPlanta as $valorAprovacao) {
                $valorAprovado = $valorAprovacao->valorAprovado(new Valor(), $idAnuncio);
                $genericoDAO->cadastrar($valorAprovado);
            }
        }

        $verificaDadosPlanta = $genericoDAO->consultar(new Planta(), false, array("idimovel" => $anuncioAprovacao->getImovel()->getId()));
        if ($verificaDadosPlanta != null) {
            if (!is_array($verificaDadosPlanta)) {
                $verificaDadosPlanta = (array) $verificaDadosPlanta[0];
            }
            foreach ($verificaDadosPlanta as $plantaAprovacao) {
                $entidadePlanta = $plantaAprovacao;
                $entidadePlanta->setImagemdiretorio($plantaAprovacao->getImagemaprovacaodiretorio());
                $entidadePlanta->setImagemnome($plantaAprovacao->getImagemaprovacaonome());
                $entidadePlanta->setImagemtamanho($plantaAprovacao->getImagemaprovacaotamanho());
                $entidadePlanta->setImagemtipo($plantaAprovacao->getImagemaprovacaotipo());
                $genericoDAO->editar($entidadePlanta);
            }
        }
    }

}
