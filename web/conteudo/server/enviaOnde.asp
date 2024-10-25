<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<!--#include file="../functions/classMail.asp" -->
<%

'========================================================================================================================'
' Campos do formulário

	Nome = Trim(Request.Form("nome"))
	Email = Trim(Request.Form("email"))
	Telefone = Trim(Request.Form("telefone"))
	Cidade = Trim(Request.Form("cidade"))
	Mensagem = Trim(Request.Form("mensagem"))
	
'========================================================================================================================'
' Corpo do email

	htmlMail = "<b>Pergunta via portal</b>" &_
				"<p>" &_
				"<strong>Nome:</strong> " & Nome & "<br>" &_
				"<strong>E-mail:</strong> " & Email & "<br>" &_
				"<strong>Telefone:</strong> " & Telefone & "<br>" &_
				"<strong>Cidade:</strong> " & Cidade & "<br>" &_
				"</p>" &_
				"<p><strong>Mensagem:</strong><br>" & Replace(Mensagem, vbcrlf, "</br>") & "</p>"

'========================================================================================================================'
' Buscar destino do e-mail

	call connOpen
	
		RS = Conn.Execute("SELECT * FROM formulario WHERE formulario_id = 3;")

		destinoNome = RS("formulario_nome")
		destinoMail = RS("formulario_email")
			
	call connClose

'========================================================================================================================'
' Enviar e-mail

	Set Mail = new Envio
	
		Mail.Remetente Nome, Email
		Mail.addMail destinoNome, destinoMail
		Mail.Assunto = "Vinícola Aliança - Onde comprar"
		Mail.Conteudo = htmlMail
						
	Set Mail = Nothing

'==========================================================================================='
' Redirecionar

Response.Redirect Request.ServerVariables("HTTP_REFERER") & "&Msg=OK"

%>