<%
Set connEnvios = Server.CreateObject("ADODB.Connection")
connEnvios.Open "DBQ=" & Server.MapPath("../../dados/envios.mdb") & ";Driver={Microsoft Access Driver (*.mdb)}" 
%>