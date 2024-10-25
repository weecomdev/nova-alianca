<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="conteudo/functions/functions.asp" -->
<%
'==============================================================================================================================='
'Checagem de Engine

	Select Case Request.QueryString("Engine")
	
		Case "mundo", "video", "contato", "vinicola", "produto", "faq", "agenda", "premio", "imprensa", "onde", "representante", "confraria"
			checkEngine = Trim(Request.QueryString("Engine"))
		Case Else
			checkEngine = "home"

	End Select

'==============================================================================================================================='
'Checagem de JS por Engine

	Sub checkJS(pagina)
	
		Select Case pagina
		
			Case "home"
				jsUrl = "conteudo/javascript/home.js"
			Case "contato"

				If Request.ServerVariables("SERVER_NAME") = "www.vinhos-alianca.com.br" Then
				jsUrl = "http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAgH05CTMPFZ5sJ8tDiW-pZxRebeaIKSz5yum4i-SBwnLPiuvsuBRciPjrOlWSkr-ZWvqIA1iUvj7RaA"
				else
				jsUrl = "http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAgH05CTMPFZ5sJ8tDiW-pZxS7bvNI2KL5Q8T3MsDYKWDx-8p0YRRDwqqwv4kp-h0Sjp4jIOoL-4e3dQ"
				End If
		End Select
		
		Response.Write "<script language=""javascript"" type=""text/javascript"" src=""" & jsUrl & """></script>"
	
	End Sub

'==============================================================================================================================='
'Botão voltar

	Sub checkVoltar()
		
		If InStr(Request.ServerVariables("HTTP_REFERER"), getHttp()) > 0 Then
			Response.Write "<a id='voltar' href='javascript:history.back()'>Voltar</a>"
		End If
	
	End Sub
	
'==============================================================================================================================='

%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <META NAME="author" CONTENT="CDI - Comunicação Digital Inteligente">
    <META NAME="description" CONTENT="Vinícula Nova Aliança">

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Vinícola Nova Aliança</title>
	<link href="interface/css/geral.css" rel="stylesheet" type="text/css" />
	<script language="javascript" type="text/javascript" src="conteudo/javascript/geral.js"></script>
	<script language="javascript" type="text/javascript" src="conteudo/javascript/painelEngine.js"></script>
	<% call checkJS(checkEngine) %>


<!--Analytics-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18021768-11']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>



</head>
<body>

	<!-- Acessibilidade -->
    <a accesskey="c" class="acesso" href="#texto">Ir ao conteúdo</a>

    <!-- Layout -->
    <div id="layout">
    
        <!-- Topo -->
        <!--#include file="conteudo/ssi/topo.asp" -->
        
        <!-- Conteúdo -->
        <a name="texto"></a>
        <div id="conteudo" class="<%= checkEngine %>">

        	<% call checkVoltar() %>
        	<% Server.Execute "conteudo/engines/" & checkEngine & ".asp" %>

        </div>
        
        <!-- Rodapé -->
        <!--#include file="conteudo/ssi/rodape.asp" -->
        
    </div>   

<bb1><!---1448657758---><bb2></body>
</html>

