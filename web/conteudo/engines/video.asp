<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<!--#include file="../functions/classConteudo.asp" -->
<%

	Sub montaVideo()
	
		call connOpen()
	
			SQL = "SELECT * FROM video WHERE video_id = " & Pagina.Id & ";"
			
			RS.Open SQL,Conn
	
				If RS.EOF Then			
					Response.Write "Não há informações disponíveis."
				Else
				
					videoCor = "8D8573"
					videoLargura = 600
					videoAltura = 338
				
					videoUrl = "http://www.youtube.com/v/" & RS("video_url") & "&hl=pt-br&fs=1&rel=0&color1=0x" & videoCor & "&color2=0x" & videoCor & ""
					
					Response.Write "<h1>" & RS("video_nome") & "</h1>"
				
					Response.Write "<div>"
					Response.Write "<object width='" & videoLargura & "' height='" & videoAltura & "'>"
					Response.Write "<param name='movie' value='" & videoURL & "'></param>"
					Response.Write "<param name='allowFullScreen' value='true'></param>"
					Response.Write "<param name='allowscriptaccess' value='always'></param>"
					Response.Write "<embed src='" & videoURL & "' type='application/x-shockwave-flash' allowscriptaccess='always' " &_
								   "allowfullscreen='true' width='" & videoLargura & "' height='" & videoAltura & "'></embed>"
					Response.Write "</object>"
					Response.Write "</div>"
				
					Response.Write "<p>" & RS("video_desc") & "</p>"
									
				End If
					
			RS.Close
	
		call connClose()
		
	End Sub
	
	Function modeloLista()
	
		Response.Write "<a href='default.asp?Engine=video&Id=" & cStr(RS("video_id")) & "'>"
		Response.Write "<h1>" & RS("video_nome") & "</h1>"
		Response.Write "</a>"

	End Function

	Set Pagina = New Conteudo
	
		If Pagina.Id = 0 Then
			If Pagina.totalRS > 1 Then
				Pagina.imgEngine
				Pagina.montaLista
			Else
				Pagina.Id = Pagina.menorRS
				call montaVideo
			End If
		Else
			call montaVideo
		End If
		
	Set Pagina = Nothing
	
%>
