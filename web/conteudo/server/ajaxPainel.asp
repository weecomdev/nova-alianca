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
	SQL = "SELECT * FROM home ORDER BY home_ordem;"
	RS.Open SQL,Conn,3,2
	
		'escrever dados em XML
		Response.Write "<painel>"
		
		Do While Not RS.EOF
		
			'Abrir Imagem
			Response.Write "<imagem id=" & chr(34) & RS("home_id") & chr(34) & ">"

			'Título
			Response.Write "<titulo>"
			If RS("home_nome") <> "" Then
				Response.Write RS("home_nome")
			Else
				Response.Write "vazio"
			End If
			Response.Write "</titulo>"
			
			'Descrição
			Response.Write "<mensagem>"
			If RS("home_desc") <> "" Then
				Response.Write RS("home_desc")
			Else
				Response.Write "vazio"		
			End If
			Response.Write "</mensagem>"
			
			'Fechar Imagem
			Response.Write "</imagem>"
			
			RS.MoveNext
		
		Loop
				
		Response.Write "</painel>"
		
call connClose

'==============================================================================================================='

%>
