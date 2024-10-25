<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<%
Id = Trim(Request.QueryString("Id"))

Set fso = CreateObject("Scripting.FileSystemObject")
	Set folder = fso.GetFolder(Server.Mappath("../../imagens/galeria/" & Id & "/thumbs/")).Files
		numFotos = folder.count
	Set folder = Nothing
Set fso = Nothing

Set RS=Server.CreateObject("Adodb.recordset")
SQL = "SELECT * FROM galeria WHERE galeria_id LIKE '" & Id & "';"
RS.Open SQL,Conn,3,2
%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel Administrativo</title>
<link href="../interface/innerStyle.css" rel="stylesheet" type="text/css">
<style>

#imgCel Table {
	border: 1px solid #333333;
	background: #D2D2D2;
	width: 380px;
}
#imgCel Table Td { width: 58px; }

#imgCel Table Label {
	display: block;
	height: 58px;
	width: 58px;
	border: 1px solid #333333;
	background: #FFFFFF url(../interface/page_loadThumb.gif) center no-repeat;
}
#imgCel Table Label Input {
	position: relative;
	float: left;
	cursor: pointer;
}
#imgCel Table Label Img {
	position: relative;
	float: right;
	cursor: pointer;
	top: 38px;
}

</style>
<script src="../includes/java/inner.js"></script>
<script language="javascript">

//================================================================================
// RELOAD DE IMAGENS

function thumbShow() {

	thumbCheck = document.getElementById("imgCel").getElementsByTagName("label")
	
	for (var i = 0; i < thumbCheck.length; i++) {
		thumbCheck[i].style.backgroundImage = "" +
		"url(" + "../../imagens/galeria/<%= Id  %>/thumbs/<%= Id  %>_"+ (i+1) +".jpg?" +
		(new Date()).getTime() + ")";
	}

}

onload = thumbShow;

//================================================================================
// ACIONAR ADIÇÃO OU EXCLUSÃO DE FOTOS

function enviar(envio, quem) {

	if (envio == 1) {
	
		var arrayBox = document.getElementById("imgCel").getElementsByTagName("input");
		var checkBox = false;
		
		for (var i = 0; i < arrayBox.length; i++) {	if (arrayBox[i].checked == true) { checkBox = true; break; } }
		
		if (checkBox) {
		
			quem.style.background = "url(../interface/page_barra.gif) center no-repeat";
			quem.value = "";
		
			document.form.method = "post";
			document.form.action = "setupDel.asp";
			document.form.submit();
		
		}
	
	}
	else {
	
		if (document.form.foto.value != "") {
			
			quem.style.background = "url(../interface/page_barra.gif) center no-repeat";
			quem.value = "";
			
			document.form.method="post";
			document.form.encoding = "multipart/form-data";
			document.form.action = "setupAdd.asp";
			document.form.submit();
		
		}

	}
	
}

//================================================================================
// TROCAR FILTER DOS SELECIONADOS

function fotoColor(quem) {

	if (navigator.appName.search("Microsoft") == -1) { 
		quem.parentNode.style.opacity = (quem.checked == true) ? ".50" : "";
	}
	else {
		quem.parentNode.style.filter = (quem.checked == true) ? "Gray" : "";
	}
	
}

//================================================================================
// SELECIONA IMAGENS PELO LINK

function fotoSel(quem) {

	var fotoInput = quem.getElementsByTagName("input")[0];
	
	fotoInput.checked = (fotoInput.checked == true) ? false : true;
	fotoColor(fotoInput);

}


//================================================================================
// SELECIONA TODAS IMAGENS

function boxAll() {

	var arrayBox = document.getElementById("imgCel").getElementsByTagName("input");

	for (var i = 0; i < arrayBox.length; i++) {
		arrayBox[i].checked = true;
		fotoColor(arrayBox[i]);
	}

}

//================================================================================
// ZOOM NAS IMAGENS

function zoomPop(quem) {
	
	var zoomCheck = quem.parentNode.getElementsByTagName("input")[0]
	var zoomImg = "../../imagens/galeria/<%= Id  %>/fotos/<%= Id  %>_"+ zoomCheck.value +".jpg";
	
	var sizeFinal = (navigator.appName.search("Microsoft") == -1) ? document.body.offsetHeight : document.body.scrollHeight ;
	var zoomSize = (sizeFinal < 360) ? (sizeFinal - 40) : 320;

	document.getElementById("innerFrame").contentWindow.location.href = "../includes/showImage.asp?Imagem=" + zoomImg + "&Tamanho=" + zoomSize
	showPop();
	
	if (navigator.appName.search("Microsoft") == -1) { 
		zoomCheck.checked = (zoomCheck.checked == true) ? false : true;
		fotoColor(zoomCheck);
	}
} 

