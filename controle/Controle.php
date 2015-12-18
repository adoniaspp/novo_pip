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
            $transacaoPagSeguro = (isset($parametros['paytransaction_id_1'])) ? $parametros['paytransaction_id_1'] : "";
            if ($transacaoPagSeguro != "") {
                if($_SESSION["idusuario"] != ""){
                    //incluir chamada do comprar planos
                } else {
                    self::index();    
                }
            } elseif ($entidade == "" && $acao == "") {
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
            $entidade = (isset($parametros['hdnEntidade']) && trim($parametros['hdnEntidade']) !== "" ? trim($parametros['hdnEntidade']) : null);
            $acao = (isset($parametros['hdnAcao']) && trim($parametros['hdnAcao']) !== "" ? trim($parametros['hdnAcao']) : null);

            $code = (isset($parametros['notificationCode']) && trim($parametros['notificationCode']) !== "" ? trim($parametros['notificationCode']) : null);
            $type = (isset($parametros['notificationType']) && trim($parametros['notificationType']) !== "" ? trim($parametros['notificationType']) : null);
            ##### do nosso site
            if ($entidade && $acao) {
                if (is_file(PIPROOT . '/controle/' . $entidade . "Controle.php")) {
                    include_once ($entidade . "Controle.php");
                    $classe = $entidade . "Controle";
                    $controle = new $classe;
                    $controle->$acao($parametros);
                } else {
                    Template::error404();
                }
                ##### do pagseguro    
            } elseif ($code && $type) {
                require_once PIPROOT . "/controle/PagSeguroControle.php";
                $pagSeguroControle = new PagSeguroControle();
                $notificationType = new PagSeguroNotificationType($type);
                $strType = $notificationType->getTypeFromValue();

                switch ($strType) {
                    case 'TRANSACTION':
                        $pagSeguroControle->transactionNotification($code);
                        break;
                    case 'APPLICATION_AUTHORIZATION':
                        $pagSeguroControle->authorizationNotification($code);
                        break;
                    case 'PRE_APPROVAL':
                        $pagSeguroControle->preApprovalNotification($code);
                        break;
                    default:
                    //gera log
                    //LogPagSeguro::error("Unknown notification type [" . $notificationType->getValue() . "]");
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
