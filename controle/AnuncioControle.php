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
include_once 'modelo/ValorAprovacao.php';
include_once 'modelo/ImovelDiferencial.php';
include_once 'modelo/ImovelDiferencialPlanta.php';
include_once 'modelo/Diferencial.php';
include_once 'modelo/NovoValorAnuncio.php';
include_once 'modelo/MapaImovel.php';
include_once 'modelo/MapaImovelAprovacao.php';
include_once 'modelo/FuncoesAuxiliares.php';
include_once 'assets/libs/tcpdf/tcpdf.php';

class AnuncioControle {

    function form($parametros) {
        $item = "errotoken";
        $pagina = "VisaoErrosGenerico.php";
        if (Sessao::verificarSessaoUsuario() & Sessao::verificarToken(array("hdnToken" => $parametros["token"]))) {

            if (isset($parametros["idImovel"])) {
                //modelo
                $genericoDAO = new GenericoDAO();
                $selecionarImovel = $genericoDAO->consultar(new Imovel(), true, array("id" => $parametros['idImovel'], "idUsuario" => $_SESSION['idusuario']));
                //verifica se existe o imovel selecionado
                if ($selecionarImovel) {
                    #verificar a melhor forma de tratar o blindado recursivo
                    $selecionarEndereco = $genericoDAO->consultar(new Endereco(), true, array("id" => $selecionarImovel[0]->getIdEndereco()));
                    $selecionarImovel[0]->setEndereco($selecionarEndereco[0]);

                    $selecionarDiferencial = $genericoDAO->consultar(new ImovelDiferencial(), true, array("idimovel" => $selecionarImovel[0]->getId()));
                    $selecionarImovel[0]->setImovelDiferencial($selecionarDiferencial);
                    //verificar se o anuncio ja foi publicado e redirecionar para a tela de consulta
                    $anuncios = $selecionarImovel[0]->getAnuncio();
                    if (is_array($anuncios)) {
                        foreach ($anuncios as $anuncio) {
                            if ($anuncio->getStatus() == "cadastrado") {
                                $redirecionamento = $this;
                                $redirecionamento->listarCadastrar();
                                return;
                            }
                        }
                    } else {
                        if ($anuncios->getStatus() == "cadastrado") {
                            $redirecionamento = $this;
                            $redirecionamento->listarCadastrar();
                            return;
                        }
                    }
                    $usuarioPlano = new UsuarioPlano();
                    $condicoes["idusuario"] = $_SESSION["idusuario"];
                    $condicoes["status"] = 'pago'; //status do plano
                    $listarUsuarioPlano = $genericoDAO->consultar($usuarioPlano, true, $condicoes);
                    $listarPlanos = $genericoDAO->consultar(new Plano, false, array("gratuito" => "SIM")); //somente listar o plano gratuito para escrever no combo da listagem de planos ativos
                    $sessao["idimovel"] = $selecionarImovel[0]->getId();
                    $sessao["tipoimovel"] = $selecionarImovel[0]->getIdtipoImovel();
                    Sessao::configurarSessaoAnuncio($sessao);
                    $formAnuncio = array();
                    $formAnuncio["usuarioPlano"] = $listarUsuarioPlano;
                    $formAnuncio["imovel"] = $selecionarImovel;
                    $formAnuncio["planos"] = $listarPlanos;
                    $formAnuncio["anuncio"] = ($anuncios != NULL ? $anuncios : new Anuncio());
                    $item = $formAnuncio;
                    $pagina = "AnuncioVisaoPublicar.php";
                }
            } elseif (isset($parametros["idAnuncio"])) {
                $genericoDAO = new GenericoDAO();
                //busca o anuncio com status de cadastrado
                $selecionarAnuncio = $genericoDAO->consultar(new Anuncio(), true, array("id" => $parametros['idAnuncio'], "status" => "cadastrado"));
                if ($selecionarAnuncio) {
                    //verifica se o usuario do anuncio = usuario sessao
                    $selecionarUsuarioPlano = $genericoDAO->consultar(new UsuarioPlano(), true, array("id" => $selecionarAnuncio[0]->getIdusuarioplano(), "idusuario" => $_SESSION['idusuario']));
                    if ($selecionarUsuarioPlano) {
                        //busca dados na base
                        $selecionarImovel = $genericoDAO->consultar(new Imovel(), true, array("id" => $selecionarAnuncio[0]->getIdimovel()));
                        $selecionarEndereco = $genericoDAO->consultar(new Endereco(), true, array("id" => $selecionarImovel[0]->getIdEndereco()));
                        $selecionarImovel[0]->setEndereco($selecionarEndereco[0]);
                        $selecionarDiferencial = $genericoDAO->consultar(new ImovelDiferencial(), true, array("idimovel" => $selecionarImovel[0]->getId()));
                        $selecionarImovel[0]->setImovelDiferencial($selecionarDiferencial);
                        $selecionarNovoValor = $genericoDAO->consultar(new NovoValorAnuncio(), false, array("idanuncio" => $selecionarAnuncio[0]->getId(), "status" => "ativo"));

                        //configurar sessao anuncio
                        $sessao["idimovel"] = $selecionarImovel[0]->getId();
                        $sessao["tipoimovel"] = $selecionarImovel[0]->getIdtipoImovel();
                        Sessao::configurarSessaoAnuncio($sessao);

                        //configurar sessao imagens
                        $imagemAnuncio = $selecionarAnuncio[0]->getImagem();
                        if ($imagemAnuncio) {
                            if (is_array($imagemAnuncio)) {
                                foreach ($imagemAnuncio as $imagem) {
                                    $fotos = new stdClass();
                                    $fotos->name = $imagem->getNome();
                                    $fotos->size = $imagem->getTamanho();
                                    $fotos->type = $imagem->getTipo();
                                    $fotos->legenda = "" . $imagem->getLegenda();
                                    $fotos->idImage = $imagem->getId();
                                    $fotos->url = PIPURL . "fotos/imoveis/" . $imagem->getDiretorio() . "/" . $imagem->getNome();
                                    $fotos->thumbnailUrl = PIPURL . "fotos/imoveis/" . $imagem->getDiretorio() . "/thumbnail/" . $imagem->getNome();
                                    $fotos->deleteUrl = PIPURL . "?file=" . $imagem->getNome();
                                    $fotos->deleteType = "DELETE";
                                    $fotos->id = $imagem->getid();
                                    sessao::configurarSessaoImagemAnuncio("inserir", $imagem->getNome(), $fotos);
                                }
                            } else {
                                $fotos = new stdClass();
                                $fotos->name = $imagemAnuncio->getNome();
                                $fotos->size = $imagemAnuncio->getTamanho();
                                $fotos->type = $imagemAnuncio->getTipo();
                                $fotos->legenda = "" . $imagemAnuncio->getLegenda();
                                $fotos->idImage = $imagemAnuncio->getId();
                                $fotos->url = PIPURL . "fotos/imoveis/" . $imagemAnuncio->getDiretorio() . "/" . $imagemAnuncio->getNome();
                                $fotos->thumbnailUrl = PIPURL . "fotos/imoveis/" . $imagemAnuncio->getDiretorio() . "/thumbnail/" . $imagemAnuncio->getNome();
                                $fotos->deleteUrl = PIPURL . "?file=" . $imagemAnuncio->getNome();
                                $fotos->deleteType = "DELETE";
                                $fotos->id = $imagemAnuncio->getid();
                                sessao::configurarSessaoImagemAnuncio("inserir", $imagemAnuncio->getNome(), $fotos);
                            }
                        }

                        //prepara itens para visao
                        $formAnuncio = array();
                        $tipoAnuncio = $selecionarImovel[0]->getIdtipoimovel();
                        //carrega dados no apartamento na planta
                        if ($tipoAnuncio == "2") {
                            $selecionarValoresPlanta = $genericoDAO->consultar(new Valor(), true, array("idanuncio" => $selecionarAnuncio[0]->getId()));
                            $formAnuncio["ValoresPlanta"] = $selecionarValoresPlanta;

                            #configurar sessao de apartamento na planta
                            $imagemPlantas = $selecionarImovel[0]->getPlanta();
                            if ($imagemPlantas) {
                                if (is_array($imagemPlantas)) {
                                    foreach ($imagemPlantas as $imagem) {
                                        $fotos = array();
                                        $fotos["name"] = $imagem->getImagemnome();
                                        $fotos["type"] = $imagem->getImagemtipo();
                                        $fotos["tmp_name"] = "";
                                        $fotos["error"] = 0;
                                        $fotos["size"] = $imagem->getImagemtamanho();
                                        $diretorio = $imagem->getImagemdiretorio();
                                        Sessao::configurarSessaoImagemPlanta($imagem->getOrdemplantas(), $fotos, $diretorio);
                                    }
                                } else {
                                    $fotos = new stdClass();
                                    $fotos["name"] = $imagemPlantas->getImagemnome();
                                    $fotos["type"] = $imagemPlantas->getImagemtipo();
                                    $fotos["tmp_name"] = "";
                                    $fotos["error"] = 0;
                                    $fotos["size"] = $imagemPlantas->getImagemtamanho();
                                    $diretorio = $imagemPlantas->getImagemdiretorio();
                                    Sessao::configurarSessaoImagemPlanta($imagem->getOrdemplantas(), $fotos, $diretorio);
                                }
                            }
                        }

                        $formAnuncio["usuarioPlano"] = $selecionarUsuarioPlano;
                        $formAnuncio["imovel"] = $selecionarImovel;
                        $formAnuncio["anuncio"] = $selecionarAnuncio[0];
                        $formAnuncio["novovalor"] = $selecionarNovoValor;

                        $consultasAdHoc = new ConsultasAdHoc();
                        $existeAlteracaoNaoAprovada = $consultasAdHoc->ConsultarAnunciosPendentesPorUsuario($_SESSION['idusuario'], false, array("pendenteanalise", "emanalise"), $selecionarAnuncio[0]->getIdanuncio());
                        $formAnuncio["existeAlteracaoNaoAprovada"] = count($existeAlteracaoNaoAprovada) > 0;

                        $item = $formAnuncio;
                        $pagina = "AnuncioVisaoEditar.php";
                    }
                }
            }
        }

        $visao = new Template();
        $visao->setItem($item);
        $visao->exibir($pagina);
    }

