CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `buscaanuncioapartamento` AS
    SELECT 
        `a`.`id` AS `idanuncio`,
        `a`.`idanuncio` AS `idanuncioformatado`,
        `a`.`finalidade` AS `finalidade`,
        `a`.`tituloanuncio` AS `tituloanuncio`,
        `a`.`descricaoanuncio` AS `descricaoanuncio`,
        `a`.`status` AS `status`,
        `a`.`publicarmapa` AS `publicarmapa`,
        `a`.`publicarcontato` AS `publicarcontato`,
        `a`.`valormin` AS `valormin`,
        `a`.`datahoracadastro` AS `datahoracadastro`,
        `i`.`id` AS `idimovel`,
        `i`.`condicao` AS `condicao`,
        `ti`.`descricao` AS `tipo`,
        `ap`.`quarto` AS `quarto`,
        `ap`.`suite` AS `suite`,
        `ap`.`banheiro` AS `banheiro`,
        `ap`.`garagem` AS `garagem`,
        `ap`.`area` AS `area`,
        `ap`.`sacada` AS `sacada`,
        `ap`.`unidadesandar` AS `unidadesandar`,
        `ap`.`andar` AS `andar`,
        `ap`.`condominio` AS `condominio`,
        `ap`.`cobertura` AS `cobertura`,
        `en`.`cep` AS `cep`,
        `en`.`logradouro` AS `logradouro`,
        `en`.`numero` AS `numero`,
        `b`.`id` AS `idbairro`,
        `b`.`nome` AS `bairro`,
        `ci`.`id` AS `idcidade`,
        `ci`.`nome` AS `cidade`,
        `es`.`id` AS `idestado`,
        `es`.`nome` AS `estado`,
        `en`.`complemento` AS `complemento`,
        `mi`.`latitude` AS `latitude`,
        `mi`.`longitude` AS `longitude`,
        `us`.`id` AS `id`,
        `us`.`nome` AS `nome`,
        `us`.`tipousuario` AS `tipousuario`,
        `us`.`email` AS `email`,
        `us`.`foto` AS `foto`
    FROM
        (((((`apartamento` `ap`
        LEFT JOIN ((((`imovel` `i`
        LEFT JOIN `anuncio` `a` ON ((`a`.`idimovel` = `i`.`id`)))
        LEFT JOIN `mapaimovel` `mi` ON ((`mi`.`idanuncio` = `a`.`id`)))
        LEFT JOIN `usuario` `us` ON ((`i`.`idusuario` = `us`.`id`)))
        LEFT JOIN `tipoimovel` `ti` ON ((`i`.`idtipoimovel` = `ti`.`id`))) ON ((`ap`.`idimovel` = `i`.`id`)))
        LEFT JOIN `endereco` `en` ON ((`en`.`id` = `i`.`idendereco`)))
        LEFT JOIN `estado` `es` ON ((`es`.`id` = `en`.`idestado`)))
        LEFT JOIN `cidade` `ci` ON ((`ci`.`id` = `en`.`idcidade`)))
        LEFT JOIN `bairro` `b` ON ((`b`.`id` = `en`.`idbairro`)))

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `buscaanuncioapartamentoplanta` AS
    SELECT 
        `a`.`id` AS `idanuncio`,
        `a`.`idanuncio` AS `idanuncioformatado`,
        `a`.`finalidade` AS `finalidade`,
        `a`.`tituloanuncio` AS `tituloanuncio`,
        `a`.`descricaoanuncio` AS `descricaoanuncio`,
        `a`.`status` AS `status`,
        `a`.`publicarmapa` AS `publicarmapa`,
        `a`.`publicarcontato` AS `publicarcontato`,
        `a`.`valormin` AS `valormin`,
        `a`.`datahoracadastro` AS `datahoracadastro`,
        `i`.`id` AS `idimovel`,
        `i`.`condicao` AS `condicao`,
        `ti`.`descricao` AS `tipo`,
        `app`.`id` AS `idapartamento`,
        `app`.`andares` AS `andares`,
        `app`.`unidadesandar` AS `unidadesandar`,
        `app`.`totalunidades` AS `totalunidades`,
        `app`.`numerotorres` AS `numerotorres`,
        `en`.`cep` AS `cep`,
        `en`.`logradouro` AS `logradouro`,
        `en`.`numero` AS `numero`,
        `b`.`id` AS `idbairro`,
        `b`.`nome` AS `bairro`,
        `ci`.`id` AS `idcidade`,
        `ci`.`nome` AS `cidade`,
        `es`.`id` AS `idestado`,
        `es`.`nome` AS `estado`,
        `en`.`complemento` AS `complemento`,
        `mi`.`latitude` AS `latitude`,
        `mi`.`longitude` AS `longitude`,
        `us`.`id` AS `id`,
        `us`.`nome` AS `nome`,
        `us`.`tipousuario` AS `tipousuario`,
        `us`.`email` AS `email`,
        `us`.`foto` AS `foto`
    FROM
        (((((`apartamentoplanta` `app`
        LEFT JOIN ((((`imovel` `i`
        LEFT JOIN `anuncio` `a` ON ((`a`.`idimovel` = `i`.`id`)))
        LEFT JOIN `mapaimovel` `mi` ON ((`mi`.`idanuncio` = `a`.`id`)))
        LEFT JOIN `usuario` `us` ON ((`i`.`idusuario` = `us`.`id`)))
        LEFT JOIN `tipoimovel` `ti` ON ((`i`.`idtipoimovel` = `ti`.`id`))) ON ((`app`.`idimovel` = `i`.`id`)))
        LEFT JOIN `endereco` `en` ON ((`en`.`id` = `i`.`idendereco`)))
        LEFT JOIN `estado` `es` ON ((`es`.`id` = `en`.`idestado`)))
        LEFT JOIN `cidade` `ci` ON ((`ci`.`id` = `en`.`idcidade`)))
        LEFT JOIN `bairro` `b` ON ((`b`.`id` = `en`.`idbairro`)))

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `buscaanunciocasa` AS
    SELECT 
        `a`.`id` AS `idanuncio`,
        `a`.`idanuncio` AS `idanuncioformatado`,
        `a`.`finalidade` AS `finalidade`,
        `a`.`tituloanuncio` AS `tituloanuncio`,
        `a`.`descricaoanuncio` AS `descricaoanuncio`,
        `a`.`status` AS `status`,
        `a`.`publicarmapa` AS `publicarmapa`,
        `a`.`publicarcontato` AS `publicarcontato`,
        `a`.`valormin` AS `valormin`,
        `a`.`datahoracadastro` AS `datahoracadastro`,
        `i`.`id` AS `idimovel`,
        `i`.`condicao` AS `condicao`,
        `ti`.`descricao` AS `tipo`,
        `ca`.`quarto` AS `quarto`,
        `ca`.`banheiro` AS `banheiro`,
        `ca`.`suite` AS `suite`,
        `ca`.`garagem` AS `garagem`,
        `ca`.`area` AS `area`,
        `en`.`cep` AS `cep`,
        `en`.`logradouro` AS `logradouro`,
        `en`.`numero` AS `numero`,
        `b`.`id` AS `idbairro`,
        `b`.`nome` AS `bairro`,
        `ci`.`id` AS `idcidade`,
        `ci`.`nome` AS `cidade`,
        `es`.`id` AS `idestado`,
        `es`.`nome` AS `estado`,
        `en`.`complemento` AS `complemento`,
        `mi`.`latitude` AS `latitude`,
        `mi`.`longitude` AS `longitude`,
        `us`.`id` AS `id`,
        `us`.`nome` AS `nome`,
        `us`.`tipousuario` AS `tipousuario`,
        `us`.`email` AS `email`,
        `us`.`foto` AS `foto`
    FROM
        (((((`casa` `ca`
        LEFT JOIN ((((`imovel` `i`
        LEFT JOIN `anuncio` `a` ON ((`a`.`idimovel` = `i`.`id`)))
        LEFT JOIN `mapaimovel` `mi` ON ((`mi`.`idanuncio` = `a`.`id`)))
        LEFT JOIN `usuario` `us` ON ((`i`.`idusuario` = `us`.`id`)))
        LEFT JOIN `tipoimovel` `ti` ON ((`i`.`idtipoimovel` = `ti`.`id`))) ON ((`ca`.`idimovel` = `i`.`id`)))
        LEFT JOIN `endereco` `en` ON ((`en`.`id` = `i`.`idendereco`)))
        LEFT JOIN `estado` `es` ON ((`es`.`id` = `en`.`idestado`)))
        LEFT JOIN `cidade` `ci` ON ((`ci`.`id` = `en`.`idcidade`)))
        LEFT JOIN `bairro` `b` ON ((`b`.`id` = `en`.`idbairro`)))

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `buscaanuncioprediocomercial` AS
    SELECT 
        `a`.`id` AS `idanuncio`,
        `a`.`idanuncio` AS `idanuncioformatado`,
        `a`.`finalidade` AS `finalidade`,
        `a`.`tituloanuncio` AS `tituloanuncio`,
        `a`.`descricaoanuncio` AS `descricaoanuncio`,
        `a`.`status` AS `status`,
        `a`.`publicarmapa` AS `publicarmapa`,
        `a`.`publicarcontato` AS `publicarcontato`,
        `a`.`valormin` AS `valormin`,
        `a`.`datahoracadastro` AS `datahoracadastro`,
        `i`.`id` AS `idimovel`,
        `i`.`condicao` AS `condicao`,
        `ti`.`descricao` AS `tipo`,
        `pc`.`area` AS `area`,
        `en`.`cep` AS `cep`,
        `en`.`logradouro` AS `logradouro`,
        `en`.`numero` AS `numero`,
        `b`.`id` AS `idbairro`,
        `b`.`nome` AS `bairro`,
        `ci`.`id` AS `idcidade`,
        `ci`.`nome` AS `cidade`,
        `es`.`id` AS `idestado`,
        `es`.`nome` AS `estado`,
        `en`.`complemento` AS `complemento`,
        `mi`.`latitude` AS `latitude`,
        `mi`.`longitude` AS `longitude`,
        `us`.`id` AS `id`,
        `us`.`nome` AS `nome`,
        `us`.`tipousuario` AS `tipousuario`,
        `us`.`email` AS `email`,
        `us`.`foto` AS `foto`
    FROM
        (((((`prediocomercial` `pc`
        LEFT JOIN ((((`imovel` `i`
        LEFT JOIN `anuncio` `a` ON ((`a`.`idimovel` = `i`.`id`)))
        LEFT JOIN `mapaimovel` `mi` ON ((`mi`.`idanuncio` = `a`.`id`)))
        LEFT JOIN `usuario` `us` ON ((`i`.`idusuario` = `us`.`id`)))
        LEFT JOIN `tipoimovel` `ti` ON ((`i`.`idtipoimovel` = `ti`.`id`))) ON ((`pc`.`idimovel` = `i`.`id`)))
        LEFT JOIN `endereco` `en` ON ((`en`.`id` = `i`.`idendereco`)))
        LEFT JOIN `estado` `es` ON ((`es`.`id` = `en`.`idestado`)))
        LEFT JOIN `cidade` `ci` ON ((`ci`.`id` = `en`.`idcidade`)))
        LEFT JOIN `bairro` `b` ON ((`b`.`id` = `en`.`idbairro`)))

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `buscaanunciosalacomercial` AS
    SELECT 
        `a`.`id` AS `idanuncio`,
        `a`.`idanuncio` AS `idanuncioformatado`,
        `a`.`finalidade` AS `finalidade`,
        `a`.`tituloanuncio` AS `tituloanuncio`,
        `a`.`descricaoanuncio` AS `descricaoanuncio`,
        `a`.`status` AS `status`,
        `a`.`publicarmapa` AS `publicarmapa`,
        `a`.`publicarcontato` AS `publicarcontato`,
        `a`.`valormin` AS `valormin`,
        `a`.`datahoracadastro` AS `datahoracadastro`,
        `i`.`id` AS `idimovel`,
        `i`.`condicao` AS `condicao`,
        `ti`.`descricao` AS `tipo`,
        `sl`.`area` AS `area`,
        `sl`.`banheiro` AS `banheiro`,
        `sl`.`garagem` AS `garagem`,
        `sl`.`condominio` AS `condominio`,
        `en`.`cep` AS `cep`,
        `en`.`logradouro` AS `logradouro`,
        `en`.`numero` AS `numero`,
        `b`.`id` AS `idbairro`,
        `b`.`nome` AS `bairro`,
        `ci`.`id` AS `idcidade`,
        `ci`.`nome` AS `cidade`,
        `es`.`id` AS `idestado`,
        `es`.`nome` AS `estado`,
        `en`.`complemento` AS `complemento`,
        `mi`.`latitude` AS `latitude`,
        `mi`.`longitude` AS `longitude`,
        `us`.`id` AS `id`,
        `us`.`nome` AS `nome`,
        `us`.`tipousuario` AS `tipousuario`,
        `us`.`email` AS `email`,
        `us`.`foto` AS `foto`
    FROM
        (((((`salacomercial` `sl`
        LEFT JOIN ((((`imovel` `i`
        LEFT JOIN `anuncio` `a` ON ((`a`.`idimovel` = `i`.`id`)))
        LEFT JOIN `mapaimovel` `mi` ON ((`mi`.`idanuncio` = `a`.`id`)))
        LEFT JOIN `usuario` `us` ON ((`i`.`idusuario` = `us`.`id`)))
        LEFT JOIN `tipoimovel` `ti` ON ((`i`.`idtipoimovel` = `ti`.`id`))) ON ((`sl`.`idimovel` = `i`.`id`)))
        LEFT JOIN `endereco` `en` ON ((`en`.`id` = `i`.`idendereco`)))
        LEFT JOIN `estado` `es` ON ((`es`.`id` = `en`.`idestado`)))
        LEFT JOIN `cidade` `ci` ON ((`ci`.`id` = `en`.`idcidade`)))
        LEFT JOIN `bairro` `b` ON ((`b`.`id` = `en`.`idbairro`)))

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `buscaanuncioterreno` AS
    SELECT 
        `a`.`id` AS `idanuncio`,
        `a`.`idanuncio` AS `idanuncioformatado`,
        `a`.`finalidade` AS `finalidade`,
        `a`.`tituloanuncio` AS `tituloanuncio`,
        `a`.`descricaoanuncio` AS `descricaoanuncio`,
        `a`.`datahoracadastro` AS `datahoracadastro`,
        `a`.`status` AS `status`,
        `a`.`publicarmapa` AS `publicarmapa`,
        `a`.`publicarcontato` AS `publicarcontato`,
        `a`.`valormin` AS `valormin`,
        `i`.`id` AS `idimovel`,
        `i`.`condicao` AS `condicao`,
        `ti`.`descricao` AS `tipo`,
        `t`.`area` AS `area`,
        `en`.`cep` AS `cep`,
        `en`.`logradouro` AS `logradouro`,
        `en`.`numero` AS `numero`,
        `b`.`id` AS `idbairro`,
        `b`.`nome` AS `bairro`,
        `ci`.`id` AS `idcidade`,
        `ci`.`nome` AS `cidade`,
        `es`.`id` AS `idestado`,
        `es`.`nome` AS `estado`,
        `en`.`complemento` AS `complemento`,
        `mi`.`latitude` AS `latitude`,
        `mi`.`longitude` AS `longitude`,
        `us`.`id` AS `id`,
        `us`.`nome` AS `nome`,
        `us`.`tipousuario` AS `tipousuario`,
        `us`.`email` AS `email`,
        `us`.`foto` AS `foto`
    FROM
        (((((`terreno` `t`
        LEFT JOIN ((((`imovel` `i`
        LEFT JOIN `anuncio` `a` ON ((`a`.`idimovel` = `i`.`id`)))
        LEFT JOIN `mapaimovel` `mi` ON ((`mi`.`idanuncio` = `a`.`id`)))
        LEFT JOIN `usuario` `us` ON ((`i`.`idusuario` = `us`.`id`)))
        LEFT JOIN `tipoimovel` `ti` ON ((`i`.`idtipoimovel` = `ti`.`id`))) ON ((`t`.`idimovel` = `i`.`id`)))
        LEFT JOIN `endereco` `en` ON ((`en`.`id` = `i`.`idendereco`)))
        LEFT JOIN `estado` `es` ON ((`es`.`id` = `en`.`idestado`)))
        LEFT JOIN `cidade` `ci` ON ((`ci`.`id` = `en`.`idcidade`)))
        LEFT JOIN `bairro` `b` ON ((`b`.`id` = `en`.`idbairro`)))

CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `buscaanunciotodos` AS
    SELECT 
        `a`.`id` AS `idanuncio`,
        `a`.`idanuncio` AS `idanuncioformatado`,
        `a`.`finalidade` AS `finalidade`,
        `a`.`tituloanuncio` AS `tituloanuncio`,
        `a`.`descricaoanuncio` AS `descricaoanuncio`,
        `a`.`status` AS `status`,
        `a`.`publicarmapa` AS `publicarmapa`,
        `a`.`publicarcontato` AS `publicarcontato`,
        `a`.`valormin` AS `valormin`,
        `a`.`datahoracadastro` AS `datahoracadastro`,
        `i`.`id` AS `idimovel`,
        `i`.`condicao` AS `condicao`,
        `ti`.`descricao` AS `tipo`,
        `en`.`cep` AS `cep`,
        `en`.`logradouro` AS `logradouro`,
        `en`.`numero` AS `numero`,
        `b`.`id` AS `idbairro`,
        `b`.`nome` AS `bairro`,
        `ci`.`id` AS `idcidade`,
        `ci`.`nome` AS `cidade`,
        `es`.`id` AS `idestado`,
        `es`.`nome` AS `estado`,
        `en`.`complemento` AS `complemento`,
        `mi`.`latitude` AS `latitude`,
        `mi`.`longitude` AS `longitude`,
        `us`.`id` AS `id`,
        `us`.`nome` AS `nome`,
        `us`.`tipousuario` AS `tipousuario`,
        `us`.`email` AS `email`,
        `us`.`foto` AS `foto`,
        `nv`.`novovalor` AS `novovalor`,
        ((((`nv`.`novovalor` - `a`.`valormin`) / `a`.`valormin`) * 100) * -(1)) AS `percentual`
    FROM
        (`bairro` `b`
        LEFT JOIN ((((((((`anuncio` `a`
        LEFT JOIN `imovel` `i` ON ((`a`.`idimovel` = `i`.`id`)))
        LEFT JOIN `novovaloranuncio` `nv` ON ((`a`.`id` = `nv`.`idanuncio`)))
        LEFT JOIN `mapaimovel` `mi` ON ((`mi`.`idanuncio` = `a`.`id`)))
        LEFT JOIN `usuario` `us` ON ((`i`.`idusuario` = `us`.`id`)))
        LEFT JOIN `tipoimovel` `ti` ON ((`i`.`idtipoimovel` = `ti`.`id`)))
        LEFT JOIN `endereco` `en` ON ((`en`.`id` = `i`.`idendereco`)))
        LEFT JOIN `estado` `es` ON ((`es`.`id` = `en`.`idestado`)))
        LEFT JOIN `cidade` `ci` ON ((`ci`.`id` = `en`.`idcidade`))) ON ((`b`.`id` = `en`.`idbairro`)))
    WHERE
        ((`a`.`status` = 'cadastrado')
            OR (`nv`.`status` = 'ativo'))