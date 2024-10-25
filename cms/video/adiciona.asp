<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="../includes/engines/functions.asp" -->
<%

call upOpen

Function tubeId(url)

	If InStr(Trim(url), "?v=") > 0 Then
		tubeId = Split(Split(Trim(url), "?v=")(1), "&")(0)
	Else
		If InStr(Trim(url), "/v/") > 0 Then
			tubeId = Split(Split(Trim(url), "/v/")(1), "&")(0)
		End If
	End If
	
End Function

Set add = new cmsEngine

	add.Tabela = "video"
	add.Campos = Array("nome","desc", "url")
	add.Valores = Array( Upload.Form("nome"), Upload.Form("descricao"), tubeId(Upload.Form("url")) )
	
	add.Adicionar
	
Set add = Nothing

%>

<script language="JavaScript" type="text/JavaScript">
parent.document.location.reload();
</script>
