<%

'==============================================================================================================================='
' CLASSE PARA GERAR CONTE�DO DO PORTAL
'==============================================================================================================================='

Class Conteudo

'-------------------------------------------------------------------------------------------------------------------------------'
'COME�O E FIM DA CLASSE

	Dim Engine, subEngine, Id, Pagina

	Sub Class_Initialize()
	
		'QueryString
		Engine = Trim(Request.QueryString("Engine"))
		subEngine = Trim(Request.QueryString("subEngine"))
		Id = cInt(Request.QueryString("Id"))
		Pagina = cInt(Request.QueryString("Pagina"))
		
		'Definir primeira p�gina
		If Pagina = 0 Then
			Pagina = 1
		End If
		
		'Padr�o m�ximo da listagem
		listaMax = 12
		
		'Padr�o de ordena��o
		listaOrdem = Engine & "_nome"
		
	End Sub
	
'-------------------------------------------------------------------------------------------------------------------------------'
'RETORNAR VALORES DAS TABELAS

	Function checkId(tipo)
	
		call connOpen()
		
			RS = Conn.Execute("SELECT " & tipo & "(" & Engine & "_id) AS valor FROM " & Engine & ";")
			checkId = cInt(RS("valor"))
			
		call connClose()
	
	End Function

	'Total de registros
	Function totalRS()
		totalRS = checkId("COUNT") 	
	End Function
	
	'Primeiro ID
	Function menorRS()
		menorRS = checkId("MIN") 	
	End Function
	
	'Total de registros
	Function maiorRS()
		maiorRS = checkId("MAX") 	
	End Function

'-------------------------------------------------------------------------------------------------------------------------------'
'FUN��O PARA INSERIR IMAGENS

	Sub montaImg(imgNome)
	
		'caminho da imagem
		imgUrl = "../imagens/" & Engine & "/" & imgNome & ".jpg"
		
		'caso exista imagem
		If checkImg(imgUrl) Then
			Response.Write "<img src='" & imgUrl & "' alt='" & Engine & "' />"
		End If
	
	End Sub

'-------------------------------------------------------------------------------------------------------------------------------'
'FUN��O PARA INSERIR PAINEL DE IMAGENS DAS SE��ES PRINCIPAIS

	Sub imgEngine()
	
		'verificar galeria
		call connOpen()
		
			SQL = "SELECT engine_galeria_id FROM engine_galeria WHERE engine_galeria_engine = '" & Engine & "';"
			
			RS.Open SQL,Conn
	
				If Not RS.EOF Then			

					engineId = cStr(RS("engine_galeria_id"))
					
					'checar n�mero de total dispon�veis
					Set FSO = CreateObject("Scripting.FileSystemObject")
						numFotos = FSO.GetFolder(Server.MapPath("../imagens/engine_galeria/" & engineId & "/fotos/")).Files.Count
					Set FSO = Nothing
				
					'caso existam imagens
					If numFotos > 0 Then
						Response.Write "<div id='painelEngine'></div>"
					End If

				End If
					
			RS.Close

		call connClose()
	
	End Sub

'-------------------------------------------------------------------------------------------------------------------------------'
' FUN��O PARA EXIBIR T�TULO

	Dim Legenda
	
	Sub montaTitulo()
	
		If Legenda <> "" Then
			Response.Write "<h1>" & Legenda & "</h1>"
		End if
	
	End Sub

'-------------------------------------------------------------------------------------------------------------------------------'
' FUN��O PARA EXIBIR TEXTO E IMAGEM

	Sub montaTexto()
	
		't�tulo da se��o
		call montaTitulo()
	
		call connOpen()
	
			SQL = "SELECT * FROM " & Engine & " WHERE " & Engine & "_id = " & Id & ";"
			
			RS.Open SQL,Conn
	
				If RS.EOF Then			
					Response.Write "<p>N�o h� informa��es dispon�veis.</p>"
				Else
					modeloTexto()				
				End If
					
			RS.Close
	
		call connClose()
		
	End Sub
	
