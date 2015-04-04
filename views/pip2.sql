-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 04-Abr-2015 às 02:23
-- Versão do servidor: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pip2`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `buscaanuncioapartamento`
--
CREATE TABLE IF NOT EXISTS `buscaanuncioapartamento` (
`id` int(11)
,`finalidade` varchar(100)
,`tituloanuncio` varchar(2000)
,`descricaoanuncio` varchar(2000)
,`status` varchar(100)
,`valorvisivel` varchar(100)
,`publicarmapa` varchar(10)
,`publicarcontato` varchar(10)
,`valormin` double
,`condicao` varchar(100)
,`usuario` int(11)
,`descricao` varchar(200)
,`quarto` int(11)
,`suite` int(11)
,`banheiro` int(11)
,`garagem` int(11)
,`area` double
,`sacada` varchar(10)
,`unidadesandar` int(11)
,`andar` int(11)
,`condominio` double
,`cobertura` varchar(10)
,`cep` varchar(100)
,`logradouro` varchar(100)
,`numero` varchar(100)
,`idbairro` int(11)
,`bairro` varchar(100)
,`idcidade` int(11)
,`cidade` varchar(100)
,`idestado` int(11)
,`estado` varchar(100)
,`complemento` varchar(100)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `buscaanuncioapartamentoplanta`
--
CREATE TABLE IF NOT EXISTS `buscaanuncioapartamentoplanta` (
`id` int(11)
,`finalidade` varchar(100)
,`tituloanuncio` varchar(2000)
,`descricaoanuncio` varchar(2000)
,`status` varchar(100)
,`valorvisivel` varchar(100)
,`publicarmapa` varchar(10)
,`publicarcontato` varchar(10)
,`valormin` double
,`condicao` varchar(100)
,`usuario` int(11)
,`descricao` varchar(200)
,`idapartamento` int(11)
,`andares` int(11)
,`unidadesandar` int(11)
,`totalunidades` int(11)
,`numerotorres` int(11)
,`cep` varchar(100)
,`logradouro` varchar(100)
,`numero` varchar(100)
,`idbairro` int(11)
,`bairro` varchar(100)
,`idcidade` int(11)
,`cidade` varchar(100)
,`idestado` int(11)
,`estado` varchar(100)
,`complemento` varchar(100)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `buscaanunciocasa`
--
CREATE TABLE IF NOT EXISTS `buscaanunciocasa` (
`id` int(11)
,`finalidade` varchar(100)
,`tituloanuncio` varchar(2000)
,`descricaoanuncio` varchar(2000)
,`status` varchar(100)
,`valorvisivel` varchar(100)
,`publicarmapa` varchar(10)
,`publicarcontato` varchar(10)
,`valormin` double
,`condicao` varchar(100)
,`usuario` int(11)
,`descricao` varchar(200)
,`quarto` int(11)
,`banheiro` int(11)
,`suite` int(11)
,`garagem` int(11)
,`area` double
,`cep` varchar(100)
,`logradouro` varchar(100)
,`numero` varchar(100)
,`idbairro` int(11)
,`bairro` varchar(100)
,`idcidade` int(11)
,`cidade` varchar(100)
,`idestado` int(11)
,`estado` varchar(100)
,`complemento` varchar(100)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `buscaanunciosalacomercial`
--
CREATE TABLE IF NOT EXISTS `buscaanunciosalacomercial` (
`id` int(11)
,`finalidade` varchar(100)
,`tituloanuncio` varchar(2000)
,`descricaoanuncio` varchar(2000)
,`status` varchar(100)
,`valorvisivel` varchar(100)
,`publicarmapa` varchar(10)
,`publicarcontato` varchar(10)
,`valormin` double
,`condicao` varchar(100)
,`usuario` int(11)
,`descricao` varchar(200)
,`area` double
,`banheiro` int(11)
,`garagem` int(11)
,`condominio` double
,`cep` varchar(100)
,`logradouro` varchar(100)
,`numero` varchar(100)
,`idbairro` int(11)
,`bairro` varchar(100)
,`idcidade` int(11)
,`cidade` varchar(100)
,`idestado` int(11)
,`estado` varchar(100)
,`complemento` varchar(100)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `buscaanuncioterreno`
--
CREATE TABLE IF NOT EXISTS `buscaanuncioterreno` (
`id` int(11)
,`finalidade` varchar(100)
,`tituloanuncio` varchar(2000)
,`descricaoanuncio` varchar(2000)
,`status` varchar(100)
,`valorvisivel` varchar(100)
,`publicarmapa` varchar(10)
,`publicarcontato` varchar(10)
,`valormin` double
,`condicao` varchar(100)
,`usuario` int(11)
,`descricao` varchar(200)
,`area` double
,`cep` varchar(100)
,`logradouro` varchar(100)
,`numero` varchar(100)
,`idbairro` int(11)
,`bairro` varchar(100)
,`idcidade` int(11)
,`cidade` varchar(100)
,`idestado` int(11)
,`estado` varchar(100)
,`complemento` varchar(100)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `buscaanunciotodos`
--
CREATE TABLE IF NOT EXISTS `buscaanunciotodos` (
`id` int(11)
,`finalidade` varchar(100)
,`tituloanuncio` varchar(2000)
,`descricaoanuncio` varchar(2000)
,`status` varchar(100)
,`valorvisivel` varchar(100)
,`publicarmapa` varchar(10)
,`publicarcontato` varchar(10)
,`valormin` double
,`condicao` varchar(100)
,`usuario` int(11)
,`descricao` varchar(200)
,`cep` varchar(100)
,`logradouro` varchar(100)
,`numero` varchar(100)
,`idbairro` int(11)
,`bairro` varchar(100)
,`idcidade` int(11)
,`cidade` varchar(100)
,`idestado` int(11)
,`estado` varchar(100)
,`complemento` varchar(100)
);
-- --------------------------------------------------------

--
-- Structure for view `buscaanuncioapartamento`
--
DROP TABLE IF EXISTS `buscaanuncioapartamento`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `buscaanuncioapartamento` AS select `a`.`id` AS `id`,`a`.`finalidade` AS `finalidade`,`a`.`tituloanuncio` AS `tituloanuncio`,`a`.`descricaoanuncio` AS `descricaoanuncio`,`a`.`status` AS `status`,`a`.`valorvisivel` AS `valorvisivel`,`a`.`publicarmapa` AS `publicarmapa`,`a`.`publicarcontato` AS `publicarcontato`,`a`.`valormin` AS `valormin`,`i`.`condicao` AS `condicao`,`i`.`idusuario` AS `usuario`,`ti`.`descricao` AS `descricao`,`ap`.`quarto` AS `quarto`,`ap`.`suite` AS `suite`,`ap`.`banheiro` AS `banheiro`,`ap`.`garagem` AS `garagem`,`ap`.`area` AS `area`,`ap`.`sacada` AS `sacada`,`ap`.`unidadesandar` AS `unidadesandar`,`ap`.`andar` AS `andar`,`ap`.`condominio` AS `condominio`,`ap`.`cobertura` AS `cobertura`,`en`.`cep` AS `cep`,`en`.`logradouro` AS `logradouro`,`en`.`numero` AS `numero`,`b`.`id` AS `idbairro`,`b`.`nome` AS `bairro`,`ci`.`id` AS `idcidade`,`ci`.`nome` AS `cidade`,`es`.`id` AS `idestado`,`es`.`nome` AS `estado`,`en`.`complemento` AS `complemento` from (`bairro` `b` left join (`cidade` `ci` left join (`estado` `es` left join (`endereco` `en` left join (`apartamento` `ap` left join (`tipoimovel` `ti` left join (`imovel` `i` left join `anuncio` `a` on((`a`.`idimovel` = `i`.`id`))) on((`i`.`idtipoimovel` = `ti`.`id`))) on((`ap`.`idimovel` = `i`.`id`))) on((`en`.`id` = `i`.`idendereco`))) on((`es`.`id` = `en`.`idestado`))) on((`ci`.`id` = `en`.`idcidade`))) on((`b`.`id` = `en`.`idbairro`))) where (`a`.`status` = 'cadastrado');

-- --------------------------------------------------------

--
-- Structure for view `buscaanuncioapartamentoplanta`
--
DROP TABLE IF EXISTS `buscaanuncioapartamentoplanta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `buscaanuncioapartamentoplanta` AS select `a`.`id` AS `id`,`a`.`finalidade` AS `finalidade`,`a`.`tituloanuncio` AS `tituloanuncio`,`a`.`descricaoanuncio` AS `descricaoanuncio`,`a`.`status` AS `status`,`a`.`valorvisivel` AS `valorvisivel`,`a`.`publicarmapa` AS `publicarmapa`,`a`.`publicarcontato` AS `publicarcontato`,`a`.`valormin` AS `valormin`,`i`.`condicao` AS `condicao`,`i`.`idusuario` AS `usuario`,`ti`.`descricao` AS `descricao`,`app`.`id` AS `idapartamento`,`app`.`andares` AS `andares`,`app`.`unidadesandar` AS `unidadesandar`,`app`.`totalunidades` AS `totalunidades`,`app`.`numerotorres` AS `numerotorres`,`en`.`cep` AS `cep`,`en`.`logradouro` AS `logradouro`,`en`.`numero` AS `numero`,`b`.`id` AS `idbairro`,`b`.`nome` AS `bairro`,`ci`.`id` AS `idcidade`,`ci`.`nome` AS `cidade`,`es`.`id` AS `idestado`,`es`.`nome` AS `estado`,`en`.`complemento` AS `complemento` from (`bairro` `b` left join (`cidade` `ci` left join (`estado` `es` left join (`endereco` `en` left join (`apartamentoplanta` `app` left join (`tipoimovel` `ti` left join (`imovel` `i` left join `anuncio` `a` on((`a`.`idimovel` = `i`.`id`))) on((`i`.`idtipoimovel` = `ti`.`id`))) on((`app`.`idimovel` = `i`.`id`))) on((`en`.`id` = `i`.`idendereco`))) on((`es`.`id` = `en`.`idestado`))) on((`ci`.`id` = `en`.`idcidade`))) on((`b`.`id` = `en`.`idbairro`))) where (`a`.`status` = 'cadastrado');

