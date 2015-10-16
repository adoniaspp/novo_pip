<?php

class Controle {

    public function __construct($parametros) {
        //checa tamanho da requisição
        if (isset($_SERVER["CONTENT_LENGTH"])) {
            $cabecalho = $_SERVER['CONTENT_LENGTH'];
            $tamanho = ($cabecalho / 1024) / 1024;
            if ($tamanho > 10) {
                if ($_SERVER['REQUEST_METHOD'] === "GET") {
                    $visao = new Template();
                    $visao->setItem("errotoken");
                    $visao->exibir("VisaoErrosGenerico.php");
                } else {
                    echo json_decode(array("resposta" => 0));
                }
                die();
            }
        }
        //vem do menu
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $entidade = (isset($parametros['entidade'])) ? $parametros['entidade'] : "";
            $acao = (isset($parametros['acao'])) ? $parametros['acao'] : "";
            if ($entidade == "" && $acao == "") {
                self::index();
            } else {
                if (is_file(PIPROOT . '/controle/' . $entidade . "Controle.php")) {
                    include_once ($entidade . "Controle.php");
                    $classe = $entidade . "Controle";
                    $controle = new $classe;
                    if (method_exists($controle, $acao)) {
                        $contexto = $controle->$acao($parametros);
                    } else {
                        Template::error404();
                    }
                } else {
                    Template::error404();
                }
            }
        }
        //vem do formulario
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $entidade = $parametros['hdnEntidade'];
            $acao = $parametros['hdnAcao'];
            if ($entidade != "" && $acao != "") {
                if (is_file(PIPROOT . '/controle/' . $entidade . "Controle.php")) {
                    include_once ($entidade . "Controle.php");
                    $classe = $entidade . "Controle";
                    $controle = new $classe;
                    $controle->$acao($parametros);
                } else {
                    Template::error404();
                }
            } else {
                Template::error404();
            }
        }
        //vem do upload e somente do upload
        if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
            include_once ("ImagemControle.php");
            $upload = new ImagemControle();
            exit();
        }
    }

    public static function index() {
        //modelo
        /* include_once 'DAO/GenericoDAO.php';
          include_once 'modelo/Imagem.php';
          include_once 'modelo/Anuncio.php';
          include_once 'modelo/Imovel.php';
          include_once 'modelo/HistoricoAluguelVenda.php';
          $genericoDAO = new GenericoDAO();
          $anuncios = $genericoDAO->consultar(new Anuncio(), true, array("status" => "cadastrado"));
          $item['anuncios'] = $anuncios;
         */
        //visao
        $visao = new Template();
        $visao->setItem($item);
        $visao->exibir('index', 1);
    }

}
