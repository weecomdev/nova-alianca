<?php
require 'imports.php';
global $db;

@header('Content-Type:text/html; charset=iso-8859-1');

$diagnosticos = new DiagnosticosDao($db);
$listaDiagnostico = $diagnosticos->buscarCamposDiagnostico();
$listaConfig = $diagnosticos->configuracaoMySql();
?>
<html lang="pt-BR">
<style>
	*{
		font-family: "Helvetica Neue" , "Lucida Grande" , "Segoe UI" , Arial, Helvetica, Verdana, sans-serif;
		font-size: 10pt;		
		list-style: none;
		margin: 0;
		padding: 0;
		text-decoration: none;
	}
		
	.dataHora
	{
		width: 160px;		
	}	
		
	.linhaOk
	{
		background-color: #C0DCC0;				
	}	
	
	.linhaErro
	{
		background-color: #FF686D;		
	}

	.linhaAviso
	{
		background-color: #FFE659;	
	}
	
	.tabela
	{		
		width: 100%;
	}		
	
</style>
<head>
  
  <title>Currículo Web - Informações Técnicas</title>
  <link rel="stylesheet" href="style/jquery-ui.css" />
  <script src="js/lib/jquery/jquery-1.9.1.js"></script>
  <script src="js/lib/jquery/jquery-ui.min.js"></script>  
  <script>
	  $(function() {
	    $( "#tabs" ).tabs();
	  });
  </script>
</head>
<body> 
	<div id="tabs">	
	  <ul>
	    <li><a href="#tabs-1">Log do Serviço de Diagnóstico</a></li>
	    <li><a href="#tabs-2">Informações Sobre a Instalação do PHP</a></li>
	    <li><a href="#tabs-3">Informações sobre a Instalação do MySql</a></li>	    	   
	  </ul>
	  <div id="tabs-1">
	  <table  class="tabela">   	
		<?php		 
			while(!$listaDiagnostico->EOF)
			{
			
			
				if($listaDiagnostico->fields['Tipo'] == "1")
				{
					?>
				  <tr class="linhaOk">				        
				          <td class="dataHora"><?php echo $listaDiagnostico->fields['Log'] ?></td>
				      </tr>
				      	  
	      <?php } else{ ?>
	      		  <tr class="linhaErro">				          
				          <td class="dataHora"><?php echo $listaDiagnostico->fields['Log'] ?></td>
				      </tr>
	      	
	             <?php } ?>	  
	      		      	      
		      <?php 
		        $listaDiagnostico->MoveNext();		      
		      }		
		
		?>
      </table>	
	  </div>
	  <div id="tabs-2">		 	     
	    <?php      
	      phpinfo();
	      	
	    ?>	   
	  </div>
	   <div id="tabs-3">		 	     
        <table  class="tabela">       	   
	       <?php
	         while(!$listaConfig->EOF)
	         {
	       	  ?>
       		     <tr >				        
       		       <td class="dataHora"><?php echo $listaConfig->fields['Variable_name'] ?></td>
       		       <td class="dataHora"><?php echo $listaConfig->fields['Value'] ?></td>
       		      </tr>				      	  	   	
       	      		      	      
       		  <?php 
       		  $listaConfig->MoveNext();		      
	       	 }               	
		    ?>  
	   </table>    
	  </div>	  	  
	  	  	  
	</div> 
</body>
</html>



