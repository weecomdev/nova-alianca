<%
caminhoThumb = Trim(Request.QueryString("Caminho"))
alturaThumb = 60
larguraThumb = 60

Response.Expires = 0

'Criar objeto editor de imagem
Set fotoView = Server.CreateObject("Persits.Jpeg")

'Abrir aqrquivo para edição
fotoView.Open( Server.MapPath(caminhoThumb) )

	'Se a foto for horizontal
	If fotoView.OriginalWidth > fotoView.OriginalHeight Then
		'redimenciona imagem
		newWidth = (alturaThumb * fotoView.OriginalWidth) / fotoView.OriginalHeight 
		fotoView.Width = newWidth
		fotoView.Height = alturaThumb
		'corte da sobra
		sobra = (newWidth - larguraThumb)/2
		fotoView.Crop sobra, 0, (sobra + larguraThumb), alturaThumb
		
	'Se a foto for vertical
	Else
		'redimenciona imagem
		newHeight = (larguraThumb * fotoView.OriginalHeight) / fotoView.OriginalWidth
		fotoView.Height = newHeight
		fotoView.Width = larguraThumb
		'corte da sobra
		sobra = (newHeight - alturaThumb)/2
		fotoView.Crop 0, sobra, larguraThumb, (sobra + alturaThumb)
		
	End If
	
	'Inserção da moldura na miniatura
	'fotoView.Canvas.DrawPNG 0, 0, Server.MapPath("../interface/thumb.png")

'Enviar imagem direto para o browzer
fotoView.SendBinary

%> 
