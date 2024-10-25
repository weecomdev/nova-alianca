<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<!--#include file="../functions/classConteudo.asp" -->

<%

'==============================================================================================================================='
' Listar cidades

	Sub montaCidade()

		Response.Write "<h1>Compre em sua cidade</h1>"
		
    	Response.Write "<fieldset>"
    	Response.Write "<legend>Escolha um dos estados.</legend>"

		call connOpen()
	
			SQL = "SELECT loja.*, COUNT(loja_id) AS loja_total, cep_estado.*" &_
				  "FROM (cep_cidade INNER JOIN cep_estado ON cep_cidade.cep_estado_id = cep_estado.cep_estado_id) " &_
				  "INNER JOIN loja ON cep_cidade.cep_cidade_id = loja.cep_cidade_id GROUP BY loja.cep_cidade_id;"
			
			RS.Open SQL,Conn
	
				If Not RS.EOF Then			
				
					Response.Write "<select name='estado' onchange='ondeBusca(this.value)'>"
					
					Do While Not RS.EOF
						
						Response.Write "<option value='" & RS("cep_estado_uf") & "'>"
						Response.Write RS("cep_estado_nome") & " (" & RS("loja_total") & ")"
						Response.Write "</option>"
						
						RS.MoveNext
					
					Loop
					
					Response.Write "</select>"
								
				End If
					
			RS.Close
	
		call connClose()

    	Response.Write "</fieldset>"
	
	End Sub
	
'==============================================================================================================================='
' Exibir lojas

	Sub montaLoja(cidade)
	
		Response.Write "<h1>Compre em sua cidade</h1>"
		
		call connOpen()
	
			SQL = "SELECT * FROM loja WHERE cep_cidade_id = " & cidade & ";"
			
			RS.Open SQL,Conn
	
				If RS.EOF Then
				
					Response.Write "<p>Não há informações disponíveis</p>"
				
				Else
				
					Response.Write "<dl>"
					
					Do While Not RS.EOF
						
						Response.Write "<dt>" & RS("loja_nome") & "</dt>"
						Response.Write "<dd>"

						If checkImg("../imagens/loja/" & cStr(RS("loja_id")) & ".jpg") Then
							Response.Write "<img src='../imagens/loja/" & cStr(RS("loja_id")) & ".jpg' alt='" & RS("loja_nome") & "' />"
						End If

						Response.Write RS("loja_endereco") & "<br />"
						Response.Write "<strong>Fone:</strong> " & RS("loja_fone") & "<br />"
						Response.Write "<strong>E-mail:</strong> <a href='" & RS("loja_email") & "'>" & RS("loja_email") & "</a>"
						Response.Write "<p>" & RS("loja_desc") & "</p>"
						Response.Write "</dd>"
						
						RS.MoveNext
					
					Loop
					
					Response.Write "</dl>"
								
				End If
					
			RS.Close
	
		call connClose()

	End Sub

'==============================================================================================================================='

	Set Pagina = New Conteudo
	
		If Pagina.Id = 0 Then
			Pagina.imgEngine
			call montaCidade
		Else
			call montaLoja(Pagina.Id)
		End If

	Set Pagina = Nothing
	
%>

