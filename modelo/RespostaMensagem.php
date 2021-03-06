<?php

class RespostaMensagem{
    private $id;
    private $idMensagem;
    private $resposta;
    private $datahora;
    
    
    public function getId() {
        return $this->id;
    }

    public function getIdMensagem() {
        return $this->idMensagem;
    }

    public function getResposta() {
        return htmlspecialchars($this->resposta);
    }

    public function getDatahora() {
        return $this->datahora;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdMensagem($idMensagem) {
        $this->idMensagem = $idMensagem;
    }

    public function setResposta($resposta) {
        $this->resposta = $resposta;
    }

    public function setDatahora($datahora) {
        $this->datahora = $datahora;
    }

    public function cadastrar($parametros){

        $respostaMensagem = new RespostaMensagem();
        $respostaMensagem->setIdMensagem($_SESSION["mensagem"][$parametros["hdnMensagem"]]);
        $respostaMensagem->setResposta($parametros["txtResposta"]);
        $respostaMensagem->setDatahora(date("Y/m/d H:i:s"));
        return $respostaMensagem;
    }

}

