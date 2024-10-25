<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<!--#include file="../functions/classConteudo.asp" -->
<%

'==============================================================================================================================='
' Formulário

	Sub montaPergunta()
	
%>
		<p>
        <h1>Faça a sua pergunta</h1>
    
        <form name="pergunta" method="post" action="conteudo/server/enviaOnde.asp" >
        
            <fieldset>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" />
            </fieldset>
    
            <fieldset>    
                <label for="email">E-mail:</label>
                <input type="text" name="email" id="email" />
            </fieldset>
        
            <fieldset>
                <label>Telefone:</label>
                <input type="text" name="telefone" />
            </fieldset>
        
            <fieldset>
                <label>Cidade:</label>
                <input type="text" name="cidade" />
            </fieldset>
    
            <fieldset class="msg">
                <label for="mensagem">Pergunta:</label>
                <textarea name="mensagem" id="mensagem"></textarea>
            </fieldset>
            
            <a id="botao" onclick="enviaForm(this);">Enviar</a>
            <%= checkSend() %>
        
        </form>
    	</p>
<%
	
	End Sub

'==============================================================================================================================='

	Function modeloTexto()
	
		Select Case Pagina.subEngine
			
			Case "download"
		
				Response.Write "<h1>" & RS("download_nome") & "</h1>"
				Response.Write "<p>" & RS("download_desc") & "</p>"
				Pagina.montaArquivos
				
			Case Else
			
				Response.Write "<h1>" & RS("onde_nome") & "</h1>"
				call Pagina.montaImg(Pagina.Id)
				Response.Write RS("onde_desc")
			
		End Select
		
	End Function


'==============================================================================================================================='

	Function modeloLista()
	
		Response.Write "<a href='default.asp?Engine=onde&Id=" & cStr(RS("onde_id")) & "'>"
		Response.Write "<h1>" & RS("onde_nome") & "</h1>"
		Response.Write "</a>"

	End Function

'==============================================================================================================================='

	Set Pagina = New Conteudo
	
		'checar download
		If Pagina.subEngine <> "" Then
			Pagina.Engine = Pagina.subEngine
		End If
		
		'Setar Id único
		Pagina.Id = 2
		
		'Escrever dados
		Pagina.montaTexto
		
		'Caso não seja download
		If Pagina.subEngine = "" Then
		
			'Link para downloads
			Response.Write "<p><a href=""default.asp?Engine=onde&subEngine=download""><h1>Catálogo Virtual</h1></a></p>"
		
			'Formulário
			'call montaPergunta()
			
		End If
				
	Set Pagina = Nothing
	
%>
