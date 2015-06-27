<?php

####CONFIGURACOES DO PHP######################
ini_set("display_errors", 1);
error_reporting(1);
date_default_timezone_set("America/Belem");

####CONSTANTES################################
define(PIPROOT, dirname(__FILE__));
define(PIPURL, str_replace('\\','/',"http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER["SCRIPT_NAME"])));
define(TEMPOTOKEN, 600); // 10 minutos
####INCLUDES##################################
include_once 'configuracao/Template.php';
include_once 'controle/Controle.php';
include_once 'configuracao/Sessao.php';
include_once 'assets/mailer/class.phpmailer.php';
include_once 'assets/mailer/class.smtp.php';
include_once 'configuracao/Email.php';

####INDEX#####################################
Sessao::criarSessaoUsuario();

$parte1 = strrchr($_SERVER['REQUEST_URI'], "?");
$parte2 = str_replace($parte1, "", $_SERVER['REQUEST_URI']);
$url = explode("/", $parte2);

array_shift($url);
if (sizeof($url) > 0 & $url[0] != "") { //verificar existe algo depois da barra digitada e se não está vazio
    // print "É Maior <br>"; 
    //echo "Array: " . $url[2];

    if ($url[0] == "index.php") { //verificar se existe algo depois da barra. Se for index.php, redirecionar para o inicio
        //echo "index.php";
        $parametros = $_REQUEST;
        $controle = new Controle($parametros);
    } else { //verificar se o usuário foi digitado
        $paginaCorretor = PIPURL . "/index.php?entidade=Anuncio&acao=buscarAnuncioCorretor&login=".$url[0];
        header("location: $paginaCorretor");
      //  echo 'redirect';
    }
} else {
    //echo "nada";
    $parametros = $_REQUEST;
    $controle = new Controle($parametros);
}
?>