<?php

class ConsultasAdHoc extends GenericoDAO {

    public function buscaIN($parametros) {

        $sql = 'SELECT ' . $parametros['atributos'];
        $sql = $sql . ' FROM' . ucfirst(strtolower($parametros['tabela']));
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
        $sql = $sql . ' WHERE ' . implode(' AND ', $predicados);
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
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo '<pre>';
        print_r($resultado);
        die();
        return $resultado;
    }
    
    public function buscaAnuncios($parametros) {

        $sql = 'SELECT ' . $parametros['atributos'];
        $sql = $sql . ' FROM buscaAnuncio' . ucfirst(strtolower($parametros['tabela']));
        unset($parametros['predicados']['atributos']);
        unset($parametros['predicados']['tabela']);

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
        $sql = $sql . ' WHERE ' . implode(' AND ', $predicados);
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
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        $ids = array_column($resultado, 'id');
//        foreach ($ids as $id){
//            $sql = 'SELECT * from valor where idanuncio = ' . $id . 'where valor' . ;
//            
//            $statement = $this->conexao->prepare($sql);
//            $selecionarValores[] = $genericoDAO->consultar($cidade, false, array("idanuncio" => $parametros['txtCidade'], "idestado" => $idEstado));
//        }
//        $valores = array('atributos' => '*', 'tabela' => 'valor', 'predicados' => array('id' => $ids));
//        buscaIN($valores);
//        echo '<pre>';
//        print_r($resultado['id']);
//        die();
        return $resultado;
    }
    
    public function consultarAnunciosPorUsuario() {
        
    }

}
