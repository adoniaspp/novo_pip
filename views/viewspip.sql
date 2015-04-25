CREATE VIEW buscaAnuncioCasa AS
/*Imóvel - Casa*/
SELECT a.id as idanuncio, a.finalidade, a.tituloanuncio, a.descricaoanuncio, 
a.status, a.valorvisivel, a.publicarmapa, a.publicarcontato, a.valormin,
i.id as idimovel, i.condicao,
ti.descricao,
ca.quarto, ca.banheiro, ca.suite, ca.garagem, ca.area,
en.cep, en.logradouro, en.numero, b.id as idbairro, b.nome as bairro, ci.id as idcidade, ci.nome as cidade, es.id as idestado, es.nome as estado, en.complemento,
us.id, us.nome, us.tipousuario, us.email
FROM anuncio AS a RIGHT JOIN imovel as i
ON a.idimovel = i.id
LEFT JOIN usuario as us
ON i.idusuario = us.id
RIGHT JOIN tipoimovel as ti
ON i.idtipoimovel = ti.id
RIGHT JOIN casa as ca
ON ca.idimovel = i.id
RIGHT JOIN endereco as en
ON en.id = i.idendereco
RIGHT JOIN estado as es
ON es.id = en.idestado
RIGHT JOIN cidade as ci
ON ci.id = en.idcidade
RIGHT JOIN bairro as b
ON b.id = en.idbairro
WHERE a.status = 'cadastrado';

CREATE VIEW buscaAnuncioApPlanta AS
/*Imóvel - ApNovo*/
SELECT a.id as idanuncio, a.finalidade, a.tituloanuncio, a.descricaoanuncio, 
a.status, a.valorvisivel, a.publicarmapa, a.publicarcontato, a.valormin,
i.id as idimovel, i.condicao,
ti.descricao,
app.id as idapartamento, app.andares, app.unidadesandar, totalunidades, numerotorres,
en.cep, en.logradouro, en.numero, b.id as idbairro, b.nome as bairro, ci.id as idcidade, ci.nome as cidade, es.id as idestado, es.nome as estado, en.complemento,
us.id, us.nome, us.tipousuario, us.email
FROM anuncio AS a RIGHT JOIN imovel as i
ON a.idimovel = i.id
LEFT JOIN usuario as us
ON i.idusuario = us.id
RIGHT JOIN tipoimovel as ti
ON i.idtipoimovel = ti.id
RIGHT JOIN apartamentoplanta as app
ON app.idimovel = i.id
RIGHT JOIN endereco as en
ON en.id = i.idendereco
RIGHT JOIN estado as es
ON es.id = en.idestado
RIGHT JOIN cidade as ci
ON ci.id = en.idcidade
RIGHT JOIN bairro as b
ON b.id = en.idbairro
WHERE a.status = 'cadastrado';

CREATE VIEW buscaAnuncioAp AS
/*Imóvel - Ap*/
SELECT a.id as idanuncio, a.finalidade, a.tituloanuncio, a.descricaoanuncio, 
a.status, a.valorvisivel, a.publicarmapa, a.publicarcontato, a.valormin,
i.id as idimovel, i.condicao,
ti.descricao,
ap.quarto, ap.suite, ap.banheiro, ap.garagem, ap.area, ap.sacada, ap.unidadesandar, ap.andar, ap.condominio, ap.cobertura,
en.cep, en.logradouro, en.numero, b.id as idbairro, b.nome as bairro, ci.id as idcidade, ci.nome as cidade, es.id as idestado, es.nome as estado, en.complemento,
us.id, us.nome, us.tipousuario, us.email
FROM anuncio AS a RIGHT JOIN imovel as i
ON a.idimovel = i.id
LEFT JOIN usuario as us
ON i.idusuario = us.id
RIGHT JOIN tipoimovel as ti
ON i.idtipoimovel = ti.id
RIGHT JOIN apartamento as ap
ON ap.idimovel = i.id
RIGHT JOIN endereco as en
ON en.id = i.idendereco
RIGHT JOIN estado as es
ON es.id = en.idestado
RIGHT JOIN cidade as ci
ON ci.id = en.idcidade
RIGHT JOIN bairro as b
ON b.id = en.idbairro
WHERE a.status = 'cadastrado';

CREATE VIEW buscaAnuncioSala AS
/*Imóvel - Ap*/
SELECT a.id as idanuncio, a.finalidade, a.tituloanuncio, a.descricaoanuncio, 
a.status, a.valorvisivel, a.publicarmapa, a.publicarcontato, a.valormin,
i.id as idimovel, i.condicao,
ti.descricao,
sl.area, sl.banheiro, sl.garagem, sl.condominio,
en.cep, en.logradouro, en.numero, b.id as idbairro, b.nome as bairro, ci.id as idcidade, ci.nome as cidade, es.id as idestado, es.nome as estado, en.complemento,
us.id, us.nome, us.tipousuario, us.email
FROM anuncio AS a RIGHT JOIN imovel as i
ON a.idimovel = i.id
LEFT JOIN usuario as us
ON i.idusuario = us.id
RIGHT JOIN tipoimovel as ti
ON i.idtipoimovel = ti.id
RIGHT JOIN salacomercial as sl
ON sl.idimovel = i.id
RIGHT JOIN endereco as en
ON en.id = i.idendereco
RIGHT JOIN estado as es
ON es.id = en.idestado
RIGHT JOIN cidade as ci
ON ci.id = en.idcidade
RIGHT JOIN bairro as b
ON b.id = en.idbairro
WHERE a.status = 'cadastrado';

