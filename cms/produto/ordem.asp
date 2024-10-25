<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

Id = Trim(Request.QueryString("Id"))
Ordem = cInt(Trim(Request.QueryString("Ordem")))
Linha = Trim(Request.QueryString("Linha"))

call connOpen

	SQL = "SELECT COUNT(produto_id) AS total FROM produto WHERE produto_tipo_id = " & Linha & ";"
	RS.Open SQL,Conn
	
		Total = cInt(RS("total"))

	RS.Close

call connClose

%>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Painel Administrativo</title>
<link href="../interface/popStyle.css" rel="stylesheet" type="text/css">
<script src="../includes/java/popResize.js"></script>
<script>

	function enviaOrdem(quem) {
	
		var formulario = document.getElementById("popFrame")
		
		formulario.action = "mudaOrdem.asp?Acao=" + quem;
		formulario.submit();
	
	}

</script>

</head>
<body>

    <table border="0" cellspacing="0" cellpadding="0" id="tableTitle">
      <tr>
        <td>deseja alterar a ordem deste item?</td>
      </tr>
    </table>
    
    <form id="popFrame" name="form" method="post">
    
        <div style="display: none;">
            <input type="hidden" name="id" value="<%= Id %>">
            <input type="hidden" name="ordem" value="<%= Ordem %>">
			<input type="hidden" name="linha" value="<%= Linha %>">
        </div>
        
        <% If Ordem > 1 Then %>
        <input type="button" value="Subir" class="botao" onClick="enviaOrdem('Sobe')">
        <% End If %>
        <% If Ordem < Total Then %>
        <input type="button" value="Descer" class="botao" onClick="enviaOrdem('Desce')">
        <% End If %>
        <input type="button" value="Cancelar" onClick="parent.hidePop()" class="botao">
        
    </form>

</body>
</html>