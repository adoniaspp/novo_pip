<?php

include_once 'modelo/ChamadoAssunto.php';
include_once 'modelo/ChamadoResposta.php';
include_once 'DAO/GenericoDAO.php';
include_once 'assets/libs/log4php/Logger.php';
include_once 'configuracao/Log.php';

class ChamadoAssuntoControle {
  
    function buscarChamadoLista($parametros) {
        $genericoDAO = new GenericoDAO();
        
        $chamadoAssunto = new ChamadoAssunto();
        
        $assunto = $genericoDAO->consultar($chamadoAssunto, true, array("idtipo" => $parametros["sltTipoChamado"]));
        
        //ordenar os assuntos pelo Id do banco
        $assuntoOrdenado = $assunto;

                        usort($assuntoOrdenado, function( $a, $b ) {
                            return ( $a->getId() > $b->getId() );
                        });
        
        foreach ($assuntoOrdenado as $assuntos) {
            
            echo "<div class='item' data-value='".$assuntos->getId()."'>".$assuntos->getAssunto()."</div>";
      
        }
    }
    
}
