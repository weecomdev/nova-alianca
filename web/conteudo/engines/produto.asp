<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<!--#include file="../functions/classConteudo.asp" -->

<%

'==============================================================================================================================='
' Exibir produto

	Function modeloTexto()
	
		Response.Write "<h1>" & RS("produto_nome") & "</h1>"
		call Pagina.montaImg(Pagina.Id)
		Response.Write RS("produto_desc")
		
	End Function

'==============================================================================================================================='
' Listar produtos

	Sub montaLinha()
	
		call connOpen()
		
			'Listagem das linhas que tem produtos
			SQL = "SELECT produto.*, produto_tipo.*, produto_linha.* " &_
				  "FROM (produto_tipo INNER JOIN produto_linha ON produto_tipo.produto_linha_id = produto_linha.produto_linha_id) " &_
				  "INNER JOIN produto ON produto_tipo.produto_tipo_id = produto.produto_tipo_id " &_
				  "GROUP BY produto_tipo.produto_tipo_id " &_
				  "ORDER BY produto_linha_ordem, produto_tipo_ordem;"
			
			RS.Open SQL,Conn
	
				'Caso não hajam produtos
				If RS.EOF Then
					Response.Write "<p>Não há itens disponíveis.</p>"
					
				'Caso hajam produtos
				Else
				
					'Abre Dl
					Response.Write "<dl>"
					
					'Para cada produto
					Do While Not RS.EOF
					
						'Caso seja outro tipo
						If checkTipo <> RS("produto_linha_id") Then
						
							'Escreve título, caso exista
							If RS("produto_linha_id") <> "" Then
								Response.Write "<dt onclick='listaTitulo(this)'>" & RS("produto_linha_nome") & "</dt>"
							End If
							
							'Abrir Dd com listagem
							Response.Write "<dd>"
							Response.Write "<ul>"						
						
						End If
						
						'Listar produto
						Response.Write "<li>"
						Response.Write "<a href='default.asp?Engine=produto&subEngine=tipo&Id=" & cStr(RS("produto_tipo_id")) & "'>"
						Response.Write RS("produto_tipo_nome")
						Response.Write "</a>"
						Response.Write "</li>"
						
						'Checar tipo atual
						checkTipo = RS("produto_linha_id")
				
						'Próximo registro
						RS.MoveNext
						
						'Caso não seja o último
						If Not RS.EOF Then
						
							'Caso seja outro tipo
							If checkTipo <> RS("produto_linha_id") Then
							
								'Fecha Listagem e Dd
								Response.Write "</ul>"
								Response.Write "</dd>"
							
							End If
						
						'Caso seja o último
						Else
						
							'Fecha Listagem e Dd
							Response.Write "</ul>"
							Response.Write "</dd>"
						
						End If
					
					Loop
					
					'Fecha Dl
					Response.Write "</dl>"
					
				End If
					
			RS.Close
	
		call connClose()

	End Sub
	
'==============================================================================================================================='
' Listar produtos

	Function modeloLista()
	
		Response.Write "<a href='default.asp?Engine=produto&subEngine=ver&Id=" & cStr(RS("produto_id")) & "' >"

		'Exibir thumb, caso exista
		If checkImg("../imagens/produto/thumb_" & cStr(RS("produto_id")) & ".jpg") Then
			Response.Write "<img src='../imagens/produto/thumb_" & cStr(RS("produto_id")) & ".jpg' alt='" & RS("produto_nome") & "' />"
		End If

		Response.Write RS("produto_nome")
		Response.Write "</a>"

	End Function

'==============================================================================================================================='
' Nome do tipo

	Sub nomeTipo()
	
		call connOpen()
		
			RS = Conn.Execute("SELECT produto_tipo.produto_tipo_nome, produto_linha.produto_linha_nome FROM produto_tipo INNER JOIN produto_linha ON produto_tipo.produto_linha_id = produto_linha.produto_linha_id WHERE produto_tipo_id = " & Pagina.Id & ";")
			
			Response.Write "<h1>" & RS("produto_linha_nome") & " </h1>"
			Response.Write "<h2>" & RS("produto_tipo_nome") & "</h2>"
			
		call connClose()
	
	End Sub

'==============================================================================================================================='
' Montar página

	Set Pagina = New Conteudo
	
		Select Case Pagina.subEngine
		
			Case "ver"
				Pagina.montaTexto
			Case "tipo"
				call nomeTipo()
				Pagina.listaOrdem = "produto_ordem"
				Pagina.listaFiltro = "WHERE produto_tipo_id = " & Pagina.Id
				Pagina.montaLista
			Case Else
				Pagina.imgEngine
				call montaLinha()			
								
		End Select

	Set Pagina = Nothing
	
%>

