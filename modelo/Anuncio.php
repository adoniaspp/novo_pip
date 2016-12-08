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

                   
    public function cadastrar($parametros) {
        $this->setIdImovel($_SESSION["anuncio"]["idimovel"]);
        
        $idrand = substr(date("Y/m/d H:i:s"), 0, -15) . substr(date("Y/m/d H:i:s"), 5, 2) . str_pad($_SESSION["anuncio"]["idimovel"], 5, "0", STR_PAD_LEFT);
        //ano, mês e id do imóvel
        
        $this->setIdAnuncio($idrand);       
        $this->setFinalidade($parametros['sltFinalidade']);
        $this->setTituloAnuncio($parametros['txtTitulo']);
        $this->setDescricaoAnuncio($parametros['txtDescricao']);
        $this->setStatus('cadastrado');
        $this->setDatahoracadastro(date("Y/m/d H:i:s"));
        $this->setDatahoraalteracao('');
        $this->setDatahoradesativacao('');
        $this->setPublicarmapa((isset($parametros['chkMapa']) ? "SIM" : "NAO"));
        $this->setPublicarcontato((isset($parametros['chkContato']) ? "SIM" : "NAO"));
        $this->setIdusuarioplano($parametros['sltPlano']);
        return $this;
    }
    
    public function editar($parametros){
        
        $this->setId($parametros['hdnAnuncio']);
        
        $this->setTituloanuncio($parametros['txtTitulo']);
        $this->setDescricaoanuncio($parametros['txtDescricao']);
        
        $this->setPublicarcontato((isset($parametros['chkContato']) ? "SIM" : "NAO"));

        $this->setPublicarmapa((isset($parametros['chkMapa']) ? "SIM" : "NAO"));

        
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
