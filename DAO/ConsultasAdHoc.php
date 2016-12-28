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
        if ($parametros['predicados']['valor'] >= 0) {
            $preco = $parametros['predicados']['valor'];
            unset($parametros['predicados']['valor']);
        }
        if ($parametros['predicados']['area'] != "") {
            $area = $parametros['predicados']['area'];
            unset($parametros['predicados']['area']);
        }
        $ordem = $parametros['predicados']['ordem'];
        unset($parametros['predicados']['ordem']);

        if ($parametros['predicados']['garagem'] == true || $parametros['predicados']['garagem'] == false) {
            $garagem = $parametros['predicados']['garagem'];
            unset($parametros['predicados']['garagem']);
        }
        $diferencial = $parametros['predicados']['diferencial'];
        unset($parametros['predicados']['diferencial']);
        if ($parametros['predicados']['quarto'] == 5) {
            $quartos = $parametros['predicados']['quarto'];
            unset($parametros['predicados']['quarto']);
        }
        if (count($parametros['predicados']) == 0)
            $crtlPred = FALSE;
        /* Atributos da Consulta */
        $sql = 'SELECT ' . $parametros['atributos'];
        /* View da Consulta */
        $sql = $sql . ' FROM buscaAnuncio' . ucfirst(strtolower($parametros['tabela'])) . ' vbapp';
        /* Predicados da Consulta */
        $sql = $sql . ' WHERE 1=1 ';
        if ($crtlPred) {
            foreach ($parametros['predicados'] as $chave => $valor) {

                if ($valor != "") {

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
            $sql = $sql . 'AND ' . implode(' AND ', $predicados);
        }
        if ($garagem == 'true') {
            $sql = $sql . ' AND garagem > 0 ';
        }
        if ($preco != NULL) {
            if ($preco >= 0 && $preco < 1000000) {
                $sql = $sql . ' AND valormin BETWEEN ' . $preco . ' AND ' . ($preco + 100000);
            } else {
                $sql = $sql . ' AND valormin > ' . $preco;
            }
        }
        if ($area != NULL) {
            if ($area >= 0 && $area < 220) {
                $sql = $sql . ' AND area BETWEEN ' . $area . ' AND ' . ($area + 20);
            } else {
                $sql = $sql . ' AND area > ' . $area;
            }
        }
        if ($diferencial != NULL) {
            for ($j = 0; $j < count($diferencial); $j++) {
                $sql = $sql . ' AND EXISTS (select * from imoveldiferencial tid '
                        . 'WHERE tid.idimovel = vbapp.idimovel AND tid.iddiferencial = :idDiferencial' . $j . ')';
            }
        }
        if ($quartos == 5) {
            $sql = $sql . ' AND quarto >= 5 ';
        }
        if ($parametros["idanuncio"] == null) {

            $sql = $sql . " AND status = 'cadastrado' ";
        }

        if ($ordem) {
            $criterios = explode("_", $ordem);
            if ($criterios[0] == 'preco') {
                $sql = $sql . ' ORDER BY valormin ';
            } else if ($criterios[0] == 'recente') {
                $sql = $sql . ' ORDER BY datahoracadastro ';
            }
            if ($criterios[1] == 'maior' || $criterios[1] == 'mais') {
                $sql = $sql . ' DESC ';
            } else if ($criterios[1] == 'menor' || $criterios[1] == 'menos') {
                $sql = $sql . ' ASC ';
            }
        }
        $statement = $this->conexao->prepare($sql);
        if ($diferencial != NULL) {
            foreach ($diferencial as $valor) {
                if (count($diferencial) == 1) {
                    $statement->bindValue(':idDiferencial' . 0, $valor);
                } else {
                    foreach ($diferencial as $k => $v) {
                        $statement->bindValue(':idDiferencial' . $k, $v);
                    }
                }
            }
        }
        foreach ($parametros['predicados'] as $chave => $valor) {
            if (!is_array($valor)) {
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
            $idsAnuncios = array_column($resultado['anuncio'], 'idanuncio');
            for ($i = 0; $i < count($idsAnuncios); $i++) {
                $sth = $this->conexao->prepare("SELECT diretorio, legenda, nome, destaque FROM imagem WHERE idanuncio = :idanuncio");
                $sth->bindValue(':idanuncio', $idsAnuncios[$i]);
                $sth->execute();
                $imovel['imagem'] = $sth->fetchAll(PDO::FETCH_ASSOC);
                if (count($imovel['imagem']) > 0) {
                    $resultado['anuncio'][$i]['imagem'] = ($imovel['imagem']);
                }
            }
        }
        /* Valores do anuncio */
        if (count($resultado['anuncio']) != 0) {
            $idsAnuncios = array_column($resultado['anuncio'], 'idanuncio');
            for ($i = 0; $i < count($idsAnuncios); $i++) {
                $sth = $this->conexao->prepare("SELECT novovalor, status FROM novovaloranuncio WHERE idanuncio = :idanuncio");
                $sth->bindValue(':idanuncio', $idsAnuncios[$i]);
                $sth->execute();
                $imovel['valores'] = $sth->fetchAll(PDO::FETCH_ASSOC);
                if (count($imovel['valores']) > 0) {
                    $resultado['anuncio'][$i]['valores'] = ($imovel['valores']);
                }
            }
        }
        /* diferenciais do imóvel */
        if (count($resultado['anuncio']) != 0) {
            $idsImoveis = array_column($resultado['anuncio'], 'idimovel');
            for ($i = 0; $i < count($idsImoveis); $i++) {
                $sth = $this->conexao->prepare("SELECT descricao FROM imoveldiferencial as imdif "
                        . "LEFT JOIN diferencial as d on imdif.iddiferencial = d.id WHERE idimovel = :idimovel");
                $sth->bindValue(':idimovel', $idsImoveis[$i]);
                $sth->execute();
                $imovel['diferenciais'] = $sth->fetchAll(PDO::FETCH_ASSOC);
                if (count($imovel['diferenciais']) > 0) {
                    $resultado['anuncio'][$i]['diferenciais'] = ($imovel['diferenciais']);
                }
            }
//            echo '<pre>';
//            print_r($resultado['anuncio']);
//            die();
        }
        if (count($resultado['anuncio']) != 0) {
            $idsImoveis = array_column($resultado['anuncio'], 'idimovel');
            $tiposImoveis = array_column($resultado['anuncio'], 'tipo');
            for ($i = 0; $i < count($idsImoveis); $i++) {
                if ($tiposImoveis[$i] == 'apartamentoplanta') {
                    $sth = $this->conexao->prepare("SELECT id, ordemplantas, tituloplanta, quarto, banheiro, suite, garagem, area, imagemdiretorio, imagemnome FROM planta WHERE idimovel = :idimovel");
                    $sth->bindValue(':idimovel', $idsImoveis[$i]);
                    $sth->execute();
                    $imovel['plantas'] = $sth->fetchAll(PDO::FETCH_ASSOC);
                    if (count($imovel['plantas']) > 0) {
                        $idsPlantas = array_column($imovel['plantas'], 'id');
                        for ($j = 0; $j < count($idsPlantas); $j++) {
                            $sth = $this->conexao->prepare("SELECT id, andarinicial, andarfinal, valor FROM valor WHERE idplanta = :idplanta");
                            $sth->bindValue(':idplanta', $idsPlantas[$j]);
                            $sth->execute();
                            $planta['valor'] = $sth->fetchAll(PDO::FETCH_ASSOC);
                            if(count($planta['valor']) > 0){
                                $imovel['plantas'][$j]['valores'] = $planta['valor']; 
                            }
                        }
                        $resultado['anuncio'][$i]['plantas'] = ($imovel['plantas']);
                    }
                /* echo '<pre>';
                print_r($resultado);
                echo '</pre>';
                die(); */
                }
            }
           
        }
        if (count($resultado['anuncio']) != 0) {
            $idsUsuarios = array_column($resultado['anuncio'], 'id');
            for ($i = 0; $i < count($idsUsuarios); $i++) {
                $sth = $this->conexao->prepare("SELECT tipotelefone, operadora, numero, whatsapp FROM telefone WHERE idusuario = :idusuario");
                $sth->bindValue(':idusuario', $idsUsuarios[$i]);
                $sth->execute();
                $usuario['telefone'] = $sth->fetchAll(PDO::FETCH_ASSOC);
                if (count($usuario['telefone']) > 0) {
                    $resultado['anuncio'][$i]['telefone'] = ($usuario['telefone']);
                }
            }
        }
        /* informacoes do tipo do imóvel */
        if (count($resultado['anuncio']) != 0) {
            $idsImoveis = array_column($resultado['anuncio'], 'idimovel');
            $tiposImoveis = array_column($resultado['anuncio'], 'tipo');
            for ($i = 0; $i < count($idsImoveis); $i++) {
                if ($tiposImoveis[$i] == 'casa') {
                    $sth = $this->conexao->prepare("SELECT quarto, banheiro, suite, garagem, area FROM buscaAnuncioCasa WHERE idimovel = :idimovel");
                    $sth->bindValue(':idimovel', $idsImoveis[$i]);
                    $sth->execute();
                    $imovel['casa'] = $sth->fetchAll(PDO::FETCH_ASSOC);
                    $resultado['anuncio'][$i] = array_merge($imovel['casa'][0], $resultado['anuncio'][$i]);
                }
                if ($tiposImoveis[$i] == 'apartamentoplanta') {
                    $sth = $this->conexao->prepare("SELECT andares, unidadesandar, totalunidades, numerotorres FROM buscaAnuncioApartamentoplanta WHERE idimovel = :idimovel");
                    $sth->bindValue(':idimovel', $idsImoveis[$i]);
                    $sth->execute();
                    $imovel['applanta'] = $sth->fetchAll(PDO::FETCH_ASSOC);
                    $resultado['anuncio'][$i] = array_merge($imovel['applanta'][0], $resultado['anuncio'][$i]);
                }
                if ($tiposImoveis[$i] == 'apartamento') {
                    $sth = $this->conexao->prepare("SELECT quarto, suite, banheiro, garagem, area, unidadesandar, andar, condominio FROM buscaAnuncioApartamento WHERE idimovel = :idimovel");
                    $sth->bindValue(':idimovel', $idsImoveis[$i]);
                    $sth->execute();
                    $imovel['ap'] = $sth->fetchAll(PDO::FETCH_ASSOC);
                    $resultado['anuncio'][$i] = array_merge($imovel['ap'][0], $resultado['anuncio'][$i]);
                }
                if ($tiposImoveis[$i] == 'salacomercial') {
                    $sth = $this->conexao->prepare("SELECT area, banheiro, garagem, condominio FROM buscaAnunciosalacomercial WHERE idimovel = :idimovel");
                    $sth->bindValue(':idimovel', $idsImoveis[$i]);
                    $sth->execute();
                    $imovel['sala'] = $sth->fetchAll(PDO::FETCH_ASSOC);
                    $resultado['anuncio'][$i] = array_merge($imovel['sala'][0], $resultado['anuncio'][$i]);
                }
                if ($tiposImoveis[$i] == 'terreno') {
                    $sth = $this->conexao->prepare("SELECT area FROM buscaAnuncioTerreno WHERE idimovel = :idimovel");
                    $sth->bindValue(':idimovel', $idsImoveis[$i]);
                    $sth->execute();
                    $imovel['terreno'] = $sth->fetchAll(PDO::FETCH_ASSOC);
                    $resultado['anuncio'][$i] = array_merge($imovel['terreno'][0], $resultado['anuncio'][$i]);
                }
            }
        }
        /* echo '<pre>';
          print_r($resultado['anuncio']);
          die(); */
        return $resultado;
    }

    public function ConsultarAnunciosPorUsuario($idUsuario, $administrador, $idAnuncio = null, $statusAnuncio = null, $finalidade = null) {
        $allow = $statusAnuncio;
        
        $sql = "SELECT a.* "
                . " FROM anuncio a"
                . " JOIN usuarioplano up ON up.id = a.idusuarioplano"
                . " JOIN usuario u ON up.idusuario = u.id"
                . " WHERE (u.status = 'ativo' or u.status = 'desativadousuario') "; //desativadousuário = quando o próprio usuário se desativa
        if ($idAnuncio != null)
            $sql .= " AND a.id = :idAnuncio ";
        //caso o usuário não seja Administrador do sistema, listar somente os anúncios pendentes do usuário logado
        if ($administrador != true)
                $sql.= " AND u.id = :idUsuario ";
        
        if ($statusAnuncio != null)
            $sql .= sprintf(" AND a.status in( %s )", implode(
                            ',', array_map(
                                    function($v) {
                                static $x = 0;
                                return ':allow_' . $x++;
                            }, $allow
                            )
                    )
            );

        if ($finalidade != null)
            $sql .= " AND a.finalidade = :finalidade ";
        $sql .= " ORDER BY a.ID DESC";
        $statement = $this->conexao->prepare($sql);
        //caso o usuário não seja Administrador do sistema, listar somente os anúncios pendentes do usuário logado
        if ($administrador != true){
        $statement->bindParam(':idUsuario', $idUsuario);
        
        }
        if ($idAnuncio != null)
            $statement->bindParam(':idAnuncio', $idAnuncio);
        if ($statusAnuncio != null)
            foreach ($allow as $k => $v) {
                $statement->bindValue('allow_' . $k, $v);
            }
        if ($finalidade != null)
            $statement->bindParam(':finalidade', $finalidade);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, "Anuncio");
        return $resultado;
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
    
    public function diferencialPlanta(){
     
        $sql = "SELECT a.*,d.descricao
        FROM tipoimoveldiferencial a
        JOIN diferencial d ON a.iddiferencial = d.id
        WHERE a.idtipoimovel = 3 AND a.iddiferencial not 
        in (select b.iddiferencial FROM tipoimoveldiferencial b WHERE b.idtipoimovel = 2)";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
        
    }
    
}
