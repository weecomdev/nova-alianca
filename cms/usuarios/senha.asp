<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<%

Set RS = Server.CreateObject("Adodb.recordset")
	SQL = "SELECT * FROM usuario WHERE usuario_email='" & Trim(Request.Form("Email")) & "';"
	RS.Open SQL,Conn,3,2
	
		If RS.EOF Then
			Response.Redirect "login.asp?F=2&Msg=E-mail não cadastrado"
		Else
		
			BodyMail = "login: " & RS("usuario_login") & "<br>senha: " & RS("usuario_senha")
		
			Set Mail = Server.CreateObject("Persits.MailSender") 
			
				Mail.Host = "smtp-web.kinghost.net"
			
				Mail.From = RS("usuario_email")
				Mail.FromName = "Painel Administrativo" 
		
				Mail.AddAddress RS("usuario_email"), RS("usuario_nome")
				
				Mail.isHTML = True
				
				Mail.Subject = "Painel Administrativo - Recuperar senha"
				Mail.Body = BodyMail
				
				Mail.CharSet = "iso-8859-1"
				
				Mail.Send
			
			Set Mail = Nothing 
			
		End If
	
	
	RS.Close
Set RS = nothing

Conn.Close
Set Conn = nothing

Response.Redirect "login.asp?F=2&Msg=Senha enviada"
%>