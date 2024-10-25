
<!--[if IE]> <style> #layoutTopo #info Div { width: 652px; height: 60px; } </style> <![endif]-->

<table id="layoutTopo" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td id="icons">
    	<a id="userIco" href="javascript:infoShow('user');"><b>informa&ccedil;&otilde;es de usu&aacute;rio</b></a>
        <a id="helpIco" href="javascript:infoShow('help');"><b>sistema de ajuda</b></a>
    </td>
    <td id="info">
        <% If Session("logado") = True Then %>
        <div id="userInfo">
            <a href="../usuarios/sair.asp"><img src="../interface/topo_userLogoff.jpg" border="0" title="fazer logoff" ><br>sair</a>
            <b><%= Session("userNome") %></b><br>
            &Uacute;ltimo acesso: <%= Server.HTMLEncode(FormatDateTime(Session("userAcesso"), 1)) %>
      </div>
        <% End If %>
    
        <div id="helpInfo"></div>
    </td>
  </tr>
</table>
