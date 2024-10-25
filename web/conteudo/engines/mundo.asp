<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<!--#include file="../functions/classConteudo.asp" -->
<%

	Function modeloTexto()
	
		Response.Write "<h1>" & RS("mundo_nome") & "</h1>"
		Pagina.montaImg(Pagina.Id)
		Response.Write "<p>" & RS("mundo_desc") & "</p>"
		Pagina.montaArquivos
		
	End Function
	
	Function modeloLista()
	
		Response.Write "<a href='default.asp?Engine=mundo&Id=" & cStr(RS("mundo_id")) & "'>"
		Response.Write "<h1>" & RS("mundo_nome") & "</h1>"
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
