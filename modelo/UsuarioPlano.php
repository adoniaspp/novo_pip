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

    public function DataExpiracao($dias) {
        $dateB = date_create_from_format("Y-m-d H:s:i", $this->getDatacompra());
        $dateA = $dateB->add(date_interval_create_from_date_string($dias . 'days'));
        return date_format($dateA, "d/m/Y");
    }

    public function cadastrar($idplano) {
        $this->setIdplano($idplano);
        $this->setIdusuario($_SESSION["idusuario"]);
        $this->setDatacompra(date("Y/m/d H:i:s"));       
        $this->setStatus("pagamento pendente");
    }

    public function permitidoCadastrar() {
        $permitido = false;
        //verifica se status esta ativo e se eh o mesmo usuario logado
        if ($this->getStatus() == "pago" && $_SESSION['idusuario'] == $this->getIdusuario()) {
            $permitido = true;
        }
        
        return $permitido;
    }

    public function reativarPlano() {
        if ($_SESSION['login'] === "pipdiministrador") {
            $this->setStatus("pago");
        }
    }

}
