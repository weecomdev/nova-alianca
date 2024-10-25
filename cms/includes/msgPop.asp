<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<%
Id = Trim(Request.QueryString("Id"))
Engine = Trim(Request.QueryString("Engine"))

testeArray = Split(Request.ServerVariables("HTTP_REFERER"), "/")
Link = testeArray(Ubound(testeArray)-1)

If Engine = "" Then
	Engine = "deletar"
	Action = "excluir"
Else
	Action = "alterar"
End If
	
%>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel Administrativo</title>
<link href="../interface/popStyle.css" rel="stylesheet" type="text/css">
<script src="../includes/java/popResize.js"></script>
</head>
<body>

    <table border="0" cellspacing="0" cellpadding="0" id="tableTitle">
      <tr>
        <td>deseja realmente <%= Action %> este item?</td>
      </tr>
    </table>
    
    <form id="popFrame" name="form" method="post" action="../<%= Link %>/<%= Engine %>.asp">
        <div style="display: none;">
        <%
        For Each Item in Request.QueryString
            Response.Write "<input type='hidden' name='" & Item & "' value='" & Request.QueryString(Item)(1) & "'>"
        Next
        %>
        </div>
        
        <input type="submit" value="Sim" class="botao">
        <input type="button" value="Não" onClick="parent.hidePop()" class="botao">
    </form>

</body>
</html>