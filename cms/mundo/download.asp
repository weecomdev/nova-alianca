<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<%
Id = Trim(Request.QueryString("Id"))
Arquivo = Trim(Request.QueryString("Arquivo"))
'mostra via servidor que o response.addheader será aplicado para download 
response.AddHeader "Content-Type","application/x-msdownload" 

'mostramos o arquivo que será feito o download, independente de sua extensão 
'usaremos no exemplo: arquivo.pdf 
response.AddHeader "Content-Disposition","attachment; filename=" & Arquivo 
Response.Flush 

Response.Buffer = True 
Const adTypeBinary = 1 

'leremos abaixo o arquivo em modo binário através do ADODB 
Set binario = Server.CreateObject("ADODB.Stream") 
binario.Open 
binario.Type = adTypeBinary 

'Informe aqui o caminho completo do arquivo no servidor 
' Se preferir, use Server.MapPath("arquivo.pdf") 
binario.LoadFromFile Server.MapPath("../../arquivos/mundo/"& Id & "/" & Arquivo) 
Response.BinaryWrite binario.Read 

binario.Close 
Set binario = Nothing 
Response.Flush 
%>