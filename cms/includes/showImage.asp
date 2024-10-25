<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<%
infoView = Array(Trim(Request.QueryString("Imagem")), Trim(Request.QueryString("Tamanho")))
Legenda = Trim(Request.QueryString("Legenda"))

Set fso = CreateObject("Scripting.FileSystemObject")
	If Not fso.fileExists(Server.MapPath(infoView(0))) = True Then
		Response.Write "<script> parent.hidePop() </script>"
	End If
Set fso = Nothing
%>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel Administrativo</title>
<link href="../interface/popStyle.css" rel="stylesheet" type="text/css">
<script>
function zoomSize() { 
	
	var wPop = document.getElementById("popFrame").offsetWidth;
	var hPop = (navigator.appName.search("Microsoft") == -1) ? document.body.offsetHeight : document.body.scrollHeight;
	
	parent.sizePop(wPop,hPop);
	
}
onload = zoomSize;
</script>
</head>
<body>

<% If Legenda <> "" Then %>
    <table border="0" cellspacing="0" cellpadding="0" id="tableTitle">
      <tr>
        <td>zoom da imagem</td>
      </tr>
    </table>
<% Else %>
<img src="../interface/layout_pixel.gif" style="background: #FFFFFF; height: 2px; width: 100%;"><br>
<% End If %>
<img id="popFrame" src="binaryImage.asp?Caminho=<%= infoView(0) %>&Tamanho=<%= infoView(1) %>">
    
</body>
</html>