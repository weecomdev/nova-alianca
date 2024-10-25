<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

	'cachê
	Response.Expires = 0
	Response.expiresabsolute = Now() - 1
	Response.CacheControl = "no-cache"
	Response.AddHeader "Pragma", "no-cache"
	Response.Charset = "iso-8859-1"
	
	'Info
	Id = cInt(Request.QueryString("Id"))
	Cidade = cInt(Request.QueryString("Cidade"))
	Local = cInt(Request.QueryString("Local"))
	
	'Checar requisição
	If Local = 0 Then
	
		'Adiconar
		Set add = new cmsEngine
		
			add.Tabela = "representante_local"
			add.Campos = Array("[representante_id]", "[cep_cidade_id]")
			add.Valores = Array(Id, Cidade)
		
			add.Adicionar
			
			novoId = add.novoId
			
		Set add = Nothing
		
		'Dados para inserir no HTML
		call connOpen()
		
			SQL = "SELECT cep_estado.*, cep_cidade.*" &_
				  "FROM cep_cidade INNER JOIN cep_estado ON cep_cidade.cep_estado_id = cep_estado.cep_estado_id " &_
				  "WHERE cep_cidade_id = " & Cidade & ";"

			RS = Conn.Execute(SQL)
			
			Response.ContentType = "text/xml"
			Response.Write "<?xml version=""1.0"" encoding=""ISO-8859-1"" ?>"
			
			Response.Write "<novo>"
			Response.Write "<local id=""" & novoId & """ cidade=""" & RS("cep_cidade_id") & """>" & RS("cep_estado_uf") & " | " & RS("cep_cidade_nome") & "</local>"
			Response.Write "</novo>"
		
		call connClose()

	Else
	
		'Deletar
		Set del = new cmsEngine

			del.Tabela = "representante_local"
			del.Id = Local
			
			del.Deletar

		Set del = Nothing

	End If
		
%>