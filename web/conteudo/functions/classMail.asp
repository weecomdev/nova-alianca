<%

'==============================================================================================================================='
' CLASSE PARA ENVIAR E-MAILS
'==============================================================================================================================='

Class Envio

'-------------------------------------------------------------------------------------------------------------------------------'
' Variáveis

	Dim fromArray, Destino
	Dim Assunto, Conteudo, Anexo
	Dim Smtp, checkSend
	Dim modeloPasta, modeloArquivo

'-------------------------------------------------------------------------------------------------------------------------------'
' Checagem inicial

	Sub Class_Initialize()
	
		checkSend = checkCom("Persits.MailSender")
		Smtp = "smtp-web.kinghost.net"
		modeloPasta = "../../../email/"
		modeloArquivo = "email.html"
		
	End Sub

'-------------------------------------------------------------------------------------------------------------------------------'
' Checar existência do componente

	Function checkCom(componente)
	
		On Error Resume Next
		
		Set checkObj = Server.CreateObject(componente)
		
			If Err = 0 Then
				checkCom = True
			Else
				checkCom = False
			End If
			
		Set checkObj = Nothing
	
	End Function

'-------------------------------------------------------------------------------------------------------------------------------'
' Setar remetente

	Sub Remetente(nome, endereco)
	
		Redim fromArray(1)
		
		fromArray(0) = nome
		fromArray(1) = endereco
	
	End Sub

'-------------------------------------------------------------------------------------------------------------------------------'
' Adicionar destinatário

	Sub addMail(nome, endereco)
	
		'Cria array de destinatários
		If Not isArray(Destino) Then
			Redim Destino(1,-1)
		End If
	
		'Redimensiona destinatários
		Redim Preserve Destino(1, (uBound(Destino,2) + 1))
		
		'Insere dados do destinatário
		Destino(0, uBound(Destino,2)) = nome
		Destino(1, uBound(Destino,2)) = endereco
	
	End Sub

'-------------------------------------------------------------------------------------------------------------------------------'
' Adicionar anexo

	Sub addAnexo(arquivo)
	
		'Cria array de destinatários
		If Not isArray(Anexo) Then
			Redim Destino(-1)
		End If
	
		'Redimensiona destinatários
		Redim Preserve Destino(uBound(Anexo) + 1)
		
		'Insere dados do destinatário
		Destino(uBound(Anexo)) = arquivo
	
	End Sub

'-------------------------------------------------------------------------------------------------------------------------------'
' Conteúdo

	'retorna caminho virtual
	Function getHttp()
	
		urlArray = Split(Request.ServerVariables("URL"), "/")
		getHttp = "http://" & Request.ServerVariables("HTTP_HOST") & Replace( Request.ServerVariables("URL"), urlArray(uBound(urlArray)), "")
	
	End Function
	
	'tratar imagens do email
	Function imgHttp(Codigo)
	
		novaURL = getHttp() & modeloPasta
		
		Set objRegExp = New RegExp 
		
			objRegExp.Global = True
			objRegExp.IgnoreCase = True 
			objRegExp.Pattern = "[^""'(][.-a-zA-Z0-9\/.]*(\.[Jj][Pp][Gg]|\.[Gg][Ii][Ff]|\.[Jj][Pp][Ee][Gg]|\.[Pp][Nn][Gg])"
			
			Codigo = objRegExp.Replace(Codigo, novaUrl & "$&")
			
		Set objRegExp = Nothing
		
		imgHttp = Codigo
	
	End Function
	
	'retorna conteúdo do email
	Function BodyMail()
	
		'busca modelo de email
		Set FSO = CreateObject("Scripting.FileSystemObject")
			Set htmlBody = FSO.OpenTextFile(server.MapPath(modeloPasta & modeloArquivo),1,False)
			
				BodyMail = htmlBody.ReadAll
				htmlBody.Close
			
			Set htmlBody = Nothing
		Set FSO = Nothing
		
		'altera caminho das imagens
		BodyMail = imgHttp(BodyMail)
		
		'insere conteudo no modelo
		BodyMail = Replace(BodyMail, "XXX", Conteudo)

	End Function
	
'-------------------------------------------------------------------------------------------------------------------------------'
' Enviar e-mail

	Sub Enviar
	
		'Envio por ASPEmail
		If checkSend Then
		
			Set Mail = Server.CreateObject("Persits.MailSender") 
			
				Mail.Host = Smtp
				Mail.FromName = fromArray(0)
				Mail.From = fromArray(1)
				
				'adicionar destinatários
				For x = 0 to uBound(Destino,2)
					Mail.AddAddress Destino(1,x), Destino(0,x)
				Next
				
				Mail.isHTML = True
				Mail.Subject = Assunto
				Mail.CharSet = "iso-8859-1"
				Mail.Body = BodyMail
				
				'adicionar anexos
				If isArray(Anexo) Then
					For x = 0 to uBound(Anexo)
						Mail.AddAttachment Anexo(x)
					Next
				End If
				
				'enviar
				If Request.ServerVariables("HTTP_HOST") <> "localhost" Then
					Mail.Send
				End If
			
			Set Mail = Nothing 
			
		'Envio por ASPMail
		Else
			
			Set Mail = Server.CreateObject("SMTPsvg.Mailer") 
			
				Mail.FromName = fromArray(0)
				Mail.FromAddress = fromArray(1)
				Mail.RemoteHost = Smtp

				'adicionar destinatários
				For x = 0 to uBound(Destino,2)
					Mail.AddRecipient Destino(0,x), Destino(1,x)
				Next

				Mail.Subject = Assunto
				Mail.ContentType = "text/html"
				Mail.CustomCharSet = "iso-8859-1"
				Mail.BodyText = BodyMail
				
				'adicionar anexos
				If isArray(Anexo) Then
					For x = 0 to uBound(Anexo)
						Mail.AddAttachment Anexo(x)
					Next
				End If
				
				'enviar
				If Request.ServerVariables("HTTP_HOST") <> "localhost" Then
					Mail.SendMail
				End if
			
			Set Mail = Nothing 
			
		End If

	End Sub
	
'-------------------------------------------------------------------------------------------------------------------------------'
' Acionar envio por último

	Sub Class_Terminate()
	
		call Enviar()
	
	End Sub

	
End Class

%>