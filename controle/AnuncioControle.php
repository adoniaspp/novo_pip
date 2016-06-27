<?php

include_once 'modelo/Anuncio.php';
include_once 'modelo/Apartamento.php';
include_once 'modelo/ApartamentoPlanta.php';
include_once 'modelo/Casa.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Imovel.php';
include_once 'modelo/Planta.php';
include_once 'modelo/Plano.php';
include_once 'modelo/Imagem.php';
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
include_once 'assets/libs/tcpdf/tcpdf.php';

class AnuncioControle {

    function form($parametros) {
        if (Sessao::verificarSessaoUsuario() & Sessao::verificarToken(array("hdnToken" => $parametros["token"]))) {
            //modelo
            $imovel = new Imovel();
            $genericoDAO = new GenericoDAO();
            $selecionarImovel = $genericoDAO->consultar($imovel, true, array("id" => $parametros['idImovel'], "idUsuario" => $_SESSION['idusuario']));
            #verificar a melhor forma de tratar o blindado recursivo
            $selecionarEndereco = $genericoDAO->consultar(new Endereco(), true, array("id" => $selecionarImovel[0]->getIdEndereco()));
            $selecionarImovel[0]->setEndereco($selecionarEndereco[0]);

            $selecionarDiferencial = $genericoDAO->consultar(new ImovelDiferencial(), true, array("idimovel" => $selecionarImovel[0]->getId()));
            $selecionarImovel[0]->setImovelDiferencial($selecionarDiferencial);
            //verifica se existe o imovel selecionado
            if ($selecionarImovel) {
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
                $condicoes["status"] = 'ativo';
                $listarUsuarioPlano = $genericoDAO->consultar($usuarioPlano, true, $condicoes);
                $sessao["idimovel"] = $selecionarImovel[0]->getId();
                $sessao["tipoimovel"] = $selecionarImovel[0]->getIdtipoImovel();
                Sessao::configurarSessaoAnuncio($sessao);
                $formAnuncio = array();
                $formAnuncio["usuarioPlano"] = $listarUsuarioPlano;
                $formAnuncio["imovel"] = $selecionarImovel;
                $formAnuncio["anuncio"] = ($anuncios != NULL ? $anuncios : new Anuncio());
                $item = $formAnuncio;
                $pagina = "AnuncioVisaoPublicar.php";
            } else {
                $item = "errotoken";
                $pagina = "VisaoErrosGenerico.php";
            }
            //visao
            $visao = new Template();
            $visao->setItem($item);
            $visao->exibir($pagina);
        } else {
            $item = "errotoken";
            $pagina = "VisaoErrosGenerico.php";
            $visao = new Template();
            $visao->setItem($item);
            $visao->exibir($pagina);
        }
    }

