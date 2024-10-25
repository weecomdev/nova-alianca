<%
'==============================================================================================================================='
' FUNÇÕES PARA CONEXÃO COM O BANCO

' variaveis de conexão
Dim Conn, RS

' abrir banco de dados
Sub connOpen

	Set Conn = CreateObject("ADODB.Connection")
	
		If Request.ServerVariables("HTTP_HOST") = "localhost" Then
			Conn.Open "driver=MySQL ODBC 3.51 Driver;server=localhost;uid=root;pwd=teste;database=alianca"
		Else
			Conn.Open "Driver=MySQL ODBC 3.51 Driver;DATABASE=vinhosalianca;SERVER=mysql.vinhos-alianca.com.br;UID=vinhosalianca;PASSWORD=123456;"
		End If

		Set RS = CreateObject("ADODB.Recordset") 

End Sub

' fechar banco de dados
Sub connClose

	Set RS = Nothing

	Conn.close
	Set Conn = nothing

End sub

'==============================================================================================================================='
'==============================================================================================================================='
' FUNÇÃO PARA EXCLUIR ARQUIVOS

Sub delArquivo(arquivo)

	Set FSO = Server.CreateObject("Scripting.FileSystemObject")
	
		If FSO.fileExists(Server.MapPath(arquivo)) Then
			FSO.DeleteFile Server.MapPath(arquivo)
		End If
	
	Set FSO = Nothing

End Sub

'==============================================================================================================================='
'==============================================================================================================================='
' FUNÇÃO PARA UPLOAD

Dim Upload, pastaUpload

Sub upOpen

	If pastaUpload = "" Then
		pastaUpload = "../../imagens"
	End If

	Set Upload = Server.CreateObject("Persits.Upload")
		Upload.OverwriteFiles = False  
	
		upNum = Upload.Save(Server.MapPath(pastaUpload))
		
End Sub

'==============================================================================================================================='
'==============================================================================================================================='
' FUNÇÃOS PARA DATETIME

Function Tempo(checkTempo)

	Tempo = Right("000" & Year(checkTempo),4) & "-" & Right("0" & Month(checkTempo),2) & "-" & Right("0" & Day(checkTempo),2) & " " &_
			Right("0" & Hour(checkTempo),2) & ":" & Right("0" & Minute(checkTempo),2) & ":" & Right("0" & Second(checkTempo),2)

End Function

'==============================================================================================================================='
'==============================================================================================================================='
' CLASSE DE CONTEÚDO

Class cmsEngine
	
'-------------------------------------------------------------------------------------------------------------------------------'
'declarar variáveis

	Dim Tabela, Id
	Dim Campos, Valores
	
'-------------------------------------------------------------------------------------------------------------------------------'
'funções para resgatar valores

	'retorna último ID da tabela
	Function novoId()
	
		call connOpen()
		
			RS = Conn.Execute("SELECT MAX(" & Tabela & "_id) AS teste FROM " & Tabela & ";")
			novoId = cInt(RS("teste"))
			
		call connClose()
	
	End Function

	'retorna total de registros
	Function totalRS()
	
		call connOpen()
		
			RS = Conn.Execute("SELECT COUNT(" & Tabela & "_id) AS total FROM " & Tabela & ";")
			totalRS = cInt(RS("total"))
			
		call connClose()
	
	End Function

'-------------------------------------------------------------------------------------------------------------------------------'
'função para adicionar conteúdo

	Sub Adicionar()
	
		call connOpen()
		
			If isArray(Campos) Then
		
				For x = 0 To uBound(Campos)
					
					'para campos externos
					If Mid(Campos(x), 1, 1) = "[" And Mid(Campos(x), Len(Campos(x)), Len(Campos(x))) = "]" Then
						Campos(x) = Replace( Replace(Campos(x), "[", "") , "]", "")
						Sufixo = ""
					Else
						Sufixo = Tabela & "_"
					End If
				
					addCampos = addCampos & Sufixo & Campos(x)
					addValores = addValores & "'" & Valores(x) & "'"
				
					If x < uBound(Campos) Then
						addCampos = addCampos & ", "
						addValores = addValores & ", "
					End If
				
				Next
				
				addInfo = " (" & addCampos & ") VALUES (" & addValores & ")"
				
			Else
			
				addInfo = " VALUES ()"
				
			End If

			SQL = "INSERT INTO " & Tabela & addInfo
			RS = Conn.Execute(SQL)
			
		call connClose()
	
	End Sub

