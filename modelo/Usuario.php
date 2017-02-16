<?php

class Usuario {

    private $id;
    private $tipousuario;
    private $nome;
    private $cpfcnpj;
    private $login;
    private $senha;
    private $status;
    private $datahoracadastro;
    private $datahoraalteracao;
    private $email;
    private $idendereco;
    private $exibirendereco;
    private $exibircontato;
    private $exibiranuncios;
    private $foto;
    protected $endereco;
    protected $telefone;
    protected $empresa;

    function getId() {
        return $this->id;
    }

    function getTipousuario() {
        return $this->tipousuario;
    }

    function getNome() {
        return $this->nome;
    }

    function getCpfcnpj() {
        return $this->cpfcnpj;
    }

    function getLogin() {
        return $this->login;
    }

    function getSenha() {
        return $this->senha;
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

    function getEmail() {
        return $this->email;
    }

    function getIdendereco() {
        return $this->idendereco;
    }

    function getExibirendereco() {
        return $this->exibirendereco;
    }

    function getExibircontato() {
        return $this->exibircontato;
    }

    function getExibiranuncios() {
        return $this->exibiranuncios;
    }

    function getFoto() {
        return $this->foto;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getEmpresa() {
        return $this->empresa;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTipousuario($tipousuario) {
        $this->tipousuario = $tipousuario;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setCpfcnpj($cpfcnpj) {
        $this->cpfcnpj = $cpfcnpj;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setSenha($senha) {
        $this->senha = $senha;
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

    function setEmail($email) {
        $this->email = $email;
    }

    function setIdendereco($idendereco) {
        $this->idendereco = $idendereco;
    }

    function setExibirendereco($exibirendereco) {
        $this->exibirendereco = $exibirendereco;
    }

    function setExibircontato($exibircontato) {
        $this->exibircontato = $exibircontato;
    }

    function setExibiranuncios($exibiranuncios) {
        $this->exibiranuncios = $exibiranuncios;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

    
    function criptografarSenha($senha) {
        $timeTarget = 0.2;
        $cost = 9;
        do {
            $cost++;
            $start = microtime(true);
            password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);
        $options = [
            'cost' => $cost,
        ];
        return password_hash($senha, PASSWORD_BCRYPT, $options);
    }

    function cadastrar($parametros, $idendereco) {
        $usuario = new Usuario();
        $usuario->setTipousuario($parametros['sltTipoUsuario']);
        $usuario->setLogin($parametros['txtLogin']);
        $usuario->setSenha($this->criptografarSenha($parametros['txtSenha']));

        if ($usuario->getTipousuario() == "pf") {
            $usuario->setCpfcnpj($parametros['txtCPF']);
            $usuario->setNome($parametros['txtNome']);
        } else {
            $usuario->setCpfcnpj($parametros['txtCNPJ']);
            $usuario->setNome($parametros['txtNomeEmpresa']);
        }
        $usuario->setEmail($parametros['txtEmail']);
        $usuario->setStatus("ativo");
        $usuario->setDatahoracadastro(date('Y-m-d H:i:s'));
        $usuario->setDatahoraalteracao("");
        $usuario->setIdendereco($idendereco);
        $usuario->setExibirendereco("SIM");
        $usuario->setExibircontato("SIM");
        $usuario->setExibiranuncios("SIM");
        $usuario->setFoto("");

        $arquivo_tmp = $_FILES['attachmentName']['tmp_name'];
        $nome = $_FILES['attachmentName']['name'];
        $extensao = strrchr($nome, '.');
        $extensao = strtolower($extensao);
        $novoNome = md5(microtime()) . $extensao;
        $destino = PIPROOT . '/fotos/usuarios/' . $novoNome;
        if (move_uploaded_file($_FILES['attachmentName']['tmp_name'], $destino)) {
            $usuario->setFoto($novoNome);
        }
        return $usuario;
    }

    function editar($parametros) {
        $usuario = new Usuario();
        $usuario->setId($_SESSION["idusuario"]);
        if ($_SESSION["tipopessoa"] == "pf") {
            $usuario->setNome($parametros['txtNome']);
        } else {
            $usuario->setNome($parametros['txtNomeEmpresa']);
        }
        $usuario->setEmail($parametros['txtEmail']);
        $usuario->setDatahoraalteracao(date('Y-m-d H:i:s'));
        return $usuario;
    }

    function alterarSenha($parametros) {
        $usuario = new Usuario();
        $usuario->setId($_SESSION["idRecuperaSenhaUsuario"]);
        $usuario->setSenha($this->criptografarSenha($parametros['txtSenha']));
        return $usuario;
    }

    function trocarSenha($parametros) {
        $usuario = new Usuario();
        $usuario->setId($_SESSION["idusuario"]);
        $usuario->setSenha($this->criptografarSenha($parametros['txtSenhaNova']));
        return $usuario;
    }
    
    public function configuracoes($parametros){
        
        $this->setId($_SESSION["idusuario"]);
        
        $this->setExibirendereco((isset($parametros['chkEndereco']) ? "SIM" : "NAO"));

        $this->setExibircontato((isset($parametros['chkContato']) ? "SIM" : "NAO"));

        $this->setExibiranuncios((isset($parametros['chkAnuncios']) ? "SIM" : "NAO"));
        
        $this->setStatus((isset($parametros['chkStatus']) ? "ativo" : "desativadousuario"));
        
        return $this;
    }
    
    public function inativar($parametros){
        
      
        
        $usuario = new Usuario();
        
        $usuario->setId($parametros["hdnUsuario"]);
                
        $usuario->setStatus("inativo");
        
        return $usuario;
    }
    
    public function ativar($parametros){
        
      
        
        $usuario = new Usuario();
        
        $usuario->setId($parametros["hdnUsuario"]);
                
        $usuario->setStatus("ativo");
        
        return $usuario;
    }

}
