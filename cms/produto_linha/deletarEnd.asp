<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<!--#include file="../includes/engines/functions.asp" -->
<%

catId = Trim(Request.QueryString("Id"))
newId = Trim(Request.Form("categoria"))
Manejo = Trim(Request.Form("manejo"))

'DELETA CATEGORIA DESEJADA
Set del = new cmsEngine

	del.Tabela = "produto_linha"
	del.Id = catId
	
	del.Deletar
	del.Ordenar "refazer"
	
	call delArquivo("../../imagens/produto_linha/" & catId & ".jpg")
	
Set del = Nothing

'DELETA CATEGORIA DESEJADA
Set RS=Server.CreateObject("Adodb.recordset")
Set delRS=Server.CreateObject("Adodb.recordset")

If Manejo = "OK" Then
	'DELETA SUB-CATEGORIAS DA CATEGORIA SELECIONADA
	If newId = 0 Then
	
		SQL = "SELECT * FROM produto_tipo WHERE produto_linha_id LIKE '" & catId & "';"
		RS.Open SQL,Conn,3,2
		
			If Not RS.EOF Then
				
				Do While Not RS.EOF

					'deleta produtos relativos à linha	
					'-------------------------------------------------------------------------------------------------'	
						delSQL = "SELECT * FROM produto WHERE produto_tipo_id = " & RS("produto_tipo_id") & ";"
						delRS.Open delSQL,Conn,3,2
						
							If Not delRS.EOF Then
								
								Do While Not delRS.EOF
									
									call delArquivo("../../imagens/produto/" & delRS("produto_id") & ".jpg")
									call delArquivo("../../imagens/produto/thumb_" & delRS("produto_id") & ".jpg")
								
									delRS.Delete
									delRS.MoveNext
									
								Loop
								
							End If
						
						delRS.Close
					'-------------------------------------------------------------------------------------------------'
				
					RS.Delete
					RS.MoveNext
					
				Loop
				
			End If
		
		RS.Close

	'REMAJEA SUB-CATEGORIAS DA CATEGORIA SELECIONADA PARA OUTRA CATEGORIA
	Else
	
		'checar ordem
		SQL = "SELECT COUNT(produto_tipo_id) AS total FROM produto_tipo WHERE produto_linha_id = " & newId & ";"
		RS.Open SQL,Conn
		
			Total = cInt(RS("total")) + 1
	
		RS.Close

		'remaneja em ordem após as existetes
		SQL = "SELECT * FROM produto_tipo WHERE produto_linha_id LIKE '" & catId & "' ORDER BY produto_tipo_ordem;"
		RS.Open SQL,Conn,3,2
		
			If Not RS.EOF Then
				
				Do While Not RS.EOF
					RS("produto_linha_id") = newId
					RS("produto_tipo_ordem") = Total
					RS.Update
					RS.MoveNext
					Total = Total + 1
				Loop
				
			End If
		
		RS.Close
	
	End If
End If

Set delRS = nothing
Set RS = nothing

Set Conn = nothing
%>
<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>