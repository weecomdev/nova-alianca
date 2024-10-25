<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<%

	UF = Request.QueryString("UF")

	call openAjax("xml")

	call connOpen

		SQL = "SELECT representante_local.*, COUNT(representante_id) AS representante_total, cep_estado.*, cep_cidade.*" &_
			  "FROM (cep_cidade INNER JOIN cep_estado ON cep_cidade.cep_estado_id = cep_estado.cep_estado_id) " &_
			  "INNER JOIN representante_local ON cep_cidade.cep_cidade_id = representante_local.cep_cidade_id " &_
			  "WHERE cep_estado.cep_estado_uf = '" & UF & "' GROUP BY cep_cidade.cep_cidade_id ORDER BY cep_cidade.cep_cidade_nome;"
		
		RS.Open SQL,Conn

			If Not RS.EOF Then			
			
				Response.Write "<cidades uf=""" & UF & """>"
				
				Do While Not RS.EOF
					
					Response.Write "<cidade id='" & RS("cep_cidade_id") & "' total='" & RS("representante_total") & "'>"
					Response.Write RS("cep_cidade_nome")
					Response.Write "</cidade>"
		
					RS.MoveNext
					
				Loop
				
				Response.Write "</cidades>"
							
			End If
				
		RS.Close

	call connClose
		
%>