<?php

class ConsultasAdHoc extends GenericoDAO {

    public function buscaAnuncios($parametros) {

        unset($parametros['predicados']['atributos']);
        unset($parametros['predicados']['tabela']);
        $crtlPred = true;
        /* Configurações dos Parametros */
        foreach ($parametros['predicados'] as $chave => $valor) {
            if ($valor == '') {
                unset($parametros['predicados'][$chave]);
            }
        }
        if (count($parametros['predicados']) == 1)
            $crtlPred = FALSE;
        if ($parametros['predicados']['valor']) {
            $preco = $parametros['predicados']['valor'];
            unset($parametros['predicados']['valor']);
        }
        $garagem = $parametros['predicados']['garagem'];
        unset($parametros['predicados']['garagem']);
        if ($parametros['predicados']['quarto'] == 5) {
            $quartos = $parametros['predicados']['quarto'];
            unset($parametros['predicados']['quarto']);
        }

        /* Atributos da Consulta */
        $sql = 'SELECT ' . $parametros['atributos'];
        /* View da Consulta */
        $sql = $sql . ' FROM buscaAnuncio' . ucfirst(strtolower($parametros['tabela']));
        /* Predicados da Consulta */
        foreach ($parametros['predicados'] as $chave => $valor) {
            $keys = array_fill(0, count($valor), $chave);
            $place_holders = implode(
                    ',', array_map(
                            function($v) {
                        static $x = 0;
                        return ':' . $v . '_' . $x++;
                    }, $keys
                    )
            );
            $predicados[] = $chave . ' IN (' . $place_holders . ')';
        }
        if ($crtlPred) {
            $sql = $sql . ' WHERE ' . implode(' AND ', $predicados);
            if ($preco && $preco>1000000) {
                $sql = $sql . 'valormin BETWEEN ' . $preco . ' AND ' . ($preco + 100000);
            }else{
                $sql = $sql . 'valormin >' . $preco;
            }
            if ($garagem == 'true') {
                $sql = $sql . 'garagem>0';
            }
            if ($quartos == 5) {
                $sql = $sql . 'quarto>=5';
            }
        }
//        var_dump($sql);;
//        die();
        $statement = $this->conexao->prepare($sql);

        foreach ($parametros['predicados'] as $chave => $valor) {
            if (count($valor) == 1) {
                $statement->bindValue($chave . '_' . 0, $valor);
            } else {
                foreach ($valor as $k => $v) {
                    $statement->bindValue($chave . '_' . $k, $v);
                }
            }
        }
        $statement->execute();
        $resultado['anuncio'] = $statement->fetchAll(PDO::FETCH_ASSOC);

        /* Imagens do anuncio */
        if (count($resultado['anuncio']) != 0) {
            $ids = array_column($resultado['anuncio'], 'id');
            $campos = implode(',', array_fill(0, count($ids), '?'));
            $sth = $this->conexao->prepare("SELECT idanuncio, diretorio, legenda, destaque FROM imagem WHERE idanuncio IN ($campos)");
            $sth->execute($ids);
            $resultado['imagens'] = $sth->fetchAll(PDO::FETCH_ASSOC);
        }
        echo '<pre>';
        print_r($resultado['anuncio']);
        die();
        return $resultado;
    }

    public function consultarAnunciosPorUsuario() {
        
    }
    
    public function ConsultarRegistroAtivoDeRecuperarSenha($idUsuario) {
        $sql = "SELECT r.* "
                . " FROM recuperasenha r"
                . " WHERE r.status = 'ativo'"
                . " AND r.idusuario = :idUsuario ";
        $statement = $this->conexao->prepare($sql);
        $statement->bindParam(':idUsuario', $idUsuario);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, "RecuperaSenha");
        return $resultado;
    }
}
