<?php

class Chamado {
    
    private $id;
    private $idusuario;
    private $assuntoparametrizado;
    private $idchamadoassunto;
    private $codigochamado;
    private $mensagem;
    private $status;
    private $datahoracadastro;
    private $datahoracancela;
    private $datahoraresposta;
    
    protected $chamadoassunto;
    protected $chamadotitulo;
    protected $usuario;
    protected $chamadoresposta;
            
    function getId() {
        return $this->id;
    }

    function getIdusuario() {
        return $this->idusuario;
    }

    function getAssuntoparametrizado() {
        return $this->assuntoparametrizado;
    }

    function getIdchamadoassunto() {
        return $this->idchamadoassunto;
    }

    function getCodigochamado() {
        return $this->codigochamado;
    }

    function getMensagem() {
        return $this->mensagem;
    }

    function getStatus() {
        return $this->status;
    }

    function getDatahoracadastro() {
        return $this->datahoracadastro;
    }

    function getDatahoracancela() {
        return $this->datahoracancela;
    }

    function getDatahoraresposta() {
        return $this->datahoraresposta;
    }

    function getChamadoassunto() {
        return $this->chamadoassunto;
    }

    function getChamadotitulo() {
        return $this->chamadotitulo;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getChamadoresposta() {
        return $this->chamadoresposta;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    function setAssuntoparametrizado($assuntoparametrizado) {
        $this->assuntoparametrizado = $assuntoparametrizado;
    }

    function setIdchamadoassunto($idchamadoassunto) {
        $this->idchamadoassunto = $idchamadoassunto;
    }

    function setCodigochamado($codigochamado) {
        $this->codigochamado = $codigochamado;
    }

    function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setDatahoracadastro($datahoracadastro) {
        $this->datahoracadastro = $datahoracadastro;
    }

    function setDatahoracancela($datahoracancela) {
        $this->datahoracancela = $datahoracancela;
    }

    function setDatahoraresposta($datahoraresposta) {
        $this->datahoraresposta = $datahoraresposta;
    }

    function setChamadoassunto($chamadoassunto) {
        $this->chamadoassunto = $chamadoassunto;
    }

    function setChamadotitulo($chamadotitulo) {
        $this->chamadotitulo = $chamadotitulo;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setChamadoresposta($chamadoresposta) {
        $this->chamadoresposta = $chamadoresposta;
    }
                   
    function cadastrar($parametros, $maiorId){
        
        $this->setIdusuario($_SESSION['idusuario']);
        
        if($parametros['sltChamadoAssunto'] == null){ //caso seja elogio, sujestões ou outros assuntos
            $this->setIdchamadoassunto($parametros['idAssuntoChamado']);
            $this->setAssuntoparametrizado("NAO");
        } else{ //caso seja problema, erro ou dúvida
            $this->setIdchamadoassunto($parametros['sltChamadoAssunto']); 
            $this->setAssuntoparametrizado("SIM");
        }
      
        $ano = substr(date("Y"), -2); 
        $mes = date("m");
        if($maiorId == null){
            $maiorId = "01";
        } else $maiorId = $maiorId + 1;
        
        switch ($maiorId){
           case 1: $maiorId = "01"; break;
           case 2: $maiorId = "02"; break;
           case 3: $maiorId = "03"; break;
           case 4: $maiorId = "04"; break;
           case 5: $maiorId = "05"; break;
           case 6: $maiorId = "06"; break;
           case 7: $maiorId = "07"; break;
           case 8: $maiorId = "08"; break;
           case 9: $maiorId = "09"; break;
        }
        
        $this->setCodigochamado($ano.$mes.$maiorId);
        $this->setMensagem($parametros['txtMsgChamado']);
        $this->setStatus("aberto");
        $this->setDatahoracadastro(date("Y/m/d H:i:s"));
        
        return $this;
        
    }
    
    function cancelar($parametros){
        
        $this->setId($parametros['hdnChamado']);
        $this->setStatus("cancelado");
        $this->setDatahoracancela(date("Y/m/d H:i:s"));
        
        return $this;
    }
    
    public static function retornarTipo($parametro){
        switch ($parametro) {
            case "1":
            $tipo = "Problema";
            break;
            case "2":
            $tipo = "Dúvida";
            break;
            case "3":
            $tipo = "Reclamação";
            break;
            case "4":
            $tipo = "Elogio";
            break;
            case "5":
            $tipo = "Sugestões";
            break;
            case "6":
            $tipo = "Outros Assuntos";
            break;
        }
        return $tipo;
    } 
    
    public static function retornarAssunto($parametro){
        switch ($parametro) {
            case "1":
            $assunto = "Erro ao realizar operação (cadastro, atualização, edição, etc)";
            break;
            case "2":
            $assunto = "Problema em meu anúncio";
            break;
            case "3":
            $assunto = "Problema em meu imóvel";
            break;
            case "4":
            $assunto = "Problema em meus dados";
            break;
            case "5":
            $assunto = "Problema em meus planos";
            break;
            case "6":
            $assunto = "Outros problemas";
            break;
            case "7":
            $assunto = "Trocar Senha";
            break;
            case "8":
            $assunto = "Alterar Meu Cadastro";
            break;
            case "9":
            $assunto = "Alterar/Excluir Imóvel";
            break;
            case "10":
            $assunto = "Alterar/Excluir Anúncio";
            break;
            case "11":
            $assunto = "Planos para anúncio";
            break;
            case "12":
            $assunto = "Outras Dúvidas";
            break;
            case "13":
            $assunto = "Demora Atendimento";
            break;
            case "14":
            $assunto = "Reclamação de Imóvel";
            break;
            case "15":
            $assunto = "Reclamação de Anúncio";
            break;
            case "16":
            $assunto = "Reclamação Sobre os Planos";
            break;
            case "17":
            $assunto = "Outras Reclamações";
            break;
        }
        return $assunto;
    }
    
    function alterarStatus($parametros){
        
        $this->setId($parametros["hdnChamado"]);
        $this->setStatus($parametros["sltStatusChamadoResposta"]);
    
        return $this;
        
    }
    
}
