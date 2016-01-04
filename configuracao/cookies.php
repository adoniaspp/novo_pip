<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Cookies {

    public static function consultarPreferencias() {
        if (isset($_COOKIE['pip'])) {
            $teste = $_COOKIE['pip'];
//            var_dump($teste['casa']['venda']);
//            die();
        }
        return false;
    }

    public static function configurarPreferencias($parametros) {

        switch ($parametros['anuncio'][0]['tipo']) {
            case 'casa':
                if ($parametros['anuncio'][0]['finalidade'] == 'Venda') {
                    setcookie('pip[casa][venda][quarto]', $parametros['anuncio'][0]['quarto']);
                    setcookie('pip[casa][venda][garagem]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[casa][venda][valormin]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[casa][venda][cidade]', $parametros['anuncio'][0]['cidade']);
                    setcookie('pip[casa][venda][bairro]', $parametros['anuncio'][0]['bairro']);
                    setcookie('pip[casa][venda][estado]', $parametros['anuncio'][0]['estado']);
                }
                if ($parametros['anuncio'][0]['finalidade'] == 'Aluguel') {
                    setcookie('pip[casa][aluguel][quarto]', $parametros['anuncio'][0]['quarto']);
                    setcookie('pip[casa][aluguel][garagem]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[casa][aluguel][valormin]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[casa][aluguel][cidade]', $parametros['anuncio'][0]['cidade']);
                    setcookie('pip[casa][aluguel][bairro]', $parametros['anuncio'][0]['bairro']);
                    setcookie('pip[casa][aluguel][estado]', $parametros['anuncio'][0]['estado']);
                }
                break;
            case 'apartamentoplanta':
                if ($parametros['anuncio'][0]['finalidade'] == 'Venda') {
                    setcookie('pip[apartamentoplanta][venda][quarto]', $parametros['anuncio'][0]['quarto']);
                    setcookie('pip[apartamentoplanta][venda][garagem]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[apartamentoplanta][venda][valormin]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[apartamentoplanta][venda][cidade]', $parametros['anuncio'][0]['cidade']);
                    setcookie('pip[apartamentoplanta][venda][bairro]', $parametros['anuncio'][0]['bairro']);
                    setcookie('pip[apartamentoplanta][venda][estado]', $parametros['anuncio'][0]['estado']);
                }
                if ($parametros['anuncio'][0]['finalidade'] == 'Aluguel') {
                    setcookie('pip[apartamentoplanta][aluguel][quarto]', $parametros['anuncio'][0]['quarto']);
                    setcookie('pip[apartamentoplanta][aluguel][garagem]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[apartamentoplanta][aluguel][valormin]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[apartamentoplanta][aluguel][cidade]', $parametros['anuncio'][0]['cidade']);
                    setcookie('pip[apartamentoplanta][aluguel][bairro]', $parametros['anuncio'][0]['bairro']);
                    setcookie('pip[apartamentoplanta][aluguel][estado]', $parametros['anuncio'][0]['estado']);
                }
                break;
            case 'apartamento':
                if ($parametros['anuncio'][0]['finalidade'] == 'Venda') {
                    setcookie('pip[apartamento][venda][quarto]', $parametros['anuncio'][0]['quarto']);
                    setcookie('pip[apartamento][venda][garagem]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[apartamento][venda][valormin]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[apartamento][venda][cidade]', $parametros['anuncio'][0]['cidade']);
                    setcookie('pip[apartamento][venda][bairro]', $parametros['anuncio'][0]['bairro']);
                    setcookie('pip[apartamento][venda][estado]', $parametros['anuncio'][0]['estado']);
                }
                if ($parametros['anuncio'][0]['finalidade'] == 'Aluguel') {
                    setcookie('pip[apartamento][aluguel][quarto]', $parametros['anuncio'][0]['quarto']);
                    setcookie('pip[apartamento][aluguel][garagem]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[apartamento][aluguel][valormin]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[apartamento][aluguel][cidade]', $parametros['anuncio'][0]['cidade']);
                    setcookie('pip[apartamento][aluguel][bairro]', $parametros['anuncio'][0]['bairro']);
                    setcookie('pip[apartamento][aluguel][estado]', $parametros['anuncio'][0]['estado']);
                }
                break;
            case 'salacomercial':
                if ($parametros['anuncio'][0]['finalidade'] == 'Venda') {
                    setcookie('pip[salacomercial][venda][quarto]', $parametros['anuncio'][0]['quarto']);
                    setcookie('pip[salacomercial][venda][garagem]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[salacomercial][venda][valormin]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[salacomercial][venda][cidade]', $parametros['anuncio'][0]['cidade']);
                    setcookie('pip[salacomercial][venda][bairro]', $parametros['anuncio'][0]['bairro']);
                    setcookie('pip[salacomercial][venda][estado]', $parametros['anuncio'][0]['estado']);
                }
                if ($parametros['anuncio'][0]['finalidade'] == 'Aluguel') {
                    setcookie('pip[salacomercial][aluguel][quarto]', $parametros['anuncio'][0]['quarto']);
                    setcookie('pip[salacomercial][aluguel][garagem]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[salacomercial][aluguel][valormin]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[salacomercial][aluguel][cidade]', $parametros['anuncio'][0]['cidade']);
                    setcookie('pip[salacomercial][aluguel][bairro]', $parametros['anuncio'][0]['bairro']);
                    setcookie('pip[salacomercial][aluguel][estado]', $parametros['anuncio'][0]['estado']);
                }
                break;
            case 'prediocomercial':
                if ($parametros['anuncio'][0]['finalidade'] == 'Venda') {
                    setcookie('pip[prediocomercial][venda][quarto]', $parametros['anuncio'][0]['quarto']);
                    setcookie('pip[prediocomercial][venda][garagem]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[prediocomercial][venda][valormin]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[prediocomercial][venda][cidade]', $parametros['anuncio'][0]['cidade']);
                    setcookie('pip[prediocomercial][venda][bairro]', $parametros['anuncio'][0]['bairro']);
                    setcookie('pip[prediocomercial][venda][estado]', $parametros['anuncio'][0]['estado']);
                }
                if ($parametros['anuncio'][0]['finalidade'] == 'Aluguel') {
                    setcookie('pip[prediocomercial][aluguel][quarto]', $parametros['anuncio'][0]['quarto']);
                    setcookie('pip[prediocomercial][aluguel][garagem]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[prediocomercial][aluguel][valormin]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[prediocomercial][aluguel][cidade]', $parametros['anuncio'][0]['cidade']);
                    setcookie('pip[prediocomercial][aluguel][bairro]', $parametros['anuncio'][0]['bairro']);
                    setcookie('pip[prediocomercial][aluguel][estado]', $parametros['anuncio'][0]['estado']);
                }
                break;
            case 'terreno':
                if ($parametros['anuncio'][0]['finalidade'] == 'Venda') {
                    setcookie('pip[terreno][venda][quarto]', $parametros['anuncio'][0]['quarto']);
                    setcookie('pip[terreno][venda][garagem]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[terreno][venda][valormin]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[terreno][venda][cidade]', $parametros['anuncio'][0]['cidade']);
                    setcookie('pip[terreno][venda][bairro]', $parametros['anuncio'][0]['bairro']);
                    setcookie('pip[terreno][venda][estado]', $parametros['anuncio'][0]['estado']);
                }
                if ($parametros['anuncio'][0]['finalidade'] == 'Aluguel') {
                    setcookie('pip[terreno][aluguel][quarto]', $parametros['anuncio'][0]['quarto']);
                    setcookie('pip[terreno][aluguel][garagem]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[terreno][aluguel][valormin]', $parametros['anuncio'][0]['garagem']);
                    setcookie('pip[terreno][aluguel][cidade]', $parametros['anuncio'][0]['cidade']);
                    setcookie('pip[terreno][aluguel][bairro]', $parametros['anuncio'][0]['bairro']);
                    setcookie('pip[terreno][aluguel][estado]', $parametros['anuncio'][0]['estado']);
                }
                break;
        }
    }

}
