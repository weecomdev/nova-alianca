<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<!--#include file="../functions/classConteudo.asp" -->
<%

	Function modeloTexto()
	
		Response.Write "<h1>" & RS("vinicola_nome") & "</h1>"
		call Pagina.montaImg(Pagina.Id)
		Response.Write RS("vinicola_desc")
		
	End Function

	Function modeloLista()
	
		Response.Write "<a href='default.asp?Engine=vinicola&Id=" & cStr(RS("vinicola_id")) & "'>"
		Response.Write "<h1>" & RS("vinicola_nome") & "</h1>"
		Response.Write "</a>"

	End Function

	Set Pagina = New Conteudo
	
		If Pagina.Id = 0 Then
			If Pagina.totalRS > 1 Then
				Pagina.imgEngine
				Pagina.montaLista
			Else
				Pagina.Id = Pagina.menorRS
				Pagina.montaTexto
			End If
		Else
			Pagina.montaTexto
		End If

	Set Pagina = Nothing
	
%>

<br />
<br />
<h1><a href='default.asp?Engine=imprensa&subEngine=download&Id=1'>Download do logotipo</a></h1>
