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
            'upload_dir' => dirname($_SERVER["SCRIPT_FILENAME"]) . '/fotos/',
            'upload_url' => dirname($_SERVER["HTTP_REFERER"]) . '/fotos/',
        ));
    }

    protected function handle_form_data($file, $index) {
        $legenda = $this->parametros["txtLegenda"];
        $file->legenda = (isset($_FILES["files"]["name"][0])?$legenda[$_FILES["files"]["name"][0]]:$legenda[$file->name]);
        $file->idImagem = '';
//        var_dump($_FILES["files"]["name"][0]);
//        echo "<pre>";
//        print_r($_SESSION);
//        print_r($this->parametros);
//        die();
    }

    public function delete($print_response = true) {
//        var_dump(4);
        Sessao::configurarSessaoImagem("excluir", $_REQUEST["file"]);
        parent::delete();
        exit();
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error, $index = null, $content_range = null) {
        //var_dump(1);
        $file = parent::handle_file_upload(
                        $uploaded_file, $name, $size, $type, $error, $index, $content_range
        );
        if (empty($file->error)) {
            Sessao::configurarSessaoImagem("inserir", $file->name, $file);
            $file->idImagem = $idImagem;
            $file->id = $idImagem;
        }

        return $file;
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

}
