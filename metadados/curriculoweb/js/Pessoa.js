var pessoa = {
	Pessoa: function() {
			
        this.jsonAjax = new bf2.JSONAjax();
        this.html = "<div id=\"myModal\" style=\"display: block;\" class=\"modal\"><div class=\"modal-content\"><div class=\"menupopup\"><h1 style=\"font-size: 12px; padding: 0 8px\">Termo de Consentimento</h1></div><div class=\"modal-body\">#TextoHtml</div><div class=\"modal-footer\"><button id=\"botaoNaoAceito\"  onclick=\"pessoaUtil.NaoAceitaTermo()\" class=\"menupopupbotao\">Não Aceito</button><button id=\"botaoAceito\"  onclick=\"pessoaUtil.AceitaTermo()\" class=\"menupopupbotao\">Aceito</button></div></div></div>";

		this.validarCPF = function(val) {			
			val = unformatNumber(val);
			if (val != "") {
				if (!isCpf(val)) {
                    alert('Erro: CPF ou senha inválida.\nTente novamente!');
					return false;
				}
			}
			return true;
        }
        this.MostraPopupTermoConsentimento = function (termo) {

            var textoTermo = pessoaUtil.html.replace("#TextoHtml", termo);
            document.getElementById("alerta").innerHTML = textoTermo;
        }

        this.NaoAceitaTermo = function () {
            jQuery('#msg-err').html('');
            jQuery('#msg-err').removeClass('msg-err');
            document.getElementById("alerta").innerHTML = "";
        }

        this.AceitaTermo = function () {
   
            jQuery('#msg-err').html('');
            jQuery('#msg-err').removeClass('msg-err');
            document.getElementById("alerta").innerHTML = "";

            try {
               obj = pessoaUtil.jsonAjax.postForm(pessoaUtil.Form);
                if (obj.login) {

                    jQuery('#msg-err').html('');
                    jQuery('#msg-err').removeClass('msg-err');
                    location.href = bf2.baseUrl + "?modulo=home&acao=inicial";

                } else {

                    jQuery('#msg-err').addClass('msg-err');
                    jQuery('#msg-err').html(obj.message);

                }
            } catch (e) {
                alert(e);
            }
        }
         		
        this.cadastrar = function (form) {
		    if (jQuery("#Senha").val() != jQuery("#ConfirmaSenha").val()) {
		        alert("Sua confirmação de senha está diferente da senha!");
		        jQuery("#ConfirmaSenha").focus();
		        return false;
		    }
		    else {
		        var caracteresInvalidos = '';
		        if (jQuery("#Nome").val().indexOf('\'') > -1)
		            caracteresInvalidos = '\'';
		        if (jQuery("#Nome").val().indexOf('"') > -1) {
		            caracteresInvalidos = caracteresInvalidos + ' "';
		        }
		        if (caracteresInvalidos != '') {
		            alert("Campo Nome com caracteres inválidos: " + caracteresInvalidos);
		            return false;
		        }

                var param = new Array();
                param[0] = "modulo=home";
                param[1] = "acao=buscarPoliticaSenha"

                obj = pessoaUtil.jsonAjax.get('index.php', param);

                if (obj != null)
                {
                    if ((obj.MinimoCaracteres != null) && (obj.MinimoCaracteres != '0'))
                        if (jQuery("#Senha").val().length < obj.MinimoCaracteres) {
                            alert("Número Mínimo de Caracteres para senha: " + obj.MinimoCaracteres);
                            return false;
                        }
                    
                    var regExp;

                    if (obj.UsaLetrasNumeros == "S")
                    {   
                        regExp = /[a-zA-Z]/g;

                        if (!regExp.test(jQuery("#Senha").val()))
                        {
                            alert("A senha precisa conter letras!");
                            return false;
                        }

                        regExp = /\d/;

                        if (!regExp.test(jQuery("#Senha").val())) {
                            alert("A senha precisa conter Números!");
                            return false;
                        }

                    }

                    if (obj.UsaMaiusculasMinusculas == "S") {
                        regExp = /[a-z]/;

                        if (!regExp.test(jQuery("#Senha").val()))
                        {
                            alert("A senha precisa conter letras Minúsculas!");
                            return false;
                        }

                        regExp = /[A-Z]/;

                        if (!regExp.test(jQuery("#Senha").val())) {
                            alert("A senha precisa conter letras Maiúsculas!");
                            return false;
                        }

                    }

                    if (obj.UsaCaracteresEspeciais == "S") {
                        regExp = /[-’/`~!#*$@_%+=.,^&(){}[\]|;:”<>?\\]/g;

                        if (!regExp.test(jQuery("#Senha").val())) {
                            alert("A senha precisa conter Caracteres Especiais!");
                            return false;
                        }

                    }
                    else
                    {
                        caracteresInvalidos = '';
                        if (jQuery("#Senha").val().indexOf('\'') > -1)
                            caracteresInvalidos = '\'';
                        if (jQuery("#Senha").val().indexOf('"') > -1) {
                            caracteresInvalidos = caracteresInvalidos + ' "';
                        }
                        if (caracteresInvalidos != '') {
                            alert("Campo Senha com caracteres inválidos: " + caracteresInvalidos);
                            return false;
                        }
                    }

                       
                }
           
		    }
			
            try {

                jQuery('#msg-err').html('');
                jQuery('#msg-err').removeClass('msg-err');


                var param = new Array();
                param[0] = "modulo=home";
                param[1] = "acao=buscarPessoaTermoConsentimento";
                param[2] = "CPF=" + jQuery('#Cpf').val();

                objPessoa = pessoaUtil.jsonAjax.get('index.php', param);

                if (objPessoa == null) {
                    pessoaUtil.Form = form;
                    var params = new Array();
                    params[0] = "modulo=home";
                    params[1] = "acao=buscarTermoHtml";
                    objTermoHtml = pessoaUtil.jsonAjax.post('index.php', params);
                    if (objTermoHtml.trim() != "") {
                        pessoaUtil.MostraPopupTermoConsentimento(objTermoHtml);
                    }
                    else
                    {
                        pessoaUtil.AceitaTermo();
                    }                      
                }
                else {
                    alert("CPF informado já cadastrado no sistema.");
                    return false;
                }        
			} catch (e) {
				alert(e);
			}
			return false;
		}
	}

}
var pessoaUtil = new pessoa.Pessoa();