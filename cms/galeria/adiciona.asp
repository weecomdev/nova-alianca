<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Set add = new cmsEngine

	add.Tabela = "galeria"
	add.Campos = Array("nome", "post")
	add.Valores = Array(Request.Form("nome"), Tempo(Now()))
	
	add.Adicionar
	
	novoId = add.novoId
	
Set add = Nothing

'============================================================================='

Set fso = CreateObject("Scripting.FileSystemObject")

	fso.CreateFolder(Server.MapPath("../../imagens/galeria/" & novoId))
	fso.CreateFolder(Server.MapPath("../../imagens/galeria/" & novoId & "/fotos"))
	fso.CreateFolder(Server.MapPath("../../imagens/galeria/" & novoId & "/thumbs"))

Set fso = Nothing

'============================================================================='

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>


