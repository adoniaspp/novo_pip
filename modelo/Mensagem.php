<?php

class Mensagem {

    private $id;
    private $idanuncio;
    private $idusuario;
    private $nome;
    private $email;
    private $telefone;
    private $mensagem;
    private $proposta;
    private $status;
    private $datahora;
    protected $usuario;
    protected $anuncio;
    protected $respostamensagem; #Utilizado somente para recuperar a resposta

    function getId() {
        return $this->id;
    }

    function getIdanuncio() {
        return $this->idanuncio;
    }

    function getIdusuario() {
        return $this->idusuario;
    }

    function getNome() {
        return htmlspecialchars($this->nome);
    }

    function getEmail() {
        return htmlspecialchars($this->email);
    }

    function getTelefone() {
        return htmlspecialchars($this->telefone);
    }

    function getMensagem() {
        return htmlspecialchars($this->mensagem);
    }

    function getProposta() {
        return htmlspecialchars($this->proposta);
    }

    function getStatus() {
        return $this->status;
    }

    function getDatahora() {
        return $this->datahora;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getAnuncio() {
        return $this->anuncio;
    }

    function getRespostamensagem() {
        return $this->respostamensagem;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdanuncio($idanuncio) {
        $this->idanuncio = $idanuncio;
    }

    function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    function setProposta($proposta) {
        $this->proposta = $proposta;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setDatahora($datahora) {
        $this->datahora = $datahora;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setAnuncio($anuncio) {
        $this->anuncio = $anuncio;
    }

    function setRespostamensagem($respostamensagem) {
        $this->respostamensagem = $respostamensagem;
    }

    
    function cadastrar($parametros) {

        $mensagem = new Mensagem();
        $mensagem->setNome($parametros['txtNomeDuvida']);
        $mensagem->setEmail($parametros['txtEmailDuvida']);
        $mensagem->setTelefone("");
        $mensagem->setMensagem($parametros['txtMsgDuvida']);
        $mensagem->setProposta($parametros['txtProposta']);
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
