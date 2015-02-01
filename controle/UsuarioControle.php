<?php

include_once 'modelo/Usuario.php';
include_once 'modelo/Endereco.php';
include_once 'modelo/Telefone.php';
include_once 'modelo/Empresa.php';
include_once 'modelo/Estado.php';
include_once 'modelo/Cidade.php';
include_once 'modelo/Bairro.php';
include_once 'modelo/RecuperaSenha.php';
include_once 'controle/UsuarioPlanoControle.php';
include_once 'DAO/GenericoDAO.php';
include_once 'configuracao/ConsultaUrl.php';
include_once 'DAO/ConsultasAdHoc.php';
include_once 'modelo/Mensagem.php';
include_once 'modelo/Anuncio.php';
include_once 'assets/pager/Pager.php';
include_once 'modelo/Imovel.php';
include_once 'modelo/Imagem.php';
include_once 'modelo/RespostaMensagem.php';
include_once 'modelo/HistoricoAluguelVenda.php';

class UsuarioControle {

    function form($parametros) {
        $visao = new Template();
        switch ($parametros['tipo']) {
            case "cadastro":
                $visao->exibir('UsuarioVisaoCadastro.php');
                break;
            case "login":
                $visao->exibir('UsuarioVisaoLogin.php');
                break;
            case "esquecisenha":
                $visao->exibir('UsuarioVisaoEsqueciSenha.php');
                break;
            case "alterarsenha":
                $recuperasenha = new RecuperaSenha();
                $genericoDAO = new GenericoDAO();
                $selecionarRecuperaSenha = $genericoDAO->consultar($recuperasenha, false, array("hash" => $parametros["id"]));
                if ($selecionarRecuperaSenha && $selecionarRecuperaSenha[0]->getStatus() == "ativo") {
                    $_SESSION['idRecuperaSenhaUsuario'] = $selecionarRecuperaSenha[0]->getIdusuario();
                    $_SESSION['idRecuperaSenha'] = $selecionarRecuperaSenha[0]->getId();
                    $visao->exibir('UsuarioVisaoAlterarSenha.php');
                } else {
                    $visao->setItem("errolink");
                    $visao->exibir('VisaoErrosGenerico.php');
                }
                break;
            case "trocarsenha":
                $visao->exibir('UsuarioVisaoTrocarSenha.php');
                break;
            case "trocarimagem":
                $genericoDAO = new GenericoDAO();
                $selecionarUsuario = $genericoDAO->consultar(new Usuario(), false, array("id" => $_SESSION["idusuario"]));
                $visao->setItem($selecionarUsuario[0]);
                $visao->exibir('UsuarioVisaoTrocarImagem.php');
                break;
        }
    }

