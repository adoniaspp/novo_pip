<?php

class Template {

    private $item;
    private $tipo;

    public function getItem() {
        return $this->item;
    }

    public function setItem($item) {
        $this->item = $item;
    }

    public function __construct($tipo = '') {
        //$this->cabecalho();
        $this->tipo = $tipo;
    }

    public function exibir($visao, $paginaInicial = 0) {
        if ($this->tipo == 'ajax') {
            $this->corpo($visao, 0);
        } else {
            $this->cabecalho();
            if ($paginaInicial === 1) {
                $this->inicial();
            } elseif (is_file('visao/' . $visao)) {
                $this->corpo($visao);
            } else {
                self::error404();
            }
            $this->rodape();
        }
    }

    public function cabecalho() {
        #tratar a inclusao automatica de scripts
        #verificar a variavel active do menu
        include_once 'assets/html/cabecalho.php';
    }

    public function corpo($visao) {
        include_once 'visao/' . $visao;
    }

    public function inicial() {
        include_once 'assets/html/index.php';
    }

    public static function error404() {
        include_once 'assets/html/error404.php';
    }

    public function rodape() {
        include 'assets/html/rodape.html';
    }

    public function __destruct() {
        //$this->rodape();
    }

}
