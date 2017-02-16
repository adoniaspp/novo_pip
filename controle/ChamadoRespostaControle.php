<?php

include_once 'modelo/ChamadoResposta.php';
include_once 'modelo/Chamado.php';
include_once 'DAO/GenericoDAO.php';
include_once 'assets/libs/log4php/Logger.php';
include_once 'configuracao/Log.php';

class ChamadoRespostaControle {
    
    use Log;
    
    function responderChamado($parametros){
        
        $this->log("Inicio da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));

        if (Sessao::verificarToken($parametros)) {
        
        $genericoDAO = new GenericoDAO();

        $chamadoResposta = new ChamadoResposta();
        
        $chamado = new Chamado();
        
        $entidadeChamado = $chamado->alterarStatus($parametros);
        
        $idChamado = $genericoDAO->editar($entidadeChamado);

        $entidadeChamadoResposta = $chamadoResposta->cadastrar($parametros);
        
        $genericoDAO->iniciarTransacao();
        
        $idChamadoResposta = $genericoDAO->cadastrar($entidadeChamadoResposta);
        
        if($idChamadoResposta && $idChamado){

            $genericoDAO->commit();

            $genericoDAO->fecharConexao();

            echo json_encode(array("resultado" => 1)); //resposta cadastrada
                
        } else {
        
        $genericoDAO->rollback();    
            
        echo json_encode(array("resultado" => 0));    
            
        }
        
        }
        
    }
    
    function usuarioRespondeChamado($parametros){
        
        $this->log("Inicio da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));

        if (Sessao::verificarToken($parametros)) {
        
        $genericoDAO = new GenericoDAO();

        $chamadoResposta = new ChamadoResposta();
        
        $chamado = new Chamado();
        
        $entidadeChamado = $chamado->alterarStatus($parametros);
        
        $idChamado = $genericoDAO->editar($entidadeChamado);

        $entidadeChamadoResposta = $chamadoResposta->cadastrar($parametros);
        
        $genericoDAO->iniciarTransacao();
        
        $idChamadoResposta = $genericoDAO->cadastrar($entidadeChamadoResposta);
        
        if($idChamadoResposta && $idChamado){

            $genericoDAO->commit();

            $genericoDAO->fecharConexao();

            echo json_encode(array("resultado" => 1)); //resposta cadastrada
                
        } else {
        
        $genericoDAO->rollback();    
            
        echo json_encode(array("resultado" => 0));    
            
        }
        
        }
        
    }
    
}
