<!--#include file="../functions/functions.asp" -->
<!--#include file="../functions/classConteudo.asp" -->
<%
	'cabeçalho Ajax
	call openAjax("xml")

	'verificar galeria
	call connOpen()

		RS = Conn.Execute("SELECT engine_galeria_id FROM engine_galeria WHERE engine_galeria_engine = '" & Request.QueryString("Engine") & "';")
		engineId = cInt(RS("engine_galeria_id"))
		
	call connClose()

	'montar XML
	Set FSO = CreateObject("Scripting.FileSystemObject")
		Set Arquivos = FSO.GetFolder(Server.Mappath("../../../imagens/engine_galeria/" & engineId & "/fotos")).Files
	
			Response.Write "<painel galeria=""" & engineId & """>"
		
			For Each File in Arquivos 
			
				checkId = Split(File.Name, ".jpg")(0)
			
				Response.Write "<imagem id=""" & checkId & """/>"
			
			Next 
			
			Response.Write "</painel>"
				
		Set Arquivos = Nothing
	Set FSO = Nothing

%>