<?php

include_once 'modelo/Anuncio.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Imovel.php';
include_once 'modelo/ImovelDiferencial.php';
include_once 'modelo/Casa.php';
include_once 'modelo/Apartamento.php';
include_once 'modelo/ApartamentoPlanta.php';
include_once 'modelo/SalaComercial.php';
include_once 'modelo/PredioComercial.php';
include_once 'modelo/Terreno.php';
include_once 'modelo/Planta.php';
include_once 'modelo/TipoImovelDiferencial.php';
include_once 'modelo/Plano.php';
include_once 'modelo/Imagem.php';
include_once 'modelo/HistoricoAluguelVenda.php';
include_once 'modelo/UsuarioPlano.php';
include_once 'modelo/Usuario.php';
include_once 'modelo/Telefone.php';
include_once 'modelo/Empresa.php';
include_once 'modelo/Estado.php';
include_once 'modelo/Cidade.php';
include_once 'modelo/Bairro.php';
include_once 'DAO/GenericoDAO.php';
include_once 'DAO/ConsultasAdHoc.php';
include_once 'assets/pager/Pager.php';
include_once 'modelo/Mensagem.php';
include_once 'modelo/AnuncioClique.php';
include_once 'modelo/EmailAnuncio.php';


class ImovelControle {
    
    function form() {
        //modelo
        # definir regras de negocio tal como permissao de acesso
        if (Sessao::verificarSessaoUsuario()) {
            //visao
            $visao = new Template();
            $visao->exibir('ImovelVisaoCadastro.php');
        }
    }
    
