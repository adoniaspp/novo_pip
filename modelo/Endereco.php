<?php

class Endereco {
    
    private $id;
    private $cep;
    private $idestado;
    private $idcidade;
    private $idbairro;
    private $logradouro;
    private $numero;
    private $complemento;
    protected $estado;
    protected $cidade;
    protected $bairro;

    public function getId() {
        return $this->id;
    }

    public function getCep() {
        return $this->cep;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getLogradouro() {
        return $this->logradouro;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getComplemento() {
        return $this->complemento;
    }
    
    public function getIdestado() {
        return $this->idestado;
    }
    
    public function getIdcidade() {
        return $this->idcidade;
    }
    
    public function getIdbairro() {
        return $this->idbairro;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
     public function setIdestado($idestado) {
        $this->idestado = $idestado;
    }
    
    public function setIdcidade($idcidade) {
        $this->idcidade = $idcidade;
    }
    
    public function setIdbairro($idbairro) {
        $this->idbairro = $idbairro;
    }

    public function setCep($cep) {
        $this->cep = str_replace("-", "", str_replace(".", "", $cep));
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    public function setLogradouro($logradouro) {
        $this->logradouro = $logradouro;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    function cadastrar($parametros, $idestado, $idcidade, $idbairro){
        $endereco = new Endereco();
        $endereco->setCep($parametros['hdnCEP']);
        $endereco->setIdestado($idestado);
        $endereco->setIdcidade($idcidade);
        $endereco->setIdbairro($idbairro);
        $endereco->setLogradouro($parametros['txtLogradouro']);
        $endereco->setNumero($parametros['txtNumero']);
        $endereco->setComplemento($parametros['txtComplemento']);
        return $endereco;
    }
    
    function editar($parametros,$idendereco,$idestado, $idcidade, $idbairro){
        $endereco = new Endereco();
        $endereco->setId($idendereco);
        $endereco->setCep($parametros['hdnCEP']);
        $endereco->setIdestado($idestado);
        $endereco->setIdcidade($idcidade);
        $endereco->setIdbairro($idbairro);
        $endereco->setLogradouro($parametros['txtLogradouro']);
        $endereco->setNumero($parametros['txtNumero']);
        $endereco->setComplemento($parametros['txtComplemento']);
//        print_r($endereco);        
//        die();
        return $endereco;
    }
    
    public function enderecoMapa(){
        return 'Brazil, ' . $this->getEstado()->getUf() . ', ' . $this->getCidade()->getNome() . ', ' . $this->getBairro()->getNome() . ', ' . $this->getLogradouro();        
    }
}
