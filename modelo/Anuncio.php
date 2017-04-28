<?php

class Anuncio {

    private $id;
    private $idimovel;
    private $idanuncio;
    private $finalidade;
    private $tituloanuncio;
    private $descricaoanuncio;
    private $status;
    private $datahoracadastro;
    private $datahoraalteracao;
    private $datahoradesativacao;
    private $publicarmapa;
    private $publicarcontato;
    private $idusuarioplano;
    private $valormin;
    protected $imovel;
    protected $usuarioplano;
    protected $historicoaluguelvenda;
    protected $novovaloranuncio;
    protected $mapaimovel;
    protected $imagem;

    function getId() {
        return $this->id;
    }

    function getIdimovel() {
        return $this->idimovel;
    }

    function getIdanuncio() {
        return $this->idanuncio;
    }

    function getFinalidade() {
        return $this->finalidade;
    }

    function getTituloanuncio() {
        return $this->tituloanuncio;
    }

    function getDescricaoanuncio() {
        return $this->descricaoanuncio;
    }

    function getStatus() {
        return $this->status;
    }

    function getDatahoracadastro() {
        return $this->datahoracadastro;
    }

    function getDatahoraalteracao() {
        return $this->datahoraalteracao;
    }

    function getDatahoradesativacao() {
        return $this->datahoradesativacao;
    }

    function getPublicarmapa() {
        return $this->publicarmapa;
    }

    function getPublicarcontato() {
        return $this->publicarcontato;
    }

    function getIdusuarioplano() {
        return $this->idusuarioplano;
    }

    function getValormin() {
        return $this->valormin;
    }

    function getImovel() {
        return $this->imovel;
    }

    function getUsuarioplano() {
        return $this->usuarioplano;
    }

    function getHistoricoaluguelvenda() {
        return $this->historicoaluguelvenda;
    }

    function getNovovaloranuncio() {
        return $this->novovaloranuncio;
    }

    function getMapaimovel() {
        return $this->mapaimovel;
    }

    function getImagem() {
        return $this->imagem;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdimovel($idimovel) {
        $this->idimovel = $idimovel;
    }

    function setIdanuncio($idanuncio) {
        $this->idanuncio = $idanuncio;
    }

    function setFinalidade($finalidade) {
        $this->finalidade = $finalidade;
    }

    function setTituloanuncio($tituloanuncio) {
        $this->tituloanuncio = $tituloanuncio;
    }

    function setDescricaoanuncio($descricaoanuncio) {
        $this->descricaoanuncio = $descricaoanuncio;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setDatahoracadastro($datahoracadastro) {
        $this->datahoracadastro = $datahoracadastro;
    }

    function setDatahoraalteracao($datahoraalteracao) {
        $this->datahoraalteracao = $datahoraalteracao;
    }

    function setDatahoradesativacao($datahoradesativacao) {
        $this->datahoradesativacao = $datahoradesativacao;
    }

    function setPublicarmapa($publicarmapa) {
        $this->publicarmapa = $publicarmapa;
    }

    function setPublicarcontato($publicarcontato) {
        $this->publicarcontato = $publicarcontato;
    }

    function setIdusuarioplano($idusuarioplano) {
        $this->idusuarioplano = $idusuarioplano;
    }

    function setValormin($valormin) {
        $this->valormin = $valormin;
    }

    function setImovel($imovel) {
        $this->imovel = $imovel;
    }

    function setUsuarioplano($usuarioplano) {
        $this->usuarioplano = $usuarioplano;
    }

    function setHistoricoaluguelvenda($historicoaluguelvenda) {
        $this->historicoaluguelvenda = $historicoaluguelvenda;
    }

    function setNovovaloranuncio($novovaloranuncio) {
        $this->novovaloranuncio = $novovaloranuncio;
    }

    function setMapaimovel($mapaimovel) {
        $this->mapaimovel = $mapaimovel;
    }

    function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function alterarStatus($parametros) {
        $this->setId($parametros['hdnAnuncio']);
        $this->setStatus($parametros['sltStatusAnuncio']);
        $this->setDatahoraalteracao(date("Y/m/d H:i:s"));
        return $this;
    }

}
