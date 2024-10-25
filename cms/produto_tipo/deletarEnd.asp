<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<!--#include file="../includes/engines/functions.asp" -->
<%

catId = Trim(Request.QueryString("Id"))
newId = Trim(Request.Form("categoria"))
Manejo = Trim(Request.Form("manejo"))

'DELETA CATEGORIA DESEJADA
Set del = new cmsEngine

	del.Tabela = "produto_tipo"
	del.Id = catId
	
	del.Deletar
	
	del.ordemFiltro = "produto_linha_id = " & Request("linha")
	del.Ordenar "refazer"
	
Set del = Nothing

Set RS=Server.CreateObject("Adodb.recordset")

If Manejo = "OK" Then

	'DELETA SUB-CATEGORIAS DA CATEGORIA SELECIONADA
	If newId = 0 Then
	
		SQL = "SELECT * FROM produto WHERE produto_tipo_id LIKE '" & catId & "';"
		RS.Open SQL,Conn,3,2
		
			If Not RS.EOF Then
				
				Do While Not RS.EOF
				
					RS.Delete
					RS.MoveNext
					
					call delArquivo("../../imagens/produto/" & Request.Form("id") & ".jpg")
					call delArquivo("../../imagens/produto/thumb_" & Request.Form("id") & ".jpg")
					
				Loop
				
			End If
		
		RS.Close
		Set RS = nothing
	
	'REMAJEA SUB-CATEGORIAS DA CATEGORIA SELECIONADA PARA OUTRA CATEGORIA
	Else
	
		SQL = "SELECT * FROM produto WHERE produto_tipo_id LIKE '" & catId & "';"
		RS.Open SQL,Conn,3,2
		
			If Not RS.EOF Then
				
				Do While Not RS.EOF
					RS("produto_tipo_id") = newId
					RS.Update
					RS.MoveNext
				Loop
				
			End If
		
		RS.Close
		Set RS = nothing
	
	End If
	
End If

	
Set Conn = nothing
%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>