    function buscarAnuncio($parametros) {
        $funcoesAuxiliares = new FuncoesAuxiliares();
        $visao = new Template('ajax');
        $consultasAdHoc = new ConsultasAdHoc();
        $parametros["atributos"] = "*";
        $parametros["tabela"] = $parametros["tipoImovel"];
        if ($parametros["page"])
            $page = TRUE;
        unset($parametros["page"]);
        unset($parametros["tipoImovel"]);
        unset($parametros["hdnEntidade"]);
        unset($parametros["hdnAcao"]);
        if ($parametros["idbairro"] != "") {
            $parametros["idbairro"] = explode(",", $parametros["idbairro"]); //caso mais de um bairro seja escolhido
        }

        if ($parametros["id"] != "") {
            $parametros["id"] = explode(",", $parametros["id"]); //caso mais de um corretor seja escolhido
        }
        $parametros["predicados"] = $parametros;

        $listaAnuncio = $consultasAdHoc->buscaAnuncios($parametros);

        if (count($listaAnuncio['anuncio']) == 0) {
            $visao->setItem("errosemresultadobusca");
            $visao->exibir('VisaoErrosGenerico.php');
        }
        if ($page)
            $listaAnuncio["page"] = TRUE;

        $visao->setItem($listaAnuncio);
        $visao->exibir('AnuncioVisaoBusca.php');
    }

