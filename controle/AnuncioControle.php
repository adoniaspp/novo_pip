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
include_once 'assets/pager/Pager.php';
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
        unset($parametros["tipoImovel"]);
        unset($parametros["hdnEntidade"]);
        unset($parametros["hdnAcao"]);
        $parametros["predicados"] = $parametros;
        $listarAnuncio = $consultasAdHoc->buscaAnuncios($parametros);
        $visao->setItem($listarAnuncio);
        $visao->exibir('AnuncioVisaoBusca.php');
//        if($listarAnuncio){
//            echo json_encode($listarAnuncio);
//        }else{
//            echo json_encode("false");
//        }
    }

    function detalhar($parametros) {
//        var_dump($parametros);
        $parametros["id"] = $parametros["hdnCodAnuncio"];
        unset($parametros["hdnCodAnuncio"]);
        $parametros["tabela"] = $parametros["hdnTipoImovel"];
        unset($parametros["hdnTipoImovel"]);
        $visao = new Template();
        $consultasAdHoc = new ConsultasAdHoc();
        $parametros["atributos"] = "*";
        unset($parametros["hdnEntidade"]);
        unset($parametros["hdnAcao"]);
        $parametros["predicados"] = $parametros;
        $listarAnuncio = $consultasAdHoc->buscaAnuncios($parametros);
//        print_r($listarAnuncio);
//        die();
        $visao->setItem($listarAnuncio);
        $visao->exibir('AnuncioVisaoDetalhe.php');
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

                $listarImovel[] = $selecionarImovel;
            }
            //visao
            $visao = new Template();
            $visao->setItem($listarImovel);
            $visao->exibir('AnuncioVisaoListagemCadastrar.php');
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

                    $entidadeUsuarioPlano = $genericoDAO->consultar(new UsuarioPlano(), true, array("id" => $parametros["sltPlano"]));
                    $entidadeUsuarioPlano = $entidadeUsuarioPlano[0];
                    if (($entidadeUsuarioPlano->getPlano()->getTitulo() != "infinity" && $_SESSION["tipopessoa"] == "pj") || $_SESSION["tipopessoa"] == "pf") {
                        //se o plano nao eh infinity e nem eh uma empresa, entao atualiza o status do usuarioplano
                        $entidadeUsuarioPlano->setStatus("utilizado");
                        $genericoDAO->editar($entidadeUsuarioPlano);
                    }

                    if (isset($_SESSION["imagem"])) {
                        foreach ($_SESSION["imagem"] as $file) {
                            $imagem = new Imagem();
                            $entidadeImagem = $imagem->cadastrar($file, $idAnuncio, $parametros["rdbDestaque"]);
                            $idImagem = $genericoDAO->cadastrar($entidadeImagem);
                        }
                    } else {
                        $imagem = new Imagem();
                        $file->url = PIPURL . "/assets/imagens/foto_padrao.png";
                        $file->legenda = "";
                        $file->name = "padrao";
                        $entidadeImagem = $imagem->cadastrar($file, $idAnuncio, "padrao");
                        $idImagem = $genericoDAO->cadastrar($entidadeImagem);
                    }

                    //visao
                    if ($idAnuncio) {
                        $genericoDAO->commit();
                        Sessao::desconfigurarVariavelSessao("anuncio");
                        Sessao::desconfigurarVariavelSessao("imagem");
                        echo json_encode(array("resultado" => 1));
                    } else {
                        $genericoDAO->rollback();
                        echo json_encode(array("resultado" => 0));
                    }
                }
            }
        }
    }

    private function verificaValorMinimo($anuncio, $parametros) {
        switch ($_SESSION["anuncio"]["tipoimovel"]) {
            case 1://casa
            case 3://apartamento
            case 4://sala comercial
            case 5://predio comercial
            case 6://terreno
                $anuncio->setValormin($parametros["txtValor"]);
                break;
        }
    }

}