    function buscarAnuncio($parametros) {

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
        /*
        echo "<pre>";
        var_dump($listarAnuncio);
        echo "</pre>";
        */
        
        
        if ($listarAnuncio["anuncio"][0]["status"] != "cadastrado" &&
                $parametros["sessaoUsuario"] != $parametros["idUsuario"]) {


            $item = "errousuarioouanuncio";
            $pagina = "VisaoErrosGenerico.php";
            $visao = new Template();
            $visao->setItem($item);
            $visao->exibir($pagina);
        } else {

            $usuarioQtdAnuncio = count($consultasAdHoc->ConsultarAnunciosPorUsuario($parametros["idUsuario"], null, array('cadastrado')));

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
            
            foreach($valores as $nValor){

                        $nValor = $genericoDAO->consultar(new NovoValorAnuncio(), false, array("idanuncio" => $parametros["idanuncio"]));
                        $listarAnuncio["novoValor"] = $nValor;

                    }
            
            $mapaNovo = $genericoDAO->consultar(new MapaImovel(), false, array("idanuncio" => $parametros["idanuncio"]));      
                  
            if($mapaNovo != null){
                
                $listarAnuncio["mapaImovel"] = $mapaNovo;
                
            }       
        
            $numeroPlantas = count($listarAnuncio["anuncio"][0]["plantas"]);
            
            
            //trazer os diferenciais da planta
            for($x = 0; $x < $numeroPlantas; $x++){

                $dif[$listarAnuncio["anuncio"][0]["plantas"][$x]["id"]] = $genericoDAO->consultar(new ImovelDiferencialPlanta(), 
                        true, array("idplanta" => $listarAnuncio["anuncio"][0]["plantas"][$x]["id"]));
          
            }
            
            
            
            $listarAnuncio["difPlantas"] = $dif;
  
            $listarAnuncio["mensagem"] = $mensagem;
            
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
            $item["anuncio"] = $genericoDAO->consultar(new Anuncio(), false, array("id" => $idanuncio));
            $item["imovel"] = $genericoDAO->consultar(new Imovel(), true, array("id" => $item["anuncio"][0]->getIdimovel()));
            $descricaoTipoImovel = $item["imovel"][0]->getTipoimovel()->getDescricao();
            $consultasAdHoc = new ConsultasAdHoc();
            $parametros["idanuncio"] = $idanuncio;
            $parametros["tabela"] = $descricaoTipoImovel;
            $parametros["atributos"] = "*";
            $parametros["predicados"] = $parametros;
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
            $listaAnuncio = $consultasAdHoc->ConsultarAnunciosPorUsuario($_SESSION['idusuario'], null, array('cadastrado'));
            foreach ($listaAnuncio as $anuncio) {
                $imovel = $genericoDAO->consultar(new Imovel(), false, array("id" => $anuncio->getIdImovel()));
                $anuncio->setImovel($imovel[0]);
                
                $usuarioplano = $genericoDAO->consultar(new UsuarioPlano(), true, array("id" => $anuncio->getIdusuarioplano()));
                $anuncio->setUsuarioplano($usuarioplano[0]);
                
                $novoValor = $genericoDAO->consultar(new NovoValorAnuncio(), false, array("idanuncio" => $anuncio->getId()));
                //caso haja mais de um valor alterado do anúncio, inserir no array 
                
                    
                    foreach($novoValor as $nValor){

                        $nValor = $genericoDAO->consultar(new NovoValorAnuncio(), false, array("idanuncio" => $anuncio->getId()));
                        $anuncio->setNovovaloranuncio($nValor);

                    }
                    
                
             
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

            $listaAnuncio = $consultasAdHoc->ConsultarAnunciosPorUsuario($_SESSION['idusuario'], null, array('finalizado'));
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
                if (Sessao::verificarToken($parametros)) {

                    $genericoDAO = new GenericoDAO();
                    $genericoDAO->iniciarTransacao();

                    $anuncio = new Anuncio();
                    $entidadeAnuncio = $anuncio->cadastrar($parametros);
                    $this->verificaValorMinimo($entidadeAnuncio, $parametros);
                    $idAnuncio = $genericoDAO->cadastrar($entidadeAnuncio);
                    
                    //dados do anúncio para serem enviados via ajax, após a publicação
                    $dadosAnuncio = $genericoDAO->consultar(new Anuncio, true, array("id" => $idAnuncio));
                   
                    $tipoImovel = new TipoImovel();
                    
                    $tipo = $dadosAnuncio[0]->getImovel()->getIdTipoImovel();
                    
                    $retornaTipoImovel = $tipoImovel->retornaDescricaoTipo($tipo);
                    
                    $entidadeUsuarioPlano = $genericoDAO->consultar(new UsuarioPlano(), true, array("id" => $parametros["sltPlano"]));
                    $entidadeUsuarioPlano = $entidadeUsuarioPlano[0];
                    if (($entidadeUsuarioPlano->getPlano()->getTitulo() != "infinity" && $_SESSION["tipopessoa"] == "pj") || $_SESSION["tipopessoa"] == "pf") {
                        //se o plano nao eh infinity e nem eh uma empresa, entao atualiza o status do usuarioplano
                        $entidadeUsuarioPlano->setStatus("utilizado");
                        $genericoDAO->editar($entidadeUsuarioPlano);
                    }

                    //se for apartamento na planta
                    if ($_SESSION["anuncio"]["tipoimovel"] == 2) {
                        $valor = new Valor();
                        $valor->setIdanuncio($idAnuncio);
                        //traz todas as plantas
                        $plantas = $genericoDAO->consultar(new Imovel(), true, array("id" => $_SESSION["anuncio"]["idimovel"]));
                        $plantas = $plantas[0]->getPlanta();
                        if (is_object($plantas))
                            $plantas = array($plantas);
                        //itera para cada planta
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
                            //imagens das plantas
                            $sessaoImagemPlanta = $_SESSION["imagemPlanta"][$planta->getOrdemplantas()];
                            if (isset($sessaoImagemPlanta)) {
                                $planta->setImagemdiretorio($sessaoImagemPlanta["diretorio"]);
                                $planta->setImagemnome($sessaoImagemPlanta["name"]);
                                $planta->setImagemtamanho($sessaoImagemPlanta["size"]);
                                $planta->setImagemtipo($sessaoImagemPlanta["type"]);
                                $genericoDAO->editar($planta);
                            }
                        }
                    }
                    //somente salva fotos se houver
                    if (isset($_SESSION["imagemAnuncio"])) {
                        foreach ($_SESSION["imagemAnuncio"] as $file) {
                            $imagem = new Imagem();
                            $entidadeImagem = $imagem->cadastrar($file, $idAnuncio, $parametros["rdbDestaque"]);
                            $idImagem = $genericoDAO->cadastrar($entidadeImagem);
                        }
                    }
                    
                    $statusMapa = false;
                    
                    //cadastro da latitude e longitude se houver alteração no mapa
                    if($parametros["hdnLatitude"] != "" && $parametros["hdnLongitude"] != ""){
                        
                        $mapaImovel = new MapaImovel();
                        $cadastrarMapa = $mapaImovel->cadastrar($parametros, $idAnuncio);
                        
                        $statusCadastroMapa = $genericoDAO->cadastrar($cadastrarMapa);
                        
                        if($statusCadastroMapa) {
                            
                            $statusMapa = true;
                            
                        }
                        
                    } else $statusMapa = true;
                    //visao
                    if ($idAnuncio && $statusMapa) {
                      
                        $genericoDAO->commit();
                        Sessao::desconfigurarVariavelSessao("anuncio");
                        Sessao::desconfigurarVariavelSessao("imagemAnuncio");
                        Sessao::desconfigurarVariavelSessao("imagemPlanta");
                        echo json_encode(array("resultado" => 1, "idanuncio" => $dadosAnuncio[0]->getIdAnuncio(), "id" =>$dadosAnuncio[0]->getId(), "tipoImovel" => $retornaTipoImovel));
                    } else {
                        $genericoDAO->rollback();
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
            switch ($_SESSION["anuncio"]["tipoimovel"]) {
                case 1://casa
                case 3://apartamento
                case 4://sala comercial
                case 5://predio comercial
                case 6://terreno
                    $valorMinimo = $this->limpaValor($parametros["txtValor"]);
                    break;
                case 2://apartamento na planta
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
                    break;
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

        $selecionarAnuncioUsuario = $genericoDAO->consultar($usuario, true, array("id" => $parametros["login"]));

        if ($selecionarAnuncioUsuario == null) {

            $selecionarAnuncioUsuario = $genericoDAO->consultar($usuario, true, array("login" => $parametros["login"]));
        }

        if (!$selecionarAnuncioUsuario) {
            //verifica se o usuario existe na base ou se está inativo
            $visao->setItem("errousuarioinativo");
            $visao->exibir('VisaoErrosGenerico.php');
        } else {
            $item["usuario"] = $genericoDAO->consultar(new Usuario(), false, array("id" => $selecionarAnuncioUsuario[0]->getId()));

            $statusUsuario = $item["usuario"] = $genericoDAO->consultar(new Usuario(), false, array("id" => $selecionarAnuncioUsuario[0]->getId()));
            $verificarStatus = $selecionarAnuncioUsuario[0]->getStatus();

            //$verificarStatus = $statusUsuario[0]->getStatus();
            $id = $selecionarAnuncioUsuario[0]->getId();

            if ($verificarStatus == 'ativo') {

                $consultasAdHoc = new ConsultasAdHoc();
                $parametrosBusca["atributos"] = "*";
                $parametrosBusca["tabela"] = "todos";
                $parametrosBusca["predicados"]["id"] = $id; //Id do corretor. 
                $parametrosBusca["predicados"]["garagem"] = "false";

                $visao = new Template();
                $item["usuario"] = $genericoDAO->consultar(new Usuario(), true, array("id" => $selecionarAnuncioUsuario[0]->getId()));
                $item["cidadeEstado"] = $genericoDAO->consultar(new Endereco(), true, array("id" => $selecionarAnuncioUsuario[0]->getIdEndereco()));
                $item["anuncio"] = $consultasAdHoc->buscaAnuncios($parametrosBusca);

                $visao->setItem($item);
                $visao->exibir('AnuncioVisaoUsuario.php');
            }
        }
    }

    function enviarEmail($parametros) {

        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();
        $dadosEmail['destino'] = $parametros['txtEmailEmail'];
        $dadosEmail['contato'] = "PIP-Online";
        $dadosEmail['assunto'] = utf8_decode("PIP-Online - Selecionou imóvel(is) para você");

        if ($parametros['txtNomeEmail'] != "") {

            $dadosEmail['msg'] .= 'Veja o(s) imóvel(is) indicados para você por ' . $parametros['txtNomeEmail'] . ':<br><br>';
        } else {
            $dadosEmail['msg'] .= 'Veja o(s) imóvel(is) indicados para você:<br><br>';
        }

        $dadosEmail['msg'] .= 'Mensagem: ' . $parametros['txtMsgEmail'] . "<br><br>";

        //Utilizado se for envio de e-mail para o correto através da tela de detalhes 
        if ($parametros['hdnAnuncio']) {
            $parametros['anunciosSelecionados'] = array($parametros['hdnAnuncio']);
        }

        foreach ($parametros['anunciosSelecionados'] as $idanuncio) {

            $item["anuncio"] = $genericoDAO->consultar(new Anuncio(), true, array("id" => $idanuncio));

            $item["imovel"] = $genericoDAO->consultar(new Imovel(), false, array("id" => $item["anuncio"][0]->getIdImovel()));

            $item["endereco"] = $genericoDAO->consultar(new Endereco(), true, array("id" => $item["imovel"][0]->getIdEndereco()));

            $emailanuncio = new EmailAnuncio();

            $selecionaremailanuncio = $emailanuncio->cadastrar($idanuncio);

            $idemailanuncio = $genericoDAO->cadastrar($selecionaremailanuncio);

            $dadosEmail['msg'] .=
                    '
    <table class="container" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: inherit; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top">
    <table class="row" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">
    <!--<table class="twelve columns">
    <tr>
    <td>
    <h1>Hi, Susan Calvin</h1>
    <p class="lead">Phasellus dictum sapien a neque luctus cursus. Pellentesque sem dolor, fringilla et pharetra vitae.</p>
    <p>Phasellus dictum sapien a neque luctus cursus. Pellentesque sem dolor, fringilla et pharetra vitae. consequat vel lacus. Sed iaculis pulvinar ligula, ornare fringilla ante viverra et. In hac habitasse platea dictumst. Donec vel orci mi, eu congue justo. Integer eget odio est, eget malesuada lorem. Aenean sed tellus dui, vitae viverra risus. Nullam massa sapien, pulvinar eleifend fringilla id, convallis eget nisi. Mauris a sagittis dui. Pellentesque non lacinia mi. Fusce sit amet libero sit amet erat venenatis sollicitudin vitae vel eros. Cras nunc sapien, interdum sit amet porttitor ut, congue quis urna.</p>
    </td>
    <td class="expander"></td>
    </tr>
    </table>-->
    <table class="row" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 20px 0px 0px;" align="left" valign="top">

          <table class="three columns" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 130px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" align="left" valign="top">

                <img height="130" width="130" src=" ' . PIPURL . "/assets/imagens/foto_padrao.png" . '" style="outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; width: auto; max-width: 100%; float: left; clear: both; display: block;" align="left" /></td>
              <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
            </tr></table></td>
        <td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 0px;" align="left" valign="top">

          <table class="nine columns" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 430px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0px 0px 10px;" align="left" valign="top">

                <table class="block-grid five-up" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; max-width: 580px; padding: 0;"><tbody><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #F1EDCA; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#F1EDCA" valign="top">
    <span>Tipo</span>
    </td><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #28A9C5; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#28A9C5" valign="top">
    <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #28A9C5; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#28A9C5" valign="top">
    <span>' . strtoupper($item["imovel"][0]->getIdentificacao()) . '</span>
    </td>
    <td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #F1EDCA; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#F1EDCA" valign="top">
    <span>Finalidade</span>
    </td><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #28A9C5; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#28A9C5" valign="top">
    <span>' . strtoupper($item["anuncio"][0]->getFinalidade()) . '</span>
    </td>
    </tr></tbody></table><br /><table class="block-grid five-up" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; max-width: 580px; padding: 0;"><tbody><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #F1EDCA; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#F1EDCA" valign="top">
    <span>Condição</span>
    </td><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #28A9C5; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#28A9C5" valign="top">
    <span>' . $item["imovel"][0]->getCondicao() . '</span>
    </td><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #F1EDCA; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#F1EDCA" valign="top">
    <span>Valor</span>
    </td><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #28A9C5; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#28A9C5" valign="top">
    <span>R$' . $item["anuncio"][0]->getValorMin() . '</span>
    </td>
    </tr></tbody></table><br /><table class="block-grid five-up" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; max-width: 580px; padding: 0;"><tbody><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #F1EDCA; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#F1EDCA" valign="top">
    <span>Endereço</span>
    </td><td style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; display: inline-block; width: 96px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #28A9C5; margin: 0; padding: 0px 0px 10px;" align="left" bgcolor="#28A9C5" valign="top">
    <span>' . $item["endereco"][0]->getLogradouro() . ', Nº ' . $item["endereco"][0]->getNumero() . ' , ' . $item["endereco"][0]->getBairro()->getNome() . ' , ' . $item["endereco"][0]->getCidade()->getNome() . '</span>
    </td>
    </tr></tbody></table></td>
              <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
            </tr></table></td>
      </tr></table></td>
    </tr></table><table class="row callout" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 100%; position: relative; display: block; padding: 0px;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="wrapper last" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; position: relative; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 10px 0px 20px;" align="left" valign="top">
    <table class="twelve columns" style="border-spacing: 0; border-collapse: collapse; vertical-align: top; text-align: left; width: 580px; margin: 0 auto; padding: 0;"><tr style="vertical-align: top; text-align: left; padding: 0;" align="left"><td class="panel" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; background: #ECF8FF; margin: 0; padding: 10px; border: 1px solid #b9e5ff;" align="left" bgcolor="#ECF8FF" valign="top">
    <p style="color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;" align="left">Acesse agora esse imóvel <a href= ' . PIPURL . 'index.php?entidade=Anuncio&amp;acao=verficahashemail&amp;id=' . $selecionaremailanuncio->getHash() . ' style="color: #2ba6cb; text-decoration: none;">Clique Aqui! »</a></p>
    </td>
    <td class="expander" style="word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; visibility: hidden; width: 0px; color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; margin: 0; padding: 0;" align="left" valign="top"></td>
    </tr></table></td>
    </tr></table> <br>';
        }

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

        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();
        $dadosEmail['destino'] = $parametros['txtEmailEmail'];
        $dadosEmail['contato'] = "PIP-Online";
        $dadosEmail['assunto'] = utf8_decode("PIP-Online - Selecionou imóvel(is) para você");

        $dadosEmail['msg'] .= 'Veja o(s) imóvel(is) indicados para você por ' . $_SESSION['nome'] . ':<br><br>';

        $dadosEmail['msg'] .= 'Mensagem: ' . $parametros['txtMsgEmail'] . "<br><br>";

        //Utilizado se for envio de e-mail para o correto através da tela de detalhes 
        if ($parametros['hdnAnuncio']) {
            $parametros['anunciosSelecionados'] = array($parametros['hdnAnuncio']);
            
        }
        
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetAuthor('PIP ONLINE');

        $pdf->SetHeaderData("", "", "PIP ON-LINE", 
                "PIP ON-LINE - Imóveis Fáceis", array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->setFontSubsetting(true);

        $pdf->SetFont('times', '', 14, '', true);

        $pdf->AddPage();

        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 
            'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
        
        $pdf->setFontSubsetting(true);

        $imovel = new Imovel();
        
        $contadorPaginas = 0;
        
        $numeroAnuncios = count($parametros['anunciosSelecionados']);
        
        foreach ($parametros['anunciosSelecionados'] as $idanuncio) {    
            
            $contadorPaginas = $contadorPaginas + 1;
            
            $item["anuncio"] = $genericoDAO->consultar(new Anuncio(), true, array("id" => $idanuncio));
            
            $item["imovel"] = $genericoDAO->consultar(new Imovel(), true, array("id" => $item["anuncio"][0]->getIdImovel()));
           
            $item["endereco"] = $genericoDAO->consultar(new Endereco(), true, array("id" => $item["imovel"][0]->getIdEndereco()));
            
            $item["imagem"] = $genericoDAO->consultar(new Imagem(), true, array("idanuncio" => $idanuncio, "destaque" => "SIM"));

            $emailanuncio = new EmailAnuncio();

            $selecionaremailanuncio = $emailanuncio->cadastrar($idanuncio);

            $idemailanuncio = $genericoDAO->cadastrar($selecionaremailanuncio);
 
            $html = "Código: ".$item["anuncio"][0]->getIdAnuncio()
                    ."<br>Tipo: ".$imovel->tipoImovelRetornar($item["imovel"][0]->getIdTipoImovel())
                    ."<br>"."Finalidade: ".$item["anuncio"][0]->getFinalidade();
                            
            if($item["imovel"][0]->getCondicao() != "nenhuma"){
                $html = $html."<br>Condição: ".ucfirst($item["imovel"][0]->getCondicao()."<br>");
            } else $html = $html."<br>";
            
            if($item["imovel"][0]->getCasa() != null){
                $html = $html."Quarto(s): ".$item["imovel"][0]->getCasa()->getQuarto()."<br>"
                             ."Banheiro(s): ".$item["imovel"][0]->getCasa()->getBanheiro()."<br>"
                             ."Suite(s): ".$item["imovel"][0]->getCasa()->getSuite()."<br>"
                             ."Vaga(s) de Garagem: ".$item["imovel"][0]->getCasa()->getGaragem()."<br>"
                             ."Área: ".$item["imovel"][0]->getCasa()->getArea()." m<sup>2</sup><br>";
            } 
            
            else if($item["imovel"][0]->getSalaComercial() != null){
                $html = $html."Banheiro(s): "
                            .$item["imovel"][0]->getSalaComercial()->getBanheiro()."<br>Vaga(s) de Garagem: "
                            .$item["imovel"][0]->getSalaComercial()->getGaragem()."<br>";
            } 
            
            else if($item["imovel"][0]->getApartamento() != null){
                $html = $html."Quarto(s): ".$item["imovel"][0]->getApartamento()->getQuarto()."<br>"
                             ."Banheiro(s): ".$item["imovel"][0]->getApartamento()->getBanheiro()."<br>"
                             ."Suite(s): ".$item["imovel"][0]->getApartamento()->getSuite()."<br>"
                             ."Vaga(s) de Garagem: ".$item["imovel"][0]->getApartamento()->getGaragem()."<br>"
                             ."Unidade(s) por Andar: ".$item["imovel"][0]->getApartamento()->getUnidadesAndar()."<br>"
                             ."Andar do Apartamento: ".$item["imovel"][0]->getApartamento()->getAndar()."º <br>"
                             ."Condominio: R($) ".$item["imovel"][0]->getApartamento()->getCondominio()."<br>"
                             ."Está na Cobertura: ".$item["imovel"][0]->getApartamento()->getCobertura()."<br>"
                             ."Área: ".$item["imovel"][0]->getApartamento()->getArea()." m<sup>2</sup><br>";
            }
            
            else if($item["imovel"][0]->getApartamentoPlanta() != null){
                $html = $html."Andares: ".$item["imovel"][0]->getApartamentoPlanta()->getAndares()."<br>"
                             ."Unidade(s) por Andar: ".$item["imovel"][0]->getApartamentoPlanta()->getUnidadesAndar()."<br>"
                             ."Total de Unidades: ".$item["imovel"][0]->getApartamentoPlanta()->getTotalUnidades()."<br>"
                             ."Número de Torres: ".$item["imovel"][0]->getApartamentoPlanta()->getNumeroTorres()."<br>";
            
                //foreach ($item["imovel"][0]->getPlanta() as $planta){
                
                if(is_array($item["imovel"][0]->getPlanta())){
                    
                    $html = $html."<br>";
                    
                    foreach ($item["imovel"][0]->getPlanta() as $planta){
                        
                        $ordem = ($planta->getOrdemPlantas() + 1); //apenas para não aparecer a planta "zero"
                        
                        $html = $html."<strong>Planta ".$ordem."</strong> : ".$planta->getTituloPlanta()."<br>"
                            ."Quarto(s): ".$planta->getQuarto()."<br>"
                            ."Banheiro(s): ".$planta->getBanheiro()."<br>"
                            ."Suite(s): ".$planta->getSuite()."<br>"
                            ."Vaga(s) de Garagem: ".$planta->getGaragem()."<br>"
                            ."Area: ".$planta->getArea()." m<sup>2</sup><br>";
                        
                    }
                    
                }
                
                else{
                
                    $html = $html."Planta: ".$item["imovel"][0]->getPlanta()->getTituloPlanta()."<br>"
                            ."Quarto(s): ".$item["imovel"][0]->getPlanta()->getQuarto()."<br>"
                            ."Banheiro(s): ".$item["imovel"][0]->getPlanta()->getBanheiro()."<br>"
                            ."Suite(s): ".$item["imovel"][0]->getPlanta()->getSuite()."<br>"
                            ."Vaga(s) de Garagem: ".$item["imovel"][0]->getPlanta()->getGaragem()."<br>"
                            ."Area: ".$item["imovel"][0]->getPlanta()->getArea()."<br>";
                }   
                //}
            }
            else if($item["imovel"][0]->getPredioComercial() != null){
                $html = $html."Área: ".$item["imovel"][0]->getPredioComercial()->getArea()." m<sup>2</sup><br><br><br><br>";
            }
            
            else if($item["imovel"][0]->getTerreno() != null){
                $html = $html."Área: ".$item["imovel"][0]->getTerreno()->getArea()." m<sup>2</sup><br><br><br><br>";
            }          
            
            if(count($item["imagem"]) > 0){
                $pdf->Image(PIPROOT."/fotos/imoveis/".$item["imagem"][0]->getDiretorio()
                    ."/".$item["imagem"][0]->getNome(), 135, "", 60, 45, '', '', '', true, 150, '', false, false, 1, false, false, false);
            } else{
                $pdf->Image(PIPROOT."/assets/imagens/foto_padrao.png", 135, "", 60, 45, '', '', '', true, 150, '', false, false, 1, false, false, false);
                
            }

            $pdf->writeHTMLCell(125, 0, '', '', $html, 0, 1, 0, true, '', true);
            
            $htmlEndereco = "Endereço: "                            
                            .$item["endereco"][0]->getLogradouro() .', Nº ' . $item["endereco"][0]->getNumero() 
                            . ', ' . $item["endereco"][0]->getBairro()->getNome() 
                            . ', ' . $item["endereco"][0]->getCidade()->getNome()."<br>";
            
            $pdf->writeHTMLCell("", 0, '', '', $htmlEndereco, 0, 1, 0, true, '', true);
            
            $htmlDetalhes = 'Para mais detalhes sobre esse anúncio, clique '. '<a href="'.PIPURL.$item["anuncio"][0]->getIdAnuncio()
                    .'" target=" _blank">AQUI</a><p>';
            
            $pdf->writeHTMLCell("", 0, '', '', $htmlDetalhes, 0, 1, 0, true, '', true);
            
            $pdf->writeHTMLCell("", 0, '', '', "<hr>", 0, 1, 0, true, '', true);
            
            if($contadorPaginas < $numeroAnuncios){ //adicionar quebra de página ao final do anúncio
                $pdf->AddPage();
            }
            
        }
        
        $pdf->Output(PIPROOT.'/pdf/'."anunciosEscolhidos".$_SESSION["login"]
                .date("is").".pdf", 'F');

        $dadosEmail["nomeArquivo"] = PIPROOT.'/pdf/'."anunciosEscolhidos".$_SESSION["login"]
                .date("is").".pdf";
        
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

           $listaAnuncioExpirado = $consultasAdHoc->ConsultarAnunciosPorUsuario($_SESSION['idusuario'], null, array('expirado', 'finalizado'), 'Aluguel');
           foreach ($listaAnuncioExpirado as $anuncio) {

               $expirado = $genericoDAO->consultar(new Imovel(), true, array("id" => $anuncio->getIdImovel()));
               $historico = $genericoDAO->consultar(new HistoricoAluguelVenda(), false, array("idanuncio" => $anuncio->getId()));
               $anuncio->setHistoricoaluguelvenda($historico[0]);
               
               $anuncio->setImovel($expirado[0]);
               $listarAnunciosExpirados[] = $anuncio;
           }
           $item["listaPlanos"] = $planos = $genericoDAO->consultar(new UsuarioPlano(), true, array("idusuario" => $_SESSION['idusuario'], "status" => "ativo"));
           
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
                   $entidadeAnuncio->setValormin($parametros["txtValor"]);
               }
               $entidadeUsuarioPlano = $genericoDAO->consultar(new UsuarioPlano(), true, array("id" => $parametros["sltPlano"]));
               $entidadeUsuarioPlano = $entidadeUsuarioPlano[0];
               if (($entidadeUsuarioPlano->getPlano()->getTitulo() != "infinity" && $_SESSION["tipopessoa"] == "pj") || $_SESSION["tipopessoa"] == "pf") {
                   //se o plano nao eh infinity e nem eh uma empresa, entao atualiza o status do usuarioplano
                   $entidadeUsuarioPlano->setStatus("utilizado");                    
               }
               if($genericoDAO->editar($entidadeAnuncio) && $genericoDAO->editar($entidadeUsuarioPlano)){
                   $genericoDAO->commit();
                   $genericoDAO->fecharConexao();
                   echo json_encode(array("resultado" => 1));
               }else{
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
        
        if(!$selecionarEmailAnuncio){ //verifica se o hash é valido
            $visao->setItem("errohashemail");
            $visao->exibir('VisaoErrosGenerico.php');
        }
        
        elseif($selecionarEmailAnuncio){ //caso o hash seja válido
            
            $verificarAtivo = $genericoDAO->consultar($anuncio, true, array("id" => $selecionarEmailAnuncio[0]->getIdAnuncio()));
      
            if ($verificarAtivo[0]->getStatus() != "cadastrado") { //verificar se o anuncio não está expirado ou finalizado

                $item = "errousuarioouanuncio";
                $visao = new Template();
                $visao->setItem($item);
                $visao->exibir("VisaoErrosGenerico.php");

                } elseif($verificarAtivo[0]->getStatus() == "cadastrado"){

                    $tipoImovel = new TipoImovel();

                    $tipo = $tipoImovel->retornaDescricaoTipo($verificarAtivo[0]->getImovel()->getIdTipoImovel());

                    $this->detalhar(array("hdnTipoImovel" => $tipo, "hdnCodAnuncio" => $verificarAtivo[0]->getId()));

                }
            
        }
        
    }
    
    function fimCadastroAnuncio($parametros){
        $this->detalhar(array("hdnTipoImovel" => $parametros["hdnTipo"], "hdnCodAnuncio" => $parametros["hdnCodAnuncio"]));
    }
    
    function alterarValor($parametros){
        
        if (Sessao::verificarSessaoUsuario()) {

            if (Sessao::verificarToken($parametros)) {

                $genericoDAO = new GenericoDAO();
                
                $novoValor = new NovoValorAnuncio();
                //setar os valores do objeto para edição
                $consultarValorInativar = $genericoDAO->consultar($novoValor, false, array("idanuncio" => $parametros["hdnAnuncio"]));
                //transformar de array para um único valor
                
                if($consultarValorInativar != null){ //setar a classe ValorNovo apenas se já existir valor
                    
                    $consultarValorInativar = $consultarValorInativar[0];
                    //setar apenas os campos que se quer editar
                    $setarInativacao = $novoValor->inativarValor($consultarValorInativar);
                    
                    $genericoDAO->iniciarTransacao();
                    //passar o objeto para edição
                    $inativar = $genericoDAO->editar($setarInativacao);
                    
                } else { //caso não exista um valor novo já cadastrado
                    
                    $genericoDAO->iniciarTransacao();
                    
                    $inativar = true;
                    
                    }
          
                $entidade = $novoValor->cadastrar($parametros);

                $resultadoNovoValor = $genericoDAO->cadastrar($entidade);

                if ($inativar && $resultadoNovoValor) {
                    
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

}
