<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<%
'========================================================================================='
' funções executadas no código

Function GetDaysInMonth(iMonth, iYear)
	Dim dTemp
	dTemp = DateAdd("d", -1, DateSerial(iYear, iMonth + 1, 1))
	GetDaysInMonth = Day(dTemp)
End Function

Function GetWeekdayMonthStartsOn(dAnyDayInTheMonth)
	Dim dTemp
	dTemp = DateAdd("d", -(Day(dAnyDayInTheMonth) - 1), dAnyDayInTheMonth)
	GetWeekdayMonthStartsOn = WeekDay(dTemp)
End Function

Function SubtractOneMonth(dDate)
	SubtractOneMonth = DateAdd("m", -1, dDate)
End Function

Function AddOneMonth(dDate)
	AddOneMonth = DateAdd("m", 1, dDate)
End Function

'========================================================================================='

Dim dDate     ' Date we're displaying calendar for
Dim iDIM      ' Days In Month
Dim iDOW      ' Day Of Week that month starts on
Dim iCurrent  ' Variable we use to hold current day of month as we write table
Dim iPosition ' Variable we use to hold current position in table

'========================================================================================='

'verifica se a data inserida é válida
If IsDate(Request.QueryString("date")) Then
	dDate = CDate(Request.QueryString("date"))
Else
	If IsDate(Request.QueryString("month") & "-" & Request.QueryString("day") & "-" & Request.QueryString("year")) Then
		dDate = CDate(Request.QueryString("month") & "-" & Request.QueryString("day") & "-" & Request.QueryString("year"))
	Else
		dDate = Date()
		If Request.QueryString.Count <> 0 Then
			Response.Write "Data inválida.<BR><BR>"
		End If
	End If
End If

'Montando o calendário do mês escolhido
iDIM = GetDaysInMonth(Month(dDate), Year(dDate))
iDOW = GetWeekdayMonthStartsOn(dDate)

%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Calendário</title>
<script src="../includes/java/popResize.js"></script>
<script language="JavaScript" type="text/JavaScript">

checkW = 200;

function addDate(data, texto) {

	var dateTd = parent.document.getElementById("dataIn");
	var checkField = dateTd.getElementsByTagName("input")
	
	checkField[0].value = data;
	checkField[1].value = texto;
	
	parent.hidePop();
	
}

</script>
<style>
Body { background-color: FFFFFF; font-family: "Trebuchet MS", Geneva, Arial, Helvetica, sans-serif; }
Table {	width: 180px; font-size: 12px; border-top: 10px solid #FFFFFF; border-bottom: 10px solid #FFFFFF; }
A, Td {	width: 23px; height: 23px; line-height: 21px; text-align: center; text-decoration: none; }
A { display: block; }
Td { background: url(../interface/calendar_onButton.jpg) center no-repeat; }

A.linkDia { background: url(../interface/calendar_offButton.jpg) center no-repeat; color: #333333; }
A.linkDia:hover { background-image: url(../interface/calendar_grayButton.jpg); color: #FFFFFF; }

#titulo Td { background: url(../interface/calendar_blackButton.jpg) center no-repeat;}
#titulo A { color: #FFFFFF; }
#titulo B {
	display: block;
	background: url(../interface/calendar_blackTitle.jpg) center no-repeat;
	width: 100%;
	height: 23px;
	color: #FFFFFF;
	font-size: xx-small;
}

#dias Td { background: url(../interface/calendar_grayButton.jpg) center no-repeat; color: #333333; }

</style>
</head>
<body>

<table border="0" cellspacing="2" cellpadding="0" align="center">
	<tr id="titulo">

<td><a href="calendar.asp?date=<%= SubtractOneMonth(dDate) %>">&lt;&lt;</a></td>
<td colspan="5" style=" width: auto;"><b><%= Server.HTMLEncode(MonthName(Month(dDate))) & " de " & Year(dDate) %></b></td>
<td><a href="calendar.asp?date=<%= AddOneMonth(dDate) %>">&gt;&gt;</a></td>

  </tr>
	<tr id="dias">
		<td>D</td>
		<td>S</td>
		<td>T</td>
		<td>Q</td>
		<td>Q</td>
		<td>S</td>
		<td>S</td>
	</tr>
<%
'criar células vazias para o começo do mês
If iDOW <> 1 Then
	Response.Write vbTab & "<TR>" & vbCrLf
	iPosition = 1
	Do While iPosition < iDOW
		Response.Write vbTab & vbTab & "<TD>&nbsp;</TD>" & vbCrLf
		iPosition = iPosition + 1
	Loop
End If

'colocar dias do mês na tabela
iCurrent = 1
iPosition = iDOW
Do While iCurrent <= iDIM

	If iPosition = 1 Then
		Response.Write vbTab & "<TR>" & vbCrLf
	End If
	
	'listar dias do mês
	numberDate = Server.HTMLEncode(FormatDateTime(iCurrent & "/" & Month(dDate) & "/" & Year(dDate), 2))
	formatDate = Server.HTMLEncode(FormatDateTime(iCurrent & "/" & Month(dDate) & "/" & Year(dDate), 1))
	Response.Write vbTab & vbTab & "<TD><A class='linkDia' HREF=""javascript:addDate('" & numberDate & "', '" & formatDate & "');"">" & iCurrent & "</A></TD>" & vbCrLf
	
	If iPosition = 7 Then
		Response.Write vbTab & "</TR>" & vbCrLf
		iPosition = 0
	End If
	
	iCurrent = iCurrent + 1
	iPosition = iPosition + 1
Loop

'células vazias do fim do mês
If iPosition <> 1 Then
	Do While iPosition <= 7
		Response.Write vbTab & vbTab & "<TD>&nbsp;</TD>" & vbCrLf
		iPosition = iPosition + 1
	Loop
	Response.Write vbTab & "</TR>" & vbCrLf
End If
%>
</table>
