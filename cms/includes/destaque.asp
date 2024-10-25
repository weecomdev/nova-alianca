<%
'Id = Trim(Request.Form("Id"))
'Tipo = Trim(Request.Form("Tipo"))

Set RS = Server.CreateObject("Adodb.recordset")
	
	'Alterar campo destaque	do item selecionado
	SQL = "SELECT * FROM " & Tipo & " WHERE id" & Tipo & " LIKE '" & Id & "'"
	RS.Open SQL,Conn,3,2

		If RS("destaque") = True Then 
			ver = False
		Else
			ver = True
		End If
		
		RS("destaque") = ver
		RS.update
	
	RS.close
	
	'Adicinar ou remover item da tabela de destaques
	
	If ver = True Then
		'Adicionar
		SQL = "SELECT * FROM destaque;"
		RS.Open SQL,Conn,3,2
		
			RS.addnew
		
			RS("tipo") = Tipo
			RS("url") = Id
			RS("post") = Now()
			
			RS.update
	
		RS.Close
	
	Else
		'Remover
		SQL = "SELECT * FROM destaque WHERE url LIKE '" & Id & "' AND tipo LIKE '" & Tipo & "';"
		RS.Open SQL,Conn,3,2
		
			If Not RS.EOF Then
				RS.Delete
			End If
	
		RS.Close
	
	End If

Set RS = nothing

Conn.close
Set Conn = nothing
%>
