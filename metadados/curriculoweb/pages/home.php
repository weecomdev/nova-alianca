<?php

	include_once 'imports.php';	
	global $configObj;
	$dateUtil = new DataUtil();					

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='pt-BR'>
<head>
	<title>Currículo Web</title>	
	<!----<meta http-equiv="X-UA-Compatible" content="IE=edge" />-->

	<meta http-equiv='Content-Type' content='text/html; charset= iso-8859-1' />
	<meta name="author" content="BF2 Tecnologia" />
	<meta name="Description" content="" />
	<meta name="Language" content="PT-BR" />	
	<meta name="Copyright" content="BF2 Tecnologia" />
	<meta name="Designer" content="BF2 Tecnologia" />
	
	<base href="<?php echo $_SESSION['UsaHttps']."://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].dirname($_SERVER['PHP_SELF'])."/" ?>"/>

	<link rel="shortcut icon" href="images/favicon.ico" />
	
	<link rel="stylesheet" type="text/css" href="style/reset.css" />
	<link rel="stylesheet" type="text/css" href="style/text.css" />
	<link rel="stylesheet" type="text/css" href="style/960.css" />
	<link rel="stylesheet" type="text/css" href="style/curriculoweb.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.all.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.base.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.theme.css" />	
 	<link rel="stylesheet" type="text/css" href="style/jquery.ui.accordion.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.autocomplete.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.button.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.core.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.datepicker.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.dialog.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.progressbar.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.resizable.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.selectable.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.slider.css" />
	<link rel="stylesheet" type="text/css" href="style/jquery.ui.tabs.css" />	
	<link rel="stylesheet" type="text/css" href="style/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="style/cor<?php echo $configObj->getValorDiretriz('cor');?>.css" />
	

	<script type="text/javascript" language="javascript" src="js/lib/jquery/jquery-1.6.min.js"></script>
	<script language="javascript" type="text/javascript" src="js/lib/jquery/jquery.maskedinput.js"></script>
	<script type="text/javascript" language="javascript" src="js/lib/jquery/jquery-ui.min.js"></script>
	
<!-- 	<script type="text/javascript" language="javascript" src="js/lib/jquery/jquery-ui-1.8.2.custom.min.js"></script>	 -->

	<script language="javascript" type="text/javascript" src="js/lib/jquery/jquery.priceFormat.js"></script>
	<script type="text/javascript" language="javascript" src="js/bf2/bf2.js"></script>
	<script type="text/javascript" language="javascript" src="js/infoIncompletas.js"></script>
	<script type="text/javascript" language="javascript" src="js/date-pt-BR.js"></script>
	
	
	<script type="text/javascript" src="js/PessoaCurso.js"></script>
	<script type="text/javascript" src="js/EmpresaAnterior.js"></script>
	<script type="text/javascript" src="js/DadoComplementar.js"></script>
	<script type="text/javascript" src="js/Vagas.js"></script>
	<script type="text/javascript" src="js/VagasHome.js"></script>
	<script type="text/javascript" src="js/Login.js"></script>
	
	
	<script type="text/javascript" language="javascript" src="js/curriculoweb.js"></script>
	<script type="text/javascript" language="javascript">jQuery.noConflict();</script>
<script>
$=jQuery;

jQuery(document).ready(function () {
    var dialog = jQuery("#camposIncompletos").dialog({
        autoOpen: false,
        height: 350,
        width: 416,
        modal: true,
        closeText: 'fechar',        		        	                        	
    });	          
});

     function myFunction() {
  var x = document.getElementById("tableListVaga");
  x.focus();
}


