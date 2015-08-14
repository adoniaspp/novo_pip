<?php

class Mensagem {

    private $id;
    private $idanuncio;
    private $idusuario;
    private $nome;
    private $email;
    private $telefone;
    private $mensagem;
    private $status;
    private $datahora;
    protected $usuario;
    protected $anuncio;
    protected $respostamensagem; #Utilizado somente para recuperar a resposta

    public function getRespostamensagem() {
        return $this->respostamensagem;
    }

    public function setRespostamensagem($respostamensagem) {
        $this->respostamensagem = $respostamensagem;
    }

    public function getId() {
        return $this->id;
    }

    public function getIdanuncio() {
        return $this->idanuncio;
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getMensagem() {
        return $this->mensagem;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getDatahora() {
        return $this->datahora;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getAnuncio() {
        return $this->anuncio;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdanuncio($idanuncio) {
        $this->idanuncio = $idanuncio;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setDatahora($datahora) {
        $this->datahora = $datahora;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setAnuncio($anuncio) {
        $this->anuncio = $anuncio;
    }

    function cadastrar($parametros) {

        $mensagem = new Mensagem();
        $mensagem->setNome($parametros['txtNomeDuvida']);
        $mensagem->setEmail($parametros['txtEmailDuvida']);
        $mensagem->setTelefone("");
        $mensagem->setMensagem($parametros['txtMsgDuvida']);
        $mensagem->setStatus("NOVA");
        $mensagem->setDatahora(date('d/m/Y H:i:s'));
        $mensagem->setIdanuncio($parametros['hdnAnuncio']);
        $mensagem->setIdusuario($parametros['hdnUsuario']);

        //$mensagem->setArquivada("NÃO");
        return $mensagem;
    }

    function editar($parametros, $status, $i = NULL) {
        $mensagem = new Mensagem();
        if ($parametros["hdnAcao"] == "lerMensagem") {
            $mensagem->setId($_SESSION["mensagem"][$parametros["id"]]);
        } else {
            $mensagem->setId($_SESSION["mensagem"][$parametros["msgs"][$i]["value"]]);
        }
        $mensagem->setStatus($status);
        return $mensagem;
    }

}