    function detalhar($parametros) {
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

        $idAnuncio = $genericoDAO->consultar(new Anuncio(), false, array("id" => $parametros["idanuncio"]));

        $idUsuarioPlano = $genericoDAO->consultar(new UsuarioPlano(), false, array("id" => $idAnuncio[0]->getIdUsuarioPlano()));

        $idUsuarioAnuncio = $genericoDAO->consultar(new Usuario(), false, array("id" => $idUsuarioPlano[0]->getIdUsuario()));

        $parametros["idUsuario"] = $idUsuarioAnuncio[0]->getId();

        $listarAnuncio = $consultasAdHoc->buscaAnuncios($parametros);

        // buscar o diretorio e o nome da foto destaque para as redes sociais
        foreach ($listarAnuncio["anuncio"][0]["imagem"] as $imagemPrincipal) {

            if ($imagemPrincipal["destaque"] == "SIM")
                $imagemPrincipalDiretorio = $imagemPrincipal["diretorio"];
            $imagemPrincipalNome = $imagemPrincipal["nome"];

            break;
        }

        if ($listarAnuncio["anuncio"][0]["status"] != "cadastrado" &&
                $parametros["sessaoUsuario"] != $parametros["idUsuario"] && $_SESSION['login'] != 'pipdiministrador') {

            $item = "errousuarioouanuncio";
            $pagina = "VisaoErrosGenerico.php";
            $visao = new Template();
            $visao->setItem($item);
            $visao->exibir($pagina);
        } else {

            $administrador = false;

            if (($_SESSION['login'] === "pipdiministrador")) {
                $administrador = true;
            }

            $usuarioQtdAnuncio = count($consultasAdHoc->ConsultarAnunciosPorUsuario($parametros["idUsuario"], $administrador, null, array('cadastrado')));

            $listarAnuncio["qtdAnuncios"] = $usuarioQtdAnuncio;

            $listarAnuncio["loginUsuario"] = $parametros["idUsuario"];

            $mensagem = $consultasAdHoc->consultar(new Mensagem(), true, array("idanuncio" => $parametros["idanuncio"]));

            $listarAnuncio["qtdMensagem"] = count($mensagem);

            $selecionarMensagem = new Mensagem();

            foreach ($mensagem as $mensagens) {
                $idMensagem = rand();
                $_SESSION["mensagem"][$idMensagem] = $mensagens->getId();
                $mensagens->setId($idMensagem);
            }

            $valores = $genericoDAO->consultar(new NovoValorAnuncio, false, array("idanuncio" => $parametros["idanuncio"]));

            foreach ($valores as $nValor) {

                $nValor = $genericoDAO->consultar(new NovoValorAnuncio(), false, array("idanuncio" => $parametros["idanuncio"]));
                $listarAnuncio["novoValor"] = $nValor;
            }

            $mapaNovo = $genericoDAO->consultar(new MapaImovel(), false, array("idanuncio" => $parametros["idanuncio"]));

            if ($mapaNovo != null) {

                $listarAnuncio["mapaImovel"] = $mapaNovo;
            }

            $numeroPlantas = count($listarAnuncio["anuncio"][0]["plantas"]);

            //trazer os diferenciais da planta
            for ($x = 0; $x < $numeroPlantas; $x++) {

                $dif[$listarAnuncio["anuncio"][0]["plantas"][$x]["id"]] = $genericoDAO->consultar(new ImovelDiferencialPlanta(), true, array("idplanta" => $listarAnuncio["anuncio"][0]["plantas"][$x]["id"]));
            }

            $listarAnuncio["difPlantas"] = $dif;

            $listarAnuncio["mensagem"] = $mensagem;

            Cookies::configurarPreferencias($listarAnuncio);
            $visao->setTag_cabecalho('
            <meta name="description" content="PIP - Procure Imóveis Pai Degua" />
            <meta name="author" content="" />
            <meta property="og:type" content="product" />
            <meta name="language" content="pt-br" />
            <meta property="og:site_name" content="PIP - Procure Imóveis Pai Degua" />
            <meta property="og:title" content="PIP Online - ' . $listarAnuncio["anuncio"][0]["tituloanuncio"] . '" />
            <meta property="og:url" content="' . PIPURL . $listarAnuncio["anuncio"][0]["idanuncioformatado"] . '" />
            <meta property="og:description" content="' . $listarAnuncio["anuncio"][0]["descricaoanuncio"] . '" />
            <meta property="og:image" content="' . PIPURL . 'fotos/imoveis/' . $imagemPrincipalDiretorio . '/' . $imagemPrincipalNome . '" />
            <meta property="og:image:type" content="image/jpeg" />
            <meta property="fb:app_id" content="966242223397117" />
            
            <meta name="twitter:card" value="summary">
            <meta name="twitter:site" content="@PIP_beta">
            <meta name="twitter:title" content="PIP Online - ' . $listarAnuncio["anuncio"][0]["tituloanuncio"] . '">
            <meta name="twitter:description" content="' . $listarAnuncio["anuncio"][0]["descricaoanuncio"] . '">
            <meta name="twitter:creator" content="@PIP_beta">
            <meta name="twitter:image" content="' . PIPURL . 'fotos/imoveis/' . $imagemPrincipalDiretorio . '/' . $imagemPrincipalNome . '">
            
            <meta itemprop="name" content="PIP Online - ' . $listarAnuncio["anuncio"][0]["tituloanuncio"] . '">
            <meta itemprop="description" content="' . $listarAnuncio["anuncio"][0]["descricaoanuncio"] . '">
            <meta itemprop="image" content="' . PIPURL . 'fotos/imoveis/' . $imagemPrincipalDiretorio . '/' . $imagemPrincipalNome . '">

            ');
            $visao->setItem($listarAnuncio);

            $visao->exibir('AnuncioVisaoDetalhe.php');
        }
    }

    function exibirAnuncioURL($parametros) {

        $genericoDAO = new GenericoDAO();

        $anuncio = $genericoDAO->consultar(new Anuncio(), true, array("idanuncio" => $parametros));
        $usuario = $genericoDAO->consultar(new Usuario(), true, array("login" => $parametros));


        if ($usuario <> NULL) {
            $this->buscarAnuncioCorretor(array("login" => $parametros)); //se o usuário existir
        }

        if ($anuncio <> NULL) { //se o anuncio existir     
            $consultasAdHoc = new ConsultasAdHoc();

            $imovel = $genericoDAO->consultar(new Imovel(), true, array("id" => $anuncio[0]->getIdImovel()));

            $this->detalhar(array("hdnTipoImovel" => $imovel[0]->getTipoimovel()->getDescricao(), "hdnCodAnuncio" => $anuncio[0]->getId()));
        } if (!$usuario && !$anuncio) { //se nem o anuncio nem o usuário existirem
            $item = "errousuarioouanuncio";
            $pagina = "VisaoErrosGenerico.php";
            $visao = new Template();
            $visao->setItem($item);
            $visao->exibir($pagina);
        }
    }

    function comparar($parametros) {

                 $genericoDAO = new GenericoDAO();
         $indice = 0;
        $idsAnuncio = $parametros['listaAnuncio'];
         unset($parametros["hdnEntidade"]);
         unset($parametros["hdnAcao"]);
         unset($parametros["tabela_length"]);
         unset($parametros["selecionarAnuncio"]);
         unset($parametros["listaAnuncio"]);
         unset($parametros["hdnCodAnuncio"]);
         unset($parametros["hdnTipoImovel"]);
         unset($parametros["hdnCodAnuncioFormatado"]);

         foreach ($idsAnuncio as $idanuncio) {
            $item["anuncio"] = $genericoDAO->consultar(new Anuncio(), false, array("idanuncio" => $idanuncio));
            $idFormatado = $item["anuncio"][0]->getId();
             $item["imovel"] = $genericoDAO->consultar(new Imovel(), true, array("id" => $item["anuncio"][0]->getIdimovel()));
                                   
             $descricaoTipoImovel = $item["imovel"][0]->getTipoimovel()->getDescricao();
   
             $consultasAdHoc = new ConsultasAdHoc();
             $parametros["tabela"] = $descricaoTipoImovel;
             $parametros["atributos"] = "*";
            $parametros["predicados"] = array("idanuncio" => $idFormatado);
                        
             $anuncio = $consultasAdHoc->buscaAnuncios($parametros);

             $listarAnuncio[$indice] = $anuncio['anuncio'][0];

             $parametros = "";
 
             $indice++;
         }
            
         $visao = new Template();
         $visao->setItem($listarAnuncio);
         $visao->exibir('AnuncioVisaoComparar.php');

    }

    function listarCadastrar() {
        if (Sessao::verificarSessaoUsuario()) {
            $consultasAdHoc = new ConsultasAdHoc();
            $listaIdsImoveis = $consultasAdHoc->ConsultarImoveisNaoAnunciadosPorUsuario($_SESSION['idusuario']);
            #verificar a melhor forma de tratar o blindado recursivo
            foreach ($listaIdsImoveis as $id) {
                $imovel = $consultasAdHoc->consultar(new Imovel(), true, array("id" => $id["id"]));
                $selecionarImovel = $imovel[0];

                $selecionarEndereco = $consultasAdHoc->consultar(new Endereco(), true, array("id" => $selecionarImovel->getIdEndereco()));
                $selecionarImovel->setEndereco($selecionarEndereco[0]);

                $selecionarPlanta = $consultasAdHoc->consultar(new Planta(), true, array("idimovel" => $selecionarImovel->getId()));
                $selecionarImovel->setPlanta($selecionarPlanta);

                $selecionarDiferencial = $consultasAdHoc->consultar(new ImovelDiferencial(), true, array("idimovel" => $selecionarImovel->getId()));
                $selecionarImovel->setImovelDiferencial($selecionarDiferencial);

                $listarImovel[] = $selecionarImovel;
            }
            //visao
            $visao = new Template();
            $visao->setItem($listarImovel);
            $visao->exibir('AnuncioVisaoListagemCadastrar.php');
        }
    }

    function listarAtivo() {
        if (Sessao::verificarSessaoUsuario()) {
            $anuncio = new Anuncio();
            $genericoDAO = new GenericoDAO();
            $consultasAdHoc = new ConsultasAdHoc();

            $listaAnuncio = $consultasAdHoc->ConsultarAnunciosPorUsuario($_SESSION['idusuario'], null, null, array('cadastrado'));
            foreach ($listaAnuncio as $anuncio) {
                $imovel = $genericoDAO->consultar(new Imovel(), false, array("id" => $anuncio->getIdImovel()));
                $anuncio->setImovel($imovel[0]);

                $usuarioplano = $genericoDAO->consultar(new UsuarioPlano(), true, array("id" => $anuncio->getIdusuarioplano()));
                $anuncio->setUsuarioplano($usuarioplano[0]);

                $novoValor = $genericoDAO->consultar(new NovoValorAnuncio(), false, array("idanuncio" => $anuncio->getId()));
                $anuncio->setNovovaloranuncio($novoValor);

                $listarAnuncios[] = $anuncio;
            }

            $visao = new Template();
            $item["listaAnuncio"] = $listarAnuncios;
            $visao->setItem($item);
            $visao->exibir('AnuncioVisaoListagem.php');
        }
    }

    function listarFinalizado() {

        if (Sessao::verificarSessaoUsuario()) {
            $anuncio = new Anuncio();
            $genericoDAO = new GenericoDAO();
            $consultasAdHoc = new ConsultasAdHoc();

            $listaAnuncio = $consultasAdHoc->ConsultarAnunciosPorUsuario($_SESSION['idusuario'], null, null, array('finalizado'));
            foreach ($listaAnuncio as $anuncio) {

                $imovel = $genericoDAO->consultar(new Imovel(), true, array("id" => $anuncio->getIdImovel()));
                $anuncio->setImovel($imovel[0]);
                $historico = $genericoDAO->consultar(new HistoricoAluguelVenda(), false, array("idanuncio" => $anuncio->getId()));
                $anuncio->setHistoricoaluguelvenda($historico[0]);
                //valores alterados
                $valorAlterado = $genericoDAO->consultar(new NovoValorAnuncio, false, array("idanuncio" => $anuncio->getId(), "status" => "ativo"));
                $anuncio->setNovovaloranuncio($valorAlterado[0]);
                //fim dos valores alterados
                $listarAnuncios[] = $anuncio;
            }

            $listaAnuncioExpirado = $consultasAdHoc->ConsultarAnunciosPorUsuario($_SESSION['idusuario'], null, array('expirado'));
            foreach ($listaAnuncioExpirado as $anuncio) {

                $expirado = $genericoDAO->consultar(new Imovel(), true, array("id" => $anuncio->getIdImovel()));

                $anuncio->setImovel($expirado[0]);
                $listarAnunciosExpirados[] = $anuncio;
            }

            //visao
            $visao = new Template();
            $item["listaAnuncioFinalizado"] = $listarAnuncios;
            $item["listaAnuncioExpirado"] = $listarAnunciosExpirados;
            $visao->setItem($item);
            $visao->exibir('AnuncioVisaoListagemFinalizado.php');
        }
    }

    function cadastrar($parametros) {

        if (Sessao::verificarSessaoUsuario()) {

            if (isset($parametros['upload']) & $parametros['upload'] === "1") {
                include_once 'controle/ImagemControle.php';
                $imagem = new ImagemControle($parametros);
            } else {
                $genericoDAO = new GenericoDAO();
                //INICIA TRANSACAO
                $genericoDAO->iniciarTransacao();
                $entidadeUsuarioPlano = new UsuarioPlano();

                //verifica se o plano eh gratuito
                if ($parametros["sltPlano"] == "gratuito") {
                    //consultar se ja existe algum plano gratuito que seja pago (administrador negou)
                    $verificarPlanoGratuito = $genericoDAO->consultar($entidadeUsuarioPlano, false, array("status" => "pago", "idplano" => 5, "idusuario" => $_SESSION["idusuario"]));
                    //se nao tem cadastra um novo
                    if (empty($verificarPlanoGratuito)) {
                        $entidadeUsuarioPlano->cadastrar(5);
                        $entidadeUsuarioPlano->setStatus("pago");
                        $genericoDAO->cadastrar($entidadeUsuarioPlano);
                        $verificarPlanoGratuito = $genericoDAO->consultar($entidadeUsuarioPlano, false, array("status" => "pago", "idplano" => 5, "idusuario" => $_SESSION["idusuario"]));
                    }
                    //busca o usuarioplano na base
                    $entidadeUsuarioPlano = $verificarPlanoGratuito[0];

                    //fim do gratuito
                } else {

                    $entidadeUsuarioPlano = $genericoDAO->consultar(new UsuarioPlano(), true, array("id" => $parametros["sltPlano"]));
                    $entidadeUsuarioPlano = $entidadeUsuarioPlano[0];
                }

                if (Sessao::verificarToken($parametros) && $entidadeUsuarioPlano->permitidoCadastrar()) {


                    //ATUALIZA O PLANO UTILIZADO
                    $entidadeUsuarioPlano->setStatus("utilizado");
                    $genericoDAO->editar($entidadeUsuarioPlano);


                    //inicio se o plano for gratuito
                    //CRIA INSTANCIA ANUNCIO
                    $anuncio = new AnuncioAprovacao();
                    $entidadeAnuncio = $anuncio->cadastrar($parametros);

                    //fazer atualização do idusuarioplano para o plano gratuito recém criado.
                    if ($parametros["sltPlano"] == "gratuito") {
                        $entidadeAnuncio->setIdusuarioplano($entidadeUsuarioPlano->getId());
                        //var_dump($entidadeAnuncio);
                    }

                    $this->verificaValorMinimo($entidadeAnuncio, $parametros);

                    //SALVA ANUNCIO
                    $idAnuncioAprovacao = $genericoDAO->cadastrar($entidadeAnuncio);
                    //die();
                    //VERIFICA O TIPO DO IMOVEL
                    //se for apartamento na planta
                    if ($_SESSION["anuncio"]["tipoimovel"] == 2) {
                        $entidadeValor = new ValorAprovacao();
                        $entidadeValor->setIdanuncioaprovacao($idAnuncioAprovacao);
                        //traz todas as plantas
                        $todasPlantas = $genericoDAO->consultar(new Imovel(), true, array("id" => $_SESSION["anuncio"]["idimovel"]));
                        $todasPlantas = $todasPlantas[0]->getPlanta();
                        if (is_object($todasPlantas))
                            $todasPlantas = array($todasPlantas);
                        //itera para cada planta
                        foreach ($todasPlantas as $planta) {
                            $entidadeValor->setIdplanta($planta->getId());
                            //monta os parametros que vem do formulario
                            $parametroAndarInicial = "hdnAndarInicial" . $planta->getOrdemplantas();
                            $parametroAndarFinal = "hdnAndarFinal" . $planta->getOrdemplantas();
                            $parametroValor = "hdnValor" . $planta->getOrdemplantas();

                            //verifica se tem algum valor informado para cada planta
                            if (isset($parametros[$parametroAndarInicial])) {

                                //itera pela quantidade de registros por planta
                                for ($i = 0; $i <= count($parametros[$parametroAndarInicial]) - 1; $i++) {
                                    $entidadeValorCadastrar = $entidadeValor;
                                    $entidadeValorCadastrar->setAndarinicial($parametros[$parametroAndarInicial][$i]);
                                    $entidadeValorCadastrar->setAndarFinal($parametros[$parametroAndarFinal][$i]);
                                    $entidadeValorCadastrar->setValor($parametros[$parametroValor][$i]);
                                    $genericoDAO->cadastrar($entidadeValorCadastrar);
                                }
                            }

                            //imagens das plantas
                            $sessaoImagemPlanta = $_SESSION["imagemPlanta"][$planta->getOrdemplantas()];
                            if (isset($sessaoImagemPlanta)) {
                                $planta->setImagemaprovacaodiretorio($sessaoImagemPlanta["diretorio"]);
                                $planta->setImagemaprovacaonome($sessaoImagemPlanta["name"]);
                                $planta->setImagemaprovacaotamanho($sessaoImagemPlanta["size"]);
                                $planta->setImagemaprovacaotipo($sessaoImagemPlanta["type"]);
                                $genericoDAO->editar($planta);
                            }
                        }
                    }

                    //somente salva fotos se houver
                    if (isset($_SESSION["imagemAnuncio"])) {
                        //gravara apenas a qtd permitida para o plano selecionado
                        $planoSelecionado = $genericoDAO->consultar(new Plano(), true, array("id" => $entidadeUsuarioPlano->getIdplano()));
                        $planoSelecionado = $planoSelecionado[0];
                        $maximoDeImagensPermitidas = $planoSelecionado->getMaximoimagens();
                        $contadorImagens = 0;
                        foreach ($_SESSION["imagemAnuncio"] as $file) {
                            $entidadeImagem = new ImagemAprovacao();
                            $entidadeImagem->cadastrar($file, $idAnuncioAprovacao, $parametros["rdbDestaque"]);
                            $genericoDAO->cadastrar($entidadeImagem);
                            $contadorImagens++;
                            if ($contadorImagens > $maximoDeImagensPermitidas) {
                                break;
                            }
                        }
                    }

                    //cadastro da latitude e longitude se houver alteração no mapa
                    if ($parametros["hdnLatitude"] != "" && $parametros["hdnLongitude"] != "") {
                        $entidadeMapaImovel = new MapaImovelAprovacao();
                        $entidadeMapaImovel->cadastrar($parametros, $idAnuncioAprovacao);
                        $genericoDAO->cadastrar($entidadeMapaImovel);
                    }

                    if ($idAnuncioAprovacao) {
                        //COMMIT!
                        $genericoDAO->commit();
                        $genericoDAO->fecharConexao();
                        //dados do anúncio para serem enviados via ajax, após a publicação
                        $tipoImovel = new TipoImovel();
                        $retornaTipoImovel = $tipoImovel->retornaDescricaoTipo($_SESSION["anuncio"]["tipoimovel"]);
                        //LIMPA AS SESSOES
                        Sessao::desconfigurarVariavelSessao("anuncio");
                        Sessao::desconfigurarVariavelSessao("imagemAnuncio");
                        Sessao::desconfigurarVariavelSessao("imagemPlanta");
                        //RETORNA SUCESSO
                        echo json_encode(array("resultado" => 1, "idanuncio" => $entidadeAnuncio->getIdAnuncio(), "id" => $idAnuncioAprovacao, "tipoImovel" => $retornaTipoImovel));
                    } else {
                        //ROLLBACK!
                        $genericoDAO->rollback();
                        //RETORNA ERRO
                        echo json_encode(array("resultado" => 0));
                    }
                } else {
                    //ROLLBACK!
                    $genericoDAO->rollback();
                    //RETORNA ERRO
                    echo json_encode(array("resultado" => 0));
                }
            }
        }
    }

    function editar($parametros) {
        if (Sessao::verificarSessaoUsuario()) {
            if (isset($parametros['upload']) & $parametros['upload'] === "1") {
                include_once 'controle/ImagemControle.php';
                $imagem = new ImagemControle($parametros);
            } else {
                if (Sessao::verificarToken($parametros)) {
                    //INICIA TRANSACAO
                    $genericoDAO = new GenericoDAO();
                    $genericoDAO->iniciarTransacao();

                    //CRIA INSTANCIA ANUNCIO
                    $anuncio = new AnuncioAprovacao();
                    $entidadeAnuncio = $anuncio->cadastrar($parametros);
                    $this->verificaValorMinimo($entidadeAnuncio, $parametros);
                    //BUSCA O MESMO IDANUNCIO
                    $selecionarAnuncio = $genericoDAO->consultar(new Anuncio(), true, array("idimovel" => $_SESSION["anuncio"]["idimovel"], "status" => "cadastrado"));
                    $entidadeAnuncio->setIdanuncio($selecionarAnuncio[0]->getIdanuncio());

                    //SALVA ANUNCIO
                    $idAnuncio = $genericoDAO->cadastrar($entidadeAnuncio);

                    //se for apartamento na planta
                    if ($_SESSION["anuncio"]["tipoimovel"] == 2) {
                        //cria instacia valoraprovacao
                        $valor = new ValorAprovacao();
                        $valor->setIdanuncioaprovacao($idAnuncio);
                        //traz todas as plantas
                        $plantas = $genericoDAO->consultar(new Imovel(), true, array("id" => $_SESSION["anuncio"]["idimovel"]));
                        $plantas = $plantas[0]->getPlanta();
                        if (is_object($plantas))
                            $plantas = array($plantas);
                        //itera para cada planta
                        //criar vetor para guardar os valores de cada planta
                        $vetorValor = array();

                        foreach ($plantas as $planta) {
                            $valor->setIdplanta($planta->getId());
                            //monta os parametros que vem do formulario
                            $parametroAndarInicial = "hdnAndarInicial" . $planta->getOrdemplantas();
                            $parametroAndarFinal = "hdnAndarFinal" . $planta->getOrdemplantas();
                            $parametroValor = "hdnValor" . $planta->getOrdemplantas();

                            //verifica se tem algum valor informado para cada planta
                            if (isset($parametros[$parametroAndarInicial])) {
                                //itera pela quantidade de registros por planta
                                for ($i = 0; $i <= count($parametros[$parametroAndarInicial]) - 1; $i++) {
                                    $entidadeValor = $valor;
                                    $entidadeValor->setAndarinicial($parametros[$parametroAndarInicial][$i]);
                                    $entidadeValor->setAndarFinal($parametros[$parametroAndarFinal][$i]);
                                    $entidadeValor->setValor($parametros[$parametroValor][$i]);
                                    $genericoDAO->cadastrar($entidadeValor);
                                }
                            }

                            //imagens das plantas DEV OK TESTAR
                            if (isset($_SESSION["imagemPlanta"][$planta->getOrdemplantas()])) {
                                $sessaoImagemPlanta = $_SESSION["imagemPlanta"][$planta->getOrdemplantas()];
                                if (isset($sessaoImagemPlanta) && $sessaoImagemPlanta["tmp_name"] != "") {
                                    $planta->setImagemaprovacaodiretorio($sessaoImagemPlanta["diretorio"]);
                                    $planta->setImagemaprovacaonome($sessaoImagemPlanta["name"]);
                                    $planta->setImagemaprovacaotamanho($sessaoImagemPlanta["size"]);
                                    $planta->setImagemaprovacaotipo($sessaoImagemPlanta["type"]);
                                    $genericoDAO->editar($planta);
                                }
                            } else {
                                //'exclui' imagem planta se nao houver na sessao
                                $planta->setImagemaprovacaodiretorio("");
                                $planta->setImagemaprovacaonome("");
                                $planta->setImagemaprovacaotamanho("");
                                $planta->setImagemaprovacaotipo("");
                                $genericoDAO->editar($planta);
                            }
                        }
                    }

                    //somente salva fotos se houver
                    if (isset($_SESSION["imagemAnuncio"])) {
                        //gravara apenas a qtd permitida para o plano selecionado
                        $entidadeUsuarioPlano = $genericoDAO->consultar(new UsuarioPlano(), true, array("id" => $parametros["sltPlano"]));
                        $entidadeUsuarioPlano = $entidadeUsuarioPlano[0];
                        $planoSelecionado = $genericoDAO->consultar(new Plano(), true, array("id" => $entidadeUsuarioPlano->getIdplano()));
                        $planoSelecionado = $planoSelecionado[0];
                        $maximoDeImagensPermitidas = $planoSelecionado->getMaximoimagens();
                        $contadorImagens = 0;
                        foreach ($_SESSION["imagemAnuncio"] as $file) {
                            $entidadeImagem = new ImagemAprovacao();
                            $entidadeImagem->cadastrar($file, $idAnuncio, $parametros["rdbDestaque"]);
                            $genericoDAO->cadastrar($entidadeImagem);
                            $contadorImagens++;
                            if ($contadorImagens > $maximoDeImagensPermitidas) {
                                break;
                            }
                        }
                    }

                    //cadastro da latitude e longitude se houver alteração no mapa
                    if ($parametros["hdnLatitude"] != "" && $parametros["hdnLongitude"] != "") {
                        $entidadeMapaImovel = new MapaImovelAprovacao();
                        $entidadeMapaImovel->cadastrar($parametros, $idAnuncio);
                        $genericoDAO->cadastrar($entidadeMapaImovel);
                    }

                    try {
                        //COMMIT!
                        $genericoDAO->commit();
                        $genericoDAO->fecharConexao();
                        //dados do anúncio para serem enviados via ajax, após a publicação
                        $tipoImovel = new TipoImovel();
                        $retornaTipoImovel = $tipoImovel->retornaDescricaoTipo($_SESSION["anuncio"]["tipoimovel"]);
                        //LIMPA AS SESSOES
                        Sessao::desconfigurarVariavelSessao("anuncio");
                        Sessao::desconfigurarVariavelSessao("imagemAnuncio");
                        Sessao::desconfigurarVariavelSessao("imagemPlanta");
                        //RETORNA SUCESSO
                        echo json_encode(array("resultado" => 1, "idanuncio" => $entidadeAnuncio->getIdAnuncio(), "id" => $idAnuncio, "tipoImovel" => $retornaTipoImovel));
                    } catch (Exception $exc) {
                        //ROLLBACK!
                        $genericoDAO->rollback();
                        //RETORNA ERRO
                        echo json_encode(array("resultado" => 0));
                    }
                }
            }
        }
    }

    function cadastrarAnuncioImagemPlanta($parametros) {
        $sucesso = 1;
        $resposta = "";
        //verifica o token
        if (Sessao::verificarToken($parametros)) {
            $ordem = $parametros["ordem"];
            $imagem = $_FILES["attachmentName" . $ordem];
            //pega o mesmo diretorio das imagens. ver em ImagemControle()->get_user_id()
            $user_dir = strrev(str_pad($_SESSION["idusuario"], 5, "0", STR_PAD_LEFT)) . "P" . hash("crc32", stripslashes(session_id()));
            $target_dir = PIPROOT . "/fotos/plantas/" . $user_dir . "/"; //retorna o idusuario + hash
            $target_file = $target_dir . basename($imagem["name"]);

            //inicio das validações
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            //verifica tipo de arquivo
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $sucesso = 0;
                $resposta = "ERRO: somente os tipos JPG, JPEG, PNG e GIF são permitidos. O arquivo enviado foi do tipo " . $imageFileType;
            } else {
                //verifica se é uma imagem
                $check = getimagesize($imagem["tmp_name"]);
                if ($check !== false) {
                    //verifica se o arquivo já existe
                    //if (file_exists($target_file)) {
                    //    $sucesso = 0;
                    //    $resposta = "ERRO: um arquivo com este nome já foi enviado";
                    //} else {
                    //verifica o tamanho do arquivo
                    if ($imagem["size"] > 3000000) {
                        $sucesso = 0;
                        $resposta = "ERRO: o arquivo é muito grande. O tamanho máximo permitido é 3MB";
                    } else {
                        //verifica se a pasta tem mais de 200 arquivos
                        $arquivosNaPasta = scandir($target_dir);
                        if (count($arquivosNaPasta) > 200) {
                            $sucesso = 0;
                            $resposta = "ERRO (200): houve um problema ao carregar a sua imagem";
                        } else {
                            mkdir($target_dir, 0700);
                            if (move_uploaded_file($imagem["tmp_name"], $target_file)) {
                                $resposta = "Imagem da Planta " . $ordem . " (" . basename($imagem["name"]) . ") foi carregado com sucesso";
                            } else {
                                $sucesso = 0;
                                $resposta = "ERRO (UPLOAD): houve um problema ao carregar a sua imagem";
                            }
                        }
                    }
                    //}
                } else {
                    $sucesso = 0;
                    $resposta = "O arquivo enviado não é uma imagem";
                }
            }
        } else {
            $sucesso = 0;
            $resposta = "Ops! Não podemos processar sua requisição. Tente novamente.";
        }
        if ($sucesso === 1) {
            Sessao::configurarSessaoImagemPlanta($ordem, $imagem, $user_dir);
        } else {
            Sessao::desconfigurarSessaoImagemPlanta($ordem);
        }
        echo json_encode(array("resultado" => $sucesso, "retorno" => $resposta));
        //echo "<pre>";
        //print_r($_SESSION["imagemPlanta"]);
        exit();
    }

