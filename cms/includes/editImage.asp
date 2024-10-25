<%
'================================================================================================='
'VARIAVEIS DE POSSÍVEL INSERÇÃO NO SISTEMA:
'
'idFoto = valor inicial de ID para imagem ser editada
'infoFoto = array com dados da imagem [largura, altura, endereço, prefixo, nome]
'infoThumb = array com dados da miniatura [largura, altura, endereço, prefixo, nome]
'infoMarca = array com dados da marca dágua inserido na imagem [endereço, largura, altura]
'corFundo = cor do fundo para inserção da imagem em uma página pré-definida
'================================================================================================='

Function editImages(idFoto)

'caso haja upload de arquivos aciona o mecanismo
If upNum > 0 Then

'================================================================================================='

'setar variáveis da imagem
If isArray(infoFoto) = True Then
	larguraImg = infoFoto(0)
	alturaImg = infoFoto(1)
	enderecoFoto = infoFoto(2)
	prefixoFoto = infoFoto(3)
	nomeFoto = infoFoto(4)
End If

'setar variáveis da miniatura
If isArray(infoThumb) = True Then
	larguraThumb = infoThumb(0)
	alturaThumb = infoThumb(1)
	enderecoThumb = infoThumb(2)
	prefixoThumb = infoThumb(3)
	nomeThumb = infoThumb(4)
End If

'setar variáveis da marca dágua
If isArray(infoMarca) = True Then
	enderecoPng = infoMarca(0)
	larguraPng = infoMarca(1)
	alturaPng = infoMarca(2)
End If

'================================================================================================='

'criar objeto editor de imagem
Set fotoEditor = Server.CreateObject("Persits.jpeg")

'aciona o processo para cada arquivo do upload 
For Each File in Upload.Files

'verifica se o arquivo é uma imagem
If File.ImageType <> "UNKNOWN" Then
	
	'abrir arquivo
	fotoEditor.Open(File.Path)
	
'CRIAR IMAGEM ===================================================================================='

If isArray(infoFoto) = True Then

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

	'Inserção da marca dagua na imagem
	If isArray(infoMarca) = True Then
		fotoEditor.Canvas.DrawPNG (fotoEditor.Width - larguraPng - 10), (fotoEditor.Height - alturaPng - 10), Server.MapPath(enderecoPng)
	End If
	
	'verificando nomenclatura da imagem
	If nomeFoto = "" Then
		salvarFoto = enderecoFoto & prefixoFoto & idFoto
	Else
		salvarFoto = enderecoFoto & prefixoFoto & nomeFoto
	End If
	
	'salvando imagem redimencionada no diretorio desejado
	fotoEditor.Save Server.MapPath(salvarFoto & ".jpg")
	
End If

'================================================================================================='

'CRIAR THUMB ====================================================================================='

If isArray(infoThumb) = True Then

	fotoEditor.Open(File.Path)

	'caso seja horizontal
	If fotoEditor.OriginalWidth > fotoEditor.OriginalHeight Then

		'redimenciona pela altura
		fotoEditor.Height = alturaThumb
		fotoEditor.Width = (fotoEditor.OriginalWidth * alturaThumb) / fotoEditor.OriginalHeight
		
		'----------------------------------------------------------------'
		'caso não preencher largura
		If fotoEditor.Width < larguraThumb Then
			'redimenciona pela largura
			fotoEditor.Width = larguraThumb
			fotoEditor.Height = (fotoEditor.Height * larguraThumb) / ((fotoEditor.OriginalWidth * alturaThumb) / fotoEditor.OriginalHeight)
		End If
		'----------------------------------------------------------------'

		'cortar imagem
		sobra = (fotoEditor.Width - larguraThumb)/2
		fotoEditor.Crop sobra, 0, (larguraThumb + sobra), alturaThumb
		
	'caso seja vertical
	Else

		'redimenciona pela largura
		fotoEditor.Width = larguraThumb
		fotoEditor.Height = (fotoEditor.OriginalHeight * larguraThumb) / fotoEditor.OriginalWidth
		
		'----------------------------------------------------------------'
		'caso exceder altura limite
		If fotoEditor.Height < alturaThumb Then
			'redimenciona pela altura
			fotoEditor.Height = alturaThumb
			fotoEditor.Width = (fotoEditor.Width * alturaThumb) / ((fotoEditor.OriginalHeight * larguraThumb) / fotoEditor.OriginalWidth)
		End If
		'----------------------------------------------------------------'
		
		'cortar imagem
		sobra = (fotoEditor.Height - alturaThumb)/2
		fotoEditor.Crop 0, sobra, larguraThumb, (alturaThumb + sobra)
	
	End If

	'Inserção da moldura na miniatura
'	If pngThumb <> "" Then
'		fotoEditor.Canvas.DrawPNG 0, 0, Server.MapPath(pngThumb)
'	End If
	
	'verificando nomenclatura da miniatura
	If nomeFoto = "" Then
		salvarThumb = enderecoThumb & prefixoThumb & idFoto
	Else
		salvarThumb = enderecoThumb & prefixoThumb & nomeThumb
	End If

	'salvando miniatura na pasta desejada
	fotoEditor.Save Server.MapPath(salvarThumb & ".jpg")

End If

'================================================================================================='

	'deletar arquivo original
	File.Delete
	
	'acrescentar contador para próximo arquivo
	idFoto = idFoto + 1

'deletar o arquivo caso não seja uma imagem 
Else
	File.Delete
End If		
		
Next

'descartar objeto editor de imagem		
Set fotoEditor = Nothing
Set Upload = Nothing

'================================================================================================='

End If

End Function

'================================================================================================='

'inicio do processo de upload acionado ao carregar a include
Set Upload = Server.CreateObject("Persits.Upload")
	Upload.OverwriteFiles = False  
	
	upNum = Upload.Save(Server.MapPath("../../imagens"))

%>