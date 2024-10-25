<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<%
Login = Trim(Request.Form("login"))
Senha = Trim(Request.Form("senha"))

Set RS = Server.CreateObject("Adodb.recordset")
	SQL = "SELECT * FROM usuario WHERE usuario_login='" & Login & "' AND usuario_senha='" & Senha & "';"
	RS.cursorlocation = 3
	RS.Open SQL,Conn,3,2

If RS.EOF Then
	Response.Redirect "login.asp?Msg=Login ou senha incorretos"
Else
	Session("logado") = True
	Session("userId") = RS("usuario_id")
	Session("userNome") = RS("usuario_nome")
	Session("userEmail") = RS("usuario_email")
	Session("userAcesso") = RS("usuario_acesso")

'	RS("usuario_acesso") = Date()
'	RS.update
	
	Response.Redirect "../vinicola/listar.asp"
	
End If

RS.Close
set RS = nothing

Conn.Close
Set Conn = nothing
%>