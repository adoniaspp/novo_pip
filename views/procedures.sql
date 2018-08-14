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