'-------------------------------------------------------------------------------------------------------------------------------'
'função para editar conteúdo

	Sub Editar()
	
		call connOpen()
		
			For x = 0 To uBound(Campos)
			
				'para campos externos
				If Mid(Campos(x), 1, 1) = "[" And Mid(Campos(x), Len(Campos(x)), Len(Campos(x))) = "]" Then
					Campos(x) = Replace( Replace(Campos(x), "[", "") , "]", "")
					Sufixo = ""
				Else
					Sufixo = Tabela & "_"
				End If
			
				editSQL = editSQL & Sufixo & Campos(x) & "='" & Valores(x) & "'"
			
				If x < uBound(Campos) Then
					editSQL = editSQL & ", "
				End If
			
			Next
			
			SQL = "UPDATE " & Tabela & " SET " & editSQL & " WHERE " & Tabela & "_id LIKE '" & Id & "';"
			RS = Conn.Execute(SQL)
			
		call connClose()
	
	End Sub 
	
'-------------------------------------------------------------------------------------------------------------------------------'
'função para deletar conteúdo

	Sub Deletar()
	
		call connOpen()
		
			SQL = "DELETE FROM  " & Tabela & " WHERE " & Tabela & "_id LIKE '" & Id & "';"			
			RS = Conn.Execute(SQL)
			
		call connClose()

	End Sub 
	
'-------------------------------------------------------------------------------------------------------------------------------'
'função para alterar destaques

	Sub Destaque()
	
		call connOpen()
		
			SQL = "SELECT " & Tabela & "_destaque AS destaque FROM " & Tabela & " AS destaque WHERE " & Tabela & "_id LIKE '" & Id & "'"
			RS = Conn.Execute(SQL)
			
				If RS("destaque") = 1 Then
					newDestaque = 0
				Else 
					newDestaque = 1
				End If
				
			SQL = "UPDATE " & Tabela & " SET " & Tabela & "_destaque=" & newDestaque & " WHERE " & Tabela & "_id LIKE '" & Id & "'"
			RS = Conn.Execute(SQL)
	
		call connClose()
	
	End Sub 
	
'-------------------------------------------------------------------------------------------------------------------------------'
'função para alterar ordem

	Dim ordemFiltro

	Sub Ordenar(Tipo)
	
		If ordemFiltro <> "" Then
			ordemFiltro = " WHERE " & ordemFiltro & " "
		End If
	
		call connOpen()
		
			Select Case Tipo
			
				Case "Sobe", "Desce"
				
					numOrdem = 0
				
					SQL = "SELECT * FROM " & Tabela & ordemFiltro & " ORDER BY " & Tabela & "_ordem;"
					RS.Open SQL,Conn,3,2
					
						Do While Not RS.EOF
						
							If numOrdem = 0 Then
								If cInt(RS(Tabela & "_id")) = cInt(Id) Then
									numOrdem = RS(Tabela & "_ordem")
									If Tipo = "Sobe" Then
										RS(Tabela & "_ordem") = numOrdem - 1
										RS.MovePrevious
										RS(Tabela & "_ordem") = numOrdem
									Else
										RS(Tabela & "_ordem") = RS(Tabela & "_ordem") + 1
										RS.MoveNext
										RS(Tabela & "_ordem") = numOrdem
									End If
								End	If
							End If
							
							RS.MoveNext
							
						Loop
					
					RS.Close
				
				Case Else
				
					numOrdem = 1

					SQL = "SELECT * FROM " & Tabela & ordemFiltro & " ORDER BY " & Tabela & "_ordem;"
					RS.Open SQL,Conn,3,2
						
						If Not RS.EOF Then
							
							Do While Not RS.EOF
							
								RS(Tabela & "_ordem") = numOrdem
								RS.MoveNext
								numOrdem = numOrdem + 1		
							
							Loop
							
						End If
					
					RS.Close
					
			End Select
		
		call connClose()

	End Sub 
	
'-------------------------------------------------------------------------------------------------------------------------------'

End Class 

'==============================================================================================================================='
' CLASSE DE IMAGENS
'==============================================================================================================================='

Class cmsImagem

'-------------------------------------------------------------------------------------------------------------------------------'
'declarar variáveis

	Dim fotoEditor
	Dim infoImagem
	
'-------------------------------------------------------------------------------------------------------------------------------'
'função para adicionar requisição de imagem

	Sub addImg(tipoImg, larguraImg, alturaImg, caminhoImg, nomeImg)
	
		'prepara variável para inserções
		If Not isArray(infoImagem) Then
			Redim infoImagem(4,-1)
		End If
	
		'Redimensiona requisições
		Redim Preserve infoImagem(4, uBound(infoImagem,2)+1)
		
		'Insere nova requisição se imagens
		infoImagem(0, uBound(infoImagem,2)) = tipoImg

		'Define valores dessa requisição
		infoImagem(1, uBound(infoImagem,2)) = larguraImg
		infoImagem(2, uBound(infoImagem,2)) = alturaImg
		infoImagem(3, uBound(infoImagem,2)) = caminhoImg
		infoImagem(4, uBound(infoImagem,2)) = nomeImg
	
	End Sub

