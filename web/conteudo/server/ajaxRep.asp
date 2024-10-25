<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<%

	Cidade = cInt(Request.QueryString("Cidade"))
	
	call openAjax("")

	call connOpen
	
		SQL = "SELECT representante.*, representante_local.*" &_
			  "FROM representante_local INNER JOIN representante ON representante.representante_id = representante_local.representante_id " &_
			  "WHERE representante_local.cep_cidade_id = " & Cidade & " ORDER BY representante.representante_nome;"
		
		RS.Open SQL,Conn
	
			If Not RS.EOF Then			
			
				Response.Write "<dl>"
				
				Do While Not RS.EOF
					
					Response.Write "<dt>" & RS("representante_nome") & "</dt>"
					Response.Write "<dd>"

					If checkImg("../../../imagens/representante/" & cStr(RS("representante_id")) & ".jpg") Then
						Response.Write "<img src='../imagens/representante/" & cStr(RS("representante_id")) & ".jpg' alt='" & RS("representante_nome") & "' />"
					End If

					Response.Write RS("representante_endereco") & "<br />"
					Response.Write "<strong>Fone:</strong> " & RS("representante_fone") & "<br />"
					
					If RS("representante_email") <> "" Then
						Response.Write "<strong>E-mail:</strong> <a href='mailto:" & RS("representante_email") & "'>" & RS("representante_email") & "</a>"
					End If
					
					Response.Write "<p>" & RS("representante_desc") & "</p>"
					Response.Write "</dd>"
		
					RS.MoveNext
					
				Loop
				
				Response.Write "</dl>"
							
			End If
				
		RS.Close
	
	call connClose
		
%>