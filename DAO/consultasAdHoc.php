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
//        if (count($parametros['predicados']) == 1)
//            $crtlPred = FALSE;
        if ($parametros['predicados']['valor'] >= 0) {
            $preco = $parametros['predicados']['valor'];
            unset($parametros['predicados']['valor']);
        }
        $garagem = $parametros['predicados']['garagem'];
        unset($parametros['predicados']['garagem']);
        if ($parametros['predicados']['quarto'] == 5) {
            $quartos = $parametros['predicados']['quarto'];
            unset($parametros['predicados']['quarto']);
        }
        if (count($parametros['predicados']) == 0)
            $crtlPred = FALSE;
        /* Atributos da Consulta */
        $sql = 'SELECT ' . $parametros['atributos'];
        /* View da Consulta */
        $sql = $sql . ' FROM buscaAnuncio' . ucfirst(strtolower($parametros['tabela']));
        /* Predicados da Consulta */
        if ($garagem == 'true') {
                $sql = $sql . ' WHERE  garagem > 0 ';
        }
        if ($crtlPred) {
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
        }
        if ($crtlPred) {
            $sql = $sql . ' WHERE ' . implode(' AND ', $predicados);
            if ($preco != NULL) {
                if ($preco >= 0 && $preco < 1000000) {
                    $sql = $sql . ' AND valormin BETWEEN ' . $preco . ' AND ' . ($preco + 100000);
                } else {
                    $sql = $sql . ' AND valormin > ' . $preco;
                }
            }
//            if ($garagem == 'true') {
//                $sql = $sql . ' AND garagem > 0 ';
//            }
            if ($quartos == 5) {
                $sql = $sql . ' AND quarto >= 5 ';
            }
        }//        var_dump($sql);
//        die();

//        var_dump($sql);
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
            $ids = array_column($resultado['anuncio'], 'idanuncio');
            $campos = implode(',', array_fill(0, count($ids), '?'));
            $sth = $this->conexao->prepare("SELECT idanuncio, diretorio, legenda, destaque FROM imagem WHERE idanuncio IN ($campos)");
            $sth->execute($ids);
            $resultado['imagens'] = $sth->fetchAll(PDO::FETCH_ASSOC);
        }

        /* diferenciais do imóvel */
        if (count($resultado['anuncio']) != 0) {
            $idsImoveis = array_column($resultado['anuncio'], 'idimovel');
            for ($i=0; $i<count($idsImoveis); $i++){
            $sth = $this->conexao->prepare("SELECT descricao FROM imoveldiferencial as imdif "
                    . "LEFT JOIN diferencial as d on imdif.iddiferencial = d.id WHERE idimovel = :idimovel");
            $sth->bindValue(':idimovel', $idsImoveis[$i]);
            $sth->execute();
            $resultado['diferenciais'] = $sth->fetchAll(PDO::FETCH_ASSOC);
//            foreach ($resultado['diferenciais'] as descricao){
//                
//            }
            $resultado['anuncio'][$i] = array_merge($resultado['diferenciais'][0], $resultado['anuncio'][$i]);
        }
        }
        echo '<pre>';
        print_r($resultado['diferenciais']);
        die();
        /* casa */
        if (count($resultado['anuncio']) != 0) {
            $idsImoveis = array_column($resultado['anuncio'], 'idimovel');
            $tiposImoveis = array_column($resultado['anuncio'], 'descricao');
            for ($i=0; $i<count($idsImoveis); $i++){
                if($tiposImoveis[$i] == 'casa'){
                    $sth = $this->conexao->prepare("SELECT quarto, banheiro, suite, garagem, area FROM buscaAnuncioCasa WHERE idimovel = :idimovel");
                    $sth->bindValue(':idimovel', $idsImoveis[$i]);
                    $sth->execute();    
                    $resultado['casa'] = $sth->fetchAll(PDO::FETCH_ASSOC);
                    $resultado['anuncio'][$i] = array_merge($resultado['casa'][0], $resultado['anuncio'][$i]); 
                   }
//                if($tiposImoveis[$i] == 'apartamentoplanta'){
//                    
//                }
//                if($tiposImoveis[$i] == 'apartamento'){
//                    
//                }
//                if($tiposImoveis[$i] == 'salacomercial'){
//                    
//                }
//                if($tiposImoveis[$i] == 'prediocomercial'){
//                    
//                }
//                if($tiposImoveis[$i] == 'terreno'){
//                    
//                }
            }
        }
   
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

    public function ConsultarPlanosComprados($ids) {
        $allow = $ids;
        $sql = sprintf(
                "SELECT * FROM plano WHERE id in( %s )", implode(
                        ',', array_map(
                                function($v) {
                            static $x = 0;
                            return ':allow_' . $x++;
                        }, $allow
                        )
                )
        );
        $sql = $sql . " ORDER BY ID DESC";
        $statement = $this->conexao->prepare($sql);
        foreach ($allow as $k => $v) {
            $statement->bindValue('allow_' . $k, $v);
        }
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function ConsultarImoveisNaoAnunciadosPorUsuario($idUsuario) {
        $sql = "SELECT i.id "
                . " FROM imovel i"
                . " WHERE i.idusuario = :idUsuario "
                . " AND NOT EXISTS ( "
                . " SELECT 1 FROM anuncio a"
                . " JOIN usuarioplano up ON up.id = a.idusuarioplano"
                . " JOIN usuario u ON up.idusuario = u.id"
                . " WHERE u.status = 'ativo'"
                //. " AND a.status = 'cadastrado'"
                . " AND a.idimovel = i.id"
                . " AND u.id = :idUsuario "
                . " ) ";
        $sql = $sql . " ORDER BY i.ID DESC";
        $statement = $this->conexao->prepare($sql);
        $statement->bindParam(':idUsuario', $idUsuario);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

}