    function apagarImagemPlanta($parametros) {
        //verifica o token
        if (Sessao::verificarToken($parametros)) {
            Sessao::desconfigurarSessaoImagemPlanta($parametros["ordem"]);
        }
        exit();
    }

    private function verificaValorMinimo($anuncio, $parametros) {

        $valorMinimo = 0;

        if (isset($parametros["chkValor"])) {
            $valorMinimo = $this->limpaValor($parametros["txtValor"]);
        } elseif ($_SESSION["anuncio"]["tipoimovel"] == 2) {
            //apartamento na planta

            $plantas = array("hdnValor0", "hdnValor1", "hdnValor2", "hdnValor3", "hdnValor4", "hdnValor5");
            $menor = array();

            foreach ($plantas as $planta) {
                if (isset($parametros[$planta])) {
                    $minimo = $this->limpaValor(min($parametros[$planta]));
                    if ((float) $minimo > 0) {
                        $menor[] = $minimo;
                    }
                }
            }
            if (min($menor) > 0) {
                $valorMinimo = min($menor);
            }
        }
        $anuncio->setValormin($valorMinimo);
    }

    private function limpaValor($valor) {
        $valor = str_replace("R$", "", $valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", ".", $valor);
        $valor = trim($valor);
        return $valor;
    }

    function buscarAnuncioCorretor($parametros) {

        $visao = new Template();
        $emailanuncio = new EmailAnuncio();
        $usuario = new Usuario();
        $genericoDAO = new GenericoDAO();



        $selecionarAnuncioUsuario = $genericoDAO->consultar($usuario, true, array("login" => $parametros["login"]));
        //var_dump($selecionarAnuncioUsuario); die();
        //var_dump($selecionarAnuncioUsuario); die();
        //if ($selecionarAnuncioUsuario == null) {
        //    $selecionarAnuncioUsuario = $genericoDAO->consultar($usuario, true, array("login" => $parametros["login"]));
        //var_dump($selecionarAnuncioUsuario);
        //echo "NULO"; die();
        //}

        if (!$selecionarAnuncioUsuario) {
            //verifica se o usuario existe na base ou se está inativo
            $visao->setItem("errousuarioinativo");
            $visao->exibir('VisaoErrosGenerico.php');
        } else {
            //$item["usuario"] = $genericoDAO->consultar(new Usuario(), false, array("id" => $selecionarAnuncioUsuario[0]->getId()));
            //var_dump($selecionarAnuncioUsuario); die();
            //$statusUsuario = $item["usuario"] = $genericoDAO->consultar(new Usuario(), false, array("id" => $selecionarAnuncioUsuario[0]->getId()));
            $verificarStatus = $selecionarAnuncioUsuario[0]->getStatus();

            //var_dump($item["usuario"]); die();
            //$verificarStatus = $statusUsuario[0]->getStatus();
            $id = $selecionarAnuncioUsuario[0]->getId();

            if ($verificarStatus == 'ativo') {

                /* $consultasAdHoc = new ConsultasAdHoc();
                  $parametrosBusca["atributos"] = "*";
                  $parametrosBusca["tabela"] = "todos";
                  $parametrosBusca["predicados"]["id"] = $id; //Id do corretor.
                  $parametrosBusca["predicados"]["garagem"] = "false"; */

                $visao = new Template();
                $item["usuario"] = $genericoDAO->consultar(new Usuario(), true, array("id" => $selecionarAnuncioUsuario[0]->getId()));
                $item["cidadeEstado"] = $genericoDAO->consultar(new Endereco(), true, array("id" => $selecionarAnuncioUsuario[0]->getIdEndereco()));
                //$item["anuncio"] = $consultasAdHoc->buscaAnuncios($parametrosBusca);

                $visao->setItem($item);
                $visao->exibir('AnuncioVisaoUsuario.php');
            } else if ($verificarStatus == 'desativadousuario') { // caso o usuário tenha desabilitado-se
                $visao->setItem($item = "usuariodesabilitado");
                $visao->exibir('VisaoErrosGenerico.php');
            }
        }
    }

    function enviarEmail($parametros) {

        //array criada para retirar os valores "SIM" que estão sendo passados
        $selecionadosCorrigidos = array();

        foreach ($parametros['listaAnuncio'] as $idsAnun) {

            if ($idsAnun != "SIM") {
                $selecionadosCorrigidos[] = $idsAnun;
            }
        }

        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();

        $dadosEmail['destino'] = $parametros['txtEmailEmail'];
        $dadosEmail['contato'] = "PIP-Online";
        $dadosEmail['assunto'] = "PIP-Online - Selecionou imóvel(is) para você";

        //$totalAunciosSelecionados = count($parametros['anunciosSelecionados']);
        $totalAunciosSelecionados = count($selecionadosCorrigidos);

        if ($parametros['txtNomeEmail'] != "") {

            if ($totalAunciosSelecionados > 1) {

                $emailEnviadoPor = 'Veja os imóveis indicados para você por ' . $parametros['txtNomeEmail'] . ':<br><br>';
            } else
                $emailEnviadoPor = 'Veja o imóvel indicado para você por ' . $parametros['txtNomeEmail'] . ':<br><br>';
        } else {

            if ($totalAunciosSelecionados > 1) {

                $emailEnviadoPor = 'Veja os imóveis indicados para você:';
            } else
                $emailEnviadoPor = 'Veja o imóvel indicados para você:';
        }

        if ($parametros['txtMsgEmail'] != "") {
            $mensagemEmail = '<li>Mensagem: ' . $parametros['txtMsgEmail'] . "</li><br><br>";
        } else
            $mensagemEmail = "";

        //Utilizado se for envio de e-mail para o correto através da tela de detalhes 
        if ($parametros['hdnAnuncio']) {
            $parametros['anunciosSelecionados'] = array($parametros['hdnAnuncio']);
        }

        if ($totalAunciosSelecionados > 1) {

            $textoSelecionados = "Imóveis selecionados através do PIP Online";
        } else
            $textoSelecionados = "Imóvel selecionado através do PIP Online";;

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
                      " . $mensagemEmail . "
                    </td>
                    </tr>
                    <tr>
                      <td colspan = '2' class='container-padding header' align='left' style='font-family:Helvetica, Arial, sans-serif;font-size:24px;font-weight:bold;padding-bottom:12px;color:#DF4726;padding-left:24px;padding-right:24px'>
                        " . $totalAunciosSelecionados . " " . $textoSelecionados . "
                      </td>
                    </tr>";

        $contador = 1;

        //foreach ($parametros['anunciosSelecionados'] as $idanuncio) {
        foreach ($selecionadosCorrigidos as $idanuncio) {

            $item["anuncio"] = $genericoDAO->consultar(new Anuncio(), true, array("idanuncio" => $idanuncio));

            $item["imovel"] = $genericoDAO->consultar(new Imovel(), true, array("id" => $item["anuncio"][0]->getIdImovel()));

            $item["imagem"] = $genericoDAO->consultar(new Imagem(), true, array("idanuncio" => $item["anuncio"][0]->getId(), "destaque" => "SIM"));

            if (count($item["imagem"]) > 0) {
                $imagemEmailAnuncio = PIPURL . "/fotos/imoveis/" . $item["imagem"][0]->getDiretorio() . "/" . $item["imagem"][0]->getNome();
            } else {
                $imagemEmailAnuncio = PIPURL . "/assets/imagens/foto_padrao.png";
            }

            switch ($item["imovel"][0]->getTipoImovel()->getDescricao()) {
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

            if ($item["anuncio"][0]->getValorMin() != 0) {
                $valorAnuncioEmail = $item["anuncio"][0]->getValorMin();
            } else
                $valorAnuncioEmail = "<font color='red'>Não Informado</font>";

            $item["endereco"] = $genericoDAO->consultar(new Endereco(), true, array("id" => $item["imovel"][0]->getIdEndereco()));

            $emailanuncio = new EmailAnuncio();

            $selecionaremailanuncio = $emailanuncio->cadastrar($item["anuncio"][0]->getId());

            $idemailanuncio = $genericoDAO->cadastrar($selecionaremailanuncio);

            $dadosEmail['msg'] .= "              
            <tr>
                
                <td class='container-padding content' align='left' 
                style='padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;
                background-color:#ffffff'>
                <img height='130' width='130' src='" . $imagemEmailAnuncio . "' style='outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; width: auto; max-width: 100%; float: left; clear: both; display: block;' align='left' />
                </td>

                <td class='container-padding content' align='left' 
                style='padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;
                background-color:#ffffff'>

                <br>

                <div class='title' style='font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:600;color:#374550'>" . $contador . " - " . $tipoImovelEmail . "</div>
                <br>

                <div class='body-text' style='font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#333333'>
                    Finalidade: " . ucfirst($item["anuncio"][0]->getFinalidade()) . "<br> 
                    Condição: " . ucfirst($item["imovel"][0]->getCondicao()) . "<br>
                    Valor(R$): " . $valorAnuncioEmail . "<br>
                    Endereço: " . $item["endereco"][0]->getLogradouro() . ', Nº ' . $item["endereco"][0]->getNumero() . ' - ' . $item["endereco"][0]->getBairro()->getNome() . ', ' . $item["endereco"][0]->getCidade()->getNome() . "<br>
                    <br><br>

                  Para mais informações sobre este anúncio, clique 
                  <a class='btn' href= " . PIPURL . "index.php?entidade=Anuncio&amp;acao=verficahashemail&amp;id=" . $selecionaremailanuncio->getHash() . ">AQUI</a>
                  <br><br>
                </div>

                </td>
            </tr>";

            $contador = $contador + 1;
        }

        $dadosEmail['msg'] .= "
                                <tr>
                                <td colspan = '2' class='container-padding footer-text' align='left' 
                                style='font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:16px;color:#000000;
                                padding-left:24px;padding-right:24px'>
                                <br><br>
                                <font style='text-decoration: underline;'>ATENÇÃO: Este é um email automático. Favor, não responder</font>
                                <br><br>

                                <strong>PIP On-Line 2017. Todos os Direitos Reservados</strong><br>

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
            $genericoDAO->commit();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 1));
        } else {
            $genericoDAO->rollback();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 0));
        }
    }

    function enviarEmailPDF($parametros) {

        $selecionadosCorrigidos = array();

        foreach ($parametros['listaAnuncio'] as $idsAnun) {

            if ($idsAnun != "SIM") {
                $selecionadosCorrigidos[] = $idsAnun;
            }
        }

        //var_dump($selecionadosCorrigidos); die();

        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();
        $dadosEmail['destino'] = $parametros['txtEmailEmail'];
        $dadosEmail['contato'] = "PIP-Online";
        $dadosEmail['assunto'] = "PIP-Online - Selecionou imóvel(is) para você";

        $dadosEmail['msg'] .= 'Veja o(s) imóvel(is) indicados para você por ' . $_SESSION['nome'] . ':<br><br>';

        $dadosEmail['msg'] .= 'Mensagem: ' . $parametros['txtMsgEmail'] . "<br><br>";

        //Utilizado se for envio de e-mail para o corretor através da tela de detalhes 
        /* if (isset($parametros['chkAnuncio'])) {
          $parametros['anunciosSelecionados'] = array($parametros['chkAnuncio']);

          } */

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetAuthor('PIP ONLINE');

        $pdf->SetHeaderData("", "", "PIP ON-LINE", "PIP ON-LINE - Imóveis Fáceis", array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->setFontSubsetting(true);

        $pdf->SetFont('times', '', 14, '', true);

        $pdf->AddPage();

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2,
            'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        $pdf->setFontSubsetting(true);

        $imovel = new Imovel();

        $contadorPaginas = 0;

        //$numeroAnuncios = count($parametros['anunciosSelecionados']);
        $numeroAnuncios = count($selecionadosCorrigidos);

        //foreach ($parametros['anunciosSelecionados'] as $idanuncio) {
        foreach ($selecionadosCorrigidos as $idanuncio) {

            $contadorPaginas = $contadorPaginas + 1;

            $item["anuncio"] = $genericoDAO->consultar(new Anuncio(), true, array("idanuncio" => $idanuncio));

            $item["imovel"] = $genericoDAO->consultar(new Imovel(), true, array("id" => $item["anuncio"][0]->getIdImovel()));

            $item["endereco"] = $genericoDAO->consultar(new Endereco(), true, array("id" => $item["imovel"][0]->getIdEndereco()));

            $item["imagem"] = $genericoDAO->consultar(new Imagem(), true, array("idanuncio" => $item["anuncio"][0]->getId(), "destaque" => "SIM"));

            $emailanuncio = new EmailAnuncio();

            $selecionaremailanuncio = $emailanuncio->cadastrar($item["anuncio"][0]->getId());

            $idemailanuncio = $genericoDAO->cadastrar($selecionaremailanuncio);

            $html = "Código: " . $item["anuncio"][0]->getIdAnuncio()
                    . "<br>Tipo: " . $imovel->tipoImovelRetornar($item["imovel"][0]->getIdTipoImovel())
                    . "<br>" . "Finalidade: " . $item["anuncio"][0]->getFinalidade();

            if ($item["imovel"][0]->getCondicao() != "nenhuma") {
                $html = $html . "<br>Condição: " . ucfirst($item["imovel"][0]->getCondicao() . "<br>");
            } else
                $html = $html . "<br>";

            if ($item["imovel"][0]->getCasa() != null) {
                $html = $html . "Quarto(s): " . $item["imovel"][0]->getCasa()->getQuarto() . "<br>"
                        . "Banheiro(s): " . $item["imovel"][0]->getCasa()->getBanheiro() . "<br>"
                        . "Suite(s): " . $item["imovel"][0]->getCasa()->getSuite() . "<br>"
                        . "Vaga(s) de Garagem: " . $item["imovel"][0]->getCasa()->getGaragem() . "<br>"
                        . "Área: " . $item["imovel"][0]->getCasa()->getArea() . " m<sup>2</sup><br>";
            } else if ($item["imovel"][0]->getSalaComercial() != null) {
                $html = $html . "Banheiro(s): "
                        . $item["imovel"][0]->getSalaComercial()->getBanheiro() . "<br>Vaga(s) de Garagem: "
                        . $item["imovel"][0]->getSalaComercial()->getGaragem() . "<br><br>";
            } else if ($item["imovel"][0]->getApartamento() != null) {
                $html = $html . "Quarto(s): " . $item["imovel"][0]->getApartamento()->getQuarto() . "<br>"
                        . "Banheiro(s): " . $item["imovel"][0]->getApartamento()->getBanheiro() . "<br>"
                        . "Suite(s): " . $item["imovel"][0]->getApartamento()->getSuite() . "<br>"
                        . "Vaga(s) de Garagem: " . $item["imovel"][0]->getApartamento()->getGaragem() . "<br>"
                        . "Unidade(s) por Andar: " . $item["imovel"][0]->getApartamento()->getUnidadesAndar() . "<br>"
                        . "Andar do Apartamento: " . $item["imovel"][0]->getApartamento()->getAndar() . "º <br>"
                        . "Condominio: R($) " . $item["imovel"][0]->getApartamento()->getCondominio() . "<br>"
                        . "Área: " . $item["imovel"][0]->getApartamento()->getArea() . " m<sup>2</sup><br>";
            } else if ($item["imovel"][0]->getApartamentoPlanta() != null) {
                $html = $html . "Andares: " . $item["imovel"][0]->getApartamentoPlanta()->getAndares() . "<br>"
                        . "Unidade(s) por Andar: " . $item["imovel"][0]->getApartamentoPlanta()->getUnidadesAndar() . "<br>"
                        . "Total de Unidades: " . $item["imovel"][0]->getApartamentoPlanta()->getTotalUnidades() . "<br>"
                        . "Número de Torres: " . $item["imovel"][0]->getApartamentoPlanta()->getNumeroTorres() . "<br>";

                //foreach ($item["imovel"][0]->getPlanta() as $planta){

                if (is_array($item["imovel"][0]->getPlanta())) {

                    $html = $html . "<br>";

                    foreach ($item["imovel"][0]->getPlanta() as $planta) {

                        $ordem = ($planta->getOrdemPlantas() + 1); //apenas para não aparecer a planta "zero"

                        $html = $html . "<strong>Planta " . $ordem . "</strong> : " . $planta->getTituloPlanta() . "<br>"
                                . "Quarto(s): " . $planta->getQuarto() . "<br>"
                                . "Banheiro(s): " . $planta->getBanheiro() . "<br>"
                                . "Suite(s): " . $planta->getSuite() . "<br>"
                                . "Vaga(s) de Garagem: " . $planta->getGaragem() . "<br>"
                                . "Area: " . $planta->getArea() . " m<sup>2</sup><br>";
                    }
                } else {

                    $html = $html . "Planta: " . $item["imovel"][0]->getPlanta()->getTituloPlanta() . "<br>"
                            . "Quarto(s): " . $item["imovel"][0]->getPlanta()->getQuarto() . "<br>"
                            . "Banheiro(s): " . $item["imovel"][0]->getPlanta()->getBanheiro() . "<br>"
                            . "Suite(s): " . $item["imovel"][0]->getPlanta()->getSuite() . "<br>"
                            . "Vaga(s) de Garagem: " . $item["imovel"][0]->getPlanta()->getGaragem() . "<br>"
                            . "Area: " . $item["imovel"][0]->getPlanta()->getArea() . "<br>";
                }
                //}
            } else if ($item["imovel"][0]->getPredioComercial() != null) {
                $html = $html . "Área: " . $item["imovel"][0]->getPredioComercial()->getArea() . " m<sup>2</sup><br><br><br><br>";
            } else if ($item["imovel"][0]->getTerreno() != null) {
                $html = $html . "Área: " . $item["imovel"][0]->getTerreno()->getArea() . " m<sup>2</sup><br><br><br><br>";
            }

            if (count($item["imagem"]) > 0) {
                $pdf->Image(PIPROOT . "/fotos/imoveis/" . $item["imagem"][0]->getDiretorio()
                        . "/" . $item["imagem"][0]->getNome(), 135, "", 60, 45, '', '', '', true, 150, '', false, false, 1, false, false, false);
            } else {
                $pdf->Image(PIPROOT . "/assets/imagens/foto_padrao.png", 135, "", 60, 45, '', '', '', true, 150, '', false, false, 1, false, false, false);
            }

            $pdf->writeHTMLCell(125, 0, '', '', $html, 0, 1, 0, true, '', true);

            $htmlEndereco = "Endereço: "
                    . $item["endereco"][0]->getLogradouro() . ', Nº ' . $item["endereco"][0]->getNumero()
                    . ', ' . $item["endereco"][0]->getBairro()->getNome()
                    . ', ' . $item["endereco"][0]->getCidade()->getNome() . "<br>";

            $pdf->writeHTMLCell("", 0, '', '', $htmlEndereco, 0, 1, 0, true, '', true);

            $htmlDetalhes = 'Para mais detalhes sobre esse anúncio, clique ' . '<a href="' . PIPURL . $item["anuncio"][0]->getIdAnuncio()
                    . '" target=" _blank">AQUI</a><p>';

            $pdf->writeHTMLCell("", 0, '', '', $htmlDetalhes, 0, 1, 0, true, '', true);

            $pdf->writeHTMLCell("", 0, '', '', "<hr>", 0, 1, 0, true, '', true);

            if ($contadorPaginas < $numeroAnuncios) { //adicionar quebra de página ao final do anúncio
                $pdf->AddPage();
            }
        }

        $pdf->Output(PIPROOT . '/pdf/' . "anunciosEscolhidos" . $_SESSION["login"]
                . date("is") . ".pdf", 'F');

        $dadosEmail["nomeArquivo"] = PIPROOT . '/pdf/' . "anunciosEscolhidos" . $_SESSION["login"]
                . date("is") . ".pdf";

        //die();

        if (Email::enviarEmail($dadosEmail)) {
            $genericoDAO->commit();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 1));
        } else {
            $genericoDAO->rollback();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 0));
        }
    }

    function listarReativarAluguel() {
        if (Sessao::verificarSessaoUsuario()) {
            $anuncio = new Anuncio();
            $genericoDAO = new GenericoDAO();
            $consultasAdHoc = new ConsultasAdHoc();

            $listaAnuncioExpirado = $consultasAdHoc->ConsultarAnunciosPorUsuario($_SESSION['idusuario'], null, null, array('expirado', 'finalizado'), 'Aluguel');
            foreach ($listaAnuncioExpirado as $anuncio) {

                $expirado = $genericoDAO->consultar(new Imovel(), true, array("id" => $anuncio->getIdImovel()));
                $historico = $genericoDAO->consultar(new HistoricoAluguelVenda(), false, array("idanuncio" => $anuncio->getId()));
                $anuncio->setHistoricoaluguelvenda($historico[0]);

                $anuncio->setImovel($expirado[0]);
                $listarAnunciosExpirados[] = $anuncio;
            }
            $item["listaPlanos"] = $planos = $genericoDAO->consultar(new UsuarioPlano(), true, array("idusuario" => $_SESSION['idusuario'], "status" => "pago"));

            //visao
            $visao = new Template();
            $item["listaAnuncioExpirado"] = $listarAnunciosExpirados;
            $visao->setItem($item);
            $visao->exibir('AnuncioVisaoListagemExpiradoAluguel.php');
        }
    }

    function reativar($parametros) {

        if (Sessao::verificarSessaoUsuario()) {

            if (Sessao::verificarToken($parametros)) {

                $genericoDAO = new GenericoDAO();
                $genericoDAO->iniciarTransacao();
                $entidadeAnuncio = new Anuncio();
                $selecionarAnuncio = $genericoDAO->consultar($entidadeAnuncio, false, array("id" => $parametros["hdnAnuncio"]));
                $entidadeAnuncio = $selecionarAnuncio[0];
                $entidadeAnuncio->setStatus('cadastrado');
                $entidadeAnuncio->setDatahoraalteracao(date('d/m/Y H:i:s'));
                $entidadeAnuncio->setTituloanuncio($parametros["txtTitulo"]);
                $entidadeAnuncio->setDescricaoanuncio($parametros["txtDescricao"]);
                $entidadeAnuncio->setPublicarmapa($parametros["chkMapa"]);
                $entidadeAnuncio->setPublicarcontato($parametros["chkContato"]);
                if ($parametros["chkValor"] == 'SIM') {
                    $parametros["txtValor"] = $this->limpaValor($parametros["txtValor"]);
                    $entidadeAnuncio->setValormin($parametros["txtValor"]);
                }
                $entidadeUsuarioPlano = $genericoDAO->consultar(new UsuarioPlano(), true, array("id" => $parametros["sltPlano"]));
                $entidadeUsuarioPlano = $entidadeUsuarioPlano[0];
                if (($entidadeUsuarioPlano->getPlano()->getTitulo() != "infinity" && $_SESSION["tipopessoa"] == "pj") || $_SESSION["tipopessoa"] == "pf") {
                    //se o plano nao eh infinity e nem eh uma empresa, entao atualiza o status do usuarioplano
                    $entidadeUsuarioPlano->setStatus("utilizado");
                }
                if ($genericoDAO->editar($entidadeAnuncio) && $genericoDAO->editar($entidadeUsuarioPlano)) {
                    $genericoDAO->commit();
                    $genericoDAO->fecharConexao();
                    echo json_encode(array("resultado" => 1));
                } else {
                    $genericoDAO->rollback();
                    $genericoDAO->fecharConexao();
                    echo json_encode(array("resultado" => 0));
                }
            }
        }
    }

    function enviarDuvidaAnuncio($parametros) {
// if (Sessao::verificarToken($parametros)) {
        $txtProposta = $this->limpaValor($parametros["txtProposta"]);
        $parametros["txtProposta"] = $txtProposta;
        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();
        $mensagem = new Mensagem();

        $entidadeMensagem = $mensagem->cadastrar($parametros);

        $resultadoMensagem = $genericoDAO->cadastrar($entidadeMensagem);

        if ($resultadoMensagem) {
//Enviar email para o anunciante;
            $selecionarUsuario = $genericoDAO->consultar(new Usuario(), false, array("id" => $parametros['hdnUsuario']));
            $selecionarAnuncio = $genericoDAO->consultar(new Anuncio(), false, array("id" => $parametros['hdnAnuncio']));
            $dadosEmail['destino'] = $selecionarUsuario[0]->getEmail();
            $dadosEmail['contato'] = $parametros['nome'];
            $dadosEmail['msg'] = "Você recebeu uma mensagem nova sobre o anuncio '" . $selecionarAnuncio[0]->getTituloAnuncio() . "'. Acesse a sua caixa de mensagens para visualizá-la<br><br>Favor não responder esse e-mail.";
            $dadosEmail['assunto'] = utf8_decode("E-mail Automático - Mensagem sobre um anuncio em PIP-Online");
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
            echo json_encode(array("resultado" => 2));
        }
    }

    function finalizar($parametros) {

        if (Sessao::verificarSessaoUsuario()) {

            if (Sessao::verificarToken($parametros)) {

                $genericoDAO = new GenericoDAO();
                $entidadeAnuncio = new Anuncio();
                $selecionarAnuncio = $genericoDAO->consultar($entidadeAnuncio, false, array("id" => $parametros["hdnAnuncio"]));
                $entidadeAnuncio = $selecionarAnuncio[0];
                $entidadeAnuncio->setStatus('finalizado');
                $entidadeAnuncio->setDatahoraalteracao(date('d/m/Y H:i:s'));
                $genericoDAO->editar($entidadeAnuncio);

                $historicoAluguelVenda = new HistoricoAluguelVenda();
                $entidadeHistoricoAluguelVenda = $historicoAluguelVenda->cadastrar($parametros);
                $resultadoFinalizarNegocio = $genericoDAO->cadastrar($entidadeHistoricoAluguelVenda);
                if ($resultadoFinalizarNegocio) {
                    echo json_encode(array("resultado" => 1));
                } else {
                    echo json_encode(array("resultado" => 0));
                }
            }
        }
    }

    function verficaHashEmail($parametros) {

        $visao = new Template();
        $emailanuncio = new EmailAnuncio();
        $anuncio = new Anuncio();
        $genericoDAO = new GenericoDAO();

        $selecionarEmailAnuncio = $genericoDAO->consultar($emailanuncio, false, array("hash" => $parametros["id"]));

        if (!$selecionarEmailAnuncio) { //verifica se o hash é valido
            $visao->setItem("errohashemail");
            $visao->exibir('VisaoErrosGenerico.php');
        } elseif ($selecionarEmailAnuncio) { //caso o hash seja válido
            $verificarAtivo = $genericoDAO->consultar($anuncio, true, array("id" => $selecionarEmailAnuncio[0]->getIdAnuncio()));

            if ($verificarAtivo[0]->getStatus() != "cadastrado") { //verificar se o anuncio não está expirado ou finalizado
                $item = "errousuarioouanuncio";
                $visao = new Template();
                $visao->setItem($item);
                $visao->exibir("VisaoErrosGenerico.php");
            } elseif ($verificarAtivo[0]->getStatus() == "cadastrado") {

                $tipoImovel = new TipoImovel();

                $tipo = $tipoImovel->retornaDescricaoTipo($verificarAtivo[0]->getImovel()->getIdTipoImovel());

                $this->detalhar(array("hdnTipoImovel" => $tipo, "hdnCodAnuncio" => $verificarAtivo[0]->getId()));
            }
        }
    }

    function alterarValor($parametros) {

        if (Sessao::verificarSessaoUsuario()) {

            //var_dump($parametros); die();

            if (Sessao::verificarToken($parametros)) {

                $genericoDAO = new GenericoDAO();

                $novoValor = new NovoValorAnuncio();
                //setar os valores do objeto para edição
                $consultarValorInativar = $genericoDAO->consultar($novoValor, false, array("idanuncio" => $parametros["hdnAnuncio"]));
                //transformar de array para um único valor

                if ($consultarValorInativar != null) { //setar a classe ValorNovo apenas se já existir valor
                    if ($parametros['txtNovoValor'] != "") {

                        $consultarValorInativar = $consultarValorInativar[0];
                        //setar apenas os campos que se quer editar
                        $setarInativacao = $novoValor->inativarValor($consultarValorInativar);

                        $genericoDAO->iniciarTransacao();
                        //passar o objeto para edição
                        $inativar = $genericoDAO->editar($setarInativacao);
                    } else {
                        $genericoDAO->iniciarTransacao();
                        $inativar = true;
                    } {
                        
                    }
                } else { //caso não exista um valor novo já cadastrado
                    $genericoDAO->iniciarTransacao();

                    $inativar = true;
                }

                if ($parametros['txtNovoValor'] != "") {

                    //echo "Entrou"; die();

                    $entidade = $novoValor->cadastrar($parametros);

                    $resultadoNovoValor = $genericoDAO->cadastrar($entidade);
                } else {
                    $resultadoNovoValor = true;
                    //echo "Não Entrou"; die();
                }

                $anuncio = new Anuncio();

                $entidadeAnuncio = $anuncio->editar($parametros);
                $idAnuncio = $genericoDAO->editar($entidadeAnuncio);

                if ($inativar && $resultadoNovoValor && $idAnuncio) {

                    $genericoDAO->commit();

                    echo json_encode(array("resultado" => 1, "novoValor" => $parametros["txtNovoValor"]));
                } else {

                    echo json_encode(array("resultado" => 0));

                    $genericoDAO->rollback();
                }

                $genericoDAO->fecharConexao();
            } else {

                echo json_encode(array("resultado" => 2)); //erro de token
            }
        } else { //caso o usuário não esteja logado
            echo json_encode(array("resultado" => 3));
        }
    }

    function listarNegado() {
        if (Sessao::verificarSessaoUsuario()) {
            $anuncio = new Anuncio();
            $genericoDAO = new GenericoDAO();
            $consultasAdHoc = new ConsultasAdHoc();

            $administrador = false;

            if (($_SESSION['login'] === "pipdiministrador")) {
                $administrador = true;
            }

            $listaAnuncio = $consultasAdHoc->ConsultarAnunciosPorUsuario($_SESSION['idusuario'], $administrador, null, array('ativacaonegada'));
            foreach ($listaAnuncio as $anuncio) {
                $imovel = $genericoDAO->consultar(new Imovel(), false, array("id" => $anuncio->getIdImovel()));
                $anuncio->setImovel($imovel[0]);

                $usuarioplano = $genericoDAO->consultar(new UsuarioPlano(), true, array("id" => $anuncio->getIdusuarioplano()));
                $anuncio->setUsuarioplano($usuarioplano[0]);

                $novoValor = $genericoDAO->consultar(new NovoValorAnuncio(), false, array("idanuncio" => $anuncio->getId()));
                $anuncio->setNovovaloranuncio($novoValor);

                $listarAnuncios[] = $anuncio;
            }

            $visao = new Template();
            $item["listaAnuncio"] = $listarAnuncios;
            $visao->setItem($item);
            $visao->exibir('AnuncioVisaoListagemNegado.php');
        }
    }

    function alterarStatus($parametros) {

        if (Sessao::verificarSessaoUsuario()) {
            $anuncio = new Anuncio();
            $genericoDAO = new GenericoDAO();

            //setar apenas os campos que se quer editar
            $setarStatus = $anuncio->alterarStatus($parametros);

            $genericoDAO->iniciarTransacao();
            //passar o objeto para edição
            $novoStatus = $genericoDAO->editar($setarStatus);

            //enviar email ao usuário, avisando sobre a mudança de status
            //$email = $this->enviarEmailGenerico($parametros);

            if ($novoStatus) {// && $email) {
                $genericoDAO->commit();

                echo json_encode(array("resultado" => 1, "novoValor" => $parametros["sltStatusAnuncio"]));
            } else {

                echo json_encode(array("resultado" => 0));

                $genericoDAO->rollback();
            }
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

        if ($parametros['sltStatusAnuncio'] == 'cadastrado') {
            $mensagemEmail = $parametros['hdnMsgEmailAtivado'];
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
