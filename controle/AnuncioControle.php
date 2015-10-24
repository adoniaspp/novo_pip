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
include_once 'modelo/AnuncioClique.php';
include_once 'modelo/EmailAnuncio.php';
include_once 'modelo/SalaComercial.php';
include_once 'modelo/PredioComercial.php';
include_once 'modelo/Terreno.php';
include_once 'modelo/TipoImovel.php';
include_once 'modelo/Valor.php';
include_once 'modelo/ImovelDiferencial.php';
include_once 'modelo/Diferencial.php';

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
//        var_dump($parametros); die();
        $visao = new Template('ajax');
        $consultasAdHoc = new ConsultasAdHoc();
        $parametros["atributos"] = "*";
        $parametros["tabela"] = $parametros["tipoImovel"];
        if($parametros["page"]) $page = TRUE; 
        unset($parametros["page"]);
        unset($parametros["tipoImovel"]);
        unset($parametros["hdnEntidade"]);
        unset($parametros["hdnAcao"]);
        $parametros["predicados"] = $parametros;
        $listaAnuncio = $consultasAdHoc->buscaAnuncios($parametros);
        //var_dump($listaAnuncio); die();
        if (count($listaAnuncio['anuncio']) == 0) {
            $visao->setItem("errosemresultadobusca");
            $visao->exibir('VisaoErrosGenerico.php');
        }
        if($page) $listaAnuncio["page"] = TRUE;
         
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
        $parametros["predicados"] = $parametros;

        $listarAnuncio = $consultasAdHoc->buscaAnuncios($parametros);

        $usuarioQtdAnuncio = count($consultasAdHoc->ConsultarAnunciosPorUsuario($listarAnuncio["anuncio"][0]["id"], null, "cadastrado"));

        $usuario = $genericoDAO->consultar(new Usuario(), false, array("id" => $listarAnuncio["anuncio"][0]["id"]));

        $listarAnuncio["qtdAnuncios"] = $usuarioQtdAnuncio;

        $listarAnuncio["loginUsuario"] = $usuario[0]->getLogin();

        $visao->setItem($listarAnuncio);
        $visao->exibir('AnuncioVisaoDetalhe.php');
    }

    function exibirAnuncioURL($parametros) {

        $genericoDAO = new GenericoDAO();

        $anuncio = $genericoDAO->consultar(new Anuncio(), true, array("idanuncio" => $parametros));
        $usuario = $genericoDAO->consultar(new Usuario(), true, array("login" => $parametros));


        if ($usuario <> NULL) {
            return "usuario"; //se o usuário existir
        }

        if ($anuncio <> NULL) { //se o anuncio existir     
            $consultasAdHoc = new ConsultasAdHoc();
            $imovel = $genericoDAO->consultar(new Imovel(), true, array("id" => $anuncio[0]->getIdImovel()));
            $endereco = $genericoDAO->consultar(new Endereco(), true, array("id" => $imovel[0]->getIdEndereco()));
            $usuario = $genericoDAO->consultar(new Usuario(), true, array("id" => $imovel[0]->getIdUsuario()));
            $qtdAnuncios = count($consultasAdHoc->ConsultarAnunciosPorUsuario($imovel[0]->getIdUsuario(), null, "cadastrado"));

            $item["anuncio"] = $anuncio;
            $item["imovel"] = $imovel;
            $item["usuario"] = $usuario;
            $item["endereco"] = $endereco;
            $item["qtdAnuncios"] = $qtdAnuncios;

            $visao = new Template();
            $visao->setItem($item);
            $visao->exibir('AnuncioVisaoDetalheURL.php');
        } elseif (!$usuario && !$anuncio) { //se nem o anuncio nem o usuário existirem
            return false;
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
//            echo "<pre>";
//            print_r($listarAnuncio);
//            die();
            $indice++;
        }

//        echo "<pre>";
//        print_r($listarAnuncio);
//        die();

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
            $listaAnuncio = $consultasAdHoc->ConsultarAnunciosPorUsuario($_SESSION['idusuario'], null, 'cadastrado');
            foreach ($listaAnuncio as $anuncio) {
                $imovel = $genericoDAO->consultar(new Imovel(), false, array("id" => $anuncio->getIdImovel()));
                $anuncio->setImovel($imovel[0]);
                $listarAnuncios[] = $anuncio;
            }
            //visao
            $visao = new Template();
            $item["listaAnuncio"] = $listarAnuncios;
            $visao->setItem($item);
            $visao->exibir('AnuncioVisaoListagem.php');
        }
    }

    function cadastrar($parametros) {
//        echo "<pre>";
//        echo "parameetros<br>";
//        print_r($parametros);
//        echo "files<br>";
//        var_dump($_FILES);
//        echo "request<br>";
//        var_dump($_REQUEST);
//        exit();

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
                        if(is_object($plantas)) $plantas = array($plantas);
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
                            if(isset($sessaoImagemPlanta)){
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
                    //visao
                    if ($idAnuncio) {
                        $genericoDAO->commit();
                        Sessao::desconfigurarVariavelSessao("anuncio");
                        Sessao::desconfigurarVariavelSessao("imagemAnuncio");
                        Sessao::desconfigurarVariavelSessao("imagemPlanta");
                        echo json_encode(array("resultado" => 1));
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
                    $valorMinimo = $parametros["txtValor"];
                    break;
                case 2://apartamento na planta
                    $plantas = array("hdnValor0", "hdnValor1", "hdnValor2", "hdnValor3", "hdnValor4", "hdnValor5");
                    $menor = array();
                    foreach ($plantas as $planta) {
                        if (isset($parametros[$planta])) {
                            $minimo = min($parametros[$planta]);
                            $minimo = str_replace("R$", "", $minimo);
                            $minimo = str_replace(".", "", $minimo);
                            $minimo = str_replace(",", ".", $minimo);
                            $minimo = trim($minimo);
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

    function buscarAnuncioCorretor($parametros) {

        $visao = new Template();
        $emailanuncio = new EmailAnuncio();
        $usuario = new Usuario();
        $genericoDAO = new GenericoDAO();
        $selecionarAnuncioUsuario = $genericoDAO->consultar($usuario, true, array("login" => $parametros["login"]));
        if (!$selecionarAnuncioUsuario) {
            //verifica se o usuario existe na base ou se está inativo
            $visao->setItem("errousuarioinativo");
            $visao->exibir('VisaoErrosGenerico.php');
        } else {
            $item["usuario"] = $genericoDAO->consultar(new Usuario(), false, array("id" => $selecionarAnuncioUsuario[0]->getId()));
            $statusUsuario = $item["usuario"] = $genericoDAO->consultar(new Usuario(), false, array("id" => $selecionarAnuncioUsuario[0]->getId()));
            $verificarStatus = $selecionarAnuncioUsuario[0]->getStatus();
            $verificarStatus = $statusUsuario[0]->getStatus();
            $id = $statusUsuario[0]->getId();

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
    <p style="color: #222222; font-family: "Helvetica","Arial",sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 0 0 10px; padding: 0;" align="left">Acesse agora esse imóvel <a href="http://localhost/PIP/index.php?entidade=Anuncio&amp;acao=verficahashemail&amp;id=' . $selecionaremailanuncio->getHash() . '" style="color: #2ba6cb; text-decoration: none;">Clique Aqui! »</a></p>
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

    function enviarDuvidaAnuncio($parametros) {
// if (Sessao::verificarToken($parametros)) {

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

}
