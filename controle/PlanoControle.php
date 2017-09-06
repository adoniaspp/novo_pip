<?php

include_once 'modelo/Plano.php';
include_once 'controle/UsuarioPlanoControle.php';
include_once 'DAO/GenericoDAO.php';

class PlanoControle {

    function listar($parametro) {
        //modelo
        $estaLogado = Sessao::verificarSessaoUsuario();
        //visao
        if ($estaLogado) {
            $redirecionamento = new UsuarioPlanoControle();
            $redirecionamento->listar();
        } else {
            $plano = new Plano();
            $genericoDAO = new GenericoDAO();
            $listarPlano = $genericoDAO->consultar($plano, true, array("status" => "ativo"));
            $visao = new Template();
            $visao->setItem($listarPlano);
            $visao->exibir('PlanoVisaoListagem.php');
        }
    }

    function precosAnuncios() {
        $visao = new Template();
        $visao->exibir('PrecosVisaoListagem.php');
    }

    function maximoDeImagens($parametros) {
        $genericoDAO = new GenericoDAO();
        //var_dump($parametros);
        if ($parametros["plano"] == "gratuito") {
            $listarPlano = $genericoDAO->consultar(new Plano(), false, array("status" => "ativo", "id" => 5));
            echo json_encode(array("resultado" => $listarPlano[0]->getMaximoimagens()));
        } else {
            $listarPlano = $genericoDAO->consultar(new UsuarioPlano(), true, array("id" => $parametros["plano"]));
//            var_dump($listarPlano);
            if (is_array($listarPlano)) {
                echo json_encode(array("resultado" => $listarPlano[0]->getPlano()->getMaximoimagens()));
            } else {
                echo json_encode(array("resultado" => 0));
            }
        }
    }

}

?>