<?php

include_once 'modelo/Anuncio.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Imovel.php';
include_once 'modelo/ImovelDiferencial.php';
include_once 'modelo/Casa.php';
include_once 'modelo/Apartamento.php';
include_once 'modelo/ApartamentoPlanta.php';
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
                
            } elseif ($entidadeImovel->getIdTipoImovel() == "3") {
            //Apartamento  
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
                
              } elseif ($entidadeImovel->getIdTipoImovel() == "2") { //Apartamento na Planta

                $idDiferencial = false;
                $apartamentoPlanta = new ApartamentoPlanta();
                $entidadeApartamentoPlanta = $apartamentoPlanta->cadastrar($parametros, $idImovel);
                $idApartamentoPlanta = $genericoDAO->cadastrar($entidadeApartamentoPlanta);
                $quantidadeDiferencial = count($parametros['chkDiferencial']);

                if ($quantidadeDiferencial = 0){} 
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
    
}

