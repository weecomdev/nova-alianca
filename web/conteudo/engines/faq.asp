<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<!--#include file="../functions/classConteudo.asp" -->

<%

'==============================================================================================================================='
' Respostas

	Function modeloTexto()
	
		Response.Write "<h2>" & RS("faq_nome") & "</h2>"
		call Pagina.montaImg(Pagina.Id)
		Response.Write RS("faq_desc")
		
	End Function
	
'==============================================================================================================================='
' Listagem

	Function modeloLista()
	
		Response.Write "<a href='default.asp?Engine=faq&Id=" & cStr(RS("faq_id")) & "'>" & RS("faq_nome") & "</a>"

	End Function

'==============================================================================================================================='
' Formulário

	Sub montaPergunta()
	
%>

        <h1>Faça a sua pergunta</h1>
    
        <form name="pergunta" method="post" action="conteudo/server/enviaFaq.asp" >
        
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
    
<%
	
	End Sub

'==============================================================================================================================='

	Set Pagina = New Conteudo
	
		Pagina.Legenda = "Dúvidas mais frequentes"
		Pagina.listaOrdem = "faq_destaque, faq_nome"
	
		Select Case Pagina.subEngine
		
			Case "pergunta"
			
				Pagina.imgEngine
				call montaPergunta
				
			Case Else
	
				If Pagina.Id = 0 Then
					Pagina.imgEngine
					Pagina.montaLista
					Response.Write "<a href='default.asp?Engine=faq&subEngine=pergunta'><h1>Faça a sua pergunta</h1></a>"
				Else
					Pagina.montaTexto
				End If

		End Select

	Set Pagina = Nothing
	
%>

