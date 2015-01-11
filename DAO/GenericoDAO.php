<?php

include_once 'configuracao/Conexao.php';

class GenericoDAO {

    public $conexao = null;

    public function __construct() {
        $this->conexao = Conexao::getInstance();
    }

    function iniciarTransacao() {
        $this->conexao->beginTransaction();
    }

    function commit() {
        $this->conexao->commit();
    }

    function rollback() {
        $this->conexao->rollBack();
    }

    function fecharConexao() {
        if ($this->conexao != null)
            $this->conexao = null;
    }

    function cadastrar($entidade) {
        $reflect = new ReflectionClass($entidade);
        $classe = $reflect->getName();
        $atributos = $reflect->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC);

        $sql = "INSERT INTO " . strtolower($classe) . " (";
        foreach ($atributos as $chave => $valor) {
            $sql = $sql . strtolower($valor->getName());
            if ($chave != (count($atributos) - 1))
                $sql = $sql . ", ";
        }
        $sql = $sql . ") VALUES (";
        foreach ($atributos as $chave => $valor) {
            $sql = $sql . ":" . strtolower($valor->getName());
            if ($chave != (count($atributos) - 1))
                $sql = $sql . ", ";
        }
        $sql = $sql . ")";
        $statement = $this->conexao->prepare($sql);
        foreach ($atributos as $valor) {
            $acao = "get" . ucfirst($valor->getName());
            $resultado = $entidade->$acao();
            $parametro = ":" . strtolower($valor->getName());
            $statement->bindValue($parametro, $resultado);
        }
        if ($statement->execute()) {
            if ($this->conexao->lastInsertId())
                return $this->conexao->lastInsertId();
            else
                return true;
        } else {
            return false;
        }
    }

    function consultar($entidade, $estrangeiro, $parametros = NULL) {
        $reflect = new ReflectionClass($entidade);
        $classe = $reflect->getName();
        $sql = "SELECT * FROM " . strtolower($classe);
        if (!(is_null($parametros))) {
            foreach ($parametros as $chave => $valor) {
                $criterios[] = $chave . "=:" . $chave;
            }
            $sql = $sql . " WHERE " . implode(" and ", $criterios);
            $sql = $sql . " ORDER BY ID DESC";
            $statement = $this->conexao->prepare($sql);
            foreach ($parametros as $chave => $valor) {
                $parametro = ":" . $chave;
                $statement->bindValue($parametro, $valor);
            }          
        }else{
            $sql = $sql . " ORDER BY ID DESC";
            $statement = $this->conexao->prepare($sql);
        }
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, $classe);
        if ($estrangeiro) {
            $blindado = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);
            if ($blindado) {
                $privados = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
                foreach ($privados as $listaPrivados) {
                    $atributos[] = $listaPrivados->name;
                }
                foreach ($resultado as $objeto) {
                    foreach ($blindado as $atributoBlindado) {
                        if (in_array("id" . $atributoBlindado->getName(), $atributos)) {
                            $entidadeBlindada = $atributoBlindado->getName();
                            $chaveEstrangeira = "id";
                            $acao = "getId" . $atributoBlindado->getName();
                            $idChaveEstrangeira = $objeto->$acao();
                        } else {
                            $entidadeBlindada = $atributoBlindado->getName();
                            $chaveEstrangeira = "id" . $classe;
                            $idChaveEstrangeira = $objeto->getId();
                        }
                        $acao = "set" . ucfirst($atributoBlindado->getName());
                        $objeto->$acao($this->selecionarBlindado($entidadeBlindada, $chaveEstrangeira, $idChaveEstrangeira));
                    }
                    $resultadoBlindado[] = $objeto;
                }
                return isset($resultadoBlindado)?$resultadoBlindado:NULL;
            } else {
                return $resultado;
            }
        } else {
            return $resultado;
        }
    }

    function selecionarBlindado($entidadeBlindada, $chaveEstrangeira, $idChaveEstrangeira) {
        $sql = "SELECT * FROM " . strtolower($entidadeBlindada) . " WHERE " . $chaveEstrangeira . " =:idChaveEstrangeira ORDER BY ID DESC";
        $statement = $this->conexao->prepare($sql);
        $statement->bindParam(':idChaveEstrangeira', $idChaveEstrangeira);
        $statement->execute();
        $statement->rowCount();

        $resultado = $statement->fetchAll(PDO::FETCH_CLASS, $entidadeBlindada);

        if ($statement->rowCount() == 1) {
            $resultado = $resultado[0];
        }
        return $resultado;
    }

    function editar($entidade) {
        $reflect = new ReflectionClass($entidade);
        $classe = $reflect->getName();
        $atributos = $reflect->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC);

        $sql = "UPDATE " . strtolower($classe) . " SET ";
        foreach ($atributos as $chave => $valor) {
            $acao = "get" . ucfirst($valor->getName());
            $resultado = $entidade->$acao();
            if(is_null($resultado) || $acao == "getId"){
                continue;
            }else{
                $criterios[] = strtolower($valor->getName()) . " = :" . strtolower($valor->getName());
//            $sql = $sql . strtolower($valor->getName()) . " = :" . strtolower($valor->getName());
//            if ($chave != (count($atributos) - 1))
//                $sql = $sql . ", ";
//            }
        }
        }
        $sql = $sql . implode(", ", $criterios) . " WHERE id = :id";
        //var_dump($sql);        die();
        //$sql = $sql . " WHERE id = :id";

        $statement = $this->conexao->prepare($sql);
        foreach ($atributos as $valor) {
            $acao = "get" . ucfirst($valor->getName());
            $resultado = $entidade->$acao();
            if(is_null($resultado)){
                continue;
            }else{
            $parametro = ":" . strtolower($valor->getName());
            $statement->bindValue($parametro, $resultado);
            }
        }
        if ($statement->execute()) {
            return true;
        } else
            return false;
    }

    function excluir($entidade, $parametro) {
        $reflect = new ReflectionClass($entidade);
        $classe = $reflect->getName();
        $sql = "DELETE FROM " . strtolower($classe) . " WHERE id=:id";
        $statement = $this->conexao->prepare($sql);
        $statement->bindParam(':id', $parametro);
        if ($statement->execute()) {
            return true;
        } else
            return false;
    }

}
