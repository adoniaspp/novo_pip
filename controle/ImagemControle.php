<?php

include_once 'modelo/Imagem.php';
include_once 'configuracao/UploadHandler.php';

class ImagemControle extends UploadHandler {

    private $parametros;
    private $idImagem;

    public function __construct($parametros = NULL) {
        $this->parametros = $parametros;
        parent::__construct(array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
            'user_dirs' => true,
            //'download_via_php' => true,
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
            'upload_dir' => dirname($_SERVER["SCRIPT_FILENAME"]) . '/fotos/imoveis/',
            'upload_url' => dirname($_SERVER["HTTP_REFERER"]) . '/fotos/imoveis/',
                ), true, array(
            1 => 'Erro Upload COD01',
            2 => 'Erro Upload COD02',
            3 => 'Erro Upload COD03',
            4 => 'Erro Upload COD04',
            6 => 'Erro Upload COD06',
            7 => 'Erro Upload COD07',
            8 => 'Erro Upload COD08',
            'post_max_size' => 'Arquivo muito grande (3 MB)',
            'max_file_size' => 'Arquivo muito grande (3 MB)',
            'min_file_size' => 'Arquivo muito pequeno (0 MB)',
            'accept_file_types' => 'Arquivo não permitido. Apenas imagens (gif, jpeg, png)',
            'max_number_of_files' => 'Quantidade máxima de fotos atingida (5 fotos)',
            'max_width' => 'Largura máxima atingida',
            'min_width' => 'Image requires a minimum width',
            'max_height' => 'Altura máxima atingida',
            'min_height' => 'Image requires a minimum height'
        ));
    }

    protected function handle_form_data($file, $index) {
        $legenda = $this->parametros["txtLegenda"];
        $file->legenda = (isset($_FILES["files"]["name"][0]) ? $legenda[$_FILES["files"]["name"][0]] : $legenda[$file->name]);
        $file->idImagem = '';
//        var_dump($_FILES["files"]["name"][0]);
//        echo "<pre>";
//        print_r($_SESSION);
//        print_r($this->parametros);
//        die();
    }

    public function delete($print_response = true) {
//        var_dump(4);
        if($_REQUEST["e"]=="1"){
            //condicao para que os arquivos em duplicidade nao sejam todos apagados
            echo '{"image.jpg":true}';
        } else {
            Sessao::configurarSessaoImagemAnuncio("excluir", $_REQUEST["file"]);
            parent::delete();
        }
        exit();
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error, $index = null, $content_range = null) {
        //var_dump(1);
        if (Sessao::existeSessaoImagem($name)) {
            $file = new stdClass();
            $file->deleteType = "DELETE";
            $file->deleteUrl = PIPURL . "/index.php?file=" . $name . "&e=1";
            //parametro get e = 1 significa arquivo existente
            $file->error = "O arquivo com o nome " . $name . " já existe";
            $file->idImagem = "";
            $file->legenda = "";
            $file->name = $name;
            $file->size = false;
            $file->type = $type;
            return $file;
        } else {
            //verifica se a pasta tem mais de 200 arquivos
            $arquivosNaPasta = scandir(parent::get_upload_path());
            if (count($arquivosNaPasta) > 200) {
                $file->deleteType = "DELETE";
                $file->deleteUrl = PIPURL . "/index.php?file=" . $name;
                $file->error = "Quantidade máxima de arquivos da pasta atingida";
                $file->idImagem = "";
                $file->legenda = "";
                $file->name = $name;
                $file->size = false;
                $file->type = $type;
                return $file;
            } else {
                $file = parent::handle_file_upload(
                                $uploaded_file, $name, $size, $type, $error, $index, $content_range
                );
                if (empty($file->error)) {
                    Sessao::configurarSessaoImagemAnuncio("inserir", $file->name, $file);
                    $file->idImagem = $idImagem;
                    $file->id = $idImagem;
                }
                return $file;
            }
        }
    }

    protected function set_additional_file_properties($file) {
        //var_dump(3);
        parent::set_additional_file_properties($file);
        //$genericoDAO = new GenericoDAO();
        //$imagem = new Imagem();
        //var_dump($file);
        //$resultado = $genericoDAO->consultar($imagem, false, array("id" => $file->idImagem));
        //var_dump($resultado);
        //$file->id = $resultado[0]->getId();
        //$file->legenda = $resultado[0]->getLegenda();
        //var_dump($file);
        //$file->deleteUrl = 'index.php?hdnEntidade=Imagem&hdnAcao=excluir&idImagem=11'.$file->idImagem.'&files='.rawurlencode($file->name);
        //var_dump($file);
    }

    protected function get_user_id() {
        $idusuario = $_SESSION["idusuario"]; //id do usuario logado no banco
        $preenchimento = str_pad($idusuario, 5, "0", STR_PAD_LEFT); //preenche com 5 casas a esquerda
        $reverte = strrev($preenchimento); //reverte a string formada
        $sessionid = stripslashes($_SESSION['token']); //token do PHP
        return $reverte . "P" . hash("crc32", $sessionid); //retorna o idusuario + hash
    }

}
