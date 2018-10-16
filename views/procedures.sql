CREATE PROCEDURE limparbase() 
BEGIN SET FOREIGN_KEY_CHECKS=0; 
truncate table preferencia;
truncate table mapaimovel;
truncate table mapaimovelaprovacao;
truncate table novovaloranuncio;
truncate table valor;
truncate table valoraprovacao;
truncate table planta;
truncate table apartamentoplanta;
truncate table apartamento;
truncate table casa;
truncate table kitnet;
truncate table prediocomercial;
truncate table salacomercial;
truncate table terreno;

truncate table chamadotitulo;
truncate table chamadoresposta;
truncate table chamado;

truncate table imoveldiferencial;
truncate table imoveldiferencialplanta;
truncate table endereco;
truncate table emailanuncio;
truncate table historicoaluguelvenda;
truncate table imagem;
truncate table imagemaprovacao;
truncate table respostamensagem;
truncate table mensagem;
truncate table denuncia;
truncate table anuncioclique;
truncate table anuncio;
truncate table anuncioaprovacao;

truncate table telefone;
truncate table imovel;
truncate table empresa;
truncate table recuperasenha;
truncate table usuarioplano;
truncate table usuario;
END

CREATE PROCEDURE excluirPendentesAprovacaoExpirados()
BEGIN

DELETE FROM va USING  `valoraprovacao` AS va WHERE va.idanuncioaprovacao in (SELECT id FROM `anuncioaprovacao` AS aa WHERE aa.status in ("pendenteanalise", "emanalise") and EXISTS ( select 1 from `anuncio` a WHERE a.idanuncio = aa.idanuncio and a.status in ("expirado")));


DELETE FROM mia USING  `mapaimovelaprovacao` AS mia WHERE mia.idanuncioaprovacao in (SELECT id FROM `anuncioaprovacao` AS aa WHERE aa.status in ("pendenteanalise", "emanalise") and EXISTS ( select 1 from `anuncio` a WHERE a.idanuncio = aa.idanuncio and a.status in ("expirado")));


DELETE FROM ia USING  `imagemaprovacao` AS ia WHERE ia.idanuncioaprovacao in (SELECT id FROM `anuncioaprovacao` AS aa WHERE aa.status in ("pendenteanalise", "emanalise") and EXISTS ( select 1 from `anuncio` a WHERE a.idanuncio = aa.idanuncio and a.status in ("expirado")));


DELETE FROM aa USING  `anuncioaprovacao` AS aa WHERE aa.status in ("pendenteanalise", "emanalise") and EXISTS ( select 1 from `anuncio` a WHERE a.idanuncio = aa.idanuncio and a.status in ("expirado"));

END

CREATE PROCEDURE excluirPendentesAprovacaoFinalizados()
BEGIN

DELETE FROM va USING  `valoraprovacao` AS va WHERE  va.idanuncioaprovacao in (SELECT id FROM `anuncioaprovacao` AS aa WHERE aa.status in ("pendenteanalise", "emanalise") and aa.idanuncio = anuncio and EXISTS ( select 1 from `anuncio` a WHERE a.idanuncio = aa.idanuncio and a.status in ("finalizado")));


DELETE FROM mia USING  `mapaimovelaprovacao` AS mia WHERE mia.idanuncioaprovacao in (SELECT id FROM `anuncioaprovacao` AS aa WHERE aa.status in ("pendenteanalise", "emanalise") and aa.idanuncio = anuncio and EXISTS ( select 1 from `anuncio` a WHERE a.idanuncio = aa.idanuncio and a.status in ("finalizado")));


DELETE FROM ia USING  `imagemaprovacao` AS ia WHERE ia.idanuncioaprovacao in (SELECT id FROM `anuncioaprovacao` AS aa WHERE aa.status in ("pendenteanalise", "emanalise") and aa.idanuncio = anuncio and EXISTS ( select 1 from `anuncio` a WHERE a.idanuncio = aa.idanuncio and a.status in ("finalizado")));


DELETE FROM aa USING  `anuncioaprovacao` AS aa WHERE aa.status in ("pendenteanalise", "emanalise") and aa.idanuncio = anuncio and EXISTS ( select 1 from `anuncio` a WHERE a.idanuncio = aa.idanuncio and a.status in ("finalizado"));

END