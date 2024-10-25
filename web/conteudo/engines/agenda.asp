<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<!--#include file="../functions/classConteudo.asp" -->
<%

	Function modeloTexto()
	
		call Pagina.montaImg(Pagina.Id)
		Response.Write "<h2><b>" & FormatDateTime(RS("agenda_data"), 2) & "</b> - " & RS("agenda_nome") & "</h2>"
		Response.Write RS("agenda_desc")
		
	End Function

	Function modeloLista()
	
		Response.Write "<a href='default.asp?Engine=agenda&Id=" & cStr(RS("agenda_id")) & "'>"
		Response.Write "<h2>" & FormatDateTime(RS("agenda_data"), 2) & "</h2> - " & RS("agenda_nome")
		Response.Write "</a>"

	End Function

	Set Pagina = New Conteudo
	
		Pagina.listaOrdem = "agenda_destaque, agenda_data DESC"
		Pagina.Legenda = "Notícias"
		
		If Pagina.Id = 0 Then
			Pagina.imgEngine
			Pagina.montaLista
		Else
			Pagina.montaTexto
		End If

	Set Pagina = Nothing
	
%>
