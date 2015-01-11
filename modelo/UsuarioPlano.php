<?php

class UsuarioPlano {

    private $id;
    private $idplano;
    private $status;
    private $datacompra;
    private $idusuario;
    protected $plano;

    public function getId() {
        return $this->id;
    }

    public function getIdplano() {
        return $this->idplano;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getDatacompra() {
        return $this->datacompra;
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function getPlano() {
        return $this->plano;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdplano($idplano) {
        $this->idplano = $idplano;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setDatacompra($datacompra) {
        $this->datacompra = $datacompra;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function setPlano($plano) {
        $this->plano = $plano;
    }

    public function DataExpiracao($validadeativacao) {
        $dataCompra = explode(" ", $this->getDatacompra());
        $dateB = date_create_from_format("d/m/Y", $dataCompra[0]); 
        $dateA = $dateB->add(date_interval_create_from_date_string($validadeativacao . 'days'));
        return date_format($dateA,"d/m/Y");
    }
    
    public function cadastrar($idplano){
        $this->setIdplano($idplano);
        $this->setIdusuario($_SESSION["idusuario"]);
        $this->setDatacompra(date('d/m/Y H:i:s'));
        $this->setStatus("pagamento pendente");        
    }
}
