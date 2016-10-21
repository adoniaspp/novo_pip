/* BUSCA ANUNCIO APARTAMENTO */

CREATE 
    ALGORITHM = UNDEFINED 
    SQL SECURITY DEFINER
VIEW `buscaAnuncioApartamento` AS
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
        `ap`.`unidadesandar` AS `unidadesandar`,
        `ap`.`andar` AS `andar`,
        `ap`.`condominio` AS `condominio`,
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
        `nv`.`novovalor`       AS `novovalor`,
               ( ( ( ( `nv`.`novovalor` - `a`.`valormin` ) / `a`.`valormin` ) * 100 ) *
                 -( 1 )
               )                      AS `percentual`

FROM `anuncio` `a`

JOIN  `imovel` `i`
    ON (`a`.`idimovel` = `i`.`id`)
JOIN `apartamento` `ap`
    ON (`ap`.`idimovel` = `i`.`id`)
LEFT JOIN `novovaloranuncio` `nv`
    ON ( `a`.`id` = `nv`.`idanuncio`  AND  `nv`.`status` = 'ativo' ) 
LEFT JOIN `mapaimovel` `mi` 
    ON (`mi`.`idanuncio` = `a`.`id`)
JOIN `usuario` `us` 
    ON (`i`.`idusuario` = `us`.`id`)
JOIN `tipoimovel` `ti` 
    ON (`i`.`idtipoimovel` = `ti`.`id`)
JOIN `endereco` `en` 
    ON (`en`.`id` = `i`.`idendereco`)
JOIN `estado` `es` 
    ON (`es`.`id` = `en`.`idestado`)
JOIN `cidade` `ci` 
    ON (`ci`.`id` = `en`.`idcidade`)
JOIN `bairro` `b` 
    ON (`b`.`id` = `en`.`idbairro`);

/* BUSCA ANUNCIO APARTAMENTO PLANTA */

CREATE 
    ALGORITHM = UNDEFINED 
    SQL SECURITY DEFINER
VIEW `buscaAnuncioApartamentoplanta` AS
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
        `us`.`foto` AS `foto`,
        `nv`.`novovalor` AS `novovalor`,
               ( ( ( ( `nv`.`novovalor` - `a`.`valormin` ) / `a`.`valormin` ) * 100 ) *
                 -( 1 )
               )                      AS `percentual`

FROM `anuncio` `a`

JOIN  `imovel` `i`
    ON (`a`.`idimovel` = `i`.`id`)
JOIN `apartamentoplanta` `app`
    ON (`app`.`idimovel` = `i`.`id`)
LEFT JOIN `novovaloranuncio` `nv`
    ON ( `a`.`id` = `nv`.`idanuncio`  AND  `nv`.`status` = 'ativo' ) 
LEFT JOIN `mapaimovel` `mi` 
    ON (`mi`.`idanuncio` = `a`.`id`)
JOIN `usuario` `us` 
    ON (`i`.`idusuario` = `us`.`id`)
JOIN `tipoimovel` `ti` 
    ON (`i`.`idtipoimovel` = `ti`.`id`)
JOIN `endereco` `en` 
    ON (`en`.`id` = `i`.`idendereco`)
JOIN `estado` `es` 
    ON (`es`.`id` = `en`.`idestado`)
JOIN `cidade` `ci` 
    ON (`ci`.`id` = `en`.`idcidade`)
JOIN `bairro` `b` 
    ON (`b`.`id` = `en`.`idbairro`);

/* BUSCA ANUNCIO CASA */

CREATE 
    ALGORITHM = UNDEFINED 
    SQL SECURITY DEFINER
VIEW `buscaAnuncioCasa` AS
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
        `us`.`foto` AS `foto`,
        `nv`.`novovalor`       AS `novovalor`,
               ( ( ( ( `nv`.`novovalor` - `a`.`valormin` ) / `a`.`valormin` ) * 100 ) *
                 -( 1 )
               )                      AS `percentual`

FROM `anuncio` `a`

JOIN  `imovel` `i`
    ON (`a`.`idimovel` = `i`.`id`)
JOIN `casa` `ca`
    ON (`ca`.`idimovel` = `i`.`id`)
LEFT JOIN `novovaloranuncio` `nv`
    ON ( `a`.`id` = `nv`.`idanuncio`  AND  `nv`.`status` = 'ativo' ) 
