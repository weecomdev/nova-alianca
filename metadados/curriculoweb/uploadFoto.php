<html>
<head>
<title></title>
	<link rel="stylesheet" type="text/css" href="style/reset.css" />
	<link rel="stylesheet" type="text/css" href="style/text.css" />
	<link rel="stylesheet" type="text/css" href="style/960.css" />
	<link rel="stylesheet" type="text/css" href="style/curriculoweb.css" />
</head>
<body>
	
    <div style='margin-left:1%;float:left;width:24%;height:50%'>
	  <img alt="Foto do(a) Candidato(a)"	src="index.php?modulo=imagem&acao=pessoa&dummy=<?php echo Date("His");?>" width="72px" height="99px">
	</div>
    <div style='float:right;width:75%;height:50%'>              
        Você pode adicionar um arquivo JPG <br />
        (o limite de tamanho do arquivo é de 400KB).
     	<form action="index.php" method="POST" enctype="multipart/form-data">
	    	<input type="hidden" name="MAX_FILE_SIZE" value="409600" > 
		    <input type="hidden" name='modulo' value="upload" > 
		    <input type="hidden" name='acao' value="uploadFoto"> 
		    <input type="hidden" name='fezUpload' value="1">
		    <br />		  			   
		    <input type="file" name='arquivo' value="escolher arquivo" accept="image/jpeg, image/pjpeg">
		    <br /><br /><br />
		    <div style='margin-left:0px;'>
		      <input type="submit" value="Fazer Upload da Foto">
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
