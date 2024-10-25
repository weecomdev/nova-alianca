<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<%
Id = Trim(Request.Form("Id"))
Arquivo = cInt(Trim(Request.Form("Arquivo")))

Set fso = CreateObject("Scripting.FileSystemObject")
	Set folder = fso.GetFolder(Server.Mappath("../../arquivos/download/"& Id & "/"))
		Set files = folder.Files
		
		fileCount = 0
		
		For Each file in Files 
		
			If fileCount = Arquivo Then
				fso.DeleteFile Server.MapPath("../../arquivos/download/"& Id & "/" & File.Name)
			End If
			fileCount = fileCount + 1
		
		Next 

		Set files = Nothing
	Set folder = Nothing
Set fso = Nothing
%>
<script language="JavaScript" type="text/JavaScript">
	parent.arquivoDel(<%= Arquivo %>);
</script>