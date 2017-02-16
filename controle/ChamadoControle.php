<?php

include_once 'modelo/Chamado.php';
include_once 'modelo/ChamadoAssunto.php';
include_once 'modelo/ChamadoTitulo.php';
include_once 'modelo/ChamadoResposta.php';
include_once 'modelo/Usuario.php';
include_once 'DAO/GenericoDAO.php';
include_once 'assets/libs/log4php/Logger.php';
include_once 'configuracao/Log.php';

class ChamadoControle {
    
    function listarChamados(){
        
        $genericoDAO = new GenericoDAO();
        $usuario = new Usuario();
        $ch = new Chamado();
        
        if(($_SESSION['login'] === "pipdiministrador")){
                $administrador = true; 
            }    
                $listaChamado = $genericoDAO->consultar($ch, true);
                
                foreach ($listaChamado as $chamado) {
                    $dadosUsuario = $genericoDAO->consultar($usuario, false, array("id" => $chamado->getIdUsuario()));
                    $chamado->setUsuario($dadosUsuario[0]);
                    
                    $listarChamado[] = $chamado;
                }
            
            $visao = new Template();
            $item["listaChamado"] = $listarChamado;
            $visao->setItem($item);
            
        $visao->exibir('ChamadoVisaoListagem.php');
    }
    
}
