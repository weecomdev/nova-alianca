<%
Set Conn = Server.CreateObject("ADODB.Connection")

	If Request.ServerVariables("HTTP_HOST") = "localhost" Then
		Conn.Open "driver=MySQL ODBC 3.51 Driver;server=localhost;uid=root;pwd=teste;database=alianca"
	Else
		Conn.Open "Driver=MySQL ODBC 3.51 Driver;DATABASE=vinhosalianca;SERVER=mysql.novaalianca.coop.br;UID=vinhosalianca;PASSWORD=123456;"
	End If

%>