</script>
</head>
<?php $existeCampoVazio = $infoIncompletas->existeCampoVazio();?>
<body onload="vagaHomeUtil.pesquisar(this.form);vagaHomeUtil.buscarVagasConcorridas(this.form);">
	<div class="container_16">	
		<div class="grid_1">&nbsp;</div>
		<div class="grid_14">
			<?php include 'site/web/cabecalho.php'; ?>
			<div class="clear">&nbsp;</div>
			
			<div id="mainPanel">
				<div class="content">
					<div class="home">
						<div class="bem-vindo" style="height: 400px">
                        <div tabindex="0">
						<strong>Olá! <?php echo $_SESSION["NomePessoaLogada"]; ?>!</strong><br/><br/>
						<?php echo $configObj->getValorDiretriz('mensagemBemVindo'); ?>	
							<br/><br/>
                        </div>
							<div class="box-cadastrar-atualizar" <?php if($existeCampoVazio) echo "style=\"background: #FFFFFF url('images/box-cadastrar-incompleto.jpg') no-repeat;\""?>>
								<div class="box-cadastrar-atualizar-content" <?php if($existeCampoVazio) echo "style=\"color:red;padding-left: 105px; padding-top: 0px; \""?>>
								<?php 
								if($existeCampoVazio){
									echo "<div tabindex='0'>".$configObj->getValorDiretriz('mensagemCurriculoIncompletoCapa')."</br><strong class=\"migalha-ativa\"><a style=\"cursor: pointer;\" id='abreIncompletas' >Clique Aqui</a></strong> para verificar as informações que devem ser preenchidas.<br></div>";	
								}
                                ?>						
								<div tabindex="0"><strong class="migalha-ativa"><a style="cursor: pointer;" onclick="curriculoWebUtil.openMenu({modulo: 'pessoa', entidade:'informacoesPessoais'});">Cadastrar/atualizar currí­culo</a></strong></div>
                               <?php 
                                    if($pessoaexclusao->fields['Excluir'] == "S")
                                    {
                                      echo "<div tabindex=\"0\">Exclusão solicitada</div>";
                                    }   
                                    else
                                    {
                                        echo "<div tabindex=\"0\"><strong class=\"migalha-ativa\"><a style=\"cursor: pointer;\" onclick=\"javascript: curriculoWebUtil.MostrarSolicitarExclusao();\">Solicitar exclusão do currículo</a></strong></div>";
                                    }
                                ?>                
								<?php 
								if(!$existeCampoVazio){
									echo "<div tabindex='0'>"."Atualizado em ".$dateUtil->formatDateTime($_SESSION["UltAlteracao"])."</div>";
								}
                                ?>
									
								</div>
							</div>
						</div>
						<div class="vagas-disponiveis">
							<div class="titulo-vagas-disponiveis" tabindex="0" aria-label="Vagas Disponíveis Grupo">&nbsp;</div>
							<div class="box-middle-vagas-disponiveis">
								<div class="box-top-vagas-disponiveis"></div>
										
									<div class="box-middle-content">
                                        <div>
										
                                                                                <?php                    
                                                                                    $diretrizTipoDeFiltro = $configObj->getValorDiretriz('filtrarVagasPorAreaOuRegiao');
                                                                                    
                                                                                    if( $diretrizTipoDeFiltro == 1){
                                                                                ?>                                                                            
                                                                                        <div style="float: left; width: 240px; margin-right: 10px;">
                                                                                            Área de Atuação:<br/>
                                                                                            <select id="AreaAtuacao" name="AreaAtuacao" class="campo" style="width: 240px;">
                                                                                                    <option value="">Selecione ... </option>
                                                                                            <?php 
                                                                                            if (!is_null($listaAreaAtuacao)){
                                                                                                    while (!$listaAreaAtuacao->EOF) { ?>
                                                                                                            <option value="<?php echo $listaAreaAtuacao->fields['AreaAtuacao']; ?>"><?php echo $listaAreaAtuacao->fields['Descricao60']; ?></option>
                                                                                                    <?php $listaAreaAtuacao->MoveNext(); 
                                                                                                    }
                                                                                            } ?>
                                                                                            </select>
                                                                                        </div>                                                                            
                                                                                <?php
                                                                                    }
                                                                                    else
                                                                                    if( $diretrizTipoDeFiltro == 2)
                                                                                    {
                                                                                ?>
                                                                                        <div style="float: left; width: 240px; margin-right: 10px;">
                                                                                            Região:<br/>
                                                                                            <select id="Regiao" name="Regiao" class="campo" style="width: 240px;">
                                                                                                    <option value="">Selecione ... </option>
                                                                                            <?php 
                                                                                            if (!is_null($listaRegiao)){
                                                                                                    while (!$listaRegiao->EOF) { ?>
                                                                                                            <option value="<?php 
                                                                                                                echo $listaRegiao->fields['Regiao']; 
                                                                                                            ?>">
                                                                                                                <?php 
                                                                                                                echo $listaRegiao->fields['Descricao60']; 
                                                                                                                ?>
                                                                                                            </option>
                                                                                                    <?php $listaRegiao->MoveNext(); 
                                                                                                    }
                                                                                            } ?>
                                                                                            </select>
                                                                                        </div>  
                                                                                <?php
                                                                                    }
                                                                                ?>                                                                            
                                                                            
                                                                            
										<div style="float: left; margin-top: 7px; width: 80px;">
											<input type="button" aria-label="Filtrar" onblur="myFunction()" class="botao-filtrar" style="float: none; margin-bottom: 10px; margin-top: 10px;" value="" onclick="vagaHomeUtil.pesquisar(this.form);"/>
										</div>
                                        </div>

										<div style="max-height: 165px; width: 348px; overflow: auto">					

											<table id="tableListVaga"  class="informacoes-academicas" width="330px">
								
											</table>
                                        </div>
									    <div class="clear"></div>
                                    </div>
	
									
								<div class="box-bottom-vagas-disponiveis"></div>
							</div>
						</div>
						<div class="vagas-concorridas">
							<div class="titulo-vagas-concorridas" aria-label="Vagas Concorridas Grupo" tabindex="0">&nbsp;</div>
							<div class="box-middle-vagas-disponiveis">
                                <div class="clear"></div>
								<div class="box-top-vagas-disponiveis"></div>					
									<div class="box-middle-content">	

										<div style="max-height: 165px; width: 348px; overflow: auto">
											<table id="tableListVagaConcorrida" class="informacoes-academicas" width="330px">
								
											</table>

										</div>
										<div class="clear"></div>
			
									</div>
									
								<div class="box-bottom-vagas-disponiveis"></div>
							</div>
						</div>
						<div class="clear"></div>
						
					</div>
				</div>	
			</div>

			<div class="clear">&nbsp;</div>
			<?php include 'site/web/rodape.php'; ?>
		</div>			
		<div class="grid_1">&nbsp;</div>
	</div>

</body>

<div id="camposIncompletos" title="Campos Incompletos" style="font-size: 11px; font-family: Arial; ">
	<b><?php echo $infoIncompletas->getCamposVaziosHTML();?></b>		
</div>

<script>
											
jQuery("#abreIncompletas").click(function(){
		jQuery("#camposIncompletos").dialog('open');			
});

</script>

</html>