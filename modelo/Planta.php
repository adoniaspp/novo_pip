<?php


class Planta {
   
    private $id;
    private $idapartamentoplanta;
    private $idimovel;
    private $ordemplantas;
    private $tituloplanta;
    private $quarto;
    private $banheiro;
    private $suite;
    private $garagem;
    private $area;
    private $imagemdiretorio;
    private $imagemnome;
    private $imagemtamanho;
    private $imagemtipo;
    
    public function getId() {
        return $this->id;
    }

    public function getIdapartamentoplanta() {
        return $this->idapartamentoplanta;
    }

    public function getIdimovel() {
        return $this->idimovel;
    }

    public function getOrdemplantas() {
        return $this->ordemplantas;
    }

    public function getTituloplanta() {
        return $this->tituloplanta;
    }

    public function getQuarto() {
        return $this->quarto;
    }

    public function getBanheiro() {
        return $this->banheiro;
    }

    public function getSuite() {
        return $this->suite;
    }

    public function getGaragem() {
        return $this->garagem;
    }

    public function getArea() {
        return $this->area;
    }

    public function getImagemdiretorio() {
        return $this->imagemdiretorio;
    }

    public function getImagemnome() {
        return $this->imagemnome;
    }

    public function getImagemtamanho() {
        return $this->imagemtamanho;
    }

    public function getImagemtipo() {
        return $this->imagemtipo;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdapartamentoplanta($idapartamentoplanta) {
        $this->idapartamentoplanta = $idapartamentoplanta;
    }

    public function setIdimovel($idimovel) {
        $this->idimovel = $idimovel;
    }

    public function setOrdemplantas($ordemplantas) {
        $this->ordemplantas = $ordemplantas;
    }

    public function setTituloplanta($tituloplanta) {
        $this->tituloplanta = $tituloplanta;
    }

    public function setQuarto($quarto) {
        $this->quarto = $quarto;
    }

    public function setBanheiro($banheiro) {
        $this->banheiro = $banheiro;
    }

    public function setSuite($suite) {
        $this->suite = $suite;
    }

    public function setGaragem($garagem) {
        $this->garagem = $garagem;
    }

    public function setArea($area) {
        $this->area = $area;
    }

    public function setImagemdiretorio($imagemdiretorio) {
        $this->imagemdiretorio = $imagemdiretorio;
    }

    public function setImagemnome($imagemnome) {
        $this->imagemnome = $imagemnome;
    }

    public function setImagemtamanho($imagemtamanho) {
        $this->imagemtamanho = $imagemtamanho;
    }

    public function setImagemtipo($imagemtipo) {
        $this->imagemtipo = $imagemtipo;
    }

                    
    function cadastrar($parametros, $idApartamentoPlanta, $idimovel, $indiceControle) {

        $planta = new Planta();
        $planta->setIdapartamentoplanta($idApartamentoPlanta);
        $planta->setIdimovel($idimovel);
        $planta->setOrdemplantas($indiceControle);
        $planta->setTituloplanta($parametros["txtPlanta"][$indiceControle]);
        $planta->setQuarto($parametros["sltQuarto"][$indiceControle]);
        $planta->setBanheiro($parametros["sltBanheiro"][$indiceControle]);
        $planta->setSuite($parametros["sltSuite"][$indiceControle]);          
        $planta->setGaragem($parametros["sltGaragem"][$indiceControle]);
        $planta->setArea($parametros["txtArea"][$indiceControle]);
        return $planta;
        
    }
    
    function editar($parametros, $idPartamentoPlanta, $idPlanta, $indiceControle) {
       
        
        $planta = new Planta();
        $planta->setId($idPlanta);
        $planta->setIdapartamentoplanta($idPartamentoPlanta);
        $planta->setIdimovel($_SESSION["imovel"]["id"]);
        $planta->setOrdemplantas($indiceControle);
        $planta->setTituloplanta($parametros["txtPlanta"][$indiceControle]);
        $planta->setQuarto($parametros["sltQuarto"][$indiceControle]);
        $planta->setBanheiro($parametros["sltBanheiro"][$indiceControle]);
        $planta->setSuite($parametros["sltSuite"][$indiceControle]);          
        $planta->setGaragem($parametros["sltGaragem"][$indiceControle]);
        $planta->setArea($parametros["txtArea"][$indiceControle]);
        return $planta;
        
    }
    
    function cadastrarImagem($parametros){
        $this->setImagemdiretorio(dirname($_SERVER["HTTP_REFERER"]) . '/fotos/planta/');
        $this->setImagemnome($parametros["name"]);
        $this->setImagemtipo($parametros["type"]);
        $this->setImagemtamanho($parametros["size"]);
    }
}