    function cadastrar($parametros, $idendereco){
        $visao = new Template();
       /* echo "<pre>";
        print_r($parametros);
        die();*/
        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();

            //consultar existencia de estado, se não existir gravar no banco
            $estado = new Estado();
            $selecionarEstado = $genericoDAO->consultar($estado, false, array("uf" => $parametros['txtEstado']));
            if (!count($selecionarEstado) > 0) {
                $entidadeEstado = $estado->cadastrar($parametros);
                $idEstado = $genericoDAO->cadastrar($entidadeEstado);
            } else {
                $idEstado = $selecionarEstado[0]->getId();
            }
            //consultar existencia de cidade, se não existir gravar no banco e utilizar idestado
            $cidade = new Cidade();
            $selecionarCidade = $genericoDAO->consultar($cidade, false, array("nome" => $parametros['txtCidade'], "idestado" => $idEstado));
            if (!count($selecionarCidade) > 0) {
                $entidadeCidade = $cidade->cadastrar($parametros, $idEstado);
                $idCidade = $genericoDAO->cadastrar($entidadeCidade);
            } else {
                $idCidade = $selecionarCidade[0]->getId();
            }
            //consultar existencia de bairro, se não existir gravar no banco e utilizar idcidade
            $bairro = new Bairro();
            $selecionarBairro = $genericoDAO->consultar($bairro, false, array("nome" => $parametros['txtBairro'], "idcidade" => $idCidade));
            if (!count($selecionarBairro) > 0) {
                $entidadeBairro = $bairro->cadastrar($parametros, $idCidade);
                $idBairro = $genericoDAO->cadastrar($entidadeBairro);
            } else {
                $idBairro = $selecionarBairro[0]->getId();
            }
            //gravar endereço e utilizar idestado, idcdidade e idbairro
            $endereco = new Endereco();
            $entidadeEndereco = $endereco->cadastrar($parametros, $idEstado, $idCidade, $idBairro);
            $idEndereco = $genericoDAO->cadastrar($entidadeEndereco);
            //Imovel
            $imovel = new Imovel();
            $entidadeImovel = $imovel->cadastrar($parametros, $idEndereco);
            $idImovel = $genericoDAO->cadastrar($entidadeImovel);
            $idDiferencial = false;
            //Casa
            if ($entidadeImovel->getIdTipoImovel() == "1") {
                
                $casa = new Casa();
                $entidadeCasa = $casa->cadastrar($parametros, $idImovel);
                $idCasa = $genericoDAO->cadastrar($entidadeCasa);
                $idCadastroImovel = $idCasa;
                if($idCasa){$idDiferencial = true;}
                
            } elseif ($entidadeImovel->getIdTipoImovel() == "2") { //Apartamento na Planta

                $idDiferencial = false;
                $apartamentoPlanta = new ApartamentoPlanta();
                $entidadeApartamentoPlanta = $apartamentoPlanta->cadastrar($parametros, $idImovel);
                $idApartamentoPlanta = $genericoDAO->cadastrar($entidadeApartamentoPlanta);
                $quantidadeDiferencial = count($parametros['chkDiferencial']);
                $resultadoDiferencial = true;
                 
                $idCadastroImovel = $idApartamentoPlanta;
                if($idApartamentoPlanta){$idDiferencial = true;}
                
                $quantidadePlanta = $parametros['sltNumeroPlantas']; 
                $resultadoPlanta = true;

                //cadastro das planta

                for ($indicePlanta = 0; $indicePlanta < $quantidadePlanta; $indicePlanta++) {
                        $planta = new Planta();
                        $entidadePlanta = $planta->cadastrar($parametros, $idApartamentoPlanta, $indicePlanta);
                        $idPlanta = $genericoDAO->cadastrar($entidadePlanta);
                        if (!($idPlanta)) {
                            $resultadoPlanta = false;
                            break;
                        }
                } //fim do cadastro das plantas
                $idCadastroImovel = $idPlanta;
                if($idPlanta){$idDiferencial = true;}
                
                
                else{
                    
                $idCadastroImovel = true; //true setado, pois não existem plantas, apenas 1
                $idDiferencial = true;
                
                }    
                    
            } elseif ($entidadeImovel->getIdTipoImovel() == "3") {//Apartamento  
                $idDiferencial = false;
                $apartamento = new Apartamento();
                $entidadeApartamento = $apartamento->cadastrar($parametros, $idImovel);
                $idApartamento = $genericoDAO->cadastrar($entidadeApartamento);
                $quantidadeDiferencial = count($parametros['chkDiferencial']);
                $resultadoDiferencial = true;
                    for ($indiceDiferencial = 0; $indiceDiferencial < $quantidadeDiferencial; $indiceDiferencial++) {
                        $ImovelDiferencial = new ImovelDiferencial();
                        $entidadeDiferencial = $ImovelDiferencial->cadastrar($parametros, $idImovel, $indiceDiferencial);
                        $idDiferencial = $genericoDAO->cadastrar($entidadeDiferencial);
                        if (!($idDiferencial)) {
                            $resultadoDiferencial = false;
                            break;
                        }
                    }
                 
                $idCadastroImovel = $idApartamento;
                if($idApartamento){$idDiferencial = true;}
                
              } elseif ($entidadeImovel->getIdTipoImovel() == "4") {//Sala Comercial  
                $idDiferencial = false;
                $salaComercial = new SalaComercial();
                $entidadeSalaComercial = $salaComercial->cadastrar($parametros, $idImovel);
                $idSalaComercial = $genericoDAO->cadastrar($entidadeSalaComercial);
                $quantidadeDiferencial = count($parametros['chkDiferencial']);
                $resultadoDiferencial = true;
                    for ($indiceDiferencial = 0; $indiceDiferencial < $quantidadeDiferencial; $indiceDiferencial++) {
                        $ImovelDiferencial = new ImovelDiferencial();
                        $entidadeDiferencial = $ImovelDiferencial->cadastrar($parametros, $idImovel, $indiceDiferencial);
                        $idDiferencial = $genericoDAO->cadastrar($entidadeDiferencial);
                        if (!($idDiferencial)) {
                            $resultadoDiferencial = false;
                            break;
                        }
                    }
                 
                $idCadastroImovel = $idSalaComercial;
                if($idSalaComercial){$idDiferencial = true;}
                
              } elseif ($entidadeImovel->getIdTipoImovel() == "5") {//Prédio Comercial  

                $idDiferencial = false;
                $predioComercial = new PredioComercial();

                $entidadePredioComercial = $predioComercial->cadastrar($parametros, $idImovel);
                $idPredioComercial = $genericoDAO->cadastrar($entidadePredioComercial);
                $quantidadeDiferencial = count($parametros['chkDiferencial']);
                $resultadoDiferencial = true;
                    for ($indiceDiferencial = 0; $indiceDiferencial < $quantidadeDiferencial; $indiceDiferencial++) {
                        $ImovelDiferencial = new ImovelDiferencial();
                        $entidadeDiferencial = $ImovelDiferencial->cadastrar($parametros, $idImovel, $indiceDiferencial);
                        $idDiferencial = $genericoDAO->cadastrar($entidadeDiferencial);
                        if (!($idDiferencial)) {
                            $resultadoDiferencial = false;
                            break;
                        }
                    }
                $idCadastroImovel = $idPredioComercial;
                if($idPredioComercial){$idDiferencial = true;}
                
              } elseif ($entidadeImovel->getIdTipoImovel() == "6") {//Terreno

                $idDiferencial = false;
                $terreno = new Terreno();

                $entidadeTerreno = $terreno->cadastrar($parametros, $idImovel);
                $idTerreno = $genericoDAO->cadastrar($entidadeTerreno);
                $quantidadeDiferencial = count($parametros['chkDiferencial']);
                $resultadoDiferencial = true;
                    for ($indiceDiferencial = 0; $indiceDiferencial < $quantidadeDiferencial; $indiceDiferencial++) {
                        $ImovelDiferencial = new ImovelDiferencial();
                        $entidadeDiferencial = $ImovelDiferencial->cadastrar($parametros, $idImovel, $indiceDiferencial);
                        $idDiferencial = $genericoDAO->cadastrar($entidadeDiferencial);
                        if (!($idDiferencial)) {
                            $resultadoDiferencial = false;
                            break;
                        }
                    }

                $idCadastroImovel = $idTerreno;
                if($idTerreno){$idDiferencial = true;}
                
              }

            if ($idEndereco && $idImovel && $idCadastroImovel && $idDiferencial) {                
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                $visao->setItem("sucessocadastroimovel");
                $visao->exibir('VisaoErrosGenerico.php');
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                $visao->setItem("errobanco");
                $visao->exibir('VisaoErrosGenerico.php');
            }
            } else {
                $visao->setItem("errotoken");
                $visao->exibir('VisaoErrosGenerico.php');
            }
        
    }

