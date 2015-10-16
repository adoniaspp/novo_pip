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
include_once 'modelo/Casa.php';
include_once 'modelo/Apartamento.php';
include_once 'modelo/ApartamentoPlanta.php';
include_once 'modelo/SalaComercial.php';
include_once 'modelo/PredioComercial.php';
include_once 'modelo/Terreno.php';
include_once 'modelo/Planta.php';
include_once 'modelo/TipoImovel.php';
include_once 'modelo/ImovelDiferencial.php';
include_once 'modelo/Diferencial.php';
include_once 'assets/libs/captcha/securimage/securimage.php';
include_once 'assets/libs/log4php/Logger.php';
include_once 'configuracao/Log.php';

class UsuarioControle {

    use Log;

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
        $this->log("Inicio da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
        //Endereço
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
                $this->log("Término da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
                $visao->setItem("sucessocadastrousuario");
                $visao->exibir('VisaoErrosGenerico.php');
            } else {
                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                $visao->setItem("errobanco");
                $visao->exibir('VisaoErrosGenerico.php');
            }
        } else {
            $this->log("Término da Operação por Erro no Token");
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErrosGenerico.php');
        }
    }

    function validarCaptcha($parametros) {

        $captcha = new Securimage();

        if ($captcha->check($parametros["captcha_code"])) {
            echo "true";
        } else
            echo "false";
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
            $visao->setItem($selecionarUsuario);
            $visao->exibir('UsuarioVisaoEdicao.php');
        } else {
            $visao = new Template();
            $visao->exibir('UsuarioVisaoLogin.php');
        }
    }

    function alterar($parametros) {
        $this->log("Inicio da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
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
            $editarUsuario = $genericoDAO->editar($entidadeUsuario);

            //visao
            if ($editarUsuario & $editarEndereco & $resultadoTelefoneFinalExcluir & $resultadoTelefone) {
                $genericoDAO->commit();
                $genericoDAO->fecharConexao();
                $this->log("Término da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
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
            $this->log("Término da Operação por Erro no Token");
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErrosGenerico.php');
        }
    }

    function buscarLogin($parametros) {
        $visao = new Template();
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
        $visao = new Template();
        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("email" => $parametros['txtEmail']));
            if (count($selecionarUsuario) > 0) {
                if ($selecionarUsuario[0]->getId() == $_SESSION["idusuario"]) {
                    echo "true";
                } else {
                    echo "false";
                }
            } else {
                echo "true";
            }
        } else {
            $visao->setItem("errotoken");
            $visao->exibir('VisaoErrosGenerico.php');
        }
    }

    function buscarCpf($parametros) {

        if (Sessao::verificarToken($parametros)) {
            $usuario = new Usuario();
            $genericoDAO = new GenericoDAO();
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("cpfcnpj" => $parametros['txtCPF']));
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
            $selecionarUsuario = $genericoDAO->consultar($usuario, false, array("cpfcnpj" => $parametros['txtCNPJ']));

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
            echo json_encode(array("resultado" => 1, "nome" => $_SESSION['nome'],
                "redirecionamento" => $redirecionamento));
        } else {
            echo json_encode(array("resultado" => 2)); //usuario ou senha invalido
        }
        $this->log("login");
    }

    function logout($parametros) {
        if (Sessao::encerrarSessaoUsuario()) {
            echo json_encode(array("resultado" => 1));
            $this->log("logout");
        } else {
            echo json_encode(array("resultado" => 0));
            $this->log("Falha no Logout");
        }
    }

    public function renovarSessao($parametros) {
        Sessao::renovarSessao();
        echo json_encode(array("resultado" => 1));
    }

    function esquecerSenha($parametros) {
        $this->log("Inicio da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
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
                    if (!$resultadoExcluirRecuperaSenha) { //apagar token já cadastrado - 002
                        $genericoDAO->rollback();
                        $genericoDAO->fecharConexao();
                        echo json_encode(array("resultado" => 2));
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
                        <h4>Você já solicitou uma troca de senha no PIP Imóveis. Desconsidere o email já enviado e clique no link abaixo para processar a troca:</h4><br>
                        <a href=http://localhost/index.php?entidade=Usuario&acao=form&tipo=alterarsenha&id=" . $entidadeRecuperaSenha->getHash() . ">http://localhost/index.php?entidade=Usuario&acao=form&tipo=alterarsenha&id=" . $entidadeRecuperaSenha->getHash() . "</a>";
                    } else {
                        $dadosEmail['msg'] = "PIP Imóveis - Clique abaixo para recuperar sua senha. Este é um email automático. Não responda.
                        <br> 
                        <a href=http://localhost/index.php?entidade=Usuario&acao=form&tipo=alterarsenha&id=" . $entidadeRecuperaSenha->getHash() . ">http://localhost/index.php?entidade=Usuario&acao=form&tipo=alterarsenha&id=" . $entidadeRecuperaSenha->getHash() . "</a>";
                    }
                    $dadosEmail['contato'] = $_SESSION["nome"];
                    $dadosEmail['assunto'] = utf8_decode("Recuperação de Senha - PIP");
                    if (Email::enviarEmail($dadosEmail)) { //email enviado com sucesso
                        $genericoDAO->commit();
                        $genericoDAO->fecharConexao();
                        echo json_encode(array("resultado" => 1));
                    } else { //erro no envio do email
                        $genericoDAO->rollback();
                        $genericoDAO->fecharConexao();
                        echo json_encode(array("resultado" => 3));
                    }
                    $this->log("Término da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
                } else { //erro ao cadastrar token no banco - 004
                    $genericoDAO->rollback();
                    $genericoDAO->fecharConexao();
                    echo json_encode(array("resultado" => 4));
                }
            } else { //email não encontrado
                echo json_encode(array("resultado" => 0));
            }
        } else { //erro de sessão do token - 005
            echo json_encode(array("resultado" => 5));
            $this->log("Término da Operação por Erro no Token");
        }
    }

    function alterarSenha($parametros) { //Usuário Esqueceu a Senha
        $this->log("Inicio da Operação " . $parametros["hdnEntidade"] . ucfirst($parametros["hdnAcao"]));
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
                echo json_encode(array("resultado" => 1));
            } else {

                $genericoDAO->rollback();
                $genericoDAO->fecharConexao();
                echo json_encode(array("resultado" => 0)); //erro de banco de dados - 000
            }
        } else {
            echo json_encode(array("resultado" => 5)); //erro de sessão do token - 005
        }
    }

    function trocarSenha($parametros) { //Usuário Deseja Alterar Senha
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
                    echo json_encode(array("resultado" => 1));
                    //banco
                } else {
                    $genericoDAO->rollback();
                    $genericoDAO->fecharConexao();
                    echo json_encode(array("resultado" => 0));
                }
                //A Senha atual está incorreta.
            } else {
                echo json_encode(array("resultado" => 2));
            }
            //token
        } else {
            echo json_encode(array("resultado" => 3));
        }
    }

    public function meuPIP() {
        if (Sessao::verificarSessaoUsuario()) {
            //modelo
            $usuarioPlano = new UsuarioPlano();
            $genericoDAO = new GenericoDAO();
            $consultasAdHoc = new ConsultasAdHoc();

            $listarUsuarioPlano = $genericoDAO->consultar($usuarioPlano, true, array("idusuario" => $_SESSION["idusuario"]));
            $usuario = $genericoDAO->consultar(new Usuario, true, array("id" => $_SESSION["idusuario"]));
            $itemMeuPIP = array();
            $itemMeuPIP["usuarioPlano"] = $listarUsuarioPlano;
            $itemMeuPIP["usuario"] = $usuario;
            $itemMeuPIP["imovel"] = is_array($genericoDAO->consultar(new Imovel(), true, array("idusuario" => $_SESSION['idusuario'])));
            $itemMeuPIP["imovelCadastrado"] = $genericoDAO->consultar(new Imovel(), true, array("idusuario" => $_SESSION['idusuario']));
            $itemMeuPIP["anuncio"] = count($consultasAdHoc->ConsultarAnunciosPorUsuario($_SESSION['idusuario']) > 0);
            $itemMeuPIP["mensagem"] = $genericoDAO->consultar(new Mensagem(), false, array("idusuario" => $_SESSION['idusuario']));
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

        $entidadeMensagem = $genericoDAO->consultar(new Mensagem(), true, array("id" => $_SESSION["mensagem"][$parametros["hdnMensagem"]]));

        $entidadeMensagem = $entidadeMensagem[0];

        $entidadeMensagem->setStatus("RESPONDIDO"); //alterar o status da mensagem para Respondido

        $statusRespondido = $genericoDAO->editar($entidadeMensagem);

        if ($resultadoRespostaMensagem && $statusRespondido) {

            //Enviar email para o usuário
            $selecionarMensagem = $genericoDAO->consultar(new Mensagem(), false, array("id" => $entidadeRespostaMensagem->getIdMensagem()));

            $selecionarAnuncio = $genericoDAO->consultar(new Anuncio(), false, array("id" => $selecionarMensagem[0]->getIdAnuncio()));
            $dadosEmail['destino'] = $selecionarMensagem[0]->getEmail(); //$parametros["email"];  
            $dadosEmail['nome'] = $selecionarMensagem[0]->getNome(); //$parametros["nome"]; 
            $dadosEmail['msg'] = "O vendedor respondeu sua mensagem: <br><br>Resposta: " . $parametros["txtResposta"] . "<br><br>Este é um e-mail automático. Favor, não responder";
            $dadosEmail['contato'] = $_SESSION["nome"];
            $dadosEmail['assunto'] = "PIP Online - Resposta do vendedor sobre o anuncio " . $selecionarAnuncio[0]->getTituloAnuncio();
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
                $arquivo_tmp = $_FILES['attachmentName']['tmp_name'];
                $nome = $_FILES['attachmentName']['name'];
                $extensao = strrchr($nome, '.');
                $extensao = strtolower($extensao);
                $novoNome = md5(microtime()) . $extensao;
                $destino = PIPROOT . '/fotos/usuarios/' . $novoNome;
                if (move_uploaded_file($_FILES['attachmentName']['tmp_name'], $destino)) {
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
