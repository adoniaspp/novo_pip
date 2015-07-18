CREATE VIEW buscaAnuncioCasa AS
/*Imóvel - Casa*/
SELECT a.id as idanuncio, a.finalidade, a.tituloanuncio, a.descricaoanuncio, 
a.status, a.valorvisivel, a.publicarmapa, a.publicarcontato, a.valormin, a.datahoracadastro,
i.id as idimovel, i.condicao,
ti.descricao as tipo,
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

CREATE VIEW buscaAnuncioApartamentoPlanta AS
/*Imóvel - ApNovo*/
SELECT a.id as idanuncio, a.finalidade, a.tituloanuncio, a.descricaoanuncio, 
a.status, a.valorvisivel, a.publicarmapa, a.publicarcontato, a.valormin, a.datahoracadastro,
i.id as idimovel, i.condicao,
ti.descricao as tipo,
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

CREATE VIEW buscaAnuncioApartamento AS
/*Imóvel - Ap*/
SELECT a.id as idanuncio, a.finalidade, a.tituloanuncio, a.descricaoanuncio, 
a.status, a.valorvisivel, a.publicarmapa, a.publicarcontato, a.valormin, a.datahoracadastro,
i.id as idimovel, i.condicao,
ti.descricao as tipo,
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

CREATE VIEW buscaAnuncioSalaComercial AS
/*Imóvel - Ap*/
SELECT a.id as idanuncio, a.finalidade, a.tituloanuncio, a.descricaoanuncio, 
a.status, a.valorvisivel, a.publicarmapa, a.publicarcontato, a.valormin, a.datahoracadastro,
i.id as idimovel, i.condicao,
ti.descricao as tipo,
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
SELECT a.id as idanuncio, a.finalidade, a.tituloanuncio, a.descricaoanuncio, a.datahoracadastro,
a.status, a.valorvisivel, a.publicarmapa, a.publicarcontato, a.valormin,
i.id as idimovel, i.condicao,
ti.descricao as tipo,
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
a.status, a.valorvisivel, a.publicarmapa, a.publicarcontato, a.valormin, a.datahoracadastro,
i.id as idimovel, i.condicao,
ti.descricao as tipo,
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












