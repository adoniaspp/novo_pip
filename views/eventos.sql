CREATE EVENT `desativarAnuncio` ON SCHEDULE EVERY 1 DAY STARTS '2015-01-09 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `anuncio` a join `usuarioplano` up on a.idusuarioplano = up.id join `plano` p on up.idplano = p.id SET a.status = 'expirado', a.datahoradesativacao = CURDATE() WHERE DATEDIFF( CURDATE(), a.datahoracadastro ) > p.validadepublicacao and a.status = 'cadastrado'

CREATE EVENT `desativarPlano` ON SCHEDULE EVERY 1 DAY STARTS '2016-12-28 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `usuarioplano` up join `plano` p on up.idplano = p.id  SET up.status = 'expirado' WHERE DATEDIFF( CURDATE(), up.datacompra ) > p.validadeativacao and (up.status = 'pago' or up.status = 'pagamento pendente') 
