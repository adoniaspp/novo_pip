<?php

class ConsultasAdHoc extends GenericoDAO {
    public function buscaAnuncios($parametros) {
        
        $sql = 'SELECT ' . $parametros['atributos']; 
        $sql = $sql . ' FROM buscaAnuncio' .  ucfirst(strtolower($parametros['tabela']));
        foreach ($parametros['predicados'] as $chave => $valor){
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
        $sql = $sql . ' WHERE ' . implode(' AND ', $predicados);  
        $statement = $this->conexao->prepare($sql);
        foreach ($parametros['predicados'] as $chave => $valor){
            foreach ($valor as $k => $v) {
                $statement->bindValue($chave . '_' . $k, $v);
            }   
        }
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo '<pre>';print_r($resultado);
        die();
        return $resultado;
    }
    public function consultarAnunciosPorUsuario() {
        
    }
}

