<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!--#include file="conteudo/functions/functions.asp" -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Listar produtos</title>
<style>

* { margin: 0; padding: 0; }

Body {
	font-family: "Trebuchet MS", Georgia, "Times New Roman", Times, serif;
	font-size: 13px;
	color: #8D8573;
	background: #F4F4F4;
	margin: 20px 20px 0px 20px;
}

A { text-decoration: none; color: #2b1515; }

Dl { margin-left: 20px; border-right: 1px solid #2b1515; }
Dl Dl { border-right: none; }
Dl Dt {
	position: relative;
	display: block;
	font-weight: bold;
	font-size: 20px;
	line-height: 30px;
	padding-left: 20px;
	border-left: 1px solid #2b1515;
	border-bottom: 1px solid #2b1515;
	border-top: 1px solid #2b1515;
	background-color: #2b1515;
	color: #FFF;
	cursor: pointer;
}
Dl Dd Dl Dt { font-size: 16px; background: #8D8573; color: #2b1515; }
Dl Dd Dl Dt:first-child { border-top: none; }

Dl Dd Ul, p {
	list-style: none;
	padding: 10px;
	margin-left: 20px;
	border-left: 1px solid #2b1515;
	background: #FFF;
}
Dl Dd Ul Li { line-height: 24px; } 
Dl Dd Ul Li A { display: block; } 
Dl Dd Ul Li A:hover { background-color: #f4f4f4; }

Span {
	position: absolute;
	right: 0px;
	top: 0px;
	width: 30px;
	height: 30px;
	line-height: 30px;
	color: #FFF;
	text-align: center;
	font-size: 36px;
}

</style>
<script>

function titulo(quem) {
	
	var conteudo = quem.nextObject();
	var sinal = quem.getElementsByTagName("span")[0];
	
	conteudo.style.display = (conteudo.style.display != "none") ? "none" : "block" ;
	sinal.innerHTML = (sinal.innerHTML != "+") ? "+" : "-";
	
}

Object.prototype.nextObject = function() {
	var n = this;
	do n = n.nextSibling;
	while (n && n.nodeType != 1);
	return n;
}

</script>
</head>
<body>
<%

	call connOpen()
		
		'Montar produtos		
		Sub listar(idLinha)
		
			'Listagem dos produtos
			SQL = "SELECT produto.*, produto_tipo.*, produto_linha.* " &_
				  "FROM (produto_tipo INNER JOIN produto_linha ON produto_tipo.produto_linha_id = produto_linha.produto_linha_id) " &_
				  "INNER JOIN produto ON produto_tipo.produto_tipo_id = produto.produto_tipo_id " &_
				  "WHERE produto_tipo.produto_linha_id = " & idLinha & " " &_
				  "ORDER BY produto_linha.produto_linha_ordem, produto_tipo.produto_tipo_ordem, produto.produto_ordem;"
			
			RS.Open SQL,Conn
	
				'Caso não hajam produtos
				If RS.EOF Then
					Response.Write "<p>Não há itens disponíveis.</p>"
					
				'Caso hajam produtos
				Else
				
					'Abre Dl
					Response.Write "<dl>"
					
					'Para cada produto
					Do While Not RS.EOF
					
						'Caso seja outro tipo
						If checkTipo <> RS("produto_tipo_id") Then
						
							'zerar contador
							contador = 0
						
							'Escreve título
							Response.Write "<dt onclick='titulo(this)'><strong>" & RS("produto_tipo_ordem") & "º</strong> - " & RS("produto_tipo_nome") & "<span>-</span></dt>"
							
							'Abrir Dd com listagem
							Response.Write "<dd>"
							Response.Write "<ul>"						
						
						End If
						
						'Adicionar contador
						contador = contador + 1
						
						'Caso a ordem seja zero
						If RS("produto_ordem") = 0 Then
							'Atualizar ordem
							Set ordemRS = CreateObject("ADODB.Recordset") 
								ordemRS = Conn.Execute("UPDATE produto SET produto_ordem = " & contador & " WHERE produto_id = " & RS("produto_id") & ";")
							Set ordemRS = Nothing
						End If

						'Listar produto
						Response.Write "<li>"
						Response.Write "<a href='default.asp?Engine=produto&subEngine=ver&Id=" & cStr(RS("produto_id")) & "'>"
						Response.Write "<strong>" & RS("produto_ordem") & "º</strong> - " & RS("produto_nome")
						Response.Write "</a>"
						Response.Write "</li>"
						
						'Checar tipo atual
						checkTipo = RS("produto_tipo_id")
										
						'Próximo registro
						RS.MoveNext
						
						'Caso não seja o último
						If Not RS.EOF Then
						
							'Caso seja outro tipo
							If checkTipo <> RS("produto_tipo_id") Then
							
								'Fecha Listagem e Dd
								Response.Write "</ul>"
								Response.Write "</dd>"
							
							End If
						
						'Caso seja o último
						Else
						
							'Fecha Listagem e Dd
							Response.Write "</ul>"
							Response.Write "</dd>"
						
						End If
					
					Loop
					
					'Fecha Dl
					Response.Write "</dl>"
					
				End If
					
			RS.Close
			
		End Sub
		
		'Montar linhas
		
		Set linhaRS = CreateObject("ADODB.Recordset")
		
			'Listagem dos produtos
			linhaSQL =  "SELECT * FROM produto_linha ORDER BY produto_linha.produto_linha_ordem;"
			
			linhaRS.Open linhaSQL,Conn

				Response.Write "<dl>"
			
				Do While Not linhaRS.EOF
				
					Response.Write "<dt onclick='titulo(this)'><strong>" & linhaRS("produto_linha_ordem") & "º</strong> - " & linhaRS("produto_linha_nome") & "<span>-</span></dt>"
					Response.Write "<dd>"
					
					call listar(linhaRS("produto_linha_id"))
					
					Response.Write "</dd>"
					
					linhaRS.MoveNext
				
				Loop
				
				Response.Write "</dl>"
				
			linhaRS.Close
			
		Set linhaRS = Nothing
			
	call connClose()

%>
</body>
</html>