'-------------------------------------------------------------------------------------------------------------------------------'
'função para gerar imagem redimensionada

	Sub Encaixar(larguraImg, alturaImg)
	
		'caso seja horizontal ou quadrada
		If fotoEditor.OriginalWidth > fotoEditor.OriginalHeight Or fotoEditor.OriginalWidth = fotoEditor.OriginalHeight Then
	
			'redimenciona pela largura
			fotoEditor.Width = larguraImg
			fotoEditor.Height = (fotoEditor.OriginalHeight * larguraImg) / fotoEditor.OriginalWidth
			
			'caso exceder altura limite
			If fotoEditor.Height > alturaImg Then
			
				'redimenciona pela altura
				fotoEditor.Height = alturaImg
				fotoEditor.Width = (fotoEditor.Width * alturaImg) / ((fotoEditor.OriginalHeight * larguraImg) / fotoEditor.OriginalWidth)
			
			End If
			
		'caso seja vertical
		Else
	
			'redimenciona pela altura
			fotoEditor.Height = alturaImg
			fotoEditor.Width = (fotoEditor.OriginalWidth * alturaImg) / fotoEditor.OriginalHeight
			
			'caso exceder largura limite
			If fotoEditor.Width > larguraImg Then
			
				'redimenciona pela largura
				fotoEditor.Width = larguraImg
				fotoEditor.Height = (fotoEditor.Height * larguraImg) / ((fotoEditor.OriginalWidth * alturaImg) / fotoEditor.OriginalHeight)
	
			End If
		
		End If

	End Sub

'-------------------------------------------------------------------------------------------------------------------------------'
'função para enquadrar imagem

	Sub Enquadrar(larguraImg, alturaImg)
	
		'caso seja horizontal
		If fotoEditor.OriginalWidth > fotoEditor.OriginalHeight Then
	
			'redimenciona pela altura
			fotoEditor.Height = alturaImg
			fotoEditor.Width = (fotoEditor.OriginalWidth * alturaImg) / fotoEditor.OriginalHeight
			
			'caso não preencher largura
			If fotoEditor.Width < larguraImg Then
				'redimenciona pela largura
				fotoEditor.Width = larguraImg
				fotoEditor.Height = (fotoEditor.Height * larguraImg) / ((fotoEditor.OriginalWidth * alturaImg) / fotoEditor.OriginalHeight)
			End If
			
		'caso seja vertical
		Else
	
			'redimenciona pela largura
			fotoEditor.Width = larguraImg
			fotoEditor.Height = (fotoEditor.OriginalHeight * larguraImg) / fotoEditor.OriginalWidth
			
			'caso exceder altura limite
			If fotoEditor.Height < alturaImg Then
				'redimenciona pela altura
				fotoEditor.Height = alturaImg
				fotoEditor.Width = (fotoEditor.Width * alturaImg) / ((fotoEditor.OriginalHeight * larguraImg) / fotoEditor.OriginalWidth)
			End If
		
		End If
		
		'cortar imagem
		sobraW = (fotoEditor.Width - larguraImg)/2
		sobraH = (fotoEditor.Height - alturaImg)/2
		fotoEditor.Crop sobraW, sobraH, (fotoEditor.Width - sobraW), (fotoEditor.Height - sobraH)
	
	End Sub

'-------------------------------------------------------------------------------------------------------------------------------'
'função para rotacionar imagem

	Sub Girar(direcao)
	
		If direcao = "direita" Then
			fotoEditor.RotateR
		Else
			fotoEditor.RotateL
		End if		
	
	End Sub

'-------------------------------------------------------------------------------------------------------------------------------'
'função acionada antes de fechar a classe

	Sub Class_Terminate()
	
		'para cada arquivo no Upload
		For Each File in Upload.Files
		
			'caso seja imagem
			If File.ImageType <> "UNKNOWN" Then
			
				'objeto APSJpeg			
				Set fotoEditor = Server.CreateObject("Persits.jpeg")
				
					'caso hajam requisições de imagem
					If isArray(infoImagem) Then
					
						'para cada requisição
						For x=0 to uBound(infoImagem,2)
						
							'abrir arquivo
							fotoEditor.Open(File.Path)
							
							'verifica edição da imagem
							Select Case infoImagem(0,x)
								Case 1
									call Encaixar(infoImagem(1,x), infoImagem(2,x))
								Case 2
									call Enquadrar(infoImagem(1,x), infoImagem(2,x))
								Case 3 ' redimensionar e girar
									call Girar("direita")
									call Encaixar(infoImagem(1,x), infoImagem(2,x))
									
							End Select
							
							'Qualidade
							fotoEditor.Quality = 80
							
							'salvar
							fotoEditor.Save Server.MapPath(infoImagem(3,x) & infoImagem(4,x) & ".jpg")
						
						Next
					
					End If

				Set fotoEditor = Nothing
				
				'Deletar arquivo original
				File.Delete
			
			'caso não seja imagem será deletado
			Else
				File.Delete
			End If
		
		Next
	
	End Sub

'-------------------------------------------------------------------------------------------------------------------------------'
	
End Class

'==============================================================================================================================='
'==============================================================================================================================='


%>
