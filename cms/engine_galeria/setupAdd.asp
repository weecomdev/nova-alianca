<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/editImage.asp" -->
<%
IdGaleria = Upload.Form("id")
numFotos = Upload.Form("numfotos")
Id = Cint(numFotos) + 1

'============================================================================='

infoFoto = Array(440, 440, "../../imagens/engine_galeria/" & IdGaleria & "/fotos/", IdGaleria & "_", "")
infoThumb = Array(110, 110, "../../imagens/engine_galeria/" & IdGaleria & "/thumbs/", IdGaleria & "_", "")
	
editImages(Id)

'============================================================================='

Response.Redirect "setup.asp?Id=" & IdGaleria

%>