<script src="assets/js/jquery.mask.min.js"></script>
<script src="assets/js/util.validate.js"></script>
<script src="assets/js/pwstrength.js"></script>
<script src="assets/js/additional-methods.min.js"></script>
<script>

//Inicio CEP
    $(document).ready(function () {
        $("#txtCEP").mask("99.999-999"); //mascara
        $("#divCEP").hide(); //oculta campos do DIVCEP
        $("#btnCEP").click(function () {
            buscarCep()
        });
        $("#txtCEP").blur(function () {
            buscarCep()
        });
        $("#btnCadastrar").click(function () {
            $("#form").submit();
        });
        $("#btnCancelar").click(function () {
            if (confirm("Deseja cancelar o cadastro do usuário?")) {
                location.href = "index.php?entidade=Usuario&acao=meuPIP";
            }
        });
        $("#btnConfirmar").click(function () {
            if ($("#form").valid()) {
                if (typeof ($("input[name^=hdnTipoTelefone]").val()) == "undefined") {
                    alert("Você deve cadastrar pelo menos um telefone para contato.");
                } else
                if ($("#hdnCEP").val() != "") {
                    //chama modal de confirmacao    
                    carregaDadosModal($("div[class='modal-body']"));
                    $('#myModal').modal('show');
                } else {
                    $("#msgCEP").remove();
                    var msgCEP = $("<div>", {id: "msgCEP"});
                    msgCEP.attr('class', 'alert alert-danger').html("Primeiro faça a busca do CEP").append('<button data-dismiss="alert" class="close" type="button">×</button>');
                    $("#alertCEP").append(msgCEP);
                }
            }
        });
        function carregaDadosModal($div) {
            $div.html("");
            if ($("#sltTipoUsuario").val() === "pf")
            {
                $div.append("Tipo de Pessoa: " + "Física" + "<br />");
                $div.append("Nome: " + $("#txtNome").val() + "<br />");
                $div.append("CPF: " + $("#txtCpf").val() + "<br />");
                $div.append("Login: " + $("#txtLogin").val() + "<br />");
                $div.append("Email: " + $("#txtEmail").val() + "<br />");
                $div.append("Logradouro: " + $("#txtLogradouro").val() + "<br />");
                $div.append("Numero: " + $("#txtNumero").val() + "<br />");
                $div.append("Complemento: " + $("#txtComplemento").val() + "<br />");
                $div.append("Bairro: " + $("#txtBairro").val() + "<br />");
                $div.append("Cidade: " + $("#txtCidade").val() + "<br />");
                $div.append("Estado: " + $("#txtEstado").val() + "<br />");
                $div.append("CEP: " + $("#txtCEP").val() + "<br />");
            } else {
                $div.append("Tipo de Pessoa: " + "Jurídica" + "<br />");
                $div.append("Nome: " + $("#txtNome").val() + "<br />");
                $div.append("CNPJ: " + $("#txtCnpj").val() + "<br />");
                $div.append("Login: " + $("#txtLogin").val() + "<br />");
                $div.append("Email: " + $("#txtEmail").val() + "<br />");
                $div.append("Responsável: " + $("#txtResponsavel").val() + "<br />");
                $div.append("CPF do Responsável: " + $("#txtCpfResponsavel").val() + "<br />");
                $div.append("Razão Social: " + $("#txtRazaoSocial").val() + "<br />");
                $div.append("Logradouro: " + $("#txtLogradouro").val() + "<br />");
                $div.append("Numero: " + $("#txtNumero").val() + "<br />");
                $div.append("Complemento: " + $("#txtComplemento").val() + "<br />");
                $div.append("Bairro: " + $("#txtBairro").val() + "<br />");
                $div.append("Cidade: " + $("#txtCidade").val() + "<br />");
                $div.append("Estado: " + $("#txtEstado").val() + "<br />");
                $div.append("CEP: " + $("#txtCEP").val() + "<br />");
            }

        }

        $(document).ready(function () {
            $("#divLogo").hide();
            $("#sltTipoUsuario").change(function () {
                if ($(this).val() == "pj") {
                    $("#divLogo").fadeIn();
                    $("#divImagem").hide();
                } else {
                    $("#divLogo").fadeOut();
                    $("#divImagem").fadeIn();
                }

            })
        })

        function buscarCep() {
            var validator = $("#form").validate();
            if (validator.element("#txtCEP")) {
                $.ajax({
                    url: "index.php",
                    dataType: "json",
                    type: "POST",
                    data: {
                        cep: $('#txtCEP').val(),
                        hdnEntidade: "Endereco",
                        hdnAcao: "buscarCEP"
                    },
                    beforeSend: function () {
                        $("#msgCEP").remove();
                        var msgCEP = $("<div>", {id: "msgCEP", class: "alert alert-warning"}).html("...aguarde buscando CEP...");
                        $("#divCEP").fadeOut('slow'); //oculta campos do DIVCEP
                        $("#alertCEP").append(msgCEP);
                        $('#txtCEP').attr('disabled', 'disabled');
                        $('#btnCEP').attr('disabled', 'disabled');
                        $('#txtEstado').val('');
                        $('#txtCidade').val('');
                        $('#txtBairro').val('');
                        $('#txtLogradouro').val('');
                        $('#hdnCEP').val('');
                    },
                    success: function (resposta) {
                        $("#msgCEP").remove();
                        var msgCEP = $("<div>", {id: "msgCEP"});
                        if (resposta.resultado == 0) {
                            msgCEP.attr('class', 'alert alert-danger').html("N&atilde;o localizamos o CEP informado").append('<button data-dismiss="alert" class="close" type="button">×</button>');
                        } else {
                            $("#divCEP").fadeIn('slow'); //mostra campos do DIVCEP
                            $('#txtEstado').val(resposta.uf);
                            $('#txtCidade').val(resposta.cidade);
                            $('#txtBairro').val(resposta.bairro);
                            $('#txtLogradouro').val(resposta.logradouro);
                            $('#hdnCEP').val($('#txtCEP').val());
                            var endereco = 'Brazil, ' + resposta.uf + ', ' + resposta.cidade + ', ' + resposta.bairro + ', ' + resposta.logradouro;
                        }
                        $("#alertCEP").append(msgCEP); //mostra resultado de busca cep
                        $('#txtCEP').removeAttr('disabled');
                        $('#btnCEP').removeAttr('disabled');
                    }
                })
            }
        }
        
        //######### FIM DO CEP ########

//       Inicio Informações Básicas
        $.validator.addMethod('filesize', function(value, element, param) {
    // param = size (en bytes) 
    // element = element to validate (<input>)
    // value = value of the element (file name)
            return this.optional(element) || (element.files[0].size <= param) 
        });
        
        
        
        $("#divEmpresa").hide(); //oculta campos do DIVEMPRESA 
        $("#divnome").hide();
        $("#divCpf").hide();
        $("#divCnpj").hide();
        $("#txtCpf").mask("999.999.999-99");
        $("#txtCnpj").mask("99.999.999/9999-99");
        $("#txtCpfResponsavel").mask("999.999.999-99");
        $("#sltTipoUsuario").change(function () {
            if ($(this).val() == "pf") {
                $("#divnome").fadeIn('slow');
                $("#divEmpresa").fadeOut('slow'); //oculta campos do DIVEMPRESA 
                $("#divCnpj").hide();
                $("#divCpf").show();
                $("#lblNome").html("Nome Completo");
            } else if ($(this).val() == "pj") {
                $("#divnome").fadeIn('slow');
                $("#divEmpresa").fadeIn('slow'); //mostra campos do DIVEMPRESA
                $("#divCnpj").show();
                $("#divCpf").hide();
                $("#lblNome").html("Nome da Empresa");
                $("#txtNome").attr("placeholder", "Informe o nome da empresa");
            } else {
                $("#divnome").fadeOut('slow');
                $("#divEmpresa").fadeOut('slow'); //mostra campos do DIVEMPRESA
                $("#divCnpj").fadeOut('slow');
                $("#divCpf").fadeOut('slow');
            }
        });
        "use strict";
        var options = {
            bootstrap3: true,
            minChar: 8,
            errorMessages: {
                password_too_short: "<font color='red'>A senha é muito pequena</font>",
                same_as_username: "<font color='red'>Sua senha não pode ser igual ao seu login</font>"
            },
            verdicts: ["Fraca", "Normal", "Média", "Forte", "Muito Forte"],
            usernameField: "#txtLogin",
            onLoad: function () {
                $('#messages').text('Start typing password');
            },
            onKeyUp: function (evt) {
                $(evt.target).pwstrength("outputErrorList");
            }
        };
        $('#txtSenha').pwstrength(options);
//        Fim Informações Básicas

//        Inicio Telefone
        $("#btnTelefone").click(function () {
            $("#txtTel").rules("add", {
                required: true,
                messages: {
                    required: "Campo obrigatório",
                }
            });
            $("#sltOperadora").rules("add", {
                required: true,
                messages: {
                    required: "Campo obrigatório",
                }
            });
            $("#sltTipotelefone").rules("add", {
                required: true,
                messages: {
                    required: "Campo obrigatório",
                }
            });
            var telefone = $("#txtTel");
            var tipoTelefone = $("#sltOperadora");
            var tipoOperadora = $("#sltTipotelefone");
            if (telefone.valid() && tipoTelefone.valid() && tipoOperadora.valid()) {
                $("#dadosTelefone").append(
                        "<tr><td> <input type=hidden id=hdnTipoTelefone[] name=hdnTipoTelefone[] value=" + $("#sltTipotelefone").val() + ">" + $("#sltTipotelefone").val() + "</td>" +
                        "<td> <input type=hidden id=hdnOperadora[] name=hdnOperadora[] value=" + $("#sltOperadora").val() + ">" + $("#sltOperadora").val() + "</td>" +
                        "<td> <input type=hidden id=hdnTelefone[] name=hdnTelefone[] value=" + $("#txtTel").val() + ">" + $("#txtTel").val() + "</td>" +
                        "<td> <button type=button class=btn btn-default btn-lg onclick=$(this).parent().parent().remove()> <span class=glyphicon glyphicon-trash></span> Excluir</button> </td></tr>");
            }
            $("#txtTel").rules("remove");
            $("#sltOperadora").rules("remove");
            $("#sltTipotelefone").rules("remove");
            $("#txtTel").val("");
            $("#sltOperadora").val("");
            $("#sltTipotelefone").val("");
        });
        $("#txtTel").mask("(00) 0000-00009");
//        Fim do Telefone

        //######### VALIDACAO DO FORMULARIO ########
        $('#form').validate({
            onkeyup: false,
            rules: {
                sltTipoUsuario: {
                    required: true
                },
                txtNome: {
                    required: true
                },
                txtCpf: {
                    required: true,
                    cpf: 'both',
                    remote:
                            {
                                url: "index.php",
                                dataType: "json",
                                type: "POST",
                                data: {
                                    hdnEntidade: "Usuario",
                                    hdnAcao: "buscarCpf",
                                    hdnToken: $("#hdnToken").val()
                                }
                            }
                },
                txtCnpj: {
                    required: true,
                    cnpj: 'both',
                    remote:
                            {
                                url: "index.php",
                                dataType: "json",
                                type: "POST",
                                data: {
                                    hdnEntidade: "Usuario",
                                    hdnAcao: "buscarCnpj",
                                    hdnToken: $("#hdnToken").val()
                                }
                            }
                },
                txtCpfResponsavel: {
                    required: true,
                    cpf: 'both'
                },
                txtLogin: {
                    required: true,
                    minlength: 2,
                    remote:
                            {
                                url: "index.php",
                                dataType: "json",
                                type: "POST",
                                data: {
                                    hdnEntidade: "Usuario",
                                    hdnAcao: "buscarLogin",
                                    hdnToken: $("#hdnToken").val()
                                }
                            }
                },
                txtResponsavel: {
                    required: true
                },
                txtEmail: {
                    email: true,
                    remote:
                            {
                                url: "index.php",
                                dataType: "json",
                                type: "POST",
                                data: {
                                    hdnEntidade: "Usuario",
                                    hdnAcao: "buscarEmail",
                                    hdnToken: $("#hdnToken").val()
                                }
                            }
                },
                txtRazaoSocial: {
                    required: true
                },
                arquivo: {
                    //required: true,
                    filesize: 2097152,
                    accept: "jpeg|png|gif"
                },
                txtSenha: {
                    required: true,
                    minlength: 8,
                    maxlength: 12
                },
                txtConfirmSenha: {
                    required: true,
                    equalTo: "#txtSenha"
                },
                txtCEP: {
                    required: true
                },
                txtNumero: {
                    required: true
                }

            },
            messages: {
                txtCpf: {
                    required: "Campo obrigatório",
                    remote: "CPF já utilizado"
                },
                txtCnpj: {
                    required: "Campo obrigatório",
                    remote: "CNPJ já utilizado"
                },
                txtEmail: {
                    remote: "Email já utilizado"
                },
                sltTipoUsuario: {
                    required: "Campo obrigatório"
                },
                txtNome: {
                    required: "Campo obrigatório"
                },
                txtLogin: {
                    required: "Campo obrigatório",
                    minlength: "Login deve possuir no mínimo 2 caracteres",
                    remote: "Login já utilizado"
                },
                txtSenha: {
                    required: "Campo obrigatório",
                    minlength: "Senha deve possuir no mínimo 4 caracteres"
                },
                txtConfirmSenha: {
                    required: "Campo obrigatório",
                    equalTo: "Por Favor digite o mesmo valor novamente"
                },
                txtRazaoSocial: {
                    required: "Campo obrigatório"
                },
                txtResponsavel: {
                    required: "Campo obrigatório"
                },
                txtCEP: {
                    required: "Campo obrigatório"
                },
                txtCpfResponsavel: {
                    required: "Campo obrigatório"
                },
                arquivo: {
                    //required: "Campo obrigatório"
                    filesize: "A imagem deve ser menor que 2MB",
                    accept: "Extensão de Arquivo Inválida"
                }
            },
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function () {
                form.submit();
            }
        });
    })

