<?php

/*
 ************************************************************************
 PagSeguro Config File
 ************************************************************************
 */

$PagSeguroConfig = array();

$PagSeguroConfig['environment'] = array();
$PagSeguroConfig['environment']['environment'] = "production";

$PagSeguroConfig['credentials'] = array();
$PagSeguroConfig['credentials']['email'] = "pipcontato@gmail.com";
$PagSeguroConfig['credentials']['token'] = "AFB1EC50A9284F65A0764A5C8B25C682";

$PagSeguroConfig['application'] = array();
$PagSeguroConfig['application']['charset'] = "UTF-8"; // UTF-8, ISO-8859-1

$PagSeguroConfig['log'] = array();
$PagSeguroConfig['log']['active'] = true;
$PagSeguroConfig['log']['fileLocation'] = "../../temp/logpagseguro.log";
