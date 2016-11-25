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
    
    function precosAnuncios(){
         $visao = new Template();
         $visao->exibir('PrecosVisaoListagem.php');
    }
}

?>