<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<%
Id = Trim(Request.QueryString("Id"))

Set RS=Server.CreateObject("Adodb.recordset")
	SQL = "SELECT loja.*, cep_estado.*, cep_cidade.*" &_
		  "FROM (cep_cidade INNER JOIN cep_estado ON cep_cidade.cep_estado_id = cep_estado.cep_estado_id) " &_
		  "INNER JOIN loja ON cep_cidade.cep_cidade_id = loja.cep_cidade_id " &_
		  "WHERE loja_id LIKE '" & Id & "';"

	RS.Open SQL,Conn,3,2

Set fso = CreateObject("Scripting.FileSystemObject")
%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel Administrativo</title>
<link href="../interface/innerStyle.css" rel="stylesheet" type="text/css">
<script src="../includes/java/checkForm.js"></script>
<script src="../includes/java/inner.js"></script>
<script language="JavaScript" type="text/JavaScript">

// CHECK FORM

function formCheck() {

formArray[0] = new Array ('nome', 1);
formArray[1] = new Array ('cidade', 3);
formArray[2] = new Array ('email', 1);
formArray[3] = new Array ('fone', 1);

}

</script>
</head>

<body>
<form name="form" action="alterar.asp" method="post" enctype="multipart/form-data" onSubmit="return validateForm(this);">
<input type="hidden" name="id" value="<%= Id %>">
<table id="tableForm" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_nome" class="itemEditar">Nome:</td>
              <td><input name="nome" type="text" class="inputEditar" value="<%= RS("loja_nome") %>" /></td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
                <td id="td_endereco" class="itemEditar">Endereco:</td>
                <td><input name="endereco" type="text" class="inputEditar" value="<%= RS("loja_endereco") %>" /></td>
            </tr>
<!-- Estados -->
            <tr>
                <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_estado" class="itemEditar">Estado:</td>
              <td><select name="estado" onChange="findCidade(this.value)">
                  <option value="0">Selecione o estado</option>
<%

	Set listRS=Server.CreateObject("Adodb.recordset")
		listSQL = "SELECT * FROM cep_estado ORDER BY cep_estado_nome;"
		listRS.Open listSQL,Conn,3,2
	
		Do While Not listRS.EOF
		
			If listRS("cep_estado_id") = RS("cep_estado_id") Then
				check = " selected"
			Else
				check = ""
			End If
			
			Response.Write "<option value='" & listRS("cep_estado_id") & "'" & check & ">"
			Response.Write listRS("cep_estado_nome")
			Response.Write "</option>"

			listRS.MoveNext
	
		Loop

		listRS.Close
	Set listRS = nothing

%>
                </select></td>
            </tr>
<!-- Cidades -->
            <tr>
                <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_cidade" class="itemEditar">Cidade:</td>
              <td><select name="cidade" id="cidade">
                  <option value="0">Selecione a cidade</option>
<%

	Set listRS=Server.CreateObject("Adodb.recordset")
		listSQL = "SELECT * FROM cep_cidade WHERE cep_estado_id = " & RS("cep_estado_id") & " ORDER BY cep_cidade_nome;"
		listRS.Open listSQL,Conn,3,2
	
		Do While Not listRS.EOF
		
			If listRS("cep_cidade_id") = RS("cep_cidade_id") Then
				check = " selected"
			Else
				check = ""
			End If
			
			Response.Write "<option value='" & listRS("cep_cidade_id") & "'" & check & ">"
			Response.Write listRS("cep_cidade_nome")
			Response.Write "</option>"

			listRS.MoveNext
	
		Loop

		listRS.Close
	Set listRS = nothing

%>
                </select></td>
            </tr>

			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
                <td id="td_email" class="itemEditar">E-mail:</td>
                <td><input name="email" type="text" class="inputEditar" value="<%= RS("loja_email") %>" /></td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
                <td id="td_fone" class="itemEditar">Fone:</td>
                <td><input name="fone" type="text" class="inputEditar" value="<%= RS("loja_fone") %>" /></td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
                <td id="td_descricao" class="itemEditar">Descrição:</td>
                <td><textarea name="descricao" class="inputEditar" style="height: 100px;"><%= RS("loja_desc") %></textarea></td>
            </tr>
			<tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacer"></td>
            </tr>
            <tr>
              <td id="td_arquivo" class="itemEditar">Foto:</td>
              <td id="fotoCel">
<%
If fso.fileExists(Server.MapPath("../../imagens/loja/" & Id & ".jpg")) = True Then

	Set arquivo = FSO.GetFolder(Server.MapPath("../../imagens/loja/")).files.item(Id & ".jpg")
				
		zoomImg = "../../imagens/loja/" & Id & ".jpg"
				
		Response.Write "<div id='divEdit'>"
		Response.Write "<div id='desc'><strong>Adicionada em:</strong> " & arquivo.datelastmodified & "</div>"
		Response.Write "<a id='del' href='../includes/msgPop.asp?Id=" & Id & "&Engine=delFoto' target='innerFrame' onClick='showPop()' title='Excluir foto'></a>"
		'Response.Write "<a id='zoom' href='../includes/showImage.asp?Imagem=" & zoomImg & "&Tamanho=340' target='innerFrame' onClick='showPop()' title='Vizualizar foto'></a>"
		Response.Write "<a id='change' href='javascript:fotoChange()' title='Alterar foto'></a>"
		Response.Write "</div>"
			
	Set arquivo = Nothing
	
Else

	Response.Write "<input name='arquivo' type='file' class='inputEditar' size='58' />"

End If
%>              </td>
            </tr>

            <tr>
              <td colspan="2"><img src="../interface/layout_pixel.gif" id="spacerBig"></td>
    </tr>
            <tr>
            <td>&nbsp;</td>
              <td><input name="alterar" type="submit" id="botao" value="alterar dados" /></td>
            </tr>
      </table> 
</form>
</body>
</html>
<%
Set fso = nothing
Set listRS = nothing

RS.Close
Set RS = nothing

Conn.Close
Set Conn=nothing
%>