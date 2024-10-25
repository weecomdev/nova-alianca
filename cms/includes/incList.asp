<%
'==================================================================================================
'navQuery = Array com os nomes das variaveis que serão inseridas na navegação
'navValue = Array com os valores das variaveis que serão inseridas na navegação
'==================================================================================================


'CONFIGURAÇÕES PARA PAGINAÇÃO
'==================================================================================================

RegMax = 10 'número de registros por página
contador = "vazio" 'para verificação de registros listados

'delcarando variáveis comuns a todas as listagens
Pagina = Trim(Request.QueryString("Pagina"))
Palavra = Trim(Request.QueryString("Palavra"))
Ordem = Cint(Request.QueryString("Ordem"))

'variável para paginação
If Pagina = "" then
	Pagina = 1
End If

'==================================================================================================
'FUNÇÃO PARA ORDENAR REGISTROS
%>
<script language="javascript" type="text/javascript">

//var listQuery = "Palavra=<%= Palavra %>&Pagina=<%= Pagina %>&<%= navLink %>"

//function ordenar() {
//
//	if (form.ordem.value != "0") {
//		window.location.href = "listar.asp?Palavra=<%= Palavra %>&Pagina=<%= Pagina %>&Ordem=" + form.ordem.value;
//	}
//
//}	

</script>
<%
'==================================================================================================
Function navBar()

'verifica se há variaveis para acrescentar na navegação
If isArray(navQuery) = True Then
	For x = 0 to uBound(navQuery)
		navLink = navLink & navQuery(x) & "=" & navValue(x)
		If x < uBound(navQuery) Then
			navLink = navLink & "&"
		End IF
	Next
End If

'corrige erro de paginação por exclusão de arquivos
If isNumeric(contador) = True Then
	If contador = 0 Then
		Response.Redirect "listar.asp?Palavra=" & Palavra & "&Pagina=" & Pagina - 1 & "&Ordem=" & Ordem & "&" & navLink
	End If
End If

'Caso seja necessário cria barra de paginação
If Not RS.EOF Or RS.RecordCount > RegMax Then

	'iniciar tabela
	Response.Write "<table border='0' cellpadding='0' cellspacing='0' id='pagTable'>"
	Response.Write "<tr><td id='pagCell'>"
	
	'botão Anterior
	If Pagina > 1 then 
		Response.Write "<a id='pagLink' href='listar.asp?Pagina=" & Pagina - 1 & "&Palavra=" & Palavra & "&Ordem=" & Ordem & "&" & navLink & "'><< Anterior</a>"
	Else
		Response.Write "<< Anterior"
	End if
	
	'<<<<<< teste em andamento >>>>>>
	Response.Write "</td><td id='pagNumbers'><div id='numeros'>" 
	 
	'indice de páginas (numeros)
	
	If Not RS.RecordCount <= RS.PageSize Then
	
		Response.Write "<a>" & Pagina & " / " & RS.PageCount & "</a>"
	
	End If
	
	
'	If Not RS.RecordCount <= RS.PageSize Then
'		For i = 1 to RS.pagecount
'	
'			If i = cint(Pagina) Then
'			   response.write " | " & "<b>" & i & "</b>"
'			Else
'			   response.write " | <a href='listar.asp?Pagina=" & i & "&Palavra=" & Palavra & "&Ordem=" & Ordem & "&" & navLink & "'>" & i & "</a> "
'			End If
'	
'		Next
'	End if
	
	'<<<<<< teste em andamento >>>>>>
	Response.Write " </div></td><td id='pagCell'>"
	 
	'botão Próxima
	If Not RS.EOF Then
		If strcomp(Pagina,RS.PageCount) <> 0 then 
			Response.Write "<a id='pagLink' href='listar.asp?Pagina=" & Pagina + 1 & "&Palavra=" & Palavra & "&Ordem=" & Ordem & "&" & navLink & "'>Pr&oacute;xima >></a>"
		End if
	Else
		Response.Write "Pr&oacute;xima >>"
	End if
	
	'fechar tabela
	Response.Write "</td></tr></table>"
	
End If
'======================================================================================================

'======================================================================================================
'FERRAMENTA DE BUSCA

If isNumeric(contador) = True Then
	If contador > 1 Then

If Palavra = "" Then
	buscaMSG = "Ferramenta de busca"
Else
	buscaMSG = Palavra
End If
	
Response.Write "<table border='0' cellspacing='0' cellpadding='0' id='tableTitle' style='margin-top: 40px;'><tr>"
Response.Write "<td id='inicio'></td>"
Response.Write "<td><input name='palavra' type='text' class='inputEditar' value='" & buscaMSG & "' onFocus='inBusca();' onBlur='outBusca();' /></td>"
Response.Write "<td id='fim'></td>"
Response.Write "<td width='40' id='icon'><img src='../interface/icons_search.jpg' title='Acionar Busca' onClick='buscar();'></td>"

Response.Write "</tr></table>"

	End If
End If

'acrescentar variáveis para javascript
Response.Write "<script>" & vbCrLf
Response.Write vbTab & "listPalavra = '" & Palavra & "';" & vbCrLf
Response.Write vbTab & "listQuery = '" & navLink & "';" & vbCrLf
Response.Write "</script>"

'======================================================================================================

End Function
%>