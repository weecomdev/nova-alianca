<?php
session_start();
include "../../../imports.php";

global $configObj;
$webConfDao = new CandidatosWebConfDao($db);
$configObj = new Config($db, $webConfDao->buscaEmpresaPrincipal());

$infoIncompletas = new InfoIncompletas($db);

?>

<div class="content-interna">
    <div class="alinhamento">
        <div class="clear">&nbsp;</div>
        <div class="div-box">
            <br />
            <br />

            

            <?php
            if($infoIncompletas->existeCampoVazio()){
                echo "<div  style=\"font-size: 13px; color:red\">
							<div style=\"text-align:center\">".
                utf8_encode($configObj->getValorDiretriz('mensagemCurriculoIncompletoCapa')."</div></br></br>
							<div tabindex='0' id='mensagemFalha' style=\"margin-left: 210px\">".$infoIncompletas->getCamposVaziosHTML())."</div>
                        <br>
                    <center> <strong class=\"migalha-ativa\"><a style=\"cursor: pointer;\" id='sair' >Sair</a></strong> </center> <br>
						  </div>";
            }

            ?>

            <br />
            <br />
            <br />
        </div>
    </div>
</div>

<script>

jQuery("#sair").click(function(){
    loginUtil.logout();
});

</script>