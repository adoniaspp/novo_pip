<?php


class Diferencial {
    
     private $id;
     private $descricao;
     private $tipo;
     
     function getId() {
         return $this->id;
     }

     function getDescricao() {
         return $this->descricao;
     }

     function getTipo() {
         return $this->tipo;
     }

     function setId($id) {
         $this->id = $id;
     }

     function setDescricao($descricao) {
         $this->descricao = $descricao;
     }

     function setTipo($tipo) {
         $this->tipo = $tipo;
     }


    
}
