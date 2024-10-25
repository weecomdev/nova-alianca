<%

	'configurações para não ermazenar no cachê
	Response.Expires = 0
	Response.expiresabsolute = Now() - 1
	Response.CacheControl = "no-cache"
	Response.AddHeader "Pragma", "no-cache"

	Session("userIdioma") = Trim(Request.QueryString("Idioma"))

	Select Case Trim(Request.QueryString("Idioma"))

		Case "geral"
			Response.Redirect "../sede/listar.asp"
		Case Else
			Response.Redirect "../inicial/editar.asp"

	End Select

%>