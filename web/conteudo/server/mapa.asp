<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<%

	call connOpen

'		SQL = "SELECT representante.*, COUNT(representante_id) AS representante_total, cep_estado.cep_estado_uf AS representante_uf " &_
'			  "FROM (cep_cidade INNER JOIN cep_estado ON cep_cidade.cep_estado_id = cep_estado.cep_estado_id) " &_
'			  "INNER JOIN representante ON cep_cidade.cep_cidade_id = representante.cep_cidade_id GROUP BY representante.cep_cidade_id;"

		SQL = "SELECT representante_local.*, COUNT(representante_id) AS representante_total, cep_estado.*, cep_cidade.*" &_
			  "FROM (cep_cidade INNER JOIN cep_estado ON cep_cidade.cep_estado_id = cep_estado.cep_estado_id) " &_
			  "INNER JOIN representante_local ON cep_cidade.cep_cidade_id = representante_local.cep_cidade_id " &_
			  "GROUP BY cep_estado.cep_estado_id"
		
		RS.Open SQL,Conn

			If Not RS.EOF Then			
			
				Response.Write "&estado="
				
				Do While Not RS.EOF
					
					Response.Write lCase(RS("cep_estado_uf"))
		
					RS.MoveNext
					
					If Not RS.EOF Then
						Response.Write "#"
					End If
									
				Loop
				
				Response.Write "&"
							
			End If
				
		RS.Close

	call connClose


%>