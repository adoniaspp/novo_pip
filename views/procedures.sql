CREATE DEFINER=`root`@`localhost` PROCEDURE `limparbase`()
BEGIN
 SET FOREIGN_KEY_CHECKS=0;

truncate table preferencia;
truncate table mapaimovel;
truncate table novovaloranuncio;
truncate table valor;
truncate table planta;
truncate table apartamentoplanta;
truncate table apartamento;
truncate table casa;
truncate table kitnet;
truncate table prediocomercial;
truncate table salacomercial;
truncate table terreno;

truncate table imoveldiferencial;
truncate table endereco;
truncate table emailanuncio;
truncate table historicoaluguelvenda;
truncate table imagem;
truncate table respostamensagem;
truncate table mensagem;
truncate table anuncioclique;
truncate table anuncio;

truncate table telefone;
truncate table imovel;
truncate table empresa;
truncate table recuperasenha;
truncate table usuarioplano;
truncate table usuario;
END