LEFT JOIN `mapaimovel` `mi` 
    ON (`mi`.`idanuncio` = `a`.`id`)
JOIN `usuario` `us` 
    ON (`i`.`idusuario` = `us`.`id`)
JOIN `tipoimovel` `ti` 
    ON (`i`.`idtipoimovel` = `ti`.`id`)
JOIN `endereco` `en` 
    ON (`en`.`id` = `i`.`idendereco`)
JOIN `estado` `es` 
    ON (`es`.`id` = `en`.`idestado`)
JOIN `cidade` `ci` 
    ON (`ci`.`id` = `en`.`idcidade`)
JOIN `bairro` `b` 
    ON (`b`.`id` = `en`.`idbairro`);

/* BUSCA ANUNCIO PREDIO COMERCIAL */

CREATE 
    ALGORITHM = UNDEFINED 
    SQL SECURITY DEFINER
VIEW `buscaAnuncioPrediocomercial` AS
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
        `us`.`foto` AS `foto`,
        `nv`.`novovalor`       AS `novovalor`,
               ( ( ( ( `nv`.`novovalor` - `a`.`valormin` ) / `a`.`valormin` ) * 100 ) *
                 -( 1 )
               )                      AS `percentual`
FROM `anuncio` `a`

JOIN  `imovel` `i`
    ON (`a`.`idimovel` = `i`.`id`)
JOIN `prediocomercial` `pc`
    ON (`pc`.`idimovel` = `i`.`id`)
LEFT JOIN `novovaloranuncio` `nv`
    ON ( `a`.`id` = `nv`.`idanuncio`  AND  `nv`.`status` = 'ativo' ) 
LEFT JOIN `mapaimovel` `mi` 
    ON (`mi`.`idanuncio` = `a`.`id`)
JOIN `usuario` `us` 
    ON (`i`.`idusuario` = `us`.`id`)
JOIN `tipoimovel` `ti` 
    ON (`i`.`idtipoimovel` = `ti`.`id`)
JOIN `endereco` `en` 
    ON (`en`.`id` = `i`.`idendereco`)
JOIN `estado` `es` 
    ON (`es`.`id` = `en`.`idestado`)
JOIN `cidade` `ci` 
    ON (`ci`.`id` = `en`.`idcidade`)
JOIN `bairro` `b` 
    ON (`b`.`id` = `en`.`idbairro`);

/* BUSCA ANUNCIO SALA COMERCIAL */

CREATE 
    ALGORITHM = UNDEFINED 
    SQL SECURITY DEFINER
VIEW `buscaAnuncioSalacomercial` AS
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
        `us`.`foto` AS `foto`,
        `nv`.`novovalor`       AS `novovalor`,
               ( ( ( ( `nv`.`novovalor` - `a`.`valormin` ) / `a`.`valormin` ) * 100 ) *
                 -( 1 )
               )                      AS `percentual`
FROM `anuncio` `a`

JOIN  `imovel` `i`
    ON (`a`.`idimovel` = `i`.`id`)
JOIN `salacomercial` `sl`
    ON (`sl`.`idimovel` = `i`.`id`)
LEFT JOIN `novovaloranuncio` `nv`
    ON ( `a`.`id` = `nv`.`idanuncio`  AND  `nv`.`status` = 'ativo' ) 
LEFT JOIN `mapaimovel` `mi` 
    ON (`mi`.`idanuncio` = `a`.`id`)
JOIN `usuario` `us` 
    ON (`i`.`idusuario` = `us`.`id`)
JOIN `tipoimovel` `ti` 
    ON (`i`.`idtipoimovel` = `ti`.`id`)
JOIN `endereco` `en` 
    ON (`en`.`id` = `i`.`idendereco`)
JOIN `estado` `es` 
    ON (`es`.`id` = `en`.`idestado`)
JOIN `cidade` `ci` 
    ON (`ci`.`id` = `en`.`idcidade`)
JOIN `bairro` `b` 
    ON (`b`.`id` = `en`.`idbairro`);

/* BUSCA ANUNCIO TERRENO */

CREATE 
    ALGORITHM = UNDEFINED 
    SQL SECURITY DEFINER
VIEW `buscaAnuncioTerreno` AS
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
       `us`.`foto` AS `foto`,
       `nv`.`novovalor`       AS `novovalor`,
       ( ( ( ( `nv`.`novovalor` - `a`.`valormin` ) / `a`.`valormin` ) * 100 ) *
         -( 1 )
       )                      AS `percentual`
