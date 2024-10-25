<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="checkUser.asp" -->
<!--#include file="conecta.asp" -->
<%

	Id = Trim(Request.QueryString("Id"))
	Engine = Trim(Request.QueryString("Engine"))

	Response.AddHeader "Content-Disposition","attachment; filename=" & Engine & "_" & Id & ".doc" 
	Response.ContentType = "application/vnd.ms-word"

%>
<html>
<head>

<style>

Body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}

</style>

</head>
<body>
<%

Set RS=Server.CreateObject("Adodb.recordset")

Select Case Engine
'	Case "reprodutora", "garanhao", "animal"
'		
'		SQL = "SELECT * FROM " & Engine & " WHERE id" & Engine & " LIKE '" & Id & "';"
'		RS.Open SQL,Conn,3,2
'			
'			Response.Write "<h3>" & RS("nome") & "</h3>"
'			
'			Response.Write "<b>Local:</b> " & RS("local") & "<br>"
'			Response.Write "<b>Criador:</b> " & RS("criador") & "<br><br>"
'			
'			Response.Write "<b>Pai:</b> " & RS("pai") & "<br>"
'			Response.Write "<b>Mãe:</b> " & RS("mae") & "<br><br>"
'			
'			Response.Write "<b>Avô Paterno:</b> " & RS("pai_pai") & "<br>"
'			Response.Write "<b>Avó Paterno:</b> " & RS("pai_mae") & "<br><br>"
'			
'			Response.Write "<b>Avô Materno:</b> " & RS("mae_pai") & "<br>"
'			Response.Write "<b>Avó Paterno:</b> " & RS("mae_mae") & "<br>"
'			
'			Response.Write "<br><hr><br>"
'			
'			Set fso = Server.CreateObject("Scripting.FileSystemObject")
'				If fso.fileExists(Server.MapPath("../../imagens/" & Engine & "/fotos/" & Id & ".jpg")) Then
'				
'					Response.Write "<img src='" & Server.MapPath("../../imagens/" & Engine & "/fotos/" & Id & ".jpg") & "' />"
'					Response.Write "<br>"
'								
'				End If
'			Set fso = Nothing
'
	Case "empresa", "diferencial"

		SQL = "SELECT * FROM " & Engine & ";"
		RS.Open SQL,Conn,3,2
			
			Response.Write "<h3>" & RS("nome") & "</h3>"
			Response.Write RS("descricao")
			
			Response.Write "<br><hr><br>"
			
			Set fso = Server.CreateObject("Scripting.FileSystemObject")
				If fso.fileExists(Server.MapPath("../../imagens/geral/" & Engine & ".jpg")) Then
				
					Response.Write "<img src='" & Server.MapPath("../../imagens/geral/" & Engine & ".jpg") & "' />"
					Response.Write "<br>"
								
				End If
			Set fso = Nothing

End Select
			
		RS.Close
	Set RS = nothing

	Conn.Close
Set Conn=nothing

%>
</body>
</html>