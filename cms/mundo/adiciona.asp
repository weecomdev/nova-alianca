<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Set add = new cmsEngine

	add.Tabela = "mundo"
	add.Adicionar
	
	novoId = add.novoId
	
	Set FSO = Server.CreateObject("Scripting.FileSystemObject")
		Set Pasta = FSO.CreateFolder(Server.MapPath("../../arquivos/mundo/" & novoId))
		Set Pasta = Nothing
	Set FSO = Nothing
	
	pastaUpload = "../../arquivos/mundo/" & novoId

	call upOpen
	
	add.Id = novoId
	add.Campos = Array("nome","desc","post")
	add.Valores = Array( Upload.Form("nome"), Upload.Form("descricao"), Tempo(Now()) )
	
	add.Editar
	
Set add = Nothing


%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
