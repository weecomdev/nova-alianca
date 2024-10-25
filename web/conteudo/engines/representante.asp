<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../functions/functions.asp" -->

    <h1>Representantes</h1>

    <div id="mapa">
        <object width="100%" height="100%" id="mapaFlash" align="middle">
        
            <param name="allowScriptAccess" value="sameDomain" />
            <param name="allowFullScreen" value="false" />
            <param name="movie" value="interface/swf/mapa.swf" />
            <param name="quality" value="high" />
            <param name="bgcolor" value="#ffffff" />
            
            <embed src="interface/swf/mapa.swf" quality="high" bgcolor="#ffffff" width="100%" height="100%" name="mapa" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash"/>
            
        </object>
	</div>    
    
    <fieldset>
    	<legend>Escolha um dos estados.</legend>
<%

		call connOpen()
		
			SQL = "SELECT representante_local.*, COUNT(representante_id) AS representante_total, cep_estado.*, cep_cidade.*" &_
				  "FROM (cep_cidade INNER JOIN cep_estado ON cep_cidade.cep_estado_id = cep_estado.cep_estado_id) " &_
				  "INNER JOIN representante_local ON cep_cidade.cep_cidade_id = representante_local.cep_cidade_id " &_
				  "GROUP BY cep_estado.cep_estado_id ORDER BY cep_estado.cep_estado_nome;"

			RS.Open SQL,Conn
	
				If Not RS.EOF Then			
				
					Response.Write "<select id='estado' name='estado' onchange='repBusca(this.value)'>"
					Response.Write "<option value='0'>Lista de estados</option>"
					
					Do While Not RS.EOF
						
						Response.Write "<option value='" & RS("cep_estado_uf") & "'>"
						Response.Write RS("cep_estado_nome") '& " (" & RS("representante_total") & ")"
						Response.Write "</option>"
						
						RS.MoveNext
					
					Loop
					
					Response.Write "</select>"
								
				End If
					
			RS.Close
	
		call connClose()

%>
    </fieldset>

	<div id="resultado"></div>
