var login = {
	Login: function() {
			
        this.jsonAjax = new bf2.JSONAjax();
        this.html = "<div id=\"myModal\" style=\"display: block;\" class=\"modal\"><div class=\"modal-content\"><div class=\"menupopup\"><h1 style=\"font-size: 12px; padding: 0 8px\">Termo de Consentimento</h1></div><div class=\"modal-body\">#TextoHtml</div><div class=\"modal-footer\"><button id=\"botaoNaoAceito\"  onclick=\"loginUtil.NaoAceitaTermo()\" class=\"menupopupbotao\">Não Aceito</button><button id=\"botaoAceito\"  onclick=\"loginUtil.AceitaTermo()\" class=\"menupopupbotao\">Aceito</button></div></div></div>";


		this.login = function(form) {
			
			try {
				
				jQuery('#botao-login').attr('disabled',true);
				jQuery('#botao-login').toggleClass('button-login',false);
				jQuery('#botao-login').toggleClass('button-login-disabled',true);
				
				obj = loginUtil.jsonAjax.postForm(form);
				
                if (obj.login) {

                    param = new Array();
                    param[0] = "modulo=home";
                    param[1] = "acao=buscarPessoaTermoConsentimento";
                    param[2] = "CPF=" + jQuery('#cpf').val();

                    jQuery('#msg-err').html('');
                    jQuery('#msg-err').removeClass('msg-err');


                    objPessoa = loginUtil.jsonAjax.get('index.php', param);

                    if (objPessoa.AceiteTermo == "S") {
                        loginUtil.validaSenha(jQuery("#senha").val());
                        location.href = bf2.baseUrl + "?modulo=home&acao=inicial"; 

                    }
                    else {
                        var params = new Array();
                        params[0] = "modulo=home";
                        params[1] = "acao=buscarTermoHtml";
                        var objTermoHtml = loginUtil.jsonAjax.post('index.php', params);
                        if (objTermoHtml.trim() != "")
                            loginUtil.MostraPopupTermoConsentimento(objTermoHtml);
                        else
                        {
                            document.getElementById("alerta").innerHTML = "";
                            loginUtil.validaSenha(jQuery("#senha").val());
                            location.href = bf2.baseUrl + "?modulo=home&acao=inicial";
                          
                        }

                    }
           					
				} else {
					if (obj.code == 1) {
						jQuery('#senha').val('');
						jQuery('#senha').focus();
					} else if (obj.code == 5){
						jQuery('#cpf').focus('');
					} else if (obj.code == 6){
						jQuery('#senha').focus('');
					} else if (obj.code == 2){
						//jQuery('#cpf').val('');
						jQuery('#senha').val('');
						jQuery('#cpf').focus('');												
					}
					jQuery('#msg-err').addClass('msg-err');
					jQuery('#msg-err').html(obj.message);
					//alert(obj.message);
					
					this.enableButton();
				}
			} catch (e) {
				alert(e);				
				loginUtil.jsonAjax.hideWait();
				this.enableButton();
				return false;
			}
			
			return false;
        }

        this.MostraPopupTermoConsentimento = function (termo) {

            var textoTermo = loginUtil.html.replace("#TextoHtml", termo);
            document.getElementById("alerta").innerHTML = textoTermo;
        }

        this.NaoAceitaTermo = function () {

            var param = new Array();
            param[0] = "modulo=home";
            param[1] = "acao=setTermoConsentimento";
            param[2] = "CPF=" + jQuery('#cpf').val();
            param[3] = "TermoConsentimento=" + "N";
            jQuery('#msg-err').html('');
            jQuery('#msg-err').removeClass('msg-err');
            document.getElementById("botao-login").disabled = false;
            var atualizou = loginUtil.jsonAjax.post('index.php', param);

            if (atualizou) {
                document.getElementById("alerta").innerHTML = "";
            }
            else {
                alert("Erro ao Atualizar Termo de Consentimento.Tente Novamente!");
            }
            
        }

        this.AceitaTermo = function () {
            var param = new Array();
            param[0] = "modulo=home";
            param[1] = "acao=setTermoConsentimento";
            param[2] = "CPF=" + jQuery('#cpf').val();
            param[3] = "TermoConsentimento=" + "S";
            jQuery('#msg-err').html('');
            jQuery('#msg-err').removeClass('msg-err');
            document.getElementById("botao-login").disabled = false;
            var atualizou = loginUtil.jsonAjax.post('index.php', param);

            if (atualizou) {
                document.getElementById("alerta").innerHTML = "";
                loginUtil.validaSenha(jQuery("#senha").val());
                location.href = bf2.baseUrl + "?modulo=home&acao=inicial";
            }
            else {
                alert("Erro ao Atualizar Termo de Consentimento.Tente Novamente!");
            }
        }
        
		this.enableButton = function() {
			jQuery('#botao-login').attr('disabled',false);
			jQuery('#botao-login').toggleClass('button-login',true);
			jQuery('#botao-login').toggleClass('button-login-disabled',false);
		}
		
		this.logout = function(form) {			
			try {
				obj = loginUtil.jsonAjax.post("index.php", new Array("modulo=login", "acao=logout"));
				
				if (obj.logout) {
					location.href = bf2.baseUrl;
				} else { 
					alert(obj.message);
				}
			} catch (e) {
				alert(e);
				loginUtil.jsonAjax.hideWait();
			}
			return false;
        }

        this.validaSenha = function (senha)
        {
            var jsonAjax = new bf2.JSONAjax();

            var param = new Array();
            param[0] = "modulo=home";
            param[1] = "acao=buscarPoliticaSenha";

            obj = jsonAjax.get('index.php', param);

            var alerta = false;

            if (obj != null) {
                if ((obj.MinimoCaracteres != null) && (obj.MinimoCaracteres != '0'))
                    if (senha.length < obj.MinimoCaracteres) {
                        alerta = true;
                    }

                var regExp;

                if (obj.UsaLetrasNumeros == "S") {
                    regExp = /[a-zA-Z]/g;

                    if (!regExp.test(senha)) {
                        alerta = true;
                    }

                    regExp = /\d/;

                    if (!regExp.test(senha)) {
                        alerta = true;
                    }

                }

                if (obj.UsaMaiusculasMinusculas == "S") {
                    regExp = /[a-z]/;

                    if (!regExp.test(senha)) {
                        alerta = true;
                    }

                    regExp = /[A-Z]/;

                    if (!regExp.test(senha)) {
                        alerta = true;
                    }

                }

                if (obj.UsaCaracteresEspeciais == "S") {
                    regExp = /[-’/`~!#*$@_%+=.,^&(){}[\]|;:”<>?\\]/g;

                    if (!regExp.test(senha)) {
                        alerta = true;
                    }

                }
                else {
                    caracteresInvalidos = '';
                    if (senha.indexOf('\'') > -1)
                        caracteresInvalidos = '\'';
                    if (senha.indexOf('"') > -1) {
                        caracteresInvalidos = caracteresInvalidos + ' "';
                    }
                    if (caracteresInvalidos != '') {
                        alerta = true;
                    }
                }

                if (alerta) {
                    alert("Sua senha deve ser alterada pois não atende os critérios mínimos da política de preenchimento de senhas deste site.");
                }

            }

        }
		
		this.salvarSenha = function(form) {
			
            try {

                if (jQuery("#senhaNova").val() != jQuery("#senhaConfirma").val()) {
                    alert("Sua confirmação de senha está diferente da senha!");
                    jQuery("#ConfirmaSenha").focus();
                    return false;
                }
                else {

                    var param = new Array();
                    param[0] = "modulo=home";
                    param[1] = "acao=buscarPoliticaSenha"

                    obj = loginUtil.jsonAjax.get('index.php', param);

                    if (obj != null) {
                        if ((obj.MinimoCaracteres != null) && (obj.MinimoCaracteres != "0"))
                            if (jQuery("#senhaNova").val().length < obj.MinimoCaracteres) {
                                alert("Número Mínimo de Caracteres para senha: " + obj.MinimoCaracteres);
                                return false;
                            }

                        var regExp;

                        if (obj.UsaLetrasNumeros == "S") {
                          
                            regExp = /[a-zA-Z]/g;

                            if (!regExp.test(jQuery("#senhaNova").val())) {
                                alert("A senha precisa conter letras!");
                                return false;
                            }

                            regExp = /\d/;

                            if (!regExp.test(jQuery("#senhaNova").val())) {
                                alert("A senha precisa conter Números!");
                                return false;
                            }

                        }

                        if (obj.UsaMaiusculasMinusculas == "S") {
                            regExp = /[a-z]/;

                            if (!regExp.test(jQuery("#senhaNova").val())) {
                                alert("A senha precisa conter letras Minúsculas!");
                                return false;
                            }

                            regExp = /[A-Z]/;

                            if (!regExp.test(jQuery("#senhaNova").val())) {
                                alert("A senha precisa conter letras Maiúsculas!");
                                return false;
                            }

                        }

                        if (obj.UsaCaracteresEspeciais == "S") {
                            regExp = /[-’/`~!#*$@_%+=.,^&(){}[\]|;:”<>?\\]/g;

                            if (!regExp.test(jQuery("#senhaNova").val())) {
                                alert("A senha precisa conter Caracteres Especiais!");
                                return false;
                            }

                        }
                        else {
                            caracteresInvalidos = '';
                            if (jQuery("#senhaNova").val().indexOf('\'') > -1)
                                caracteresInvalidos = '\'';
                            if (jQuery("#senhaNova").val().indexOf('"') > -1) {
                                caracteresInvalidos = caracteresInvalidos + ' "';
                            }
                            if (caracteresInvalidos != '') {
                                alert("Campo Senha com caracteres inválidos: " + caracteresInvalidos);
                                return false;
                            }
                        }
                    }
                } 
				
				loginUtil.jsonAjax.postForm(form, function(obj){
					jQuery('#msg-err').addClass('msg-err');
					jQuery('#msg-err').html(obj.mensagem);
				
					// se alterou com sucesso, reseta o form
					if (obj.code == 1) {
						form.reset();
						jQuery("#cpf").mask("999.999.999-99");
						alert('Senha Alterada com Sucesso!')
					}
					else
					{
						alert('A senha atual está incorreta!')
					}
				});
				
				return false;
				
			} catch (e) {
				alert(e);				
				loginUtil.jsonAjax.hideWait();
				return false;
			}
			
			return false;
		}
	}
}

var loginUtil = new login.Login();