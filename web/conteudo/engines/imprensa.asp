<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<!--#include file="../functions/classConteudo.asp" -->
<%

'==============================================================================================================================='

	Function modeloLista()
	
		Response.Write "<a href='default.asp?Engine=imprensa&Id=" & cStr(RS("imprensa_id")) & "'>"
		Response.Write "<h2>" & FormatDateTime(RS("imprensa_data"), 2) & "</h2> - " & RS("imprensa_nome")
		Response.Write "</a>"

	End Function

'==============================================================================================================================='

	Function modeloTexto()
	
		Select Case Pagina.subEngine
			
			Case "download"
		
				Response.Write "<h2>" & RS("download_nome") & "</h2>"
				Response.Write "<p>" & RS("download_desc") & "</p>"
				Pagina.montaArquivos
				
			Case Else
			
				call Pagina.montaImg(Pagina.Id)
				Response.Write "<h2><b>" & FormatDateTime(RS("imprensa_data"), 2) & "</b> - " & RS("imprensa_nome") & "</h2>"
				Response.Write RS("imprensa_desc")
			
		End Select
		
	End Function


'==============================================================================================================================='

	Set Pagina = New Conteudo
	
		'Caso não haja Id especificado
		If Pagina.Id = 0 Then
		
			'Listagem da Imprensa
			Pagina.listaOrdem = "imprensa_destaque, imprensa_data DESC"
			Pagina.Legenda = "Dicas"
			Pagina.imgEngine
			Pagina.montaLista
			
			'Download
			'Response.Write "<h1><a href='default.asp?Engine=imprensa&subEngine=download&Id=1'>Download da logomarca</a></h1>"
		
		'Caso haja Id especificado
		Else
		
			If Pagina.subEngine <> "" Then
				Pagina.Engine = Pagina.subEngine
			End If
			
			Pagina.Legenda = "Atualidades"
			Pagina.montaTexto
		
		End if

	Set Pagina = Nothing
	
%>
