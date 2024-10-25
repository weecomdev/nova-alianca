<!--#include file="../functions/functions.asp" -->
<!--#include file="../functions/classConteudo.asp" -->
<%
'cabe�alho Ajax
call openAjax("")

'numero de thumbs para listar por vez
numShow = 7

'valor do Id da galeria
Id = cInt(Request.QueryString("Id"))

'Caso ID seja zero
If Id = 0 Then

	Set getId = New Conteudo
		getId.Engine = "galeria"
		Id = getId.menorRS
	Set getId = Nothing

End If

'valor da p�gina atual
Pagina = cInt(Request.QueryString("Pagina"))

If Pagina = 0 Then
	Pagina = 1
End If

'checar n�mero de total dispon�veis
Set FSO = CreateObject("Scripting.FileSystemObject")
	numFotos = fso.GetFolder(Server.Mappath("../../../imagens/galeria/" & Id & "/thumbs/")).Files.count
Set FSO = Nothing

'caso existem thumbs dispon�veis
If numFotos > 0 Then

	'caso haja mais de uma p�gina para listar
	If (numFotos/numShow) > 1 Then
	
		'arredondar para cima o n�mero de p�ginas
		If cInt(numFotos/numShow) < (numFotos/numShow) Then
			numPaginas = (numFotos/numShow) + ( 1 - ( (numFotos/numShow) - cInt(numFotos/numShow) ) )
		Else
			numPaginas = cInt(numFotos/numShow)
		End If
		
	Else
		numPaginas = 1
	End If
	
'LISTAR THUMBS DA P�GINA ATUAL
	
	Response.Write "<ul>"
	
	For x = (numShow*(Pagina-1))+1 to numShow * Pagina
	
		If x <= numFotos Then
		
			Response.Write "<li><img src='../imagens/galeria/" & Id & "/thumbs/" & Id & "_" & x & ".jpg' onClick='zoom(this)' alt='Clique para ampliar' /></li>"
	
		End If
	
	Next

	Response.Write "</ul>"
	
'LINKS DE PAGINA��O

	If numFotos > numShow Then

		Response.Write "<div>"
		
		'bot�o de anterior
		If Pagina > 1 Then
			Response.Write "<a class='anterior' href='javascript:findInfo(""Thumb"",""Id=" & Id & "&Pagina=" & Pagina - 1 & """)'>Anterior</a>"
		End If
	
		'indexador
		Response.Write "<small>" & Pagina & " / " & numPaginas & "</small>"
		
		'bot�o de pr�ximo
		If Pagina < numPaginas Then
			Response.Write "<a class='proximo' href='javascript:findInfo(""Thumb"",""Id=" & Id & "&Pagina=" & Pagina + 1 & """)'>Pr�ximo</a>"
		End If
		
		Response.Write "</div>"
		
	End If

End If

%>