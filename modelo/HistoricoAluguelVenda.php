<?php

class HistoricoAluguelVenda {

    private $id;
    private $descricao;
    private $idanuncio;
    private $datahora;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getIdanuncio() {
        return $this->idanuncio;
    }

    public function setIdanuncio($idanuncio) {
        $this->idanuncio = $idanuncio;
    }

    public function getDatahora() {
        return $this->datahora;
    }

    public function setDatahora($datahora) {
        $this->datahora = $datahora;
    }

    function cadastrar($parametros) {
        $historicoAluguelVenda = new HistoricoAluguelVenda();
        $historicoAluguelVenda->setDescricao($parametros['txtDescricao']);
        $historicoAluguelVenda->setIdanuncio($parametros['hdnAnuncio']);
        $historicoAluguelVenda->setDatahora(date('d/m/Y H:i:s'));
        return $historicoAluguelVenda;
    }

}
