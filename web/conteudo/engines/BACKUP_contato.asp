<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->
<!--#include file="../functions/classConteudo.asp" -->
<%

'===================================================================================================================================
' Listar departamentos de contato

	Sub montaContato()
	
		call connOpen()
	
			SQL = "SELECT * FROM contato;"
			
			RS.Open SQL,Conn
	
				If RS.EOF Then			
					Response.Write "<option>Não há informações disponíveis.</option>"
				Else
				
					Do While Not RS.EOF
						Response.Write "<option value='" & RS("contato_id") & "'>" & RS("contato_nome") & "</option>"
						RS.MoveNext
					Loop
									
				End If
					
			RS.Close
	
		call connClose()
		
	End Sub

'===================================================================================================================================
' Listar endereço

	Sub montaEndereco()
	
		call connOpen()
			
			SQL = "SELECT endereco.*, cep_cidade.cep_cidade_nome AS endereco_cidade, cep_estado.cep_estado_uf AS endereco_uf " &_
				  "FROM (cep_cidade INNER JOIN cep_estado ON cep_cidade.cep_estado_id = cep_estado.cep_estado_id) " &_
				  "INNER JOIN endereco ON cep_cidade.cep_cidade_id = endereco.cep_cidade_id;"

			RS.Open SQL,Conn
	
				If Not RS.EOF Then			
					
					Response.Write "<div id='endereco'>"

					'Div para API do Google Maps
					Response.Write "<div id='mapa'></div>"
					
					'Imagem do mapa
					'Response.Write "<img class='mapa' src='../imagens/engine/endereco.jpg' alt='Mapa' />"

					Response.Write "<b>" & RS("endereco_nome") & "</b>"
					
					Response.Write "<address>"
					Response.Write RS("endereco_rua") & " - " & RS("endereco_bairro") & " - " & RS("endereco_cidade") & " - " & RS("endereco_uf")
					Response.Write "</address>"
					
					Response.Write "<b>Fone/Fax:</b> " & RS("endereco_fone")
									
				End If
					
			RS.Close
	
		call connClose()
		
	End Sub

'===================================================================================================================================

%>
	<h1>Contato</h1>

    <form name="contato" method="post" action="conteudo/server/enviaContato.asp" >
    
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
    	    <label>Setor:</label>
            <select name="setor">
                <% call montaContato %>
            </select>
		</fieldset>

		<fieldset class="msg">
	        <label for="mensagem">Mensagem:</label>
	        <textarea name="mensagem" id="mensagem"></textarea>
		</fieldset>
        
        <a id="botao" onclick="enviaForm(this);">Enviar</a>
        <%= checkSend() %>
    
    </form>
    
    <% call montaEndereco %>
	 