CREATE VIEW buscaAnuncioTerreno AS
/*Imóvel - Terreno*/
SELECT a.id as idanuncio, a.finalidade, a.tituloanuncio, a.descricaoanuncio, 
a.status, a.valorvisivel, a.publicarmapa, a.publicarcontato, a.valormin,
i.id as idimovel, i.condicao,
ti.descricao,
t.area,
en.cep, en.logradouro, en.numero, b.id as idbairro, b.nome as bairro, ci.id as idcidade, ci.nome as cidade, es.id as idestado, es.nome as estado, en.complemento,
us.id, us.nome, us.tipousuario, us.email
FROM anuncio AS a RIGHT JOIN imovel as i
ON a.idimovel = i.id
LEFT JOIN usuario as us
ON i.idusuario = us.id
RIGHT JOIN tipoimovel as ti
ON i.idtipoimovel = ti.id
RIGHT JOIN terreno as t
ON t.idimovel = i.id
RIGHT JOIN endereco as en
ON en.id = i.idendereco
RIGHT JOIN estado as es
ON es.id = en.idestado
RIGHT JOIN cidade as ci
ON ci.id = en.idcidade
RIGHT JOIN bairro as b
ON b.id = en.idbairro
WHERE a.status = 'cadastrado';

CREATE VIEW buscaAnuncioTodos AS
/*Imóvel - Terreno*/
SELECT a.id as idanuncio, a.finalidade, a.tituloanuncio, a.descricaoanuncio, 
a.status, a.valorvisivel, a.publicarmapa, a.publicarcontato, a.valormin,
i.id as idimovel, i.condicao,
ti.descricao,
en.cep, en.logradouro, en.numero, b.id as idbairro, b.nome as bairro, ci.id as idcidade, ci.nome as cidade, es.id as idestado, es.nome as estado, en.complemento,
us.id, us.nome, us.tipousuario, us.email
FROM anuncio AS a RIGHT JOIN imovel as i
ON a.idimovel = i.id
LEFT JOIN usuario as us
ON i.idusuario = us.id
RIGHT JOIN tipoimovel as ti
ON i.idtipoimovel = ti.id
RIGHT JOIN endereco as en
ON en.id = i.idendereco
RIGHT JOIN estado as es
ON es.id = en.idestado
RIGHT JOIN cidade as ci
ON ci.id = en.idcidade
RIGHT JOIN bairro as b
ON b.id = en.idbairro
WHERE a.status = 'cadastrado';












/*Imagenscasa*/
SELECT a.id, im.id, im.diretorio, im.legenda, im.destaque
FROM anuncio AS a RIGHT JOIN imovel as i
ON a.idimovel = i.id
RIGHT JOIN casa as ca
ON ca.idimovel = i.id
RIGHT JOIN imagem as im
ON im.idanuncio = a.id
WHERE a.status = 'cadastrado'

/*Não precisará da view de imagens das casas pois já irei obter os ids dos anuncios a partir da view de casa. */

/*SERÁ REALIZADA UMA PESQUISA NA VIEW CASA COM FILTRO DE FINALIDADES E BAIRROS, EM SEGUIDA SERÁ REALIZADO O FILTRO NA VIEW 
IMAGENSCASA COM BASE NOS IDS DOS ANUNCIOS OBTIDOS NA VIEW BUSCAANUNCIOCASA.*/


/*<?php
 Execute a prepared statement using an array of values for an IN clause 
$params = array(1, 21, 63, 171);
Create a string for the parameter placeholders filled to the number of params 
$place_holders = implode(',', array_fill(0, count($params), '?'));

    This prepares the statement with enough unnamed placeholders for every value
    in our $params array. The values of the $params array are then bound to the
    placeholders in the prepared statement when the statement is executed.
    This is not the same thing as using PDOStatement::bindParam() since this
    requires a reference to the variable. PDOStatement::execute() only binds
    by value instead.

$sth = $dbh->prepare("SELECT id, name FROM contacts WHERE id IN ($place_holders)");
$sth->execute($params);
?>
*/

/*
SERÁ NECESSÁRIO CRIAR UMA VIEW PARA CADA TIPO DE IMOVEL E PARA CADA TIPO DUAS VIEWS DE IMAGENS E DIFERENCIAIS
NA APLICAÇÃO O RESULTADO DE CADA VIEW SERÁ ARMAZENADO EM UMA ESTRUTURA DE DADO INDEXADA POR IMAGEM, TIPOIMOVEL E DIFERENCIAIS
SERÁ NECESSÁRIO REALIZAR PESQUISA NA ESTRUTURA DE DADO PARA REALIZAR AS CORRESPONDENCIAS ENTRE O TIPOIMOVEL E SUAS IMAGENS E DIFERENCIAIS;

ANALISAREMOS AINDA O USO DE UMA STORED PROCEDURE QUE POSSA RETORNAR 3 CONJUNTOS DE RESULTADOS SEPARADAMENTE;
*/