</script> 

<?php
Sessao::gerarToken();
?>

<div class="container"> <!-- CLASSE QUE DEFINE O CONTAINER COMO FLUIDO (100%) --> 
    
    <!-- Alertas -->
      <ol class="breadcrumb">
        <li><a href="index.php">Início</a></li>
        <li class="active">Cadastro Usuário</li>
</ol>
    <!-- form -->
    <form id="form" class="form-horizontal" action="index.php" method="post" enctype="multipart/form-data">
        <input type="hidden" id="hdnEntidade" name="hdnEntidade" value="Usuario"  />
        <input type="hidden" id="hdnAcao" name="hdnAcao" value="cadastrar" />
        <input type="hidden" id="hdnCEP" name="hdnCEP" />
        <input type="hidden" id="hdnToken" name="hdnToken" value="<?php echo $_SESSION['token']; ?>" />

<!--        <input type="hidden" id="hdnTipoTelefone[]" name="hdnTipoTelefone[]" value=""  />-->
        <!-- Primeira Linha -->    
        <div class="row" id="divlinha1">

            <!--            <div id="alertsucesso" class="col-lg-12"></div>-->
            <div class="col-lg-6" id="divinformacoesbasicas">
                <div id="forms" class="panel panel-default">
                    <div class="panel-heading">Informações Básicas </div>
                    <br>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="sltTipoUsuario">Tipo de Pessoa</label>
                        <div class="col-lg-8">
                            <select class="form-control" id="sltTipoUsuario" name="sltTipoUsuario">
                                <option value="">Informe o Tipo de Pessoa</option>
                                <option value="pf">Física</option>
                                <option value="pj">Jurídica</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="divnome">
                        <label class="col-lg-3 control-label" for="txtNome" id="lblNome">Nome Completo</label>
                        <div class="col-lg-8">
                            <input type="text" id="txtNome" name="txtNome" class="form-control" placeholder="Informe o seu nome">
                        </div>
                    </div>
                    <div class="form-group" id="divCpf">
                        <label class="col-lg-3 control-label" for="txtCpf" id="lblCpf">CPF*</label>
                        <div class="col-lg-8">
                            <input type="text" id="txtCpf" name="txtCpf" class="form-control" placeholder="Informe o seu CPF">
                        </div>
                    </div>
                    <div class="form-group" id="divCnpj">
                        <label class="col-lg-3 control-label" for="txtCnpj" id="lblCpfCnpj">CNPJ*</label>
                        <div class="col-lg-8">
                            <input type="text" id="txtCnpj" name="txtCnpj" class="form-control" placeholder="Informe o seu CNPJ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtLogin">Login</label>
                        <div class="col-lg-8">
                            <input type="text" id="txtLogin" name="txtLogin" class="form-control" placeholder="Informe um login">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtSenha">Senha</label>
                        <div class="col-lg-8">
                            <input type="password" id="txtSenha" name="txtSenha" class="form-control" placeholder="Informe uma senha">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtConfirmSenha">Confirma Senha</label>
                        <div class="col-lg-8">
                            <input type="password" id="txtSenha" name="txtConfirmSenha" class="form-control" placeholder="Informe a senha novamente">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtEmail">Email</label>
                        <div class="col-lg-8">
                            <input type="text" id="txtEmail" name="txtEmail" class="form-control" placeholder="Informe o seu email">
                        </div>
                    </div>
                    <div id="divEmpresa">
                        <div class="form-group" id="divresp">
                            <label class="col-lg-3 control-label" for="txtResponsavel">Responsável</label>
                            <div class="col-lg-8">
                                <input type="text" id="txtResponsavel" name="txtResponsavel" class="form-control" placeholder="Informe o nome do responsável da empresa">
                            </div>
                        </div>
                        <div class="form-group" id="divCpfResp">
                            <label class="col-lg-3 control-label" for="txtCpfResponsavel">CPF do Responsável*</label>
                            <div class="col-lg-8">
                                <input type="text" id="txtCpfResponsavel" name="txtCpfResponsavel" class="form-control" placeholder="Informe o CPF do responsável da empresa">
                            </div>
                        </div>
                        <div class="form-group" id="divsocial">
                            <label class="col-lg-3 control-label" for="txtRazaoSocial">Razão Social</label>
                            <div class="col-lg-8">
                                <input type="text" id="txtRazaoSocial" name="txtRazaoSocial" class="form-control" placeholder="Informe a razão social da empresa">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" id=divendereco">
                <div id="forms" class="panel panel-default">
                    <div class="panel-heading"> Endereço </div>
                    <br>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="txtCEP">CEP</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="txtCEP" name="txtCEP" placeholder="Informe o seu CEP">                            
                        </div>
                        <div class="col-lg-2">
                            <button id="btnCEP" type="button" class="btn btn-info">Buscar CEP</button>
                        </div> 
                    </div>
                    <div class="form-group">
                        <div id="alertCEP" class="col-lg-12"></div>
                    </div>
                    <div id="divCEP">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="txtCidade">Cidade</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="txtCidade" name="txtCidade" readonly="true"> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="txtEstado">Estado</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="txtEstado" name="txtEstado" readonly="true" > 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="txtBairro">Bairro</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="txtBairro" name="txtBairro" readonly="true"> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="txtLogradouro">Logradouro</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="txtLogradouro" name="txtLogradouro" readonly="true"> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="txtNumero">N&uacute;mero</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="txtNumero" name="txtNumero" placeholder="Informe o n&ordm;"> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="txtComplemento">Complemento</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="txtComplemento" name="txtComplemento" placeholder="Informe o Complemento"> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Segunda Linha -->    
        <div class="row" id="divlinha2">
            <div class="col-lg-12" id="divtelefone">
                <div id="forms" class="panel panel-default">
                    <div class="panel-heading"> Telefones </div>
                    <br>
                    <div class="form-group">
                        <label class="col-lg-1 control-label" for="sltTipotelefone">Tipo</label>
                        <div class="col-lg-2">
                            <select class="form-control" id="sltTipotelefone" name="sltTipotelefone">     
                                <option value="">Tipo do Telefone</option>
                                <option value="Fixo">Fixo</option>
                                <option value="Celular">Celular</option>
                            </select>
                        </div>
                        <label class="col-lg-1 control-label" for="sltOperadora">Operadora</label>
                        <div class="col-lg-2">
                            <select class="form-control" id="sltOperadora" name="sltOperadora">  
                                <option value="">Operadora</option>
                                <option value="Oi">Oi</option>
                                <option value="Tim">Tim</option>
                                <option value="Vivo">Vivo</option>
                                <option value="Claro">Claro</option>
                                <option value="Embratel">Embratel</option>
                            </select>
                        </div>
                        <label class="col-lg-1 control-label" for="txtTel">Numero</label>
                        <div class="col-lg-2">
                            <input type="tel" class="form-control" id="txtTel" name="txtTel" placeholder="Informe o Telefone" pattern="\([0-9]{2}\)[\s][0-9]{4}-[0-9]{4,5}" />
                        </div>
                        <div class="col-lg-2">
                            <button id="btnTelefone" type="button" class="btn btn-info">Adicionar</button>
                        </div>
                    </div>
                    <!--                </div>-->
                    <!--          </div>-->
                    <div class="form-group">
                        <div class="col-lg-12">

                            <table class="table table-hover table-condensed">
            <!--                    <thead>
                                    <tr>
                                        <th>Tipo de Telefone</th>
                                        <th>Operadora</th>
                                        <th>Numero</th>
                                    </tr>
                                </thead>-->
                                <tbody id="dadosTelefone">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- upload da foto-->
        <div class="row">
        <div class="col-lg-8" id="divFotoImagem">
            <div id="forms" class="panel panel-default">
                <div class="panel-heading" id="divImagem">Sua Imagem </div>
                <div class="panel-heading" id="divLogo">Logomarca </div>
                <br>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="sltArquivo">Selecione a imagem</label>
                    <div class="col-lg-2">
                        <input  id="arquivo" name="arquivo" type="file"/> <br />
                    </div>             
                </div>

            </div>
        </div>
        </div>




        <!-- Terceira Linha -->    
        <div class="row" id="divlinha3">
            <div class="col-lg-12" id="divbotoes">
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button id="btnConfirmar"  type="button" class="btn btn-primary">Confirmar</button>
                        <button id="btnCancelar" type="button" class="btn btn-warning">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div> 

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirmação</h4>
            </div>
            <div class="modal-body">  </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                <button id="btnCadastrar" type="button" class="btn btn-primary">Cadastrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