FROM `anuncio` `a`

JOIN  `imovel` `i`
    ON (`a`.`idimovel` = `i`.`id`)
JOIN `terreno` `t`
    ON (`t`.`idimovel` = `i`.`id`)
LEFT JOIN `novovaloranuncio` `nv`
    ON ( `a`.`id` = `nv`.`idanuncio`  AND  `nv`.`status` = 'ativo' ) 
LEFT JOIN `mapaimovel` `mi` 
    ON (`mi`.`idanuncio` = `a`.`id`)
JOIN `usuario` `us` 
    ON (`i`.`idusuario` = `us`.`id`)
JOIN `tipoimovel` `ti` 
    ON (`i`.`idtipoimovel` = `ti`.`id`)
JOIN `endereco` `en` 
    ON (`en`.`id` = `i`.`idendereco`)
JOIN `estado` `es` 
    ON (`es`.`id` = `en`.`idestado`)
JOIN `cidade` `ci` 
    ON (`ci`.`id` = `en`.`idcidade`)
JOIN `bairro` `b` 
    ON (`b`.`id` = `en`.`idbairro`)

WHERE `a`.`status` = 'cadastrado';

/* BUSCA ANUNCIO TODOS */
CREATE 
    ALGORITHM = UNDEFINED 
    SQL SECURITY DEFINER
VIEW `buscaAnuncioTodos` AS
SELECT
       `a`.`id`               AS `idanuncio`,
       `a`.`idanuncio`        AS `idanuncioformatado`,
       `a`.`finalidade`       AS `finalidade`,
       `a`.`tituloanuncio`    AS `tituloanuncio`,
       `a`.`descricaoanuncio` AS `descricaoanuncio`,
       `a`.`status`           AS `status`,
       `a`.`publicarmapa`     AS `publicarmapa`,
       `a`.`publicarcontato`  AS `publicarcontato`,
       `a`.`valormin`         AS `valormin`,
       `a`.`datahoracadastro` AS `datahoracadastro`,
       `i`.`id`               AS `idimovel`,
       `i`.`condicao`         AS `condicao`,
       `ti`.`descricao`       AS `tipo`,
       `en`.`cep`             AS `cep`,
       `en`.`logradouro`      AS `logradouro`,
       `en`.`numero`          AS `numero`,
       `b`.`id`               AS `idbairro`,
       `b`.`nome`             AS `bairro`,
       `ci`.`id`              AS `idcidade`,
       `ci`.`nome`            AS `cidade`,
       `es`.`id`              AS `idestado`,
       `es`.`nome`            AS `estado`,
       `en`.`complemento`     AS `complemento`,
       `mi`.`latitude`        AS `latitude`,
       `mi`.`longitude`       AS `longitude`,
       `us`.`id`              AS `id`,
       `us`.`nome`            AS `nome`,
       `us`.`tipousuario`     AS `tipousuario`,
       `us`.`email`           AS `email`,
       `us`.`foto`            AS `foto`,
       `nv`.`novovalor`       AS `novovalor`,
       ( ( ( ( `nv`.`novovalor` - `a`.`valormin` ) / `a`.`valormin` ) * 100 ) *
         -( 1 )
       )                      AS `percentual`
FROM `anuncio` `a`

JOIN `imovel` `i`
    ON ( `a`.`idimovel` = `i`.`id` )
LEFT JOIN `novovaloranuncio` `nv`
    ON ( `a`.`id` = `nv`.`idanuncio`  AND  `nv`.`status` = 'ativo' ) 
LEFT JOIN `mapaimovel` `mi`
    ON ( `mi`.`idanuncio` = `a`.`id` )
JOIN `usuario` `us`
    ON ( `i`.`idusuario` = `us`.`id` )
JOIN `tipoimovel` `ti`
    ON ( `i`.`idtipoimovel` = `ti`.`id` )
JOIN `endereco` `en`
    ON ( `en`.`id` = `i`.`idendereco` )
JOIN `bairro` `b`
    ON ( `b`.`id` = `en`.`idbairro` )
JOIN `estado` `es`
    ON ( `es`.`id` = `en`.`idestado` )
JOIN `cidade` `ci`
    ON ( `ci`.`id` = `en`.`idcidade` )
    
WHERE `a`.`status` = 'cadastrado';