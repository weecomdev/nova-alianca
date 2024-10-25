<%
tamanhoView = Trim(Request.QueryString("Tamanho"))
caminhoView = Trim(Request.QueryString("Caminho"))

Response.Expires = 0

'Criar objeto editor de imagem
Set fotoView = Server.CreateObject("Persits.Jpeg")

'Abrir aqrquivo para edição
fotoView.Open( Server.MapPath(caminhoView) )

	'Se a foto for horizontal
	If fotoView.OriginalWidth > fotoView.OriginalHeight Then
		'dimensionado a imagem proporcionalmente
		newHeight = (tamanhoView * fotoView.OriginalHeight) / fotoView.OriginalWidth
		fotoView.Height = newHeight
		fotoView.Width = tamanhoView
		
	'Se a foto for vertical
	Else
		'dimensionado a imagem proporcionalmente
		newWidth = (tamanhoView * fotoView.OriginalWidth) / fotoView.OriginalHeight
		fotoView.Width = newWidth
		fotoView.Height = tamanhoView
		
	End If

'Enviar imagem direto para o browzer
fotoView.SendBinary
%> 