function listar() {
        if (Sessao::verificarSessaoUsuario()) {
            $imovel = new Imovel();
            $genericoDAO = new GenericoDAO();
            $listaImoveis = $genericoDAO->consultar($imovel, true, array("idusuario" => $_SESSION['idusuario']));

            #verificar a melhor forma de tratar o blindado recursivo
            foreach ($listaImoveis as $selecionarImovel) {
                $selecionarEndereco = $genericoDAO->consultar(new Endereco(), true, array("id" => $selecionarImovel->getIdEndereco()));
                $selecionarImovel->setEndereco($selecionarEndereco[0]);
                
                

                $listarImovel[] = $selecionarImovel;
                
            }
            
            
            //visao
            $visao = new Template();
            $visao->setItem($listarImovel);
            $visao->exibir('ImovelVisaoListagem.php');
        }
    }

    function listarEditar() {
        if (Sessao::verificarSessaoUsuario()) {
            $imovel = new Imovel();
            $genericoDAO = new GenericoDAO();
            $consultarAD = new ConsultasAdHoc();
            $listaImoveis = $genericoDAO->consultar($imovel, true, array("idusuario" => $_SESSION['idusuario']));
            
            #verificar a melhor forma de tratar o blindado recursivo
            foreach ($listaImoveis as $selecionarImovel) {
                $selecionarEndereco = $genericoDAO->consultar(new Endereco(), true, array("id" => $selecionarImovel->getIdEndereco()));   
                
                $selecionarImovel->setEndereco($selecionarEndereco[0]);  
                
                $selecionarPlanta = $genericoDAO->consultar(new ApartamentoPlanta(), true, array("idimovel" => $selecionarImovel->getId()));
                $selecionarImovel->setPlanta($selecionarPlanta[0]); 
                
                $listarImovel[] = $selecionarImovel;   
                
            }

            $visao = new Template();
            $visao->setItem($listarImovel);
            $visao->exibir('ImovelVisaoListagemEditar.php');
        }
    }
    
