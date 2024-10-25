<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

call upOpen

'========================================================================================================='

If Upload.Form("tipo") <> Upload.Form("checkLinha") Then

	call connOpen
	
		SQL = "SELECT COUNT(produto_id) AS total FROM produto WHERE produto_tipo_id = " & Upload.Form("tipo") & ";"
		RS.Open SQL,Conn
		
			Total = cInt(RS("total")) + 1
	
		RS.Close
	
	call connClose
	
	arrayCampos = Array("nome", "tipo_id", "desc", "ordem")
	arrayValores = Array( Upload.Form("nome"), Upload.Form("tipo"), Upload.Form("editBox"), Total)
	
Else

	arrayCampos = Array("nome", "tipo_id", "desc")
	arrayValores = Array( Upload.Form("nome"), Upload.Form("tipo"), Upload.Form("editBox") )
	
End If

'========================================================================================================='

Set edit = new cmsEngine

	edit.Tabela = "produto"
	edit.Id = Upload.Form("id")
	edit.Campos = arrayCampos
	edit.Valores = arrayValores
	
	edit.Editar
	
Set edit = Nothing

Set img = new cmsImagem

	img.addImg 3, 940, 450, "../../imagens/produto/", Upload.Form("id")
	img.addImg 1, 150, 240, "../../imagens/produto/", "thumb_" & Upload.Form("id")
		
Set img = Nothing

%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
