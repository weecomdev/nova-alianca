<%
If Not Session("logado") = True Then
	Response.Redirect "../usuarios/login.asp"
End If
%>