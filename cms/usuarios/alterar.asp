<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Set edit = new cmsEngine

	edit.Tabela = "usuario"
	edit.Id = Session("userId")
	edit.Campos = Array("login","senha","nome","email")
	edit.Valores = Array( Request.Form("login"), Request.Form("senha"), Request.Form("nome"), Request.Form("email") )
	
	edit.Editar
	
Set edit = Nothing

Session("userNome") = Nome

Response.Redirect("editar.asp?Msg=Dados alterados")
%>