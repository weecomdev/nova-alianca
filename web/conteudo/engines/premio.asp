<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<!--#include file="../functions/classConteudo.asp" -->
<%

	Function modeloTexto()
	
		call Pagina.montaImg(Pagina.Id)
		Response.Write "<h2><b>" & FormatDateTime(RS("premio_data"), 2) & "</b> - " & RS("premio_nome") & "</h2>"
		Response.Write RS("premio_desc")
		
	End Function

	Function modeloLista()
	
		Response.Write "<a href='default.asp?Engine=premio&Id=" & cStr(RS("premio_id")) & "'>"
		Response.Write "<h2>" & FormatDateTime(RS("premio_data"), 2) & "</h2> - " & RS("premio_nome")
		Response.Write "</a>"

	End Function

	Set Pagina = New Conteudo
	
		Pagina.listaOrdem = "premio_destaque, premio_data DESC"
		Pagina.Legenda = "Últimas Premiações"
		
		If Pagina.Id = 0 Then
			Pagina.imgEngine
			Pagina.montaLista
		Else
			Pagina.montaTexto
		End If

	Set Pagina = Nothing
	
%>