    function cadastrar($parametros) {
        //Endereço
        $visao = new Template();
        /*echo "<pre>";
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


            //Usuário
            $usuario = new Usuario();
            $entidadeUsuario = $usuario->cadastrar($parametros, $idEndereco);
            $idUsuario = $genericoDAO->cadastrar($entidadeUsuario);

            //Empresa
            $idEmpresa = false;
            if ($entidadeUsuario->getTipousuario() == "pj") {
                $empresa = new Empresa();
                $entidadeEmpresa = $empresa->cadastrar($parametros, $idUsuario);
                $idEmpresa = $genericoDAO->cadastrar($entidadeEmpresa);
            } else {
                $idEmpresa = true;
            }
            //Telefone
            $quantidadeTelefone = count($parametros['hdnTipoTelefone']);
            $resultadoTelefone = true;
            for ($indiceTelefone = 0; $indiceTelefone < $quantidadeTelefone; $indiceTelefone++) {
                $telefone = new Telefone();
                $entidadeTelefone = $telefone->cadastrar($parametros, $idUsuario, $indiceTelefone);
                $idTelefone = $genericoDAO->cadastrar($entidadeTelefone);
                if (!($idTelefone)) {
                    $resultadoTelefone = false;
                    break;
                }
            }

            if ($idEndereco && $idUsuario && $idEmpresa && $resultadoTelefone) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                $visao->setItem("sucessocadastrousuario");
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
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, true, array("id" => $_SESSION["idusuario"]));
            #verificar a melhor forma de tratar o blindado recursivo
            $selecionarEndereco = $genericoDAO->consultar(new Endereco(), true, array("id" => $selecionarUsuario[0]->getIdEndereco()));
            $selecionarUsuario[0]->setEndereco($selecionarEndereco[0]);
            //visao
            $visao = new Template();
//            var_dump($selecionarUsuario[0]->getEndereco()->getIdCidade());
//            die();
            $visao->setItem($selecionarUsuario);
            $visao->exibir('UsuarioVisaoEdicao.php');
        } else {
            $visao = new Template();
            $visao->exibir('UsuarioVisaoLogin.php');
        }
    }

    function alterar($parametros) {

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
            //$genericoDAO = new GenericoDAO();
            $selecionarCidade = $genericoDAO->consultar($cidade, false, array("nome" => $parametros['txtCidade'], "idestado" => $idEstado));
            if (!count($selecionarCidade) > 0) {
                $entidadeCidade = $cidade->cadastrar($parametros, $idEstado);
                $idCidade = $genericoDAO->cadastrar($entidadeCidade);
            } else {
                $idCidade = $selecionarCidade[0]->getId();
            }
            //consultar existencia de bairro, se não existir gravar no banco e utilizar idcidade
            $bairro = new Bairro();
            //$genericoDAO = new GenericoDAO();
            $selecionarBairro = $genericoDAO->consultar($bairro, false, array("nome" => $parametros['txtBairro'], "idcidade" => $idCidade));
            if (!count($selecionarBairro) > 0) {
                $entidadeBairro = $bairro->cadastrar($parametros, $idCidade);
                $idBairro = $genericoDAO->cadastrar($entidadeBairro);
            } else {
                $idBairro = $selecionarBairro[0]->getId();
            }

            //gravar endereço e utilizar idestado, idcdidade e idbairro
            $endereco = new Endereco();
            $entidadeEndereco = $endereco->editar($parametros, $_SESSION["idendereco"], $idEstado, $idCidade, $idBairro);
            $editarEndereco = $genericoDAO->editar($entidadeEndereco);

            //telefone excluir
            $telefone = new Telefone();
            $listaTelefone = $genericoDAO->consultar($telefone, false, array("idusuario" => $_SESSION["idusuario"]));
            $quantidadeTelefoneExcluir = count($listaTelefone);
            $resultadoTelefoneFinalExcluir = true;
            for ($indiceTelefone = 0; $indiceTelefone < $quantidadeTelefoneExcluir; $indiceTelefone++) {
                $resultadoExcluirTelefone = $genericoDAO->excluir($telefone, $listaTelefone[$indiceTelefone]->getId());
                if (!($resultadoExcluirTelefone)) {
                    $resultadoTelefoneFinalExcluir = false;
                    break;
                }
            }

            //Telefone cadastrar
            $quantidadeTelefone = count($parametros['hdnTipoTelefone']);
            $resultadoTelefone = true;
            for ($indiceTelefone = 0; $indiceTelefone < $quantidadeTelefone; $indiceTelefone++) {
                $telefone = new Telefone();
                $entidadeTelefone = $telefone->cadastrar($parametros, $_SESSION["idusuario"], $indiceTelefone);
                $idTelefone = $genericoDAO->cadastrar($entidadeTelefone);
                if (!($idTelefone)) {
                    $resultadoTelefone = false;
                    break;
                }
            }


            $usuario = new Usuario();
            $entidadeUsuario = $usuario->editar($parametros);
            $resultado = $genericoDAO->editar($entidadeUsuario);

            //visao
            if ($resultado & $editarEndereco & $resultadoTelefoneFinalExcluir & $resultadoTelefone) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                Sessao::desconfigurarVariavelSessao("usuario");
                $visao->setItem("sucessoedicaousuario");
                $visao->exibir('VisaoErrosGenerico.php');
                //echo json_encode(array("resultado" => 1));
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

    function buscarLogin($parametros) {

        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("login" => $parametros['txtLogin']));

            if (count($selecionarUsuario) > 0)
                echo "false";
            else
                echo "true";
        }else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErrosGenerico.php');
        }
    }

    function buscarEmail($parametros) {

        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("email" => $parametros['txtEmail']));

            if (count($selecionarUsuario) > 0)
                echo "false";
            else
                echo "true";
        }else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErrosGenerico.php');
        }
    }

    function buscarCpf($parametros) {

        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("cpfcnpj" => $parametros['txtCpf']));

            if (count($selecionarUsuario) > 0)
                echo "false";
            else
                echo "true";
        }else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErrosGenerico.php');
        }
    }

    function buscarCnpj($parametros) {

        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("cpfcnpj" => $parametros['txtCnpj']));

            if (count($selecionarUsuario) > 0)
                echo "false";
            else
                echo "true";
        }else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErrosGenerico.php');
        }
    }

    function autenticar($parametros) {
        $usuario = new Usuario();
        $genericoDAO = new GenericoDAO();
        $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("login" => $parametros['txtLogin']));

        if ((count($selecionarUsuario) > 0) && (password_verify($parametros['txtSenha'], $selecionarUsuario[0]->getSenha()))) {
            Sessao::configurarSessaoUsuario($selecionarUsuario);
            $redirecionamento = ConsultaUrl::consulta($_SERVER['HTTP_REFERER']);
            echo json_encode(array("resultado" => 1, "nome" => $_SESSION['nome'], "redirecionamento" => $redirecionamento));
        } else {
            echo json_encode(array("resultado" => 2)); //usuario ou senha invalido
        }
    }

    function logout($parametros) {
        if (Sessao::encerrarSessaoUsuario()) {
            echo json_encode(array("resultado" => 1));
        } else {
            echo json_encode(array("resultado" => 0));
        }
    }

    function esquecersenha($parametros) {
        $visao = new Template();
        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $recuperaSenha = new RecuperaSenha();
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $avisoRecuperaSenha = false;
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("email" => $parametros['txtEmail']));
            if ($selecionarUsuario) {
                $consultasAdHoc = new ConsultasAdHoc();
                $selecionarRegistroRecuperaSenha = $consultasAdHoc->ConsultarRegistroAtivoDeRecuperarSenha($selecionarUsuario[0]->getId());
                if ($selecionarRegistroRecuperaSenha) {
                    $resultadoExcluirRecuperaSenha = $genericoDAO->excluir($recuperaSenha, $selecionarRegistroRecuperaSenha[0]->getId());
                    $avisoRecuperaSenha = true;
                    if (!$resultadoExcluirRecuperaSenha) {
                        $genericoDAO->rollback();
                        $genericoDAO->fecharConexao();
                        echo json_encode(array("resultado" => 3));
                    }
                }
                //gravar registro no banco
                $recuperasenha = new RecuperaSenha();
                $entidadeRecuperaSenha = $recuperasenha->cadastrar($selecionarUsuario[0]->getId());
                $idResuperaSenha = $genericoDAO->cadastrar($entidadeRecuperaSenha);
                if ($idResuperaSenha) {
                    //enviar email
                    $dadosEmail['destino'] = $selecionarUsuario[0]->getEmail(); //$parametros["email"];  
                    $dadosEmail['nome'] = $selecionarUsuario[0]->getNome(); //$parametros["nome"];
                    if ($avisoRecuperaSenha) {
                        $dadosEmail['msg'] = "
                        <br> 
                        &lt;h1&gt;Você já solicitou uma troca de senha. Desconsidere o email já enviado e clique no link abaixo para processar a troca&lt;/h1&gt; 
                        <a href=http://localhost/PIP/index.php?entidade=Usuario&acao=form&tipo=alterarsenha&id=" . $entidadeRecuperaSenha->getHash() . ">http://localhost/PIP/index.php?entidade=Usuario&acao=form&tipo=alterarsenha&id=" . $entidadeRecuperaSenha->getHash() . "</a>";
                    } else {
                        $dadosEmail['msg'] = "PIP OnLINE - Clique abaixo para recuperar sua senha. Este é um email automático. Não responda;
                        <br> 
                        <a href=http://localhost/PIP/index.php?entidade=Usuario&acao=form&tipo=alterarsenha&id=" . $entidadeRecuperaSenha->getHash() . ">http://localhost/PIP/index.php?entidade=Usuario&acao=form&tipo=alterarsenha&id=" . $entidadeRecuperaSenha->getHash() . "</a>";
                    }
                    $dadosEmail['contato'] = $_SESSION["nome"];
                    $dadosEmail['assunto'] = "Recuperação de Senha - PIP";
                    if (Email::enviarEmail($dadosEmail)) {
                        $genericoDAO->commit();
                        $genericoDAO->fecharConexao();
                        $visao->setItem("sucessoenvioemail");
                        $visao->exibir('VisaoErrosGenerico.php');
                    } else {
                        $genericoDAO->rollback();
                        $genericoDAO->fecharConexao();
                        $visao->setItem("erroemail");
                        $visao->exibir('VisaoErrosGenerico.php');
                    }
                } else {
                    $genericoDAO->rollback();
                    $genericoDAO->fecharConexao();
                    $visao->setItem("errobanco");
                    $visao->exibir('VisaoErrosGenerico.php');
                }
            } else {
                $visao->setItem("errobanco");
                $visao->exibir('VisaoErrosGenerico.php');
            }
        } else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErrosGenerico.php');
        }
    }

    function alterarsenha($parametros) {
        $visao = new Template();
        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $usuario = new Usuario();
            $entidadeUsuario = $usuario->alterarSenha($parametros);
            $resultadoUsuario = $genericoDAO->editar($entidadeUsuario);
            $recuperasenha = new RecuperaSenha();
            $entidadeRecuperaSenha = $recuperasenha->editar($parametros);
            $resultadoAlterarSenha = $genericoDAO->editar($entidadeRecuperaSenha);
            if ($resultadoUsuario && $resultadoAlterarSenha) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                $visao->setItem("sucessoalterarsenha");
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

    function trocarsenha($parametros) {
        $visao = new Template();
        if (Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $usuario = new Usuario();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("id" => $_SESSION["idusuario"]));
            if (password_verify($parametros['txtSenhaAtual'], $selecionarUsuario[0]->getSenha())) {
                $entidadeUsuario = $usuario->trocarSenha($parametros);
                $resultadoUsuario = $genericoDAO->editar($entidadeUsuario);
                //sucesso
                if ($resultadoUsuario) {
                    $genericoDAO->commit();
                    $genericoDAO->fecharConexao();
                    $visao->setItem("sucessoalterarsenha");
                    $visao->exibir('VisaoErrosGenerico.php');
                    //banco
                } else {
                    $genericoDAO->rollback();
                    $genericoDAO->fecharConexao();
                    $visao->setItem("errobanco");
                    $visao->exibir('VisaoErrosGenerico.php');
                }
                //especifico - A Senha atual está incorreta.
            } else {
                $visao->setItem("errotrocasenha");
                $visao->exibir('VisaoErrosGenerico.php');
                //echo json_encode(array("resultado" => 3));
            }
            //token
        } else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErrosGenerico.php');
        }
    }

    public function meuPIP() {
        if (Sessao::verificarSessaoUsuario()) {
            //modelo
            $usuarioPlano = new UsuarioPlano();
            $genericoDAO = new GenericoDAO();
            $consultasAdHoc = new ConsultasAdHoc();

            $listarUsuarioPlano = $genericoDAO->consultar($usuarioPlano, true, array("idusuario" => $_SESSION["idusuario"]));
            $itemMeuPIP = array();
            $itemMeuPIP["usuarioPlano"] = $listarUsuarioPlano;
            $itemMeuPIP["imovel"] = is_array($genericoDAO->consultar(new Imovel(), true, array("idusuario" => $_SESSION['idusuario'])));
            $itemMeuPIP["anuncio"] = count($consultasAdHoc->ConsultarAnunciosPorUsuario($_SESSION['idusuario']) > 0);
            //visao
            $visao = new Template();
            $visao->setItem($itemMeuPIP);
            $visao->exibir('UsuarioVisaoMeuPIP.php');
        } else {
            $visao = new Template();
            $visao->exibir('UsuarioVisaoLogin.php');
        }
    }

    public function listarMensagem($parametros) {
        unset($_SESSION["mensagem"]);
        $mensagem = new Mensagem();
        $genericoDAO = new GenericoDAO();
        $listaMensagens = $genericoDAO->consultar($mensagem, true, array("idusuario" => $_SESSION["idusuario"]));
        foreach ($listaMensagens as $selecionarMensagem) {
            $selecionarAnuncio = $genericoDAO->consultar(new Anuncio(), true, array("id" => $selecionarMensagem->getIdAnuncio()));
            $selecionarResposta = $genericoDAO->consultar(new RespostaMensagem(), false, array("idmensagem" => $selecionarMensagem->getId()));
            $idMensagem = rand();
            $_SESSION["mensagem"][$idMensagem] = $selecionarMensagem->getId();
            $selecionarMensagem->setId($idMensagem);
            $selecionarMensagem->setRespostamensagem($selecionarResposta);
            $selecionarMensagem->setAnuncio($selecionarAnuncio[0]);
            $listarMensagens[] = $selecionarMensagem;
        }
        if ($parametros["type"] == "face") {
            echo json_encode(array("resultado" => $listarMensagens));
        } else {
            if (count($listaMensagens) > 0) {
                $visao = new Template();
                $visao->setItem($listarMensagens);
            } else {
                $visao = new Template();
                $visao->setItem(false);
            }
            $visao->exibir('UsuarioVisaoMinhasMensagens.php');
        }
    }

    public function responderMensagem($parametros) {
        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();
        $respostaMensagem = new RespostaMensagem();
        $entidadeRespostaMensagem = $respostaMensagem->cadastrar($parametros);
        $resultadoRespostaMensagem = $genericoDAO->cadastrar($entidadeRespostaMensagem);
        if ($resultadoRespostaMensagem) {
            //Enviar email para o usuário
            $selecionarMensagem = $genericoDAO->consultar(new Mensagem(), false, array("id" => $_SESSION["mensagem"][$parametros["id"]]));
            $selecionarAnuncio = $genericoDAO->consultar(new Anuncio(), false, array("id" => $selecionarMensagem[0]->getIdAnuncio()));
            $dadosEmail['destino'] = $selecionarMensagem[0]->getEmail(); //$parametros["email"];  
            $dadosEmail['nome'] = $selecionarMensagem[0]->getNome(); //$parametros["nome"]; 
            $dadosEmail['msg'] = $parametros["msg"];
            $dadosEmail['contato'] = $_SESSION["nome"];
            $dadosEmail['assunto'] = $selecionarAnuncio[0]->getTituloAnuncio();
            if (Email::enviarEmail($dadosEmail)) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 1));
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 0));
            }
        } else {
            $genericoDAO->rollback();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 0));
        }
    }

    public function arquivarMensagem($parametros) {
        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();
        for ($i = 0; $i < sizeof($parametros["msgs"]); $i++) {
            $mensagem = new Mensagem();
            $entidadeMensagem = $mensagem->editar($parametros, "EXCLUIDA", $i);
            $resultado = $genericoDAO->editar($entidadeMensagem);
            if (!$resultado) {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 0));
                break;
            }
        }
        $genericoDAO->commit();
        $genericoDAO->fecharConexao();
        echo json_encode(array("resultado" => 1));

//     var_dump(sizeof($parametros["msgs"]));
//     die();
    }

    public function lerMensagem($parametros) {
        $genericoDAO = new GenericoDAO();
        $genericoDAO->iniciarTransacao();
        $mensagem = new Mensagem();
        $entidadeMensagem = $mensagem->editar($parametros, "LIDA");
        $resultado = $genericoDAO->editar($entidadeMensagem);
        if (!$resultado) {
            $genericoDAO->rollback();
            $genericoDAO->fecharConexao();
            echo json_encode(array("resultado" => 0));
        }
        $genericoDAO->commit();
        $genericoDAO->fecharConexao();
        echo json_encode(array("resultado" => 1));
    }

    public function trocarImagem($parametros) {
        $visao = new Template();
        if (Sessao::verificarSessaoUsuario() & Sessao::verificarToken($parametros)) {
            $genericoDAO = new GenericoDAO();
            $genericoDAO->iniciarTransacao();
            $selecionarUsuario = $genericoDAO->consultar(new Usuario, false, array("id" => $_SESSION["idusuario"]));
            $usuario = $selecionarUsuario[0];
            //excluir foto antiga se houver
            if ($usuario->getFoto() != "") {
                $fotoAntiga = PIPROOT . '/fotos/usuarios/' . $usuario->getFoto();
                if (is_file($fotoAntiga)) {
                    $deletar = unlink($fotoAntiga);
                }
            } else {
                $deletar = true;
            }
            $usuario->setFoto("");

            //se nao for exclusao de foto
            if ($parametros["hdnExcluir"] == 0) {
                $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
                $nome = $_FILES['arquivo']['name'];
                $extensao = strrchr($nome, '.');
                $extensao = strtolower($extensao);
                $novoNome = md5(microtime()) . $extensao;
                $destino = PIPROOT . '/fotos/usuarios/' . $novoNome;
                if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino)) {
                    $usuario->setFoto($novoNome);
                }
            }
            $resultado = $genericoDAO->editar($usuario);
            if ($deletar & $resultado) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                $visao->setItem("sucessotrocarimagem");
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
