<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<%

	call openAjax("xml")

	call connOpen

		SQL = "SELECT loja.*, COUNT(loja_id) AS loja_total, cep_cidade.*, cep_estado.cep_estado_uf " &_
			  "FROM (cep_cidade INNER JOIN cep_estado ON cep_cidade.cep_estado_id = cep_estado.cep_estado_id) " &_
			  "INNER JOIN loja ON cep_cidade.cep_cidade_id = loja.cep_cidade_id " &_
			  "WHERE cep_estado.cep_estado_uf = '" & Trim(Request.QueryString("UF")) & "';"
		
		RS.Open SQL,Conn

			If Not RS.EOF Then			
			
				Response.Write "<cidades>"
				
				Do While Not RS.EOF
					
					Response.Write "<cidade id='" & RS("cep_cidade_id") & "' total='" & RS("loja_total") & "'>"
					Response.Write RS("cep_cidade_nome") & " - " & RS("cep_estado_uf")
					Response.Write "</cidade>"
		
					RS.MoveNext
					
				Loop
				
				Response.Write "</cidades>"
							
			End If
				
		RS.Close

	call connClose
		
%>