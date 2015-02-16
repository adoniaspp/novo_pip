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
    private $foto;
    protected $endereco;
    protected $telefone;
    protected $empresa;

    public function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

    public function getEmpresa() {
        return $this->empresa;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getId() {
        return $this->id;
    }

    public function getTipousuario() {
        return $this->tipousuario;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCpfcnpj() {
        return $this->cpfcnpj;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getSenha() {
        return $this->senha;
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

    public function getIdendereco() {
        return $this->idendereco;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTipousuario($tipousuario) {
        $this->tipousuario = $tipousuario;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setCpfcnpj($cpfcnpj) {
        $this->cpfcnpj = $cpfcnpj;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
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

    public function setIdendereco($idendereco) {
        $this->idendereco = $idendereco;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
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
        $usuario->setDatahoracadastro(date('d/m/Y H:i:s'));
        $usuario->setDatahoraalteracao("");
        $usuario->setIdendereco($idendereco);
        $usuario->setFoto("");

        $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
        $nome = $_FILES['arquivo']['name'];
        $extensao = strrchr($nome, '.');
        $extensao = strtolower($extensao);
        $novoNome = md5(microtime()) . $extensao;
        $destino = PIPROOT . '/fotos/usuarios/' . $novoNome;
        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino)) {
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
        $usuario->setDatahoraalteracao(date('d/m/Y H:i:s'));
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

}