'-------------------------------------------------------------------------------------------------------------------------------'
' FUN��O PARA LISTAR CONTE�DO

	Dim listaFiltro, listaOrdem, listaMax, listaExtra
	
	'Adicionar link extra
	Sub listaAdd(nome, link)
	
		'Cria array de links
		If Not isArray(listaExtra) Then
			Redim listaExtra(1,-1)
		End If
	
		'Redimensiona array de links
		Redim Preserve listaExtra(1, (uBound(listaExtra,2) + 1))
		
		'Insere dados do link
		listaExtra(0, uBound(listaExtra,2)) = nome
		listaExtra(1, uBound(listaExtra,2)) = link
	
	End Sub
	
	'Fun��o geral
	Sub montaLista()
	
		't�tulo da se��o
		call montaTitulo()
		
		'buscar dados no banco
		call connOpen()
			
			SQL = "SELECT * FROM " & Engine & " " & listaFiltro & " ORDER BY " & listaOrdem & ";"
			RS.cursorlocation = 3
			RS.Open SQL,Conn
	
				'caso n�o hajam registros
				If RS.EOF And Not isArray(listaExtra) Then			
				
					Response.Write "<p>N�o h� informa��es dispon�veis.</p>"
					
				'caso hajam registros
				Else
				
					'configurar pagina��o
					If Not RS.EOF Then	
						RS.PageSize = listaMax
						RS.AbsolutePage = Pagina
					End If
	
					'listar itens
					Response.Write "<ul class='listar'>"
					
						Do While Not RS.EOF And listaConta < listaMax
							
							Response.Write "<li>"
							modeloLista()
							Response.Write "</li>"
							
							RS.MoveNext
							listaConta = listaConta + 1
					
						Loop
						
						'caso existam links extras
						If isArray(listaExtra) Then
							For x = 0 To uBound(listaExtra,2)
							
								Response.Write "<li><a href='" & listaExtra(1,x) & "'>" & listaExtra(0,x) & "</a></li>"
								
							Next
						End If
					
					Response.Write "</ul>"
					
					'PAGINA��O
					If RS.RecordCount > listaMax Then
					
						Response.Write "<div id='paginar'>"
					
						'bot�o Anterior
						If Pagina > 1 Then
							Response.Write "<a id='anterior' href='default.asp?Engine=" & Engine & "&subEngine=" & subEngine & "&Pagina=" & Pagina - 1 & "'>&laquo; anterior</a>"
						End if
					
						'indice de p�ginas
						If Not RS.RecordCount <= RS.PageSize Then
							Response.Write "<small>" & Pagina & " / " & RS.pagecount & "</small>"
						End if
						
						'bot�o Pr�xima
						If Not RS.EOF Then
							If strcomp(Pagina,RS.PageCount) <> 0 then 
								Response.Write "<a id='proximo' href='default.asp?Engine=" & Engine & "&subEngine=" & subEngine & "&Pagina=" & Pagina + 1 & "'>pr�ximo &raquo;</a>"
							End if
						End If
						
						Response.Write "</div>"
					
					End If			
					
				End If
					
			RS.Close
	
		call connClose()
		
	End Sub
	
'-------------------------------------------------------------------------------------------------------------------------------'
' FUN��O PARA LISTAR ARQUIVOS

	Sub montaArquivos()
	
		Set FSO = CreateObject("Scripting.FileSystemObject")
			Set Arquivos = fso.GetFolder(Server.Mappath("../arquivos/" & Engine & "/" & Id & "/")).Files
		
				If Arquivos.Count > 0 Then
				
					Response.Write "<h3>Fa�a o download aqui:</h3>"
					Response.Write "<ul class='arquivos'>"
				
					For Each File in Arquivos 
					
						Response.Write "<li>"
						'Response.Write "<a href='conteudo/server/download.asp?Engine=" & Engine & "&Id=" & Id & "&Arquivo=" & File.Name & "'>"
						Response.Write "<a href='../arquivos/" & Engine & "/" & Id & "/" & File.Name & "' target='blank'>"
						Response.Write File.Name
						Response.Write "</a>"
						Response.Write "</li>"
					
					Next 
					
					Response.Write "</ul>"
					
				End If
		
			Set Arquivos = Nothing
		Set FSO = Nothing
	
	End Sub
	
'-------------------------------------------------------------------------------------------------------------------------------'

End Class

%>