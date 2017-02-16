<?php

include_once 'modelo/DenunciaTipo.php';
include_once 'modelo/Denuncia.php';
include_once 'modelo/Usuario.php';

class DenunciaControle {

    function denunciarAnuncio($parametros) {

        $genericoDAO = new GenericoDAO();

        $genericoDAO->iniciarTransacao();

        if (Sessao::verificarSessaoUsuario()) {
            $usuario = new Usuario();
            $usuario = $genericoDAO->consultar($usuario, false, array("id" => $parametros["hdnUsuario"]));
            $parametros["txtEmailDenuncia"] = $usuario[0]->getEmail();
        }

        $denuncia = new Denuncia();

        $entidadeDenuncia = $denuncia->criarDenuncia($parametros);

        $resultadoDenuncia = $genericoDAO->cadastrar($entidadeDenuncia);

        if ($resultadoDenuncia) {

            $genericoDAO->commit();

            $genericoDAO->fecharConexao();

            echo json_encode(array("resultado" => 1));

            //banco
        } else {

            $genericoDAO->rollback();

            $genericoDAO->fecharConexao();

            echo json_encode(array("resultado" => 0));
        }
    }

    function buscarTipoDenuncia() {
        $genericoDAO = new GenericoDAO();

        $tipoDenuncia = new DenunciaTipo();

        $tipoDenuncia = $genericoDAO->consultar($tipoDenuncia, false);

        $denunciaOrdenada = $tipoDenuncia;

        usort($denunciaOrdenada, function( $a, $b ) {
            return ( $a->getId() > $b->getId() );
        });

        foreach ($denunciaOrdenada as $denuncias) {

            echo "<div class='item' data-value='" . $denuncias->getId() . "'>" . $denuncias->getDescricao() . "</div>";
        }
    }

}
