
<!--API Maps-->
<script type="text/javascript">

    //Mapa
    function load() {
      if (GBrowserIsCompatible()) {

        var map = new GMap2(document.getElementById("mapa"));
//        map.setCenter(new GLatLng(-27.455366,-53.928307), 17);
        map.setCenter(new GLatLng(<?php echo($ll) ?>), 16);
        map.setMapType(G_NORMAL_MAP);

        // Sombra do marcador
        var baseIcon = new GIcon(G_DEFAULT_ICON);
        baseIcon.shadow = "http://www.google.com/mapfiles/shadow50.png";
        baseIcon.iconSize = new GSize(20, 34);
        baseIcon.shadowSize = new GSize(37, 34);
        baseIcon.iconAnchor = new GPoint(9, 34);
        baseIcon.infoWindowAnchor = new GPoint(9, 2);

        //Marcador	
//        var marker = new GMarker(new GLatLng(-27.455366,-53.928307));
        var marker = new GMarker(new GLatLng(<?php echo($ll) ?>));
        map.addOverlay(marker);

        //zoom in e Out
        map.addControl(new GSmallZoomControl());

      }
    }
</script>
<!--Fim api Maps-->





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

					Response.Write "<input name='mapa_address' id='mapa_address' type='hidden' value='Rua Matheo Gianella, 230" & " - " & RS("endereco_bairro") & " - " & RS("endereco_cidade") & " - " & RS("endereco_uf") & "' />"
					
					Response.Write "<b>Fone/Fax:</b> " & RS("endereco_fone")
									
				End If
					
			RS.Close
	
		call connClose()
		
	End Sub

'===================================================================================================================================

%>



	<h1>Contato</h1>

<!--    <form name="contato" method="post" action="conteudo/server/enviaContato.asp" >-->
    <form name="contato" method="post" action="enviar_contato/enviar_contato.php" >
    
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
	 
