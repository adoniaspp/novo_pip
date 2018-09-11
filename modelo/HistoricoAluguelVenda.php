<?php

class HistoricoAluguelVenda {

    private $id;
    private $descricao;
    private $sucesso;
    private $idanuncio;
    private $datahora;
    
    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getSucesso() {
        return $this->sucesso;
    }

    function getIdanuncio() {
        return $this->idanuncio;
    }

    function getDatahora() {
        return $this->datahora;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setSucesso($sucesso) {
        $this->sucesso = $sucesso;
    }

    function setIdanuncio($idanuncio) {
        $this->idanuncio = $idanuncio;
    }

    function setDatahora($datahora) {
        $this->datahora = $datahora;
    }      

    function cadastrar($parametros) {
        $historicoAluguelVenda = new HistoricoAluguelVenda();
        $historicoAluguelVenda->setDescricao($parametros['txtFinalizar']);
        $historicoAluguelVenda->setSucesso($parametros['radioSucesso']);
        $historicoAluguelVenda->setIdanuncio($parametros['hdnAnuncio']);
        $historicoAluguelVenda->setDatahora(date("Y/m/d H:i:s"));
        return $historicoAluguelVenda;
    }

}
