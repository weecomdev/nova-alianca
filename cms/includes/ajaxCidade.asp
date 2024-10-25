<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="engines/functions.asp" -->
<%

	'cabeçalho XML
	Response.Expires = 0
	Response.expiresabsolute = Now() - 1
	Response.CacheControl = "no-cache"
	Response.AddHeader "Pragma", "no-cache"
	Response.Charset = "iso-8859-1"
	Response.ContentType = "text/xml"
	Response.Write "<?xml version=" & chr(34) & "1.0" & chr(34) & " encoding=" & chr(34) & "ISO-8859-1" & chr(34) & " ?>"
	
	'Listar cidades
	call connOpen

		SQL = "SELECT cep_cidade_id, cep_cidade_nome FROM cep_cidade WHERE cep_estado_id = " & Request.QueryString("UF") & ";"
		RS.Open SQL,Conn,3,2
			
			If Not RS.EOF Then			
			
				Response.Write "<cidades>"
				
				Do While Not RS.EOF
				
					Response.Write "<cidade id='" & RS("cep_cidade_id") & "'>"
					Response.Write RS("cep_cidade_nome")
					Response.Write "</cidade>"
					
					RS.MoveNext
						
				Loop
				
				Response.Write "</cidades>"
							
			End If
				
		RS.Close

	call connClose
		
%>