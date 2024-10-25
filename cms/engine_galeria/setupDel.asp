<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/conecta.asp" -->
<%
Id = Trim(Request.Form("id"))
numFotos = Trim(Request.Form("numfotos"))

Set fso = CreateObject("Scripting.FileSystemObject")

	'Deletar fotos selecionadas
	For x = 1 to CInt(numFotos)
		If Request.Form("box_" & x) <> "" Then
			fso.DeleteFile Server.MapPath("../../imagens/engine_galeria/" & Id & "/fotos/" & Id & "_" & x & ".jpg")
			fso.DeleteFile Server.MapPath("../../imagens/engine_galeria/" & Id & "/thumbs/" & Id & "_" & x & ".jpg")
		End If
	Next

	'Processo de renomear arquivos
	Set folder = fso.GetFolder(Server.Mappath("../../imagens/engine_galeria/" & Id & "/thumbs/"))
		Set files = folder.Files
		
			'número de arquivos que restaram
			afterNum = files.count
			
			'Caso não sejam deletadas todas as imagens
			If afterNum > 0 Then
			
				'acrescentar zero antes dos arquivos que restaram para preservar a ordem
				For Each File in Files
					'verificar quantidade de zeros antes do nome
					nomeFinal = Replace(Replace(File.Name, Id & "_", ""), ".jpg", "")
					numZero = Len(afterNum) - Len(nomeFinal)
					
						For x = 1 to numZero
							preZero = preZero & "0"
						Next	
					
					'renomear imagens				
					fso.MoveFile Server.MapPath("../../imagens/engine_galeria/" & Id & "/fotos/" & File.Name), _
								 Server.MapPath("../../imagens/engine_galeria/" & Id & "/fotos/" & preZero & nomeFinal & ".jpg")
					'renomear miniaturas
					fso.MoveFile Server.MapPath("../../imagens/engine_galeria/" & Id & "/thumbs/" & File.Name), _
								 Server.MapPath("../../imagens/engine_galeria/" & Id & "/thumbs/" & preZero & nomeFinal & ".jpg")
					
					preZero = ""
				Next
	
				numNew = 1
				
				'renomear arquivos para nomenclatura definitiva
				For Each File in Files
				
					If numNew <= afterNum Then
						'renomar imagens
						fso.MoveFile Server.MapPath("../../imagens/engine_galeria/" & Id & "/fotos/" & File.Name), _
									 Server.MapPath("../../imagens/engine_galeria/" & Id & "/fotos/" & Id & "_" & numNew & ".jpg")
						'renomear miniaturas
						fso.MoveFile Server.MapPath("../../imagens/engine_galeria/" & Id & "/thumbs/" & File.Name), _
									 Server.MapPath("../../imagens/engine_galeria/" & Id & "/thumbs/" & Id & "_" & numNew & ".jpg")
						
						numNew = numNew + 1
					End If
					
				Next
			
'Caso sejam deletadas todas as imagens torna galeria invisível
'			Else
'				
'				Set RS=Server.CreateObject("Adodb.recordset")
'				SQL = "SELECT * FROM engine_galeria WHERE engine_galeria_id LIKE '" & Id & "'"
'				RS.Open SQL,Conn,3,2
'				
'					RS("engine_galeria_destaque") = False
'					RS.update
'				
'				RS.close
'				set RS = nothing
'
			End If

		Set files = Nothing
	Set folder = Nothing
	
Set fso = Nothing

Conn.close
Set Conn = nothing

'=====================================================

Response.Redirect "setup.asp?Id=" & Id

%>
