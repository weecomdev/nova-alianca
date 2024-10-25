<html>
<head>
<title></title>
	<link rel="stylesheet" type="text/css" href="style/reset.css" />
	<link rel="stylesheet" type="text/css" href="style/text.css" />
	<link rel="stylesheet" type="text/css" href="style/960.css" />
	<link rel="stylesheet" type="text/css" href="style/curriculoweb.css" />
</head>
<body>	
    <div style='float:left'>              
     	<form action="index.php" method="POST" enctype="multipart/form-data">
	    	<input type="hidden" name="MAX_FILE_SIZE" value="409600" > 
		    <input type="hidden" name='modulo' value="upload" > 
		    <input type="hidden" name='acao' value="uploadAnexo"> 
		    <input type="hidden" name='fezUploadAnexo' value="1">
		    <br />		  			   
		    <input type="file" name='arquivoAnexo' value="escolher arquivo">
		    <br /><br /><br />
		    <div style='margin-left:0px;'>
		      <input type="submit" value="Fazer Upload do Anexo">
		    </div>  
		    		    
	    </form>
    </div>
    
    <div style='margin-left:1%;height:50%;width:90%'>	
    <?php
    if(is_a($erros, "ErrosUpload")){
	    if($erros->getNroErros() > 0){
            echo $erros->getErrosHTML();
	    }
    }
    ?>   
	</div>
</body>
</html>
