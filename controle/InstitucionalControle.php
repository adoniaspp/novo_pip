<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class InstitucionalControle {

    function comoFunciona() {
        $visao = new Template();
        $visao->exibir('InstitucionalVisaoComoFunciona.php');
    }

    function quemSomos() {  /*ok*/
        $visao = new Template();
        $visao->exibir('InstitucionalVisaoQuemSomos.php');
    }

    function mapaSite() {
        $visao = new Template();
        $visao->exibir('InstitucionalVisaoMapaSite.php');
    }

    function comoAnunciar() {
        $visao = new Template();
        $visao->exibir('InstitucionalVisaoComoAnunciar.php');
    }
    
    function termosUso() {  /*ok*/
        $visao = new Template();
        $visao->exibir('InstitucionalTermosDeUso.php');
    }
    
    function duvidasFrequentes() {  /*ok*/
        $visao = new Template();
        $visao->exibir('InstitucionalDuvidasFrequentes.php');
    }
    

}
