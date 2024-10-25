<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../../conteudo/functions/functions.asp" -->
<%
'==============================================================================================================================='
' Cabeçalho CSS

	Response.ContentType = "text/css"
	
'==============================================================================================================================='
' Buscar cores

	call connOpen()

		RS.Open "SELECT * FROM cor",Conn		
		Forte = RS("cor_hexa")
		RS.MoveNext
		Neutro = RS("cor_hexa")
		RS.Close
			
	call connClose()
	
'==============================================================================================================================='
' CSS GERAL

	Sub cssGeral()
%>
        
        /* Forte */
        
        #topo #cabecalho { background-color: #<%= Forte %>; }
        #topo #menu { background-color: #<%= Forte %>; }
        A { color: #<%= Forte %>; }
        #conteudo H1 { color: #<%= Forte %>; }
        #conteudo H2 B { color: #<%= Forte %>; }
        #conteudo Ul.listar Li H2 { color: #<%= Forte %>; }
        #conteudo #paginar A:hover { color: #<%= Forte %>; }
        #conteudo Form A { color: #<%= Forte %>; }
        #conteudo Form A:hover { background-color: #<%= Forte %>; }
        #conteudo.home #painel Dl { color: #<%= Forte %>; }
        #conteudo.representante #resultado Dl Dt { color: #<%= Forte %>; }
        #conteudo A#voltar:hover { color: #<%= Forte %>; }
		#conteudo.produto Dl Dt { color: #<%= Forte %>; }
        
        /* Neutro */
        
        Body { color: #<%= Neutro %>; }
        Input, Select, Textarea { color: #<%= Neutro %>; }
        #topo #cabecalho Ul Li A:hover { color: #<%= Neutro %>; }
        #topo #menu Ul Li A:hover { color: #<%= Neutro %>; }
        #layout #topo Ul Li A.engine { color: #<%= Neutro %>; }
        #conteudo A#voltar { color: #<%= Neutro %>; }
        #conteudo Ul.listar Li A { color: #<%= Neutro %>; }
        #conteudo #paginar { border-color: #<%= Neutro %>; }
        #conteudo #paginar A { color: #<%= Neutro %>; }
        #conteudo Form Input, #conteudo Form Select, #conteudo Form Textarea { border-color: #<%= Neutro %>; }
        #conteudo Form A { background-color: #<%= Neutro %>; }
        #conteudo Form A:hover { color: #<%= Neutro %>; }
        #conteudo.onde Fieldset Legend { color: #<%= Neutro %>; }
        #conteudo.representante Fieldset Legend { color: #<%= Neutro %>; }
        #conteudo.representante #resultado Dl Dt { border-color: #<%= Neutro %>; }
		#conteudo.produto Dl Dd Ul Li A { color: #<%= Neutro %>; }
        #rodape { border-color: #<%= Neutro %>; }
        
<%
	End Sub
	
'==============================================================================================================================='
' CSS Abertura

	Sub cssAbertura()
%>
    
    /* Forte */
    #painel #mensagem { background-color: #<%= Forte %>; }
    
    /* Neutro */
    Body { color: #<%= Neutro %>; }
    
<%
	End Sub
	
'==============================================================================================================================='
' Selecionar por Página

	'Buscar página
	If Request.ServerVariables("HTTP_REFERER") <> "" Then
		urlArray = Split(Request.ServerVariables("HTTP_REFERER"),"/")
		cssEngine = Replace(urlArray(uBound(urlArray)), ".asp", "")
	End If

	'Escolher CSS
	Select Case cssEngine
	
		Case "abertura": call cssAbertura()
		Case Else : call cssGeral()
			
	End Select

%>