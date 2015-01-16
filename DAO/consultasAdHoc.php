<?php

class ConsultasAdHoc extends GenericoDAO {
    public function buscaAnuncios($parametros) {
        $params = array(1, 21, 63, 171);
        $place_holders = implode(',', array_fill(0, count($params), '?'));
        $statement = $this->conexao->prepare("SELECT id, name FROM contacts WHERE id IN ($place_holders)");
        $statement->execute($params);
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
}

