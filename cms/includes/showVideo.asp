<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<%
URL = Trim(Request.QueryString("Url"))
Id = Trim(Request.QueryString("Id"))

If Id <> "" Then

	Set RS = Server.CreateObject("Adodb.recordset")
		SQL = "SELECT * FROM video WHERE idVideo LIKE '" & Id & "';"
		RS.Open SQL, Conn, 3, 2

			URL = RS("link")

		RS.Close
	Set RS = Nothing

End If

Color = Array("A6C2FF", "006699")
%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Painel Administrativo</title>
<link href="../interface/popStyle.css" rel="stylesheet" type="text/css">
<script src="../includes/java/popResize.js"></script>
</head>
<body>
<object width="325" height="292">
<param name="movie" value="http://www.youtube.com/v/<%= URL %>&rel=0&color1=0x<%= Color(0) %>&color2=0x<%= Color(1) %>&border=0"></param>
<param name="wmode" value="transparent"></param>
<embed src="http://www.youtube.com/v/<%= URL %>&rel=0&color1=0x<%= Color(0) %>&color2=0x<%= Color(1) %>&border=0" type="application/x-shockwave-flash" wmode="transparent" width="350" height="292"></embed>
</object>
</body>
</html>