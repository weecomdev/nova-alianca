<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<%
'==============================================================================================================='
'cabeçalho ajax

call openAjax("xml")

'==============================================================================================================='

'abrir conexão com o banco
call connOpen()

	'buscar imagem na tabela do painel
	SQL = "SELECT * FROM abertura ORDER BY abertura_ordem;"
	RS.Open SQL,Conn,3,2
	
		'escrever dados em XML
		Response.Write "<painel>"
		
		Do While Not RS.EOF
		
			'Abrir Imagem
			Response.Write "<imagem id=" & chr(34) & RS("abertura_id") & chr(34) & ">"

			'Descrição
			If RS("abertura_desc") <> "" Then
				Response.Write RS("abertura_desc")
			Else
				Response.Write "vazio"		
			End If
			
			'Fechar Imagem
			Response.Write "</imagem>"
			
			RS.MoveNext
		
		Loop
				
		Response.Write "</painel>"
		
call connClose

'==============================================================================================================='

%>