function editar($parametros){
        $visao = new Template();
       /* echo "<pre>";
        print_r($parametros);
        die();*/
        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();

            //consultar existencia de estado, se não existir gravar no banco
            $estado = new Estado();
            $selecionarEstado = $genericoDAO->consultar($estado, false, array("uf" => $parametros['txtEstado']));
            if (!count($selecionarEstado) > 0) {
                $entidadeEstado = $estado->cadastrar($parametros);
                $idEstado = $genericoDAO->cadastrar($entidadeEstado);
            } else {
                $idEstado = $selecionarEstado[0]->getId();
            }
            //consultar existencia de cidade, se não existir gravar no banco e utilizar idestado
            $cidade = new Cidade();
            $selecionarCidade = $genericoDAO->consultar($cidade, false, array("nome" => $parametros['txtCidade'], "idestado" => $idEstado));
            if (!count($selecionarCidade) > 0) {
                $entidadeCidade = $cidade->cadastrar($parametros, $idEstado);
                $idCidade = $genericoDAO->cadastrar($entidadeCidade);
            } else {
                $idCidade = $selecionarCidade[0]->getId();
            }
            //consultar existencia de bairro, se não existir gravar no banco e utilizar idcidade
            $bairro = new Bairro();
            $selecionarBairro = $genericoDAO->consultar($bairro, false, array("nome" => $parametros['txtBairro'], "idcidade" => $idCidade));
            if (!count($selecionarBairro) > 0) {
                $entidadeBairro = $bairro->cadastrar($parametros, $idCidade);
                $idBairro = $genericoDAO->cadastrar($entidadeBairro);
            } else {
                $idBairro = $selecionarBairro[0]->getId();
            }
            
            //gravar endereço e utilizar idestado, idcdidade e idbairro
            $endereco = new Endereco();
            $imovel = new Imovel();

            $entidadeEndereco = $endereco->editar($parametros, $_SESSION["imovel"]["idendereco"], $idEstado, $idCidade, $idBairro);
            $idEndereco = $genericoDAO->editar($entidadeEndereco);
            //Imovel
            
            $entidadeImovel = $imovel->editar($parametros);
            $idImovel = $genericoDAO->editar($entidadeImovel);
            $idDiferencial = false;
            //Casa

            if ($entidadeImovel->getIdTipoImovel() == "1") {  
                $casa = new Casa();
                $id = $genericoDAO->consultar($casa, false, array("idimovel" => $entidadeImovel->getId()));
                
                foreach($id as $idC){ //buscar o ID
                    
                    $casaId = $idC->getId();
                }
                
                $entidadeCasa = $casa->editar($parametros, $casaId);

                $idCasa = $genericoDAO->editar($entidadeCasa);
                $idEdicaoImovel = $idCasa;
                if($idCasa){$idDiferencial = true;}
                
            } elseif ($entidadeImovel->getIdTipoImovel() == "2") { //Apartamento na Planta

                $idDiferencial = false;
                $apartamentoPlanta = new ApartamentoPlanta();
                $entidadeApartamentoPlanta = $apartamentoPlanta->cadastrar($parametros, $idImovel);
                $idApartamentoPlanta = $genericoDAO->editar($entidadeApartamentoPlanta);
                $quantidadeDiferencial = count($parametros['chkDiferencial']);
                
                $resultadoDiferencial = true;
                    for ($indiceDiferencial = 0; $indiceDiferencial < $quantidadeDiferencial; $indiceDiferencial++) {
                        $ImovelDiferencial = new ImovelDiferencial();
                        $entidadeDiferencial = $ImovelDiferencial->cadastrar($parametros, $idImovel, $indiceDiferencial);
                        $idDiferencial = $genericoDAO->cadastrar($entidadeDiferencial);
                        if (!($idDiferencial)) {
                            $resultadoDiferencial = false;
                            break;
                        }
                }
                
                $quantidadePlanta = $parametros['sltNumeroPlantas']; 
                $resultadoPlanta = true;

                if($quantidadePlanta > 1){ //veririfcar se existe mais de uma planta

                    for ($indicePlanta = 0; $indicePlanta < $quantidadePlanta; $indicePlanta++) {
                        $planta = new Planta();
                        $entidadePlanta = $planta->cadastrar($parametros, $idApartamentoPlanta, $indicePlanta);
                        $idPlanta = $genericoDAO->cadastrar($entidadePlanta);
                        if (!($idPlanta)) {
                            $resultadoPlanta = false;
                            break;
                        }
                    }
                $idCadastroImovel = $idPlanta;
                if($idPlanta){$idDiferencial = true;}
                }
                
                else{
                    
                $idCadastroImovel = true; //true setado, pois não existem plantas, apenas 1
                $idDiferencial = true;
                
                }    
                    
            } elseif ($entidadeImovel->getIdTipoImovel() == "3") {//Apartamento  
                $idDiferencial = false;
                $apartamento = new Apartamento();
                $entidadeApartamento = $apartamento->cadastrar($parametros, $idImovel);
                $idApartamento = $genericoDAO->cadastrar($entidadeApartamento);
                $quantidadeDiferencial = count($parametros['chkDiferencial']);
                $resultadoDiferencial = true;
                    for ($indiceDiferencial = 0; $indiceDiferencial < $quantidadeDiferencial; $indiceDiferencial++) {
                        $ImovelDiferencial = new ImovelDiferencial();
                        $entidadeDiferencial = $ImovelDiferencial->cadastrar($parametros, $idImovel, $indiceDiferencial);
                        $idDiferencial = $genericoDAO->cadastrar($entidadeDiferencial);
                        if (!($idDiferencial)) {
                            $resultadoDiferencial = false;
                            break;
                        }
                    }
                 
                $idCadastroImovel = $idApartamento;
                if($idApartamento){$idDiferencial = true;}
                
              } elseif ($entidadeImovel->getIdTipoImovel() == "4") {//Sala Comercial  
                $salaComercial = new SalaComercial();
                $id = $genericoDAO->consultar($salaComercial, false, array("idimovel" => $entidadeImovel->getId()));

                foreach($id as $idSC){ //buscar o ID
                    
                    $SCId = $idSC->getId();
                }

                $entidadeSalaComercial = $salaComercial->editar($parametros, $SCId);

                $idSalaComercial = $genericoDAO->editar($entidadeSalaComercial);

                $idEdicaoImovel = $idSalaComercial;
                if($idSalaComercial){$idDiferencial = true;}
                
              } elseif ($entidadeImovel->getIdTipoImovel() == "5") {//Prédio Comercial  

                $predioComercial = new PredioComercial();
                $id = $genericoDAO->consultar($predioComercial, false, array("idimovel" => $entidadeImovel->getId()));

                foreach($id as $idPC){ //buscar o ID
                    
                    $PCId = $idPC->getId();
                }

                $entidadePredioComercial = $predioComercial->editar($parametros, $PCId);

                $idPredioComercial = $genericoDAO->editar($entidadePredioComercial);

                $idEdicaoImovel = $idPredioComercial;
                if($idPredioComercial){$idDiferencial = true;}
                
              } elseif ($entidadeImovel->getIdTipoImovel() == "6") {//Terreno

                $terreno = new Terreno();
                $id = $genericoDAO->consultar($terreno, false, array("idimovel" => $entidadeImovel->getId()));

                foreach($id as $idT){ //buscar o ID
                    
                    $TId = $idT->getId();
                }

                $entidadeTerreno = $terreno->editar($parametros, $TId);

                $idTerreno = $genericoDAO->editar($entidadeTerreno);

                $idEdicaoImovel = $idTerreno;
                if($idTerreno){$idDiferencial = true;}
                
              }

            if ($idEndereco && $idImovel && $idEdicaoImovel && $idDiferencial) {                
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                $visao->setItem("sucessoedicaoimovel");
                $visao->exibir('VisaoErrosGenerico.php');
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                $visao->setItem("errobanco");
                $visao->exibir('VisaoErrosGenerico.php');
            }
            } else {
                $visao->setItem("errotoken");
                $visao->exibir('VisaoErrosGenerico.php');
            }
        
    }

    function selecionar($parametro) {
        //modelo
        if (Sessao::verificarSessaoUsuario()) {
            $imovel = new Imovel();
            $parametros["id"] = $parametro["id"];

            $genericoDAO = new GenericoDAO();
            $selecionarImovel = $genericoDAO->consultar($imovel, true, array("id" => $parametro['id']));
            echo "Passou 1";
            $idsImovel = $genericoDAO->consultar(new ApartamentoPlanta(), false, array("idimovel" => $parametro['id'])); 
            echo "<pre>";
            var_dump($idsImovel); 
            echo "</pre>";
            die();
            #verificar a melhor forma de tratar o blindado recursivo
            $selecionarEndereco = $genericoDAO->consultar(new Endereco(), true, array("id" => $selecionarImovel[0]->getIdEndereco()));
            $selecionarImovel[0]->setEndereco($selecionarEndereco[0]);
            $sessao["id"] = $selecionarImovel[0]->getId();
            $sessao["idendereco"] = $selecionarImovel[0]->getIdEndereco();
            $visao = new Template();
            $visao->setItem($selecionarImovel);
            Sessao::configurarSessaoImovel($sessao);
            $visao->exibir('ImovelVisaoEditar.php');
        } else {
            $visao = new Template();
            $visao->exibir('UsuarioVisaoLogin.php');
        }
    }
    
}

