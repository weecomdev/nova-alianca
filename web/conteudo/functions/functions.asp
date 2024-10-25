<%

'==============================================================================================================================='
' FUNÇÕES PARA CONEXÃO COM O BANCO

' variaveis de conexão
Dim Conn, RS

' abrir banco de dados
Sub connOpen

	Set Conn = CreateObject("ADODB.Connection")
	
		If Request.ServerVariables("HTTP_HOST") = "localhost" Then
			Conn.Open "driver=MySQL ODBC 3.51 Driver;server=localhost;uid=root;pwd=teste;database=alianca"
		Else
			Conn.Open "Driver=MySQL ODBC 3.51 Driver;DATABASE=vinhosalianca;SERVER=mysql.novaalianca.coop.br;UID=vinhosalianca;PASSWORD=123456;"
		End If
		
		Set RS = CreateObject("ADODB.Recordset") 

End Sub

' fechar banco de dados
Sub connClose

	Set RS = Nothing

	Conn.close
	Set Conn = nothing

End sub

'==============================================================================================================================='
' FUNÇÃO PARA CABEÇALHOS AJAX

Sub openAjax(Tipo)

	'evitar armazenamento
	Response.Expires = 0
	Response.expiresabsolute = Now() - 1
	Response.CacheControl = "no-cache"
	Response.AddHeader "Pragma", "no-cache"
	Response.Charset = "iso-8859-1"
	
	'cabeçalho xml
	If Tipo = "xml" Then
	
		Response.ContentType = "text/xml"
		Response.Write "<?xml version=" & chr(34) & "1.0" & chr(34) & " encoding=" & chr(34) & "ISO-8859-1" & chr(34) & " ?>"
		
	End if

End Sub

'==============================================================================================================================='
' FUNÇÃO PARA CHECAR SE EXISTEM IMAGENS

Function checkImg(Foto)

	Set checkFSO = CreateObject("Scripting.FileSystemObject")
		checkImg = checkFSO.fileExists(Server.MapPath(Foto))
	Set checkFSO = Nothing

End Function

'==============================================================================================================================='
' FUNÇÃO PARA CHECAR MENSAGEM ENVIADA

Function checkSend()

	If Trim(Request.QueryString("Msg")) = "OK" Then
		checkSend = "<small>mensagem enviada</small>"
	Else
		checkSend = ""
	End If
	
End Function

'==============================================================================================================================='
'FUNÇÃO PARA GERAR PRÉVIA DE TEXTO

Function Previa(Texto, Limite)

	Texto = RemoveHTMLTags(Texto)

	If Len(Texto) > Limite Then
		Texto = Mid(Texto, 1, Limite)
		Texto = Texto & "..."
	End If
	
	Previa = Texto

End Function

'==============================================================================================================================='
' FUNÇÃO PARA REMOVER TAGS HTML

Function RemoveHTMLTags(ByVal strHTML)

	'Expressão regular
    Set objER = New RegExp 
		objER.IgnoreCase = True
		objER.Global = True
		objER.Pattern = "<[^>]*>"
    
		'Substituir texto
		strTexto = objER.Replace(strHTML, "")
    
    Set objER = Nothing

    RemoveHTMLTags = strTexto

End Function

'==============================================================================================================================='
' FUNÇÃO PARA RETORNAR CAMINHO HTTP

Function getHttp()

	urlArray = Split(Request.ServerVariables("URL"), "/")
	getHttp = "http://" & Request.ServerVariables("HTTP_HOST") & Replace( Request.ServerVariables("URL"), urlArray(uBound(urlArray)), "")

End Function

%>