<?php

class ConsultasAdHoc extends GenericoDAO {

    public function buscaAnuncios($parametros) {
        if (isset($parametros['predicados']['atributos'])) {
            unset($parametros['predicados']['atributos']);
        }
        if (isset($parametros['predicados']['tabela'])) {
            unset($parametros['predicados']['tabela']);
        }

        $crtlPred = true;
        /* Configurações dos Parametros */
        foreach ($parametros['predicados'] as $chave => $valor) {
            if ($valor == '') {
                unset($parametros['predicados'][$chave]);
            }
        }
        if (isset($parametros['predicados']['valor']) && $parametros['predicados']['valor'] >= 0) {
            $preco = $parametros['predicados']['valor'];
            unset($parametros['predicados']['valor']);
        }
        if (isset($parametros['predicados']['valor']) && $parametros['predicados']['area'] != "") {
            $area = $parametros['predicados']['area'];
            unset($parametros['predicados']['area']);
        }
        if (isset($parametros['predicados']['ordem'])) {
            $ordem = $parametros['predicados']['ordem'];
            unset($parametros['predicados']['ordem']);
        }
        if (isset($parametros['predicados']['garagem']) && ($parametros['predicados']['garagem'] == true || $parametros['predicados']['garagem'] == false)) {
            $garagem = $parametros['predicados']['garagem'];
            unset($parametros['predicados']['garagem']);
        }
        if (isset($parametros['predicados']['diferencial'])) {
            $diferencial = $parametros['predicados']['diferencial'];
            unset($parametros['predicados']['diferencial']);
        }
        if ($parametros['predicados']['quarto'] == 5) {
            $quartos = $parametros['predicados']['quarto'];
            unset($parametros['predicados']['quarto']);
        }
        if (isset($parametros['predicados']['linha'])) {
            $linha = $parametros['predicados']['linha'];
            unset($parametros['predicados']['linha']);
        }
        if (isset($parametros['predicados']['paginaInicial'])) {
            $paginaInicial = $parametros['predicados']['paginaInicial'];
            unset($parametros['predicados']['paginaInicial']);
        }

        if (isset($parametros['predicados']['mobile'])) {
            $mobile = $parametros['predicados']['mobile'];
            unset($parametros['predicados']['mobile']);
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
        #Calcula o valor total de anuncios da busca
        if ($paginaInicial && $mobile) {
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
            $totalAnuncios = sizeof($resultado['anuncio']);
        }

        if ($mobile) {
            $sql = $sql . ' limit ' . $linha . ', 4';
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
                $statement->bindValue(':' . $chave . '_0', $valor);
            } else {
                foreach ($valor as $k => $v) {
                    $statement->bindValue(':' . $chave . '_' . $k, $v);
                }
            }
        }

        $statement->execute();
        $resultado['anuncio'] = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($paginaInicial && $mobile) {
            $resultado['total'] = $totalAnuncios;
        }
        $idsImoveis = array_column($resultado['anuncio'], 'idimovel');
        $idsAnuncios = array_column($resultado['anuncio'], 'idanuncio');

        /* Imagens do anuncio */
        if (count($resultado['anuncio']) != 0) {
            $allow = $idsAnuncios;
            $sql = "SELECT idanuncio, diretorio, legenda, nome, destaque FROM imagem WHERE ";
            $sql .= sprintf(" idanuncio in( %s )", implode(
                            ',', array_map(
                                    function($v) {
                                static $x = 0;
                                return ':allow_' . $x++;
                            }, $allow
                            )
                    )
            );
            $sth = $this->conexao->prepare($sql);
            foreach ($allow as $k => $v) {
                $sth->bindValue('allow_' . $k, $v);
            }
            $sth->execute();
            $retornoConsulta = $sth->fetchAll(PDO::FETCH_ASSOC);
            if (count($retornoConsulta) != 0) {
                foreach ($retornoConsulta as $retorno) {
                    $indice = array_search($retorno["idanuncio"], $idsAnuncios);
                    $resultado['anuncio'][$indice]['imagem'][] = $retorno;
                }
            }
        }

        /* Valores do anuncio */
        if (count($resultado['anuncio']) != 0) {
            $allow = $idsAnuncios;
            $sql = "SELECT idanuncio, novovalor, status FROM novovaloranuncio WHERE ";
            $sql .= sprintf(" idanuncio in( %s )", implode(
                            ',', array_map(
                                    function($v) {
                                static $x = 0;
                                return ':allow_' . $x++;
                            }, $allow
                            )
                    )
            );
            $sth = $this->conexao->prepare($sql);
            foreach ($allow as $k => $v) {
                $sth->bindValue('allow_' . $k, $v);
            }
            $sth->execute();
            $retornoConsulta = $sth->fetchAll(PDO::FETCH_ASSOC);
            if (count($retornoConsulta) != 0) {
                foreach ($retornoConsulta as $retorno) {
                    $indice = array_search($retorno["idanuncio"], $idsAnuncios);
                    $resultado['anuncio'][$indice]['valores'][] = $retorno;
                }
            }
        }

        /* Diferenciais do imóvel */
        if (count($idsImoveis) != 0) {
            $allow = $idsImoveis;
            $sql = "SELECT idimovel, descricao FROM imoveldiferencial as imdif LEFT JOIN diferencial as d on imdif.iddiferencial = d.id WHERE ";
            $sql .= sprintf(" idimovel in( %s )", implode(
                            ',', array_map(
                                    function($v) {
                                static $x = 0;
                                return ':allow_' . $x++;
                            }, $allow
                            )
                    )
            );
            $sth = $this->conexao->prepare($sql);
            foreach ($allow as $k => $v) {
                $sth->bindValue('allow_' . $k, $v);
            }
            $sth->execute();
            $retornoConsulta = $sth->fetchAll(PDO::FETCH_ASSOC);
            if (count($retornoConsulta) != 0) {
                foreach ($retornoConsulta as $retorno) {
                    $indice = array_search($retorno["idimovel"], $idsAnuncios);
                    $resultado['anuncio'][$indice]['diferenciais'][] = $retorno;
                }
            }
        }


        /* Apartamento na Planta */
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
                            if (count($planta['valor']) > 0) {
                                $imovel['plantas'][$j]['valores'] = $planta['valor'];
                            }
                        }
                        $resultado['anuncio'][$i]['plantas'] = ($imovel['plantas']);
                    }
                }
            }
        }

        /* Telefone */
        if (count($idsUsuarios) != 0) {
            $idsUsuarios = array_column($resultado['anuncio'], 'id');
            $allow = $idsUsuarios;
            $sql = "SELECT idusuario, tipotelefone, operadora, numero, whatsapp FROM telefone WHERE ";
            $sql .= sprintf(" idusuario in( %s )", implode(
                            ',', array_map(
                                    function($v) {
                                static $x = 0;
                                return ':allow_' . $x++;
                            }, $allow
                            )
                    )
            );
            $sth = $this->conexao->prepare($sql);
            foreach ($allow as $k => $v) {
                $sth->bindValue('allow_' . $k, $v);
            }
            $sth->execute();
            $retornoConsulta = $sth->fetchAll(PDO::FETCH_ASSOC);
            if (count($retornoConsulta) != 0) {
                foreach ($retornoConsulta as $retorno) {
                    $indice = array_search($retorno["idusuario"], $idsAnuncios);
                    $resultado['anuncio'][$indice]['telefone'][] = $retorno;
                }
            }
        }


        /* Informacoes do tipo do imóvel */
        if (count($resultado['anuncio']) != 0) {
            $idsImoveis = array_column($resultado['anuncio'], 'idimovel');
            $tiposImoveis = array_column($resultado['anuncio'], 'tipo');
            for ($i = 0; $i < count($idsImoveis); $i++) {
                switch ($tiposImoveis[$i]) {
                    case 'casa':
                        $idsCasa[$i] = $idsImoveis[$i];
                        break;
                    case 'apartamentoplanta':
                        $idsApartamentoPlanta[$i] = $idsImoveis[$i];
                        break;
                    case 'apartamento':
                        $idsApartamento[$i] = $idsImoveis[$i];
                        break;
                    case 'salacomercial':
                        $idsSalaComercial[$i] = $idsImoveis[$i];
                        break;
                    case 'terreno':
                        $idsTerreno[$i] = $idsImoveis[$i];
                        break;
                    default:
                        break;
                }
            }
        }

        /* Casas */
        if (count($idsCasa) != 0) {
            $allow = $idsCasa;
            $sql = "SELECT idimovel, quarto, banheiro, suite, garagem, area FROM buscaAnuncioCasa WHERE ";
            $sql .= sprintf(" idimovel in( %s )", implode(
                            ',', array_map(
                                    function($v) {
                                static $x = 0;
                                return ':allow_' . $x++;
                            }, $allow
                            )
                    )
            );
            $sth = $this->conexao->prepare($sql);
            $index = 0;
            foreach ($allow as $ids) {
                    $sth->bindValue('allow_' . $index, $ids);
                    $index++;               
            }
            $sth->execute();
            $retornoConsulta = $sth->fetchAll(PDO::FETCH_ASSOC);
            if (count($retornoConsulta) != 0) {
                foreach ($retornoConsulta as $retorno) {
                    $indice = array_search($retorno["idimovel"], $idsCasa);
                    $resultado['anuncio'][$indice] = array_merge($retorno, $resultado['anuncio'][$indice]);
                }
            }
        }

        /* Apartamento na Planta */
        if (count($idsApartamentoPlanta) != 0) {
            $allow = $idsApartamentoPlanta;
            $sql = "SELECT idimovel, andares, unidadesandar, totalunidades, numerotorres FROM buscaAnuncioApartamentoplanta WHERE ";
            $sql .= sprintf(" idimovel in( %s )", implode(
                            ',', array_map(
                                    function($v) {
                                static $x = 0;
                                return ':allow_' . $x++;
                            }, $allow
                            )
                    )
            );
            $sth = $this->conexao->prepare($sql);
            $index = 0;
            foreach ($allow as $ids) {
                    $sth->bindValue('allow_' . $index, $ids);
                    $index++;               
            }
            $sth->execute();
            $retornoConsulta = $sth->fetchAll(PDO::FETCH_ASSOC);
            if (count($retornoConsulta) != 0) {
                foreach ($retornoConsulta as $retorno) {
                    $indice = array_search($retorno["idimovel"], $idsApartamentoPlanta);
                    $resultado['anuncio'][$indice] = array_merge($retorno, $resultado['anuncio'][$indice]);
                }
            }
        }

        /* Apartamento  */
        if (count($idsApartamento) != 0) {
            $allow = $idsApartamento;
            $sql = "SELECT idimovel, quarto, suite, banheiro, garagem, area, unidadesandar, andar, condominio FROM buscaAnuncioApartamento WHERE ";
            $sql .= sprintf(" idimovel in( %s )", implode(
                            ',', array_map(
                                    function($v) {
                                static $x = 0;
                                return ':allow_' . $x++;
                            }, $allow
                            )
                    )
            );
            $sth = $this->conexao->prepare($sql);
            $index = 0;
            foreach ($allow as $ids) {
                    $sth->bindValue('allow_' . $index, $ids);
                    $index++;               
            }
            $sth->execute();
            $retornoConsulta = $sth->fetchAll(PDO::FETCH_ASSOC);

            if (count($retornoConsulta) != 0) {
                foreach ($retornoConsulta as $retorno) {
                    $indice = array_search($retorno["idimovel"], $idsApartamento);
                    $resultado['anuncio'][$indice] = array_merge($retorno, $resultado['anuncio'][$indice]);
                }
            }
        }

        /* Sala Comercial  */
        if (count($idsSalaComercial) != 0) {
            $allow = $idsSalaComercial;
            $sql = "SELECT idimovel,  area, banheiro, garagem, condominio FROM buscaAnuncioSalacomercial WHERE ";
            $sql .= sprintf(" idimovel in( %s )", implode(
                            ',', array_map(
                                    function($v) {
                                static $x = 0;
                                return ':allow_' . $x++;
                            }, $allow
                            )
                    )
            );
            $sth = $this->conexao->prepare($sql);
            $index = 0;
            foreach ($allow as $ids) {
                    $sth->bindValue('allow_' . $index, $ids);
                    $index++;               
            }
            $sth->execute();
            $retornoConsulta = $sth->fetchAll(PDO::FETCH_ASSOC);
            if (count($retornoConsulta) != 0) {
                foreach ($retornoConsulta as $retorno) {
                    $indice = array_search($retorno["idimovel"], $idsSalaComercial);
                    $resultado['anuncio'][$indice] = array_merge($retorno, $resultado['anuncio'][$indice]);
                }
            }
        }

        /* Terreno  */
        if (count($idsTerreno) != 0) {
            $allow = $idsTerreno;
            $sql = "SELECT idimovel,  area FROM buscaAnuncioTerreno WHERE ";
            $sql .= sprintf(" idimovel in( %s )", implode(
                            ',', array_map(
                                    function($v) {
                                static $x = 0;
                                return ':allow_' . $x++;
                            }, $allow
                            )
                    )
            );
            $sth = $this->conexao->prepare($sql);
            $index = 0;
            foreach ($allow as $ids) {
                    $sth->bindValue('allow_' . $index, $ids);
                    $index++;               
            }
            $sth->execute();
            $retornoConsulta = $sth->fetchAll(PDO::FETCH_ASSOC);
            if (count($retornoConsulta) != 0) {
                foreach ($retornoConsulta as $retorno) {
                    $indice = array_search($retorno["idimovel"], $idsTerreno);
                    $resultado['anuncio'][$indice] = array_merge($retorno, $resultado['anuncio'][$indice]);
                }
            }
        }

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
            $sql .= " AND u.id = :idUsuario ";

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
        if ($administrador != true) {
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
        $sql = "SELECT i.id
                FROM imovel i
                WHERE i.status = 'cadastrado' AND i.idusuario = :idUsuario
                  AND NOT EXISTS
                    (SELECT 1
                     FROM anuncio a
                     WHERE a.idimovel = i.id)
                     AND NOT EXISTS
                    (SELECT 1
                     FROM anuncioaprovacao aa
                     WHERE aa.idimovel = i.id AND aa.status = 'pendenteanalise')";
        $sql = $sql . " ORDER BY i.ID DESC";
        $statement = $this->conexao->prepare($sql);
        $statement->bindParam(':idUsuario', $idUsuario);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function diferencialPlanta() {

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

    public function consultaUsuarioDenuncia() {

        $sql = "select u.id, tipousuario, nome, cpfcnpj, login, email, u.datahoracadastro, 
            count(u.id) as 'denuncias' from denuncia d left join 
            usuario u on u.id = d.idusuario where status like 'ativo'
            group by u.id order by denuncias";

        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function consultarDenuncia() {
        $sql = "select d.id, d.idanuncio, d.idusuario, dt.descricao as 'tipodenuncia', 
            d.descricao as denuncia, d.datahoracadastro
            from denuncia d left join 
            denunciatipo dt on d.idtipodenuncia = dt.id";
        $statement = $this->conexao->prepare($sql);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function ConsultarAnunciosPendentesPorUsuario($idUsuario, $administrador, $statusAnuncio = null, $codigoAnuncio = null) {
        $allow = $statusAnuncio;

        $sql = "SELECT aa.*, (SELECT 1 FROM anuncio a WHERE a.idanuncio = aa.idanuncio AND a.status = 'cadastrado') as edicao, (SELECT 1 FROM anuncio a WHERE a.idanuncio = aa.idanuncio AND a.finalidade = 'Aluguel' AND (a.status = 'finalizado' OR a.status = 'expirado') ) as reativacao"
                . " FROM anuncioaprovacao aa"
                . " JOIN usuarioplano up ON up.id = aa.idusuarioplano"
                . " JOIN usuario u ON up.idusuario = u.id"
                . " WHERE (u.status = 'ativo' or u.status = 'desativadousuario') "
                . " AND ( "
                . " EXISTS (SELECT 1 FROM anuncio a WHERE a.idanuncio = aa.idanuncio AND a.status = 'cadastrado') "
                . " OR "
                . " NOT EXISTS (SELECT 1 FROM anuncio a WHERE a.idanuncio = aa.idanuncio )"
                . " OR "
                . " EXISTS (SELECT 1 FROM anuncio a WHERE a.idanuncio = aa.idanuncio AND a.finalidade = 'Aluguel' AND (a.status = 'finalizado' OR a.status = 'expirado'))"
                . " ) "
                . ""; //desativadousuário = quando o próprio usuário se desativa
        //caso o usuário não seja Administrador do sistema, listar somente os anúncios pendentes do usuário logado
        if ($administrador != true)
            $sql .= " AND u.id = :idUsuario ";

        if ($statusAnuncio != null)
            $sql .= sprintf(" AND aa.status in( %s )", implode(
                            ',', array_map(
                                    function($v) {
                                static $x = 0;
                                return ':allow_' . $x++;
                            }, $allow
                            )
                    )
            );

        if ($codigoAnuncio != null)
            $sql .= " AND aa.idanuncio = :codigoAnuncio";

        $sql .= " ORDER BY aa.ID DESC";
        $statement = $this->conexao->prepare($sql);
        //caso o usuário não seja Administrador do sistema, listar somente os anúncios pendentes do usuário logado
        if ($administrador != true) {
            $statement->bindParam(':idUsuario', $idUsuario);
        }

        if ($statusAnuncio != null) {
            foreach ($allow as $k => $v) {
                $statement->bindValue('allow_' . $k, $v);
            }
        }

        if ($codigoAnuncio != null) {
            $statement->bindParam(':codigoAnuncio', $codigoAnuncio);
        }
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
        
    public function verificarPlanoGratuito($idUsuario) {
        $sql = "select a.id FROM anuncio a"
                . " JOIN usuarioplano up ON up.id = a.idusuarioplano"
                . " JOIN plano p ON p.id = up.idplano"
                . " WHERE p.gratuito = 'SIM' AND up.idusuario = :idUsuario AND a.status = 'cadastrado' "
                
                . " UNION "
                . " select a.id FROM anuncioaprovacao a"
                . " JOIN usuarioplano up ON up.id = a.idusuarioplano"
                . " JOIN plano p ON p.id = up.idplano"
                . " JOIN imovel i on i.id = a.idimovel"
                . " WHERE p.gratuito = 'SIM' AND up.idusuario = :idUsuario AND a.status in ('emanalise', 'pendenteanalise') "
                . " AND i.status = 'cadastrado'"
                . " AND not exists (select 1 from anuncio an
                                    JOIN usuarioplano up2 ON up2.id = an.idusuarioplano
                                    JOIN plano p2 ON p2.id = up2.idplano
                                    WHERE p2.gratuito = 'SIM' AND up2.idusuario = :idUsuario 
                                    AND an.status = 'cadastrado')";
        $statement = $this->conexao->prepare($sql);
        $statement->bindParam(':idUsuario', $idUsuario);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    
    public function consultarAnunciosPendentesAprovacaoPorUsuario($idUsuario){
        $sql = "SELECT a.* FROM anuncioaprovacao a
                join usuarioplano up on up.id = a.idusuarioplano
                WHERE 1=1
                and up.idusuario = :idUsuario and (a.status = 'pendenteanalise' or a.status = 'emanalise')";
        $statement = $this->conexao->prepare($sql);
        $statement->bindParam(':idUsuario', $idUsuario);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, "AnuncioAprovacao");
        return $resultado;
    }
    
        public function consultarAnunciosAprovados($idUsuario){
        $sql = "SELECT *, up.status as statusplano
                FROM usuarioplano up 
                left join anuncioaprovacao ap on ap.idusuarioplano = up.idusuario
                join plano p on p.id = up.idplano
                LEFT join anuncio a on a.idusuarioplano = up.id
                WHERE 1=1
                and up.idusuario = :idUsuario";
        $statement = $this->conexao->prepare($sql);
        $statement->bindParam(':idUsuario', $idUsuario);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    
    public function excluirAnunciosPendentesFinalizar($idanuncio){
        $sql = "call excluirPendentesAprovacaoFinalizados(:idanuncio)";
        $statement = $this->conexao->prepare($sql);
        $statement->bindParam(':idanuncio', $idanuncio);
        $statement->execute();
    }
    
}
