var curriculoWeb = {

    CurriculoWebUtil: function () {
        this.html = "<div id=\"myModal\" style=\"display: block;\" class=\"modal\"><div class=\"modal-content\"><div class=\"menupopup\"><h1 style=\"font-size: 12px; padding: 0 8px\">Termo de Consentimento</h1></div><div class=\"modal-body\">#TextoHtml</div><div class=\"modal-footer\"><button id=\"botaoFechar\"  onclick=\"curriculoWebUtil.FecharTermo()\" class=\"menupopupbotao\">Fechar</button></div></div></div>";
        this.reEmail3 = /^[\w-]+(\.[\w-]+)*@(([A-Za-z\d][A-Za-z\d-]{0,61}[A-Za-z\d]\.)+[A-Za-z]{2,6}|\[\d{1,3}(\.\d{1,3}){3}\])$/;
        this.bf2Ajax = new bf2.Ajax();
        this.bf2JsonAjax = new bf2.JSONAjax();
        this.camposAlterados = new Array();
        this.camposRemovidos = new Array();
        this.minimo = Date.parseExact("01/01/1900", "dd/MM/yyyy");  

        this.TermoConsentimento = function () {

            var params = new Array();
            params[0] = "modulo=home";
            params[1] = "acao=buscarTermoHtml";
            objTermoHtml = curriculoWebUtil.bf2JsonAjax.get('index.php', params);
            curriculoWebUtil.MostraPopupTermoConsentimento(objTermoHtml);

        }

        this.FecharTermo = function () {
            document.getElementById("alerta").innerHTML = "";
        }

        this.MostraPopupTermoConsentimento = function (termo) {

            var textoTermo = curriculoWebUtil.html.replace("#TextoHtml", termo);
            document.getElementById("alerta").innerHTML = textoTermo;
        }

        this.addCampoAlterado = function (field, value) {
            this.camposAlterados[this.camposAlterados.length] = field + "="
                + value;
        }

        this.buscarCidadesPorUF = function (nomeComboUF, nomeComboCidade) {
            var params = new Array();
            params[0] = 'modulo=pessoa';
            params[1] = 'acao=buscarCidadesPorUF';
            params[2] = "UF=" + jQuery("#" + nomeComboUF).val();

            obj = this.bf2JsonAjax.post('index.php', params);
            jQuery("#" + nomeComboCidade + " option:not(option:first)").remove();

            var i = 0;
            while (i < obj.length) {
                jQuery("#" + nomeComboCidade).append('<option value="' + obj[i].Cidade + '">' + obj[i].Descricao80 + '</option');
                i++;
            }
        }

        this.habilitar = function () {
            if (document.getElementById('PossuiPIS').checked) {

                document.getElementById('PIS').removeAttribute("disabled");
                document.getElementById('DataPIS').removeAttribute("disabled");
            }
            else {
                document.getElementById('PIS').setAttribute("disabled", "disabled");
                document.getElementById('DataPIS').setAttribute("disabled", "disabled");
            }
        }

        this.deleteCampoAlterado = function (field, value) {
            idx = this.camposAlterados.indexOf(field + "=" + value);
            if (idx != -1)
                this.camposAlterados.splice(idx, 1);
            else
                this.camposRemovidos[this.camposRemovidos.length] = "remove"
                    + field + "=" + value;
        }

        this.getTamanhoCampoAlterado = function () {
            return this.camposAlterados.length;
        }

        this.getCamposAlterados = function (index) {
            return this.camposAlterados[index];
        }

        this.resetCamposAlterados = function () {
            this.camposRemovidos = new Array();
            return this.camposAlterados = new Array();
        }

        this.redirect = function (link) {
            document.location.href = bf2.baseUrl + link;
        }

        this.init = function () {
            jQuery('a[rel=lightbox[]]')
                .lightBox(
                    {
                        imageLoading: 'bf2Util/lib/jquery/lightbox-0.5/images/lightbox-ico-loading.gif',
                        imageBtnPrev: 'bf2Util/lib/jquery/lightbox-0.5/images/lightbox-btn-prev.gif',
                        imageBtnNext: 'bf2Util/lib/jquery/lightbox-0.5/images/lightbox-btn-next.gif',
                        imageBtnClose: 'bf2Util/lib/jquery/lightbox-0.5/images/lightbox-btn-close.gif',
                        txtImage: "Imagem",
                        txtOf: "de"
                    });
        }

        this.openInicial = function () {
            location.href = '?modulo=home&acao=inicial';
        };

        this.openInicialConsulta = function () {
            location.href = '?modulo=entradaConsulta&acao=inicial';
        };

        this.openEntradaConsulta = function () {
            location.href = '?modulo=entradaConsulta&acao=entradaConsulta';
        };

        this.openMenu = function (options) {
            var ajax = new bf2.Ajax();

            var param = new Array();
            param[0] = "modulo=" + options.modulo;
            param[1] = "entidade=" + options.entidade;

            ajax.post("index.php", param, function (h) {
                bf2.Util.element('mainPanel').innerHTML = h;
                bf2.Util.evalScripts('mainPanel');
            });
        };

        this.esqueceuSenha = function () {
            var ajax = new bf2.Ajax();

            var param = new Array();

            if (jQuery("#cpf").val() != "") {
                param[0] = "modulo=login";
                param[1] = "acao=esqueceuSenha";
                param[2] = "cpf=" + jQuery("#cpf").val();

                ajax.post("index.php", param, function (h) {
                    if (h == "1" || h == true)
                        alert("Sua senha foi enviada por e-mail!");
                    else
                        alert(h);
                });
            } else {
                alert("Favor informar o seu CPF.");
                jQuery("#cpf").focus();
                return false;
            }
        };

        this.avancar = function (options) {
            var ajax = new bf2.Ajax();

            var param = this.camposAlterados;

            param[param.length] = "modulo=" + options.modulo;
            param[param.length] = "entidade=" + options.entidade;

            // Verificar quais campos tiveram valor alterado e serao passados
            // por parametro..

            ajax.post("index.php", param, function (html) {
                bf2.Util.element('mainPanel').innerHTML = html;
                bf2.Util.evalScripts('mainPanel');
            });
        }


        this.salvar = function (options) {
            var ajax = new bf2.Ajax();
            var param = new Array();

            param = param.concat(this.camposAlterados);
            param = param.concat(this.camposRemovidos);
            param[param.length] = "modulo=" + options.modulo;
            param[param.length] = "entidade=" + options.entidade;
            param[param.length] = "acao=salvar";
            if (options.evaluateValueHidden) {

                // jQuery("div#listagem-campos").getChildrens();
                jQuery.each(jQuery("#listagem-campos").children(), function () {
                    if (this.type == "hidden") {
                        // if (v != ""){
                        param[param.length] = this.name + "=" + this.value;

                    }
                });
            }

        

            ajax.post("index.php", param, function (o) {
                curriculoWebUtil.resetCamposAlterados();
            });

            setTimeout(function () {
                var ajaxPessoa = new bf2.Ajax();
                var param = new Array();
                param[param.length] = "modulo=pessoa";
                param[param.length] = "acao=salvar";
                ajaxPessoa.post("index.php", param, function (o) {
                });
            }, 20);

        }

        this.concluido = function () {
            var ajax = new bf2.Ajax();
            var param = new Array();

            param[param.length] = "modulo=meucurriculo";
            param[param.length] = "acao=enviarconcluido";

            var h = ajax.post("index.php", param);

			/*
			 * var param = new Array(); param[param.length] = "modulo=email";
			 * param[param.length] = "acao=enviarConcluido"; var h =
			 * ajax.post("index.php", param);
			 */
            // Verificar quais campos tiveram valor alterado e serao passados
            // por parametro..
            var conteudo = ajax.get('site/web/MeuCurriculo/concluido.php');

            bf2.Util.element('mainPanel').innerHTML = conteudo;
            bf2.Util.evalScripts('mainPanel');
        }

        this.sair = function (options) {
            var ajax = new bf2.Ajax();

            var param = new Array();
            param[0] = "modulo=" + options.modulo;
            param[1] = "entidade=" + options.entidade;

            obj = this.bf2JsonAjax.post('index.php', param);
            if (obj.ExisteCampos) {
                var ajax = new bf2.Ajax();
                var conteudo = ajax.get('site/web/MeuCurriculo/sair.php');

                bf2.Util.element('mainPanel').innerHTML = conteudo;
                bf2.Util.evalScripts('mainPanel');
            }
            else
                loginUtil.logout();
        }


        this.baixarAnexo = function (options) {
            var ajax = new bf2.Ajax();
            var param = new Array();

            param[param.length] = "modulo=upload";
            param[param.length] = "acao=baixarAnexo";

            ajax.post("index.php", param);
        }

        this.removerAnexo = function (options) {
            var ajax = new bf2.Ajax();
            var param = new Array();

            param[param.length] = "modulo=upload";
            param[param.length] = "acao=removerAnexo";

            ajax.post("index.php", param);

            jQuery("#ArquivoBlob").val("");

            setTimeout(function () {
                var ajaxPessoa = new bf2.Ajax();
                var param = new Array();
                param[param.length] = "modulo=pessoa";
                param[param.length] = "acao=salvar";
                ajaxPessoa.post("index.php", param, function (o) {
                });
            }, 20);

        }

        this.registrarCandidatura = function (options) {
            var ajax = new bf2.Ajax();
            var param = new Array();

            param[param.length] = "modulo=vagas";
            param[param.length] = "acao=registrar";
            param[param.length] = "requisicao=" + options.requisicao;

            ajax.post("index.php", param, function (h) {
                alert(h);
            });

            jQuery("#botao-registrar").css('display', 'none');
            jQuery("#div-registrado").css('display', 'block');

            setTimeout(function () {
                var ajaxPessoa = new bf2.Ajax();
                var param = new Array();
                param[param.length] = "modulo=pessoa";
                param[param.length] = "acao=salvar";
                ajaxPessoa.post("index.php", param, function (o) {
                });
            }, 20);

        }

        this.removerCandidatura = function (options) {

            if (confirm("Deseja realmente excluir candidatura nesta vaga?")) {
                var ajax = new bf2.Ajax();
                var param = new Array();

                param[param.length] = "modulo=vagas";
                param[param.length] = "acao=remover";
                param[param.length] = "requisicao=" + options.requisicao;

                ajax.post("index.php", param, function (h) {
                    location.href = '?modulo=home&acao=inicial';
                });

                setTimeout(function () {
                    var ajaxPessoa = new bf2.Ajax();
                    var param = new Array();
                    param[param.length] = "modulo=pessoa";
                    param[param.length] = "acao=salvar";
                    ajaxPessoa.post("index.php", param, function (o) {
                    });
                }, 20);
            }
        }

        this.validaFormularioContato = function (form) {
            if (form.nome.value == "") {
                alert("Favor preencher seu nome.");
                form.nome.focus();
                return false;
            } else if (form.email.value == "") {
                alert("Favor preencher seu e-mail.");
                form.email.focus();
                return false;
            } else if (!reEmail3.test(form.email.value)) {
                alert("Favor preencher o e-mail corretamente.");
                form.email.focus();
                return false;
            } else if (form.mensagem.value == "") {
                alert("Favor preecher o campo mensagem.");
                form.mensagem.focus();
                return false;
            }
            return true;
        }

        this.verificaConteudoVazio = function (obj, texto) {
            if (obj.value == texto) {
                obj.value = "";
            }
        }

        this.verificaConteudoCheio = function (obj, texto) {
            if (obj.value == "") {
                obj.value = texto;
            }
        }

        this.validaCamposNewsletter = function (form) {

            if (form.nome.value == "") {
                alert("Favor preencher seu nome.");
                form.nome.focus();
                return false;
            } else if (form.email.value == "") {
                alert("Favor preencher seu e-mail.");
                form.email.focus();
                return false;
            } else {
                if (!reEmail3.test(form.email.value)) {
                    alert("Favor preencher o e-mail corretamente.");
                    form.email.focus();
                    return false;
                }
            }

            html = bf2Ajax.postForm(form);

            alert(html);

            form.nome.value = "";
            form.email.value = "";

            return false;
        }


        this.validarCamposInformacoesPessoais = function () {
            var validaCampos;

            if (jQuery("#Nome").val() == "") {
                alert("Favor preencher seu nome.");
                jQuery("#Nome").focus();
                return false;
            }

            if (jQuery("#Nascimento").val() == "") {
                alert("Favor preencher sua Data de Nascimento.");
                jQuery("#Nascimento").focus();
                return false;
            }
            var dataNascimento = Date.parseExact(jQuery("#Nascimento").val(), "dd/MM/yyyy");
            if (dataNascimento == null) {
                alert("Favor preencher corretamente a Data de Nascimento.");
                jQuery("#Nascimento").focus();
                return false;
            }
            if (dataNascimento.compareTo(this.minimo) < 0) {
                alert("A Data de Nascimento não pode ser anterior a "
                    + this.minimo.toString("dd/MM/yyyy") + ".");
                jQuery("#Nascimento").focus();
                return false;
            }

            if ((!$.find('[id=Sexo]')[0].checked) && (!$.find('[id=Sexo]')[1].checked)) {
                alert("Favor informar o seu Sexo.");
                Query("#Sexo").focus();
                return false;
            }
            if ($("#Nacionalidade").length) {
                if (jQuery("#Nacionalidade").val() != "10")
                {
                    if (($("#ValidadeVisto").length) && (jQuery("#ValidadeVisto").val() != ""))
                    {                        
                        var validadeVisto = Date.parseExact(jQuery("#ValidadeVisto")
                            .val(), "dd/MM/yyyy");
                        if (validadeVisto == null) {
                            alert("Favor preencher corretamente a Validade do Visto.");
                            jQuery("#ValidadeVisto").focus();
                            return false;
                        }
                        if (validadeVisto.compareTo(this.minimo) < 0) {
                            alert("A Validade do Visto não pode ser anterior a "
                                + this.minimo.toString("dd/MM/yyyy") + ".");
                            jQuery("#ValidadeVisto").focus();
                            return false;
                            }
                    }
                }
            }

            if ($("#DataRegistro").length) {
                if (jQuery("#DataRegistro").val() != '') {
                    var dataRegistro = Date.parseExact(jQuery("#DataRegistro")
                        .val(), "dd/MM/yyyy");
                    if (dataRegistro == null) {
                        alert("Favor preencher corretamente a Data de Registro.");
                        jQuery("#DataRegistro").focus();
                        return false;
                    }
                    if (dataRegistro.compareTo(this.minimo) < 0) {
                        alert("A Data de Registro não pode ser anterior a "
                            + this.minimo.toString("dd/MM/yyyy") + ".");
                        jQuery("#DataRegistro").focus();
                        return false;
                    }
                }
            }

            if ($("#ValidadeHabilitacao").length) {
                if (jQuery("#ValidadeHabilitacao").val() != '') {
                    var dataRegistro = Date.parseExact(jQuery("#ValidadeHabilitacao")
                        .val(), "dd/MM/yyyy");
                    if (dataRegistro == null) {
                        alert("Favor preencher corretamente a Validade da Carteira Nacional de Habilitação.");
                        jQuery("#ValidadeHabilitacao").focus();
                        return false;
                    }
                    if (dataRegistro.compareTo(this.minimo) < 0) {
                        alert("A Validade da Carteira Nacional de Habilitação não pode ser anterior a "
                            + this.minimo.toString("dd/MM/yyyy") + ".");
                        jQuery("#ValidadeHabilitacao").focus();
                        return false;
                    }
                }
            }

            if ($("#Email").length) {

                if (jQuery("#Email").val() == "") {
                    alert("Favor preencher seu E-mail.");
                    jQuery("#Email").focus();
                    return false;
                }

                if (jQuery("#Email").val().toLocaleLowerCase().indexOf("@") == -1) {
                    alert("Para ser um E-mail válido precisa conter o caracter '@'.");
                    jQuery("#Email").focus();
                    return false;
                   }

            }

            if ($("#PIS").length) {
                if (jQuery("#PIS").val() != "")
                {
                    if (!validarPIS())
                    {
                        alert("Dígito do PIS incorreto.");
                        jQuery("#PIS").focus();
                        return false;
                    }
                }
            }

            if ($("#Nome").length) { validaCampos = (validaTexto("Nome", "#Nome")); } else { validaCampos = true; }
            if ($("#Pai").length)  { validaCampos = (validaTexto("Pai", "#Pai")); } else { validaCampos = true; }
            if ($("#Mae").length)  { validaCampos = (validaTexto("Mãe", "#Mae")); } else { validaCampos = true; }
            if ($("#LocalNascimento").length)  { validaCampos = (validaTexto("Cidade de Nascimento", "#LocalNascimento"));}   else { validaCampos = true; }
            if ($("#AnoChegadaBrasil").length) { validaCampos = (validaTexto("Ano de Chegada Brasil", "#AnoChegadaBrasil"));} else { validaCampos = true; } 
            if ($("#Identidade").length) { validaCampos = (validaTexto("Identidade", "#Identidade")); } else { validaCampos = true; }
            if ($("#ConselhoClasse").length) { validaCampos = (validaTexto("Conselho de Classe", "#ConselhoClasse")); } else { validaCampos = true; }
            if ($("#RegistroConselho").length) { validaCampos = (validaTexto("Registro de Conselho", "#RegistroConselho")); } else { validaCampos = true; }
            if ($("#CategoriaHabilitacao").length) { validaCampos = (validaTexto("Categoria Habilitacao", "#CategoriaHabilitacao")); } else { validaCampos = true; }
            if ($("#Rua").length) { validaCampos = (validaTexto("Logradouro", "#Rua")); }  else { validaCampos = true; }
            if ($("#NroRua").length) { validaCampos = (validaTexto("Número", "#NroRua"));} else { validaCampos = true; }
            if ($("#Complemento").length) { validaCampos = (validaTexto("Complemento", "#Complemento")); } else { validaCampos = true; }
            if ($("#Bairro").length) { validaCampos = (validaTexto("Bairro", "#Bairro")); }  else { validaCampos = true; }
            if ($("#Cidade").length) { validaCampos = (validaTexto("Cidade", "#Cidade")); }  else { validaCampos = true;}
            if ($("#DDD").length) { validaCampos = (validaTexto("DDD", "#DDD")); } else { validaCampos = true; }
            if ($("#Telefone").length) { validaCampos = (validaTexto("Telefone", "#Telefone")); } else { validaCampos = true; }
            if ($("#DDDCelular").length) { validaCampos = (validaTexto("DDD Celular", "#DDDCelular"));} else { validaCampos = true;}
            if ($("#TelefoneCelular").length) { validaCampos = (validaTexto("Telefone Celular", "#TelefoneCelular")); } else { validaCampos = true; }
            if ($("#Email").length) { validaCampos = (validaTexto("Email", "#Email")); } else { validaCampos = true; }

            return validaCampos;
        }

        function validarPIS() {
            var codigo = jQuery("#PIS").val();
            var lTotal = 0, lNumDig = 0;
            if (codigo.length == 11) {
                lTotal = ((codigo.substring(0, 1) * 3) + (codigo.substring(1, 2) * 2) + (codigo.substring(2, 3) * 9) +
                    (codigo.substring(3, 4) * 8) + (codigo.substring(4, 5) * 7) + (codigo.substring(5, 6) * 6) +
                    (codigo.substring(6, 7) * 5) + (codigo.substring(7, 8) * 4) + (codigo.substring(8, 9) * 3) +
                    (codigo.substring(9, 10) * 2));
                lNumDig = (lTotal % 11);
                if (lNumDig < 2)
                    lNumDig = 0
                else
                    lNumDig = Math.abs(lNumDig - 11);
                return lNumDig == codigo.substring(10, 11);
            }
            return false;
        }

        this.validarCamposFormacao = function () {

            if ($("#Curso").length)
            {
                if (jQuery("#Curso").val() == "")
                {
                    if ($("#TipoCurso").length)
                    {
                        if (jQuery("#TipoCurso").val() != "outro") {
                            alert("Favor escolher seu curso.");
                            jQuery("#Curso").focus();
                            return false;
                        }
                    }
                }
            }

            if ($("#TipoCurso").length)
            {
                if (jQuery("#TipoCurso").val() == "outro")
                {
                    if ($("#Descricao50").length)
                    {
                        if (jQuery.trim(jQuery("#Descricao50").val()) == "")
                        {
                            alert("Favor digitar seu curso.");
                            jQuery("#Descricao50").focus();
                            return false;
                        }
                    }
                }
            }

            if ($("#Dt_Inicio").length)
            {
                if ((jQuery("#Dt_Inicio").val() != ""))
                {
                    var dataIni = Date.parseExact(jQuery("#Dt_Inicio").val(),
                        "dd/MM/yyyy");
                    if (dataIni == null) {
                        alert("Favor preencher corretamente a Data de Início.");
                        jQuery("#Dt_Inicio").focus();
                        return false;
                    }
                    if (dataIni.compareTo(this.minimo) < 0) {
                        alert("A Data de Início não pode ser anterior a "
                            + this.minimo.toString("dd/MM/yyyy") + ".");
                        jQuery("#Dt_Inicio").focus();
                        return false;
                    }
                }
                    
            }

            if ($("#Dt_Encerra").length)
            {
                if (jQuery("#Dt_Encerra").val() != "") {

                    var dataIni = Date.parseExact(jQuery("#Dt_Inicio").val(),
                        "dd/MM/yyyy");

                    var dataFim = Date.parseExact(jQuery("#Dt_Encerra").val(),
                        "dd/MM/yyyy");
                    if (dataFim == null) {
                        alert("Favor preencher corretamente a Data de Encerramento.");
                        jQuery("#Dt_Encerra").focus();
                        return false;
                    }
                    if (dataFim.compareTo(this.minimo) < 0) {
                        alert("A Data de Encerramento não pode ser anterior a "
                            + this.minimo.toString("dd/MM/yyyy") + ".");
                        jQuery("#Dt_Encerra").focus();
                        return false;
                    }

                    if (jQuery("#Dt_Encerra").val() != "") {
                        if (dataFim != null && dataIni.compareTo(dataFim) > 0) {
                            alert("A Data de Início deve ser menor que a Data de Encerramento.");
                            jQuery("#Dt_Inicio").focus();
                            return false;
                        }
                    }  
                }

            }

            // Nas informações adicionais, os campos são adicionados conforme configuração, não podendo ser fixo
            var nodes = document.getElementsByClassName("listagem-campos");
            var textoValido = true;
            var i = 0;
            while ((i < nodes.length) && (textoValido)) {
                var elem = document.getElementById(nodes[i].id);
                var validouCampo = false;
                j = 0;
                while ((j < nodes[i].children.length) && (!validouCampo)) {
                    if (nodes[i].children[j].className == "campo") {
                        if ($("#" + nodes[i].children[j].id).length)
                            textoValido = (validaTexto(nodes[i].innerText, "#" + nodes[i].children[j].id))
                        else
                            textoValido = true;
                        validouCampo = true;
                    }
                    j++;
                }
                i++;
            }
            return textoValido;
        }

        this.validarCamposExperienciaProfissional = function () {
            var validaCampos;

            if (jQuery("#EmpresaAnterior").val() == "") {
                alert("Favor preencher o campo Empresa.");
                jQuery("#EmpresaAnterior").focus();
                return false;
            }
            if (jQuery("#DataAdmissao").val() == "") {
                alert("Favor preencher sua Data de Admissão.");
                jQuery("#DataAdmissao").focus();
                return false;
            }
            if (jQuery("#DataAdmissao").val() != "" || jQuery("#DataRescisao").val() != "") {
                var dataAdmissao = Date.parseExact(jQuery("#DataAdmissao")
                    .val(), "dd/MM/yyyy");

                if (dataAdmissao == null) {
                    alert("Favor preencher corretamente a Data de Admissão.");
                    jQuery("#DataAdmissao").focus();
                    return false;
                }

                if (dataAdmissao.compareTo(this.minimo) < 0) {
                    alert("A Data de Admissão não pode ser anterior a "
                        + this.minimo.toString("dd/MM/yyyy") + ".");
                    jQuery("#DataAdmissao").focus();
                    return false;
                }

				/* Esta implementação foi modificada para que faça as validações de Data na Data de Rescisão sempre que estiver preenchida
				   mesmo que se trate da Empresa Atual, isto se faz necessário para evitar inconsistências que travam o registro da Experiência */
                if (!jQuery("#DataRescisao").val() == "") {
                    var dataRescisao = Date.parseExact(jQuery("#DataRescisao").val(), "dd/MM/yyyy");

                    if (dataRescisao == null) {
                        alert("Favor preencher corretamente a Data de Rescisão.");
                        jQuery("#DataRescisao").focus();
                        return false;
                    }

                    if (dataRescisao.compareTo(this.minimo) < 0) {
                        alert("A Data de Rescisão não pode ser anterior a " + this.minimo.toString("dd/MM/yyyy") + ".");
                        jQuery("#DataRescisao").focus();
                        return false;
                    }

                    if (dataAdmissao.compareTo(dataRescisao) > 0) {
                        alert("A Data de Admissão deve ser menor que a Data de Rescisão.");
                        jQuery("#DataAdmissao").focus();
                        return false;
                    }

                }

                //Se Não for a Empresa Atual, a Data de Rescisão deverá ser preenchida.
                if (!jQuery("#EstaTrabalhando").is(':checked')) {
                    if (jQuery("#DataRescisao").val() == "") {
                        alert("Favor preencher a Data de Rescisão.");
                        Query("#DataRescisao").focus();
                        return false;
                    }
                }
            }

            if ($("#Observacoes").length) {
                return validaCampos = ((validaTexto("Observações", "#Observacoes")) &&
                                (validaTexto("Empresa", "#EmpresaAnterior")) &&
                                (validaTexto("Anos 1", "#AnosCasa1")) &&
                                (validaTexto("Meses 1", "#MesesCasa1")) &&
                                (validaTexto("Anos 2", "#AnosCasa2")) &&
                                (validaTexto("Meses 2", "#MesesCasa2")) &&
                                (validaTexto("Anos 3", "#AnosCasa3")) &&
                                (validaTexto("Meses 3", "#MesesCasa3")));
            } else
            {
                return validaCampos = ((validaTexto("Empresa", "#EmpresaAnterior")) &&
                                (validaTexto("Anos 1", "#AnosCasa1")) &&
                                (validaTexto("Meses 1", "#MesesCasa1")) &&
                                (validaTexto("Anos 2", "#AnosCasa2")) &&
                                (validaTexto("Meses 2", "#MesesCasa2")) &&
                                (validaTexto("Anos 3", "#AnosCasa3")) &&
                                (validaTexto("Meses 3", "#MesesCasa3")));
            }
        }
        this.validarCamposDadosComplementar = function () {
            var i = 0;
            var data;
            for (i = 1; i <= 9; i++) {
                var campo = document.getElementById("DTA" + i);
                if (campo != null && jQuery("#DTA" + i).val() != "") {
                    data = Date.parseExact(jQuery("#DTA" + i).val(),
                        "dd/MM/yyyy");
                    if (data == null) {
                        alert("Favor preencher corretamente o campo '"
                            + document.getElementById("DTA" + i + "_desc").innerHTML
                            + "'");
                        jQuery("#DTA" + i).focus();
                        return false;
                    }
                    if (data.compareTo(this.minimo) < 0) {
                        alert("O campo '"
                            + document.getElementById("DTA" + i + "_desc").innerHTML
                            + "' não pode ser anterior a "
                            + this.minimo.toString("dd/MM/yyyy") + ".");
                        jQuery("#DTA" + i).focus();
                        return false;
                    }
                }
            }

            // Nas informações adicionais, os campos são adicionados conforme configuração, não podendo ser fixo
            var nodes = document.getElementsByClassName("listagem-campos");
            var textoValido = true;
            var i = 0;
            while ((i < nodes.length) && (textoValido)) {
                var elem = document.getElementById(nodes[i].id);
                var validouCampo = false;
                j = 0;
                while ((j < nodes[i].children.length) && (!validouCampo)) {
                    if (nodes[i].children[j].className == "campo") {
                        textoValido = (validaTexto(nodes[i].innerText, "#" + nodes[i].children[j].id));
                        validouCampo = true;
                    }
                    j++;
                }
                i++;
            }
            return textoValido;
        }

        this.validarCamposObrigatorios = function (ArrayCampos) {

            var params = new Array();

            params[0] = 'modulo=upload';
            params[1] = 'acao=ValidaFezUploadFoto';

            var possuiImagemUpload = this.bf2Ajax.get('index.php', params); 

            for (i = 0; i <= ArrayCampos.length - 1; i++) {
                if ((ArrayCampos[i].Nome == "Foto")) {
                    if (!(possuiImagemUpload)) {
                        alert("Favor preencher o campo '" + ArrayCampos[i].Descricao + "'sss.");
                        jQuery("#" + ArrayCampos[i].Nome).focus();
                        return false;
                    }
                }
                else
                if ((ArrayCampos[i].Nome == "ArquivoBlob"))
                {
                    if (jQuery("#" + ArrayCampos[i].Nome).val() == "")
                    {
                        alert("Favor preencher o campo '" + ArrayCampos[i].Descricao + "'.");
                        jQuery("#" + ArrayCampos[i].Nome).focus();
                        return false;
                    }
                }
                else
                if ((jQuery("#" + ArrayCampos[i].Nome).val() == "" || jQuery("#" + ArrayCampos[i].Nome).val() == "0,00")
                    && !(jQuery("#" + ArrayCampos[i].Nome).attr('disabled'))) {
                    if (((ArrayCampos[i].Nome == "PIS" || ArrayCampos[i].Nome == "DataPIS") && (jQuery("#PossuiPIS").val() == "S")) ||
                        (ArrayCampos[i].Nome != "PIS" && ArrayCampos[i].Nome != "DataPIS")) {
                        alert("Favor preencher o campo '" + ArrayCampos[i].Descricao + "'.");
                        jQuery("#" + ArrayCampos[i].Nome).focus();
                        return false;
                    }
                }
            }
            return true;
        }
        this.validaCheckInteresses = function (diretrizInteresses) {
            if (diretrizInteresses == 2) {
                var check = document.getElementsByName("areasInteresse[]");
                var temCheckMarcado = false;
                for (var i = 0; i < check.length; i++) {
                    if (check[i].checked == true) {
                        temCheckMarcado = true;
                        break;
                    }
                }
                if (!temCheckMarcado) {
                    alert("Selecione ao menos um interesse profissional.");
                    return false;
                }
                else {
                    return true;
                }

            }
            else {
                return true;
            }

        }

        function validaTexto(labelCampo, nomeCampo) {
            var texto = jQuery(nomeCampo).val();
            var caracteresInvalidos = '';
            if (texto.indexOf('\'') > -1)
                caracteresInvalidos = '\'';
            if (texto.indexOf('"') > -1) {
                caracteresInvalidos = caracteresInvalidos + ' "';
            }
            if (caracteresInvalidos != '') {
                alert("Campo " + labelCampo + " com caracteres inválidos: " + caracteresInvalidos);
                jQuery(nomeCampo).focus();
                return false;
            }
            else
                return true;
        }

        this.carregaAnexoCandidato = function () {
            curriculoWebUtil.openMenu({ modulo: 'pessoa', entidade: 'informacoesPessoais' });    

            var params = new Array();

            params[0] = 'modulo=anexo';
            params[1] = 'acao=nomeAnexo';

            var obj = this.bf2Ajax.post('index.php', params);
            jQuery("#ArquivoBlob").val(obj);
        }

        this.MostrarSolicitarExclusao = function () {
                var ajax = new bf2.Ajax();

                var param = new Array();
                param[param.length] = "modulo=pessoa";
                param[param.length] = "acao=MostrarSolicitarExclusao";

                var h = ajax.post("index.php", param);

                bf2.Util.element('mainPanel').innerHTML = h;
                bf2.Util.evalScripts('mainPanel');
        }

        this.salvarExclusao = function () {

            if (confirm("Deseja solicitar a exclusão dos dados do currículo?")) {

                    var ajax = new bf2.Ajax();
                    var param = new Array();
                    param[0] = "modulo=pessoa";
                    param[1] = "acao=setExcluir";
                    param[2] = "CPF=" + jQuery('#cpf').val();

                ajax.post("index.php", param, function (o) {
                    if (o == "1") {
                        location.href = bf2.baseUrl;
                    }
                    else
                        if (o == "2") {
                            curriculoWebUtil.openInicial();
                        }
                        else {
                            alert("Ocorreu um erro ao solicitar a exclusão do currículo. Tente novamente.");
                        }});
              
                }
            }
        }
    }

var curriculoWebUtil = new curriculoWeb.CurriculoWebUtil();