//================================================================================
// ADICIONAR E REMOVER CAMPOS DE UPLOAD

function fileAdd() { 

	var fileOnde = document.getElementById("fileCel");

	quebra = document.createElement("br")

	novo = document.createElement('input'); 
	novo.setAttribute('type', 'file'); 
	novo.setAttribute('name', 'arquivo[]');
	novo.setAttribute('className', 'inputEditar');
	novo.setAttribute('size', '58'); 
	
	fileOnde.appendChild(quebra);
	fileOnde.appendChild(novo);
	
	sizeLoad()

}

function fileDel(onde) {

	var fileOnde = document.getElementById("fileCel");
	
	if (fileOnde.getElementsByTagName("input").length > 1) {
		fileOnde.removeChild(fileOnde.lastChild);
		fileOnde.removeChild(fileOnde.lastChild);
		sizeLoad()
	}
	
}


</script>
</head>

<body>
<form name="form" action="alterar.asp" method="post" onSubmit="return validateForm(this);">
<input name="id" type="hidden" value="<%= Id %>">
<input name="numfotos" type="hidden" value="<%= numFotos %>">
<table id="tableForm" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td class="itemEditar">Fotos (<%= numFotos %>):</td>
              <td width="380" id="imgCel">
<%

If numFotos > 0 Then

	checkTr = 0
	numTd = 6
	
	Response.Write "<table border='0' cellspacing='4' cellpadding='0' align='center' bgcolor='#33FFCC'>" & vbCrLf
	
	For x=1 to numFotos
	
		If checkTr = 0 Then
			Response.Write vbTab & "<TR>" & vbCrLf
		End If
		
		Response.Write vbTab & vbTab & "<TD>"
		
			Response.Write "<label>"
			Response.Write "<input name='box_" & x & "' type='checkbox' value='" & x & "' onClick='fotoColor(this)' />"
			Response.Write "<img src='../interface/edit_foto_zoom.gif' onClick='zoomPop(this);' title='Visualizar imagem' >"
			Response.Write "</label>"
		
		Response.Write "</TD>" & vbCrLf
		
		checkTr = checkTr + 1

		If checkTr = numTd Then
			Response.Write vbTab & "</TR>" & vbCrLf
			checkTr = 0
		End If
	
	Next

	If checkTr <> numTd Then
		For i = checkTr to (numTd - 1)
			Response.Write vbTab & vbTab & "<TD>&nbsp;</TD>" & vbCrLf
		Next
		Response.Write vbTab & "</TR>" & vbCrLf	
	End If
	
Response.Write "</table>"
	
Else
	Response.Write "<div id='divEdit'>Ainda não há fotos nesta galeria</div>"
End If

%>
              </td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacerBig"></td>
            </tr>
			<tr>
              <td><a href="javascript:boxAll()" class="botao">selecionar todas</a></td>
			  <td><input name="excluir" type="button" id="botao" value="Excluir selecionados" onClick="enviar(1, this)" /></td>
    </tr>
            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacerBig"><br><img src="../interface/layout_pixel.gif" id="spacerBig"></td>
            </tr>
<tr>
    <td colspan="2" align="right"><img src="../interface/layout_pixel.gif" id="spacerBig"><img src="../interface/icons_delFile.jpg" onClick="fileDel()" title="remover campo" style="cursor: pointer; margin-right:2px;"><img src="../interface/icons_addFile.jpg" onClick="fileAdd()" title="adicionar campo" style="cursor: pointer;"></td>
</tr>
            <tr>
              <td id="td_foto" class="itemEditar">Foto:</td>
              <td id="fileCel"><input name="foto" type="file" class="inputEditar" size="58" /></td>
            </tr>

            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacerBig"></td>
    </tr>
            <tr>
            <td>&nbsp;</td>
              <td><input name="alterar" type="button" id="botao" value="Adicionar arquivo" onClick="enviar(2, this);" /></td>
            </tr>
      </table> 
</form>
</body>
</html>
<%
Set fso = nothing

RS.Close
Set RS = nothing

Conn.Close
Set Conn=nothing
%>