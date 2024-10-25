<%
Function RemoveAcentos(ByVal Texto)   

    Dim ComAcentos   
    Dim SemAcentos   
    Dim Resultado   
    Dim Cont   

    ComAcentos = "ΑΝΣΪΙΔΟΦάΛΐΜÒΩΘΓΥΒΞΤΫΚανσϊιδοφόλΰμςωθγυβξτϋκΗη"  
    SemAcentos = "AIOUEAIOUEAIOUEAOAIOUEaioueaioueaioueaoaioueCc"  
    Cont = 0   
    Resultado = Texto   

    Do While Cont < Len(ComAcentos)   
	    Cont = Cont + 1   
   		Resultado = Replace(Resultado, Mid(ComAcentos, Cont, 1), Mid(SemAcentos, Cont, 1))   
    Loop  
    
	RemoveAcentos = Resultado   

End Function
%>