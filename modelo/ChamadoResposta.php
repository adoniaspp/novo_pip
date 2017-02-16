<?php


class ChamadoResposta {
    
    private $id;
    private $idchamado;
    private $status;
    private $resposta;
    private $administracao;
    private $datahoracadastro;
    
    function getId() {
        return $this->id;
    }

    function getIdchamado() {
        return $this->idchamado;
    }

    function getStatus() {
        return $this->status;
    }

    function getResposta() {
        return $this->resposta;
    }

    function getAdministracao() {
        return $this->administracao;
    }

    function getDatahoracadastro() {
        return $this->datahoracadastro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdchamado($idchamado) {
        $this->idchamado = $idchamado;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setResposta($resposta) {
        $this->resposta = $resposta;
    }

    function setAdministracao($administracao) {
        $this->administracao = $administracao;
    }

    function setDatahoracadastro($datahoracadastro) {
        $this->datahoracadastro = $datahoracadastro;
    }

        
    function cadastrar($parametros){
        
        $this->setIdchamado($parametros['hdnChamado']);
        $this->setResposta($parametros['txtRespostaChamado']);
        $this->setStatus($parametros['sltStatusChamadoResposta']);
        if($parametros["hdnAdmin"] == "SIM"){
            $this->setAdministracao("SIM");
        } else $this->setAdministracao("NAO");
    
        $this->setDatahoracadastro(date("Y/m/d H:i:s"));
        
        return $this;
        
    }
    
    function resposta($parametros){
        
        $this->setIdchamado($parametros['hdnChamado']);
        $this->setResposta($parametros['txtRespostaChamado']);
        $this->setStatus($parametros['sltStatusChamadoResposta']);
        $this->setAdministracao("NAO");        
        $this->setDatahoracadastro(date("Y/m/d H:i:s"));
        
        return $this;
        
    }
    
}
