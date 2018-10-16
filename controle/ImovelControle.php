<?php

include_once 'modelo/Anuncio.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Imovel.php';
include_once 'modelo/ImovelDiferencial.php';
include_once 'modelo/ImovelDiferencialPlanta.php';
include_once 'modelo/Diferencial.php';
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
include_once 'modelo/Mensagem.php';
include_once 'modelo/AnuncioClique.php';
include_once 'modelo/EmailAnuncio.php';
include_once 'modelo/TipoImovel.php';

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

    function cadastrar($parametros) {
        $visao = new Template();
//        echo '<pre>';
//        print_r($parametros);
//        die();
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
            $selecionarBairro = $genericoDAO->consultar($bairro, false, array("id" => $parametros['itensBairro'][0]));
            if (!count($selecionarBairro) > 0) {
                $entidadeBairro = $bairro->cadastrar($selecionarBairro, $idCidade);
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
                if ($idCasa) {
                    $idDiferencial = true;
                }
            } elseif ($entidadeImovel->getIdTipoImovel() == "2") { //Apartamento na Planta
                $idDiferencial = false;
                $apartamentoPlanta = new ApartamentoPlanta();
                $entidadeApartamentoPlanta = $apartamentoPlanta->cadastrar($parametros, $idImovel);
                $idApartamentoPlanta = $genericoDAO->cadastrar($entidadeApartamentoPlanta);

                $idCadastroImovel = $idApartamentoPlanta;
                if ($idApartamentoPlanta) {
                    $idDiferencial = true;
                }

                $quantidadePlanta = $parametros['sltNumeroPlantas'];
                $resultadoPlanta = true;
                
                

                //cadastro das planta
                
                //for ($indicePlanta = ($quantidadePlanta - 1); $indicePlanta >= 0; $indicePlanta--) {
                for ($indicePlanta = 0; $indicePlanta <= ($quantidadePlanta - 1); $indicePlanta++) {

                    $planta = new Planta();
                    $entidadePlanta = $planta->cadastrar($parametros, $idApartamentoPlanta, $idImovel, $indicePlanta);
                    $idPlanta = $genericoDAO->cadastrar($entidadePlanta);

                        $nomeIndice = 'chkDiferencialPlanta'.($indicePlanta + 1);

                        $quantidadeDiferencialPlanta = count($parametros[$nomeIndice]);
                        
                        $resultadoDiferencialPlanta = true;

                        if ($quantidadeDiferencialPlanta > 0) {

                            for ($indiceDiferencialPlanta = 0; $indiceDiferencialPlanta < $quantidadeDiferencialPlanta; $indiceDiferencialPlanta++) {
                                $ImovelDiferencialPlanta = new ImovelDiferencialPlanta();
                                $entidadeDiferencialPlanta = $ImovelDiferencialPlanta->cadastrar($idPlanta, $parametros[$nomeIndice][$indiceDiferencialPlanta]);
                                $idDiferencialPlanta = $genericoDAO->cadastrar($entidadeDiferencialPlanta);
                                if (!($idDiferencialPlanta)) {
                                    $resultadoDiferencialPlanta = false;
                                    break;
                                }
                            }
                        }
                    
                    if (!($idPlanta)) {
   
                        $resultadoPlanta = false;
                        break;
                    }
                } //fim do cadastro das plantas

                $idCadastroImovel = $idPlanta;
                if ($idPlanta) {
                    $idDiferencial = true;
                } else {

                    $idCadastroImovel = true; //true setado, pois não existem plantas, apenas 1
                    $idDiferencial = true;
                }
            } elseif ($entidadeImovel->getIdTipoImovel() == "3") {//Apartamento  
                $idDiferencial = false;
                $apartamento = new Apartamento();
                $entidadeApartamento = $apartamento->cadastrar($parametros, $idImovel);
                $idApartamento = $genericoDAO->cadastrar($entidadeApartamento);

                $idCadastroImovel = $idApartamento;
                if ($idApartamento) {
                    $idDiferencial = true;
                }
            } elseif ($entidadeImovel->getIdTipoImovel() == "4") {//Sala Comercial  
                $idDiferencial = false;
                $salaComercial = new SalaComercial();
                $entidadeSalaComercial = $salaComercial->cadastrar($parametros, $idImovel);
                $idSalaComercial = $genericoDAO->cadastrar($entidadeSalaComercial);

                $idCadastroImovel = $idSalaComercial;
                if ($idSalaComercial) {
                    $idDiferencial = true;
                }
            } elseif ($entidadeImovel->getIdTipoImovel() == "5") {//Prédio Comercial  
                $idDiferencial = false;
                $predioComercial = new PredioComercial();

                $entidadePredioComercial = $predioComercial->cadastrar($parametros, $idImovel);
                $idPredioComercial = $genericoDAO->cadastrar($entidadePredioComercial);

                $idCadastroImovel = $idPredioComercial;
                if ($idPredioComercial) {
                    $idDiferencial = true;
                }
            } elseif ($entidadeImovel->getIdTipoImovel() == "6") {//Terreno
                $idDiferencial = false;
                $terreno = new Terreno();

                $entidadeTerreno = $terreno->cadastrar($parametros, $idImovel);
                $idTerreno = $genericoDAO->cadastrar($entidadeTerreno);

                $idCadastroImovel = $idTerreno;
                if ($idTerreno) {
                    $idDiferencial = true;
                }
            }
            //cadastro dos diferenciais do empreendimento (geral)
            
            $quantidadeDiferencial = count($parametros['chkDiferencial']);
            $resultadoDiferencial = true;

            if ($quantidadeDiferencial > 0) {

                for ($indiceDiferencial = 0; $indiceDiferencial < $quantidadeDiferencial; $indiceDiferencial++) {
                    $ImovelDiferencial = new ImovelDiferencial();
                    $entidadeDiferencial = $ImovelDiferencial->cadastrar($parametros, $idImovel, $indiceDiferencial);
                    $idDiferencial = $genericoDAO->cadastrar($entidadeDiferencial);
                    if (!($idDiferencial)) {
                        $resultadoDiferencial = false;
                        break;
                    }
                }
            }
            //fim dos diferenciais

            if ($idEndereco && $idImovel && $idCadastroImovel && $idDiferencial) {
                
                //setar os dados do imóvel
                $imovelCadastradoDados = $genericoDAO->consultar($imovel, true, array("id" => $idImovel));
                //setar o endereco do imóvel
                $imovelDifs = $imovelCadastradoDados[0]->getImovelDiferencial();
                //vetor do diferencial
                $retornoDiferencial = array();
                
                foreach ($imovelDifs as $imovelDif){

                    $difs = $genericoDAO->consultar(new Diferencial(), true, array("id" => $imovelDif->getIdDiferencial()));
                    //inserir os diferenciais no vetor
                    $retornoDiferencial[] = $difs[0]->getDescricao();
                    
                }

                $genericoDAO->commit();
                
                $enderecoCadastradoDados = $genericoDAO->consultar($endereco, true, array("id" => $imovelCadastradoDados[0]->getIdEndereco()));
                //setar bairro e cidade                
                $cidadeCadastradoDados = $genericoDAO->consultar(new Cidade(), true, array("id" => $imovelCadastradoDados[0]->getEndereco()->getIdCidade()));
                $nomeCidadeCadastrada = $cidadeCadastradoDados[0]->getNome();
                
                $bairroCadastradoDados = $genericoDAO->consultar(new Bairro(), true, array("id" => $imovelCadastradoDados[0]->getEndereco()->getIdBairro()));
                $nomeBairroCadastrado = $bairroCadastradoDados[0]->getNome();
                
                
                
                $genericoDAO->fecharConexao();
                $visao->setItem(array("tipo"=>"sucessocadastroimovel", "dados" => $imovelCadastradoDados, "endereco" => $enderecoCadastradoDados, "cidade" => $nomeCidadeCadastrada, "bairro" => $nomeBairroCadastrado, "diferencial" => $retornoDiferencial));
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
            $consultarAD = new ConsultasAdHoc();
         
            $listaImoveis = $genericoDAO->consultar($imovel, true, array("idusuario" => $_SESSION['idusuario'], "status" => "cadastrado"));
            
            $imovelDiferencialPlanta = new ImovelDiferencialPlanta();
            
           // $listaDiferencialPlanta = $genericoDAO->consultar($imovelDiferencialPlanta, true, array("idusuario" => $_SESSION['idusuario'], "status" => "cadastrado"));
            
            $plantasDif = array();
            
            #verificar a melhor forma de tratar o blindado recursivo
            foreach ($listaImoveis as $selecionarImovel) {
                $selecionarEndereco = $genericoDAO->consultar(new Endereco(), true, array("id" => $selecionarImovel->getIdEndereco()));
                
                $selecionarImovel->setEndereco($selecionarEndereco[0]);

                $selecionarPlanta = $genericoDAO->consultar(new Planta(), true, array("idimovel" => $selecionarImovel->getId()));
                
                //for($x = 0; $x < count($selecionarPlanta); $x++){
                    
                    
                    //$selecionarImovel->setImovelDiferencialPlanta($genericoDAO->consultar($imovelDiferencialPlanta, true, array("idplanta" => $selecionarPlanta[$x]->getId())));
                    //$plantasDif[] = $genericoDAO->consultar($imovelDiferencialPlanta, true, array("idplanta" => $selecionarPlanta[$x]->getId()));

                    
                //}
                
                //$listarImovel['diferencialPlanta'] = $plantasDif;
           
                $selecionarImovel->setPlanta($selecionarPlanta);

                $selecionarDiferencial = $genericoDAO->consultar(new ImovelDiferencial(), true, array("idimovel" => $selecionarImovel->getId()));
                $selecionarImovel->setImovelDiferencial($selecionarDiferencial);

                $listarImovel[] = $selecionarImovel;

                
            }
            
               /* echo "<pre>";
                var_dump($listarImovel);
                echo "</pre>";
                
                die();*/

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
            $listaImoveis = $genericoDAO->consultar($imovel, true, array("idusuario" => $_SESSION['idusuario'], "status" => "cadastrado"));

            #verificar a melhor forma de tratar o blindado recursivo
            foreach ($listaImoveis as $selecionarImovel) {
                $selecionarEndereco = $genericoDAO->consultar(new Endereco(), true, array("id" => $selecionarImovel->getIdEndereco()));
                $selecionarImovel->setEndereco($selecionarEndereco[0]);

                $selecionarPlanta = $genericoDAO->consultar(new Planta(), true, array("idimovel" => $selecionarImovel->getId()));
                $selecionarImovel->setPlanta($selecionarPlanta);

                $selecionarDiferencial = $genericoDAO->consultar(new ImovelDiferencial(), true, array("idimovel" => $selecionarImovel->getId()));
                $selecionarImovel->setImovelDiferencial($selecionarDiferencial);
                
                $selecionarAnuncioAprovacao = $genericoDAO->consultar(new AnuncioAprovacao(), true, array("idimovel" => $selecionarImovel->getId()));
                
                if($selecionarAnuncioAprovacao){
                    $selecionarImovel->setAnuncioAprovacao($selecionarAnuncioAprovacao);
                }

                $listarImovel[] = $selecionarImovel;
            }  

            $visao = new Template();
            $visao->setItem($listarImovel);
            $visao->exibir('ImovelVisaoListagemEditar.php');
        }
    }

    function editar($parametros) {
        $visao = new Template();
        
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
            $selecionarBairro = $genericoDAO->consultar($bairro, false, array("id" => $parametros['itensBairro'][0]));
            if (!count($selecionarBairro) > 0) {
                $entidadeBairro = $bairro->cadastrar($selecionarBairro, $idCidade);
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
            
            $resultadoPlanta = true;
            
            //Casa

            if ($entidadeImovel->getIdTipoImovel() == "1") {
                
                $casa = new Casa();
                $id = $genericoDAO->consultar($casa, false, array("idimovel" => $entidadeImovel->getId()));
                
                foreach ($id as $idC) { //buscar o ID
                    $casaId = $idC->getId();
                }

                $entidadeCasa = $casa->editar($parametros, $casaId);
                
                $idCasa = $genericoDAO->editar($entidadeCasa);
                $idEdicaoImovel = $idCasa;
                
            } elseif ($entidadeImovel->getIdTipoImovel() == "2") { //Apartamento na Planta
                
                $idDiferencial = false;
                
                $apartamentoPlanta = new ApartamentoPlanta();

                $id = $genericoDAO->consultar($apartamentoPlanta, false, array("idimovel" => $entidadeImovel->getId()));

                foreach ($id as $idAPL) { //buscar o ID do Imóvel
                    $APLId = $idAPL->getId();
                }
                
                $entidadeApartamentoPlanta = $apartamentoPlanta->editar($parametros, $APLId);
                $idApartamentoPlanta = $genericoDAO->editar($entidadeApartamentoPlanta);

                $quantidadePlanta = $parametros['sltNumeroPlantas'];         
                
                $vetorDifPlantas = array();
                
                //para cada planta, verificar o diferencial
                for ($indicePlanta = 0; $indicePlanta < $quantidadePlanta; $indicePlanta++) {
                    
                    $plantaCad = 'chkDiferencialPlanta'.($indicePlanta+1);
                    
                    //inserir no vetor os diferenciais marcados
                    $vetorDifPlantas = $parametros[$plantaCad];
                    
                    $resultadoDiferencialPlanta = true;
                    
                    //buscar os diferenciais cadastrados no BD para a planta 
                    $difs = $genericoDAO->consultar(new ImovelDiferencialPlanta(), false, array("idplanta" => $parametros['idPlanta'][$indicePlanta]));                   
                    
                    foreach ($difs as $dif) {
                        $IDs[] = $dif->getId(); //lista dos IDs
                        $listaIDs[] = $dif->getIdDiferencial(); //lista dos IDs do Diferencial
                    }

                    $quantidadeDiferencial = count($parametros[$plantaCad]);
                    
                    //inicio do cadastro do diferencial da planta
                    $ImovelDiferencialPlanta = new ImovelDiferencialPlanta();
                    
                    $idDiferencialPlanta = true;

                    if ($quantidadeDiferencial > 0) {
                        
                        for ($indiceDiferencial = 0; $indiceDiferencial < $quantidadeDiferencial; $indiceDiferencial++) {
                            //se o diferencial marcado não estiver na lista, cadastrar
                            if (!in_array($parametros[$plantaCad][$indiceDiferencial], $listaIDs)) {
                             
                                $entidadeDiferencial = $ImovelDiferencialPlanta->cadastrar($parametros['idPlanta'][$indicePlanta], $parametros[$plantaCad][$indiceDiferencial]);
                                
                                $idDiferencialPlanta = $genericoDAO->cadastrar($entidadeDiferencial);
                            }
                        }
                    }
                    
                    for ($indiceDiferencial = 0; $indiceDiferencial < count($difs); $indiceDiferencial++) {
                        //se o diferencial da lista do BD não existir dentro dos marcados, então excluir
                        if (!in_array($listaIDs[$indiceDiferencial], $vetorDifPlantas)) {
                            
                            $idDiferencialExclusao = $genericoDAO->consultar($ImovelDiferencialPlanta, false, array("idplanta" => $parametros['idPlanta'][$indicePlanta], "iddiferencial" => $listaIDs[$indiceDiferencial]));
                            
                            foreach($idDiferencialExclusao as $idDiferencial){
                                $id = $idDiferencial->getId();
                            }
                                                 
                            $entidadeDiferencial = $ImovelDiferencialPlanta->excluir($id);
                            
                            $idDiferencial = $genericoDAO->excluir($ImovelDiferencialPlanta, $entidadeDiferencial->getId());
                        }
                    }
                    
                    unset($vetorDifPlantas); 
                    unset($listaIDs);
                    unset($IDs);

                    if (!$idDiferencialPlanta) {
                        $idDiferencialPlanta = false;
                    } else
                        $idDiferencialPlanta = true;

                    //fim dos diferenciais da planta
                    
                    $planta = new Planta();
                    $id = $genericoDAO->consultar($planta, false, array("idimovel" => $entidadeImovel->getId(), "ordemplantas" => $indicePlanta));
  
                    foreach ($id as $idPL) { //buscar o ID
                        $PLId = $idPL->getId();
                    }

                    $entidadePlanta = $planta->editar($parametros, $entidadeApartamentoPlanta->getId(), $parametros['idPlanta'][$indicePlanta], $indicePlanta);
                    
                    $idPlanta = $genericoDAO->editar($entidadePlanta);
                    
                    if (!($idPlanta)) {
                        $resultadoPlanta = false;
                        break;
                    }
              
                } //fim da edição da planta

                $idEdicaoImovel = $idPlanta;
            } elseif ($entidadeImovel->getIdTipoImovel() == "3") {//Apartamento  
                $apartamento = new Apartamento();
                $id = $genericoDAO->consultar($apartamento, false, array("idimovel" => $entidadeImovel->getId()));

                foreach ($id as $idA) { //buscar o ID
                    $aId = $idA->getId();
                }

                $entidadeApartamento = $apartamento->editar($parametros, $aId);

                $idA = $genericoDAO->editar($entidadeApartamento);
                $idEdicaoImovel = $idA;
                
            } elseif ($entidadeImovel->getIdTipoImovel() == "4") {//Sala Comercial  
                $salaComercial = new SalaComercial();
                $id = $genericoDAO->consultar($salaComercial, false, array("idimovel" => $entidadeImovel->getId()));

                foreach ($id as $idSC) { //buscar o ID
                    $SCId = $idSC->getId();
                }

                $entidadeSalaComercial = $salaComercial->editar($parametros, $SCId);

                $idSalaComercial = $genericoDAO->editar($entidadeSalaComercial);

                $idEdicaoImovel = $idSalaComercial;
                
            } elseif ($entidadeImovel->getIdTipoImovel() == "5") {//Prédio Comercial  
                $predioComercial = new PredioComercial();
                $id = $genericoDAO->consultar($predioComercial, false, array("idimovel" => $entidadeImovel->getId()));

                foreach ($id as $idPC) { //buscar o ID
                    $PCId = $idPC->getId();
                }

                $entidadePredioComercial = $predioComercial->editar($parametros, $PCId);

                $idPredioComercial = $genericoDAO->editar($entidadePredioComercial);

                $idEdicaoImovel = $idPredioComercial;
                
            } elseif ($entidadeImovel->getIdTipoImovel() == "6") {//Terreno
                $terreno = new Terreno();
                $id = $genericoDAO->consultar($terreno, false, array("idimovel" => $entidadeImovel->getId()));

                foreach ($id as $idT) { //buscar o ID
                    $TId = $idT->getId();
                }

                $entidadeTerreno = $terreno->editar($parametros, $TId);

                $idTerreno = $genericoDAO->editar($entidadeTerreno);

                $idEdicaoImovel = $idTerreno;
            }

            //edicao dos diferenciais
            $quantidadeDiferencial = count($parametros['chkDiferencial']);
            $resultadoDiferencial = true;

            $difs = $genericoDAO->consultar(new ImovelDiferencial(), false, array("idimovel" => $entidadeImovel->getId()));

            foreach ($difs as $dif) {
                $IDs[] = $dif->getId();
                $listaIDs[] = $dif->getIdDiferencial();
            }

            //inicio do cadastro do diferencial
            $ImovelDiferencial = new ImovelDiferencial();
            $idDiferencial = true;

            if ($quantidadeDiferencial > 0) {

                for ($indiceDiferencial = 0; $indiceDiferencial < $quantidadeDiferencial; $indiceDiferencial++) {


                    if (!in_array($parametros['chkDiferencial'][$indiceDiferencial], $listaIDs)) {

                        $entidadeDiferencial = $ImovelDiferencial->cadastrar($parametros, $_SESSION["imovel"]["id"], $indiceDiferencial);
                        $idDiferencial = $genericoDAO->cadastrar($entidadeDiferencial);
                    }
                }
            }
            for ($indiceDiferencial = 0; $indiceDiferencial < count($difs); $indiceDiferencial++) {
                if (!in_array($listaIDs[$indiceDiferencial], $parametros['chkDiferencial'])) {
                    $entidadeDiferencial = $ImovelDiferencial->excluir($IDs[$indiceDiferencial]);
                    $idDiferencial = $genericoDAO->excluir($ImovelDiferencial, $entidadeDiferencial->getId());
                }
            }

            if (!$idDiferencial) {
                $idDiferencial = false;
            } else
                $idDiferencial = true;

            //fim dos diferenciais

            if ($idEndereco && $idImovel && $idEdicaoImovel && $idDiferencial && $resultadoPlanta) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                //$visao->setItem("sucessoedicaoimovel");
                //$visao->exibir('VisaoErrosGenerico.php');
                $_SESSION["confirmarOperacao"] = "sucesso";
                header("Location: index.php?entidade=Usuario&acao=MeuPIP");
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                //$visao->setItem("errobanco");
                //$visao->exibir('VisaoErrosGenerico.php');
                $_SESSION["confirmarOperacao"] = "erroGenerico";
                header("Location: index.php?entidade=Usuario&acao=MeuPIP");
            }
        } else {
            //$visao->setItem("errotoken");
            //$visao->exibir('VisaoErrosGenerico.php');
            $_SESSION["confirmarOperacao"] = "erroToken";
            header("Location: index.php?entidade=Usuario&acao=MeuPIP");
        }
    }

    function selecionar($parametro) {
        //modelo
        if (Sessao::verificarSessaoUsuario()) {
            $imovel = new Imovel();
            $parametros["id"] = $parametro["id"];

            $genericoDAO = new GenericoDAO();
            $selecionarImovel = $genericoDAO->consultar($imovel, true, array("id" => $parametro['id']));
            $idsImovel = $genericoDAO->consultar(new ApartamentoPlanta(), false, array("idimovel" => $parametro['id']));
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

    function excluir($parametro) {
        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();

        $imovel = new Imovel();
        $selecionarImovel = $genericoDAO->consultar($imovel, false, array("id" => $parametro['hdnImovel']));
        $imovel = $selecionarImovel[0];
        $imovel->excluir($imovel);
        $idImovel = $genericoDAO->editar($imovel);
        if ($idImovel) {
            $genericoDAO->commit();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 1));
        } else {
            $genericoDAO->rollback();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 0));
        }
    }

}
