<?php


class Anuncio {
   
    private $id;   
    private $idimovel;    
    private $finalidade;
    private $tituloanuncio;
    private $descricaoanuncio;
    private $status;
    private $datahoracadastro;
    private $datahoraalteracao;
    private $datahoradesativacao;
    private $valorvisivel;
    private $publicarmapa;
    private $publicarcontato;
    private $idusuarioplano;
    private $valormin;
        
    protected $imovel;
    protected $usuarioplano;
    
    public function getId() {
        return $this->id;
    }

    public function getIdimovel() {
        return $this->idimovel;
    }

    public function getFinalidade() {
        return $this->finalidade;
    }

    public function getTituloanuncio() {
        return $this->tituloanuncio;
    }

    public function getDescricaoanuncio() {
        return $this->descricaoanuncio;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getDatahoracadastro() {
        return $this->datahoracadastro;
    }

    public function getDatahoraalteracao() {
        return $this->datahoraalteracao;
    }

    public function getDatahoradesativacao() {
        return $this->datahoradesativacao;
    }

    public function getValorvisivel() {
        return $this->valorvisivel;
    }

    public function getPublicarmapa() {
        return $this->publicarmapa;
    }

    public function getPublicarcontato() {
        return $this->publicarcontato;
    }

    public function getIdusuarioplano() {
        return $this->idusuarioplano;
    }

    public function getValormin() {
        return $this->valormin;
    }

    public function getImovel() {
        return $this->imovel;
    }

    public function getUsuarioplano() {
        return $this->usuarioplano;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdimovel($idimovel) {
        $this->idimovel = $idimovel;
    }

    public function setFinalidade($finalidade) {
        $this->finalidade = $finalidade;
    }

    public function setTituloanuncio($tituloanuncio) {
        $this->tituloanuncio = $tituloanuncio;
    }

    public function setDescricaoanuncio($descricaoanuncio) {
        $this->descricaoanuncio = $descricaoanuncio;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setDatahoracadastro($datahoracadastro) {
        $this->datahoracadastro = $datahoracadastro;
    }

    public function setDatahoraalteracao($datahoraalteracao) {
        $this->datahoraalteracao = $datahoraalteracao;
    }

    public function setDatahoradesativacao($datahoradesativacao) {
        $this->datahoradesativacao = $datahoradesativacao;
    }

    public function setValorvisivel($valorvisivel) {
        $this->valorvisivel = $valorvisivel;
    }

    public function setPublicarmapa($publicarmapa) {
        $this->publicarmapa = $publicarmapa;
    }

    public function setPublicarcontato($publicarcontato) {
        $this->publicarcontato = $publicarcontato;
    }

    public function setIdusuarioplano($idusuarioplano) {
        $this->idusuarioplano = $idusuarioplano;
    }

    public function setValormin($valormin) {
        $this->valormin = $this->limpaValorNumerico($valormin);
    }

    public function setImovel($imovel) {
        $this->imovel = $imovel;
    }

    public function setUsuarioplano($usuarioplano) {
        $this->usuarioplano = $usuarioplano;
    }
        
    public function cadastrar($parametros) {
        $this->setIdImovel($_SESSION["anuncio"]["idimovel"]);
        $this->setFinalidade($parametros['sltFinalidade']);
        $this->setTituloAnuncio($parametros['txtTitulo']);
        $this->setDescricaoAnuncio($parametros['txtDescricao']);
        $this->setStatus('cadastrado');
        $this->setDatahoracadastro(date("Y/m/d H:i:s"));
        $this->setDatahoraalteracao('');
        $this->setDatahoradesativacao('');
        $this->setValorVisivel((isset($parametros['sltCamposVisiveis']) ? json_encode($parametros['sltCamposVisiveis']) : ""));
        $this->setPublicarmapa((isset($parametros['chkMapa']) ? "SIM" : "NAO"));
        $this->setPublicarcontato((isset($parametros['chkContato']) ? "SIM" : "NAO"));
        $this->setIdusuarioplano($parametros['sltPlano']);
        return $this;
    }

    private function limpaValorNumerico($valor) {
        $valor = str_replace("R$", "", $valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", ".", $valor);
        $valor = trim($valor);
        return $valor;
    }
}
