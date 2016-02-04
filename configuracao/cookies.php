<?php

include_once 'controle/PreferenciaControle.php';

class Cookies {

    public static function consultarPreferencias() {
        if (isset($_COOKIE['pip'])) {
            //var_dump($_COOKIE['pip']);
            //die();
        }
        return false;
    }

    public static function configurarPreferencias($parametros) {
        $preferencia = new PreferenciaControle();
        if (isset($_COOKIE['pip'])) {
            foreach ($_COOKIE['pip'] as $nome => $valor) {
                if ($valor == $parametros['anuncio'][0]['idanuncio']) {
                    $crtlAnuncio = true;
                }
            }
        } else {
            $crtlAnuncio = false;
        }
        if (!$crtlAnuncio) {
            $codPreferencia = $preferencia->inserir($parametros);
            setcookie('pip[' . $codPreferencia . ']', $parametros['anuncio'][0]['idanuncio']);
        }
    }

}
