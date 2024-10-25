<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<%

Engine = Trim(Request.QueryString("Engine"))
Id = Trim(Request.QueryString("Id"))
Arquivo = Trim(Request.QueryString("Arquivo"))

Response.AddHeader "Content-Type","application/x-msdownload" 
Response.AddHeader "Content-Disposition","attachment; filename=" & Arquivo 
Response.Flush 

Response.Buffer = True 
Const adTypeBinary = 1 

'leremos abaixo o arquivo em modo binário através do ADODB 
Set binario = Server.CreateObject("ADODB.Stream") 
	binario.Open 
	binario.Type = adTypeBinary 
	binario.LoadFromFile Server.MapPath("../../../arquivos/"& Engine & "/"& Id & "/" & Arquivo) 
	
	Response.BinaryWrite binario.Read 

	binario.Close 
Set binario = Nothing 

Response.Flush 

%>
