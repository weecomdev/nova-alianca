<%
Function fileList(Id)

Set fso = CreateObject("Scripting.FileSystemObject")
	Set folder = fso.GetFolder(Server.Mappath("../../arquivos/download/"& Id & "/"))
		Set files = folder.Files
		
		fileCount = 0
		
		Response.Write "<ul>"
		
		If files.count > 0 Then
		
			For Each file in Files 
			
				Response.Write "<li>"
				Response.Write "<span>"
				Response.Write Mid(File.Name, 1, 50)
				If Len(Mid(File.Name, 1, 50)) > 50 Then
					Response.Write "..."
				End If
				Response.Write "</span>"
				Response.Write "<a class='delete' href='../includes/msgPop.asp?Id=" &  Id & "&Engine=delFile&Arquivo=" & fileCount & "' target='innerFrame' onClick='showPop()' title='Excluir arquivo'></a>"
				Response.Write "<a class='down' href='download.asp?Id=" & Id & "&Arquivo=" & File.Name & "' class='linkTitulo' title='fazer download'></a>"
				Response.Write "</li>"
			
				fileCount = fileCount + 1
			
			Next 
			
		Else
			
			Response.Write "<li>Não há arquivos nesta publicação</li>"
		
		End If
		
		Response.Write "</ul>"

		Set files = Nothing
	Set folder = Nothing
Set fso = Nothing

End Function
%>