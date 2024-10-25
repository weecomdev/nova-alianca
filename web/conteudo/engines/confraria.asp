<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<!--#include file="../functions/classConteudo.asp" -->

<%

'==============================================================================================================================='
' Cadastro

	Sub montaForm

%>
        <h1>Cadastre-se</h1>
    
        <!--form name="contato" method="post" action="conteudo/server/enviaCadastro.asp" -->
	    <form name="contato" method="post" action="enviar_contato/enviar_contato.php" >
        	<input name="form" type="hidden" value="confraria" />
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
                <label for="mensagem">Mensagem:</label>
                <textarea name="mensagem" id="mensagem"></textarea>
            </fieldset>
            
            <a id="botao" onclick="enviaForm(this);">Enviar</a>
            <%= checkSend() %>
        
        </form>
        
<%

	End Sub

'==============================================================================================================================='
' Galeria

	Sub montaGaleria(Id)

		Response.Write "<h1>Galeria de fotos</h1>"
		
		'checar número de total disponíveis
		Set FSO = CreateObject("Scripting.FileSystemObject")
			numFotos = FSO.GetFolder(Server.MapPath("../imagens/galeria/" & Id & "/fotos/")).Files.Count
		Set FSO = Nothing
	
		'caso existam imagens
		If numFotos > 0 Then
			Response.Write "<div class='frame'>"
			Response.Write "<div id='zoom'><img src='../imagens/galeria/" & Id & "/fotos/" & Id & "_1.jpg' alt='Confraria' /></div>"
			Response.Write "</div>"
			Response.Write "<div id='thumb'></div>"
		Else
			Response.Write "<p>Não há imagens disponívies</p>"
		End If

	End Sub
	
'==============================================================================================================================='
' Confraria
	
	Function modeloTexto()
	
		Response.Write "<h1>" & RS("confraria_nome") & "</h1>"
		call Pagina.montaImg(Pagina.Id)
		Response.Write RS("confraria_desc")
		
	End Function
	
	Function modeloLista()
	
		Response.Write "<a href='default.asp?Engine=confraria&subEngine=" & Pagina.subEngine & "&Id=" & cStr(RS(Pagina.Engine & "_id")) & "'>"
		Response.Write "<h1>" & RS(Pagina.Engine & "_nome") & "</h1>"
		Response.Write "</a>"

	End Function

'==============================================================================================================================='
' Montar página

	Set Pagina = New Conteudo
	
		Select Case Pagina.subEngine
		
			Case "cadastro"
			
				Pagina.imgEngine
				call montaForm
				
			Case "galeria"
				
				Pagina.Engine = "galeria"
				Pagina.listaOrdem = "galeria_post, galeria_nome"
		
				If Pagina.Id = 0 Then
					If Pagina.totalRS > 1 Then
						Pagina.montaLista
					Else
						Pagina.Id = Pagina.menorRS
						call montaGaleria(Pagina.Id)
					End If
				Else
					call montaGaleria(Pagina.Id)
				End If
				
			Case Else
			
				'Conteúdo único
				Pagina.Id = 2
				Pagina.montaTexto			
			
				'Link para downloads
				Response.Write "<p><a href=""default.asp?Engine=confraria&subEngine=galeria""><h1>Galeria de Fotos</h1></a></p>"
				Response.Write "<p><a href=""default.asp?Engine=confraria&subEngine=cadastro""><h1>Cadastre-se</h1></a></p>"
			
		End Select

	Set Pagina = Nothing
	
%>

