<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<%

Id = Trim(Request.Form("Id"))
Linha = Trim(Request.Form("Linha"))

Set RS=Server.CreateObject("Adodb.recordset")

SQL = "SELECT * FROM produto WHERE produto_tipo_id = " & Id & ";"
RS.Open SQL,Conn,3,2

	If RS.EOF Then
		Response.Redirect "deletarEnd.asp?Id=" & Id & "&linha=" & Linha
	End If

RS.Close

%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel Administrativo</title>
<link href="../interface/popStyle.css" rel="stylesheet" type="text/css">
<style>

#divCat { display: none; margin-bottom: 10px; }
#divCat Select { width: 245px; background-color: #FFFFFF; font-size: 11px; }
#divCat Input { height: 22px; width: 22px; font-size: xx-small; margin-left: 5px; }

</style>
<script src="../includes/java/popResize.js"></script>
<script>

function showCat() {
	document.getElementById("divCat").style.display = "block";

	var wPop = document.body.scrollWidth;
	var hPop = (navigator.appName.search("Microsoft") == -1) ? document.body.offsetHeight : document.body.scrollHeight;
	parent.sizePop(wPop,hPop)
}

function checkSend() {
	if (document.getElementById("categoria").value != "0") { document.form.submit(); }
}

</script>
</head>
<body>

<table border="0" cellspacing="0" cellpadding="0" id="tableTitle">
    <tr>
        <td>o que fazer com os produtos deste tipo?</td>
    </tr>
</table>
    
<form id="popFrame" name="form" method="post" action="deletarEnd.asp?Id=<%= Id %>">

<div id="divCat">
    <select name="categoria" id="categoria">
<%
SQL = "SELECT * FROM produto_tipo WHERE produto_tipo_id != " & Id & " AND produto_linha_id = " & Linha & " ORDER BY produto_tipo_nome;"
RS.Open SQL,Conn,3,2

If RS.EOF Then
	Response.Write "<option value='0'>Não há outros tipos disponíveis</option>"
Else
	Response.Write "<option value='0'>Vincule estes produtos a um tipo</option>"
	Do While Not RS.EOF
		Response.Write "<option value='" & RS("produto_tipo_id") & "'>" & RS("produto_tipo_nome") & "</option>"
		RS.MoveNext
	Loop
End If

RS.Close
%>
    </select><input type="button" value="OK" class="botao" onClick="checkSend()">
</div>

<div id="divOpt">
    <input type="button" value="remanejar" onClick="showCat()" class="botao">
    <input type="submit" value="excluir" class="botao">
    <input type="button" value="cancelar" onClick="parent.hidePop()" class="botao">
</div>

<input name="manejo" type="hidden" value="OK" />
                
</form>

</body>
</html>
<%
Set RS = nothing

Conn.close
Set Conn = nothing
%>