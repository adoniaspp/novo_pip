<?php

include_once 'modelo/Anuncio.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Imovel.php';
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


class AnuncioControle {
    function buscar($parametros) {
//        $anuncio = new Anuncio();
        $consultasAdHoc = new ConsultasAdHoc();
        $parametros["atributos"] = "id, finalidade, logradouro";
        $parametros["tabela"] = "casa";
        $parametros["predicados"] = array("finalidade" => array("aluguel"), "estado" => array('Pará', 'Ananindeua')); 
        //No caso dos multiplos o alguel seria o array da visão.
        $listarAnuncio = $consultasAdHoc->buscaAnuncios($parametros);
        $visao = new Template();
        $visao->setItem($listarAnuncio);
        $visao->exibir('AnuncioVisaoBusca.php');
    }
    
}