-- --------------------------------------------------------

--
-- Structure for view `buscaanunciocasa`
--
DROP TABLE IF EXISTS `buscaanunciocasa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `buscaanunciocasa` AS select `a`.`id` AS `id`,`a`.`finalidade` AS `finalidade`,`a`.`tituloanuncio` AS `tituloanuncio`,`a`.`descricaoanuncio` AS `descricaoanuncio`,`a`.`status` AS `status`,`a`.`valorvisivel` AS `valorvisivel`,`a`.`publicarmapa` AS `publicarmapa`,`a`.`publicarcontato` AS `publicarcontato`,`a`.`valormin` AS `valormin`,`i`.`condicao` AS `condicao`,`i`.`idusuario` AS `usuario`,`ti`.`descricao` AS `descricao`,`ca`.`quarto` AS `quarto`,`ca`.`banheiro` AS `banheiro`,`ca`.`suite` AS `suite`,`ca`.`garagem` AS `garagem`,`ca`.`area` AS `area`,`en`.`cep` AS `cep`,`en`.`logradouro` AS `logradouro`,`en`.`numero` AS `numero`,`b`.`id` AS `idbairro`,`b`.`nome` AS `bairro`,`ci`.`id` AS `idcidade`,`ci`.`nome` AS `cidade`,`es`.`id` AS `idestado`,`es`.`nome` AS `estado`,`en`.`complemento` AS `complemento` from (`bairro` `b` left join (`cidade` `ci` left join (`estado` `es` left join (`endereco` `en` left join (`casa` `ca` left join (`tipoimovel` `ti` left join (`imovel` `i` left join `anuncio` `a` on((`a`.`idimovel` = `i`.`id`))) on((`i`.`idtipoimovel` = `ti`.`id`))) on((`ca`.`idimovel` = `i`.`id`))) on((`en`.`id` = `i`.`idendereco`))) on((`es`.`id` = `en`.`idestado`))) on((`ci`.`id` = `en`.`idcidade`))) on((`b`.`id` = `en`.`idbairro`))) where (`a`.`status` = 'cadastrado');

-- --------------------------------------------------------

--
-- Structure for view `buscaanunciosalacomercial`
--
DROP TABLE IF EXISTS `buscaanunciosalacomercial`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `buscaanunciosalacomercial` AS select `a`.`id` AS `id`,`a`.`finalidade` AS `finalidade`,`a`.`tituloanuncio` AS `tituloanuncio`,`a`.`descricaoanuncio` AS `descricaoanuncio`,`a`.`status` AS `status`,`a`.`valorvisivel` AS `valorvisivel`,`a`.`publicarmapa` AS `publicarmapa`,`a`.`publicarcontato` AS `publicarcontato`,`a`.`valormin` AS `valormin`,`i`.`condicao` AS `condicao`,`i`.`idusuario` AS `usuario`,`ti`.`descricao` AS `descricao`,`sl`.`area` AS `area`,`sl`.`banheiro` AS `banheiro`,`sl`.`garagem` AS `garagem`,`sl`.`condominio` AS `condominio`,`en`.`cep` AS `cep`,`en`.`logradouro` AS `logradouro`,`en`.`numero` AS `numero`,`b`.`id` AS `idbairro`,`b`.`nome` AS `bairro`,`ci`.`id` AS `idcidade`,`ci`.`nome` AS `cidade`,`es`.`id` AS `idestado`,`es`.`nome` AS `estado`,`en`.`complemento` AS `complemento` from (`bairro` `b` left join (`cidade` `ci` left join (`estado` `es` left join (`endereco` `en` left join (`salacomercial` `sl` left join (`tipoimovel` `ti` left join (`imovel` `i` left join `anuncio` `a` on((`a`.`idimovel` = `i`.`id`))) on((`i`.`idtipoimovel` = `ti`.`id`))) on((`sl`.`idimovel` = `i`.`id`))) on((`en`.`id` = `i`.`idendereco`))) on((`es`.`id` = `en`.`idestado`))) on((`ci`.`id` = `en`.`idcidade`))) on((`b`.`id` = `en`.`idbairro`))) where (`a`.`status` = 'cadastrado');

-- --------------------------------------------------------

--
-- Structure for view `buscaanuncioterreno`
--
DROP TABLE IF EXISTS `buscaanuncioterreno`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `buscaanuncioterreno` AS select `a`.`id` AS `id`,`a`.`finalidade` AS `finalidade`,`a`.`tituloanuncio` AS `tituloanuncio`,`a`.`descricaoanuncio` AS `descricaoanuncio`,`a`.`status` AS `status`,`a`.`valorvisivel` AS `valorvisivel`,`a`.`publicarmapa` AS `publicarmapa`,`a`.`publicarcontato` AS `publicarcontato`,`a`.`valormin` AS `valormin`,`i`.`condicao` AS `condicao`,`i`.`idusuario` AS `usuario`,`ti`.`descricao` AS `descricao`,`t`.`area` AS `area`,`en`.`cep` AS `cep`,`en`.`logradouro` AS `logradouro`,`en`.`numero` AS `numero`,`b`.`id` AS `idbairro`,`b`.`nome` AS `bairro`,`ci`.`id` AS `idcidade`,`ci`.`nome` AS `cidade`,`es`.`id` AS `idestado`,`es`.`nome` AS `estado`,`en`.`complemento` AS `complemento` from (`bairro` `b` left join (`cidade` `ci` left join (`estado` `es` left join (`endereco` `en` left join (`terreno` `t` left join (`tipoimovel` `ti` left join (`imovel` `i` left join `anuncio` `a` on((`a`.`idimovel` = `i`.`id`))) on((`i`.`idtipoimovel` = `ti`.`id`))) on((`t`.`idimovel` = `i`.`id`))) on((`en`.`id` = `i`.`idendereco`))) on((`es`.`id` = `en`.`idestado`))) on((`ci`.`id` = `en`.`idcidade`))) on((`b`.`id` = `en`.`idbairro`))) where (`a`.`status` = 'cadastrado');

-- --------------------------------------------------------

--
-- Structure for view `buscaanunciotodos`
--
DROP TABLE IF EXISTS `buscaanunciotodos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `buscaanunciotodos` AS select `a`.`id` AS `id`,`a`.`finalidade` AS `finalidade`,`a`.`tituloanuncio` AS `tituloanuncio`,`a`.`descricaoanuncio` AS `descricaoanuncio`,`a`.`status` AS `status`,`a`.`valorvisivel` AS `valorvisivel`,`a`.`publicarmapa` AS `publicarmapa`,`a`.`publicarcontato` AS `publicarcontato`,`a`.`valormin` AS `valormin`,`i`.`condicao` AS `condicao`,`i`.`idusuario` AS `usuario`,`ti`.`descricao` AS `descricao`,`en`.`cep` AS `cep`,`en`.`logradouro` AS `logradouro`,`en`.`numero` AS `numero`,`b`.`id` AS `idbairro`,`b`.`nome` AS `bairro`,`ci`.`id` AS `idcidade`,`ci`.`nome` AS `cidade`,`es`.`id` AS `idestado`,`es`.`nome` AS `estado`,`en`.`complemento` AS `complemento` from (`bairro` `b` left join (`cidade` `ci` left join (`estado` `es` left join (`endereco` `en` left join (`tipoimovel` `ti` left join (`imovel` `i` left join `anuncio` `a` on((`a`.`idimovel` = `i`.`id`))) on((`i`.`idtipoimovel` = `ti`.`id`))) on((`en`.`id` = `i`.`idendereco`))) on((`es`.`id` = `en`.`idestado`))) on((`ci`.`id` = `en`.`idcidade`))) on((`b`.`id` = `en`.`idbairro`))) where (`a`.`status` = 'cadastrado');

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `desativarAnuncio` ON SCHEDULE EVERY 1 MINUTE STARTS '2015-01-09 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE ANUNCIO SET status = 'desativado', datahoradesativacao = date_format(sysdate(), '%d/%m/%Y %H:%i:%s')

WHERE DATEDIFF(
     
DATE_FORMAT(CURDATE(), '%Y-%m-%d'), concat(SUBSTRING_INDEX(SUBSTRING_INDEX(`datahoracadastro`, ' ', 1),'/',-1), '-', SUBSTRING_INDEX(SUBSTRING_INDEX(`datahoracadastro`, '/', 2),'/',-1), '-', SUBSTRING_INDEX(`datahoracadastro`, '/', 1))   
    
    ) > 30$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
