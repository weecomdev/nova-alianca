<?php if(empty($eventos)){ ?>
<div class="evento">
    <div class="text">
    Nenhum evento nesta data.
    </div>
</div>
<?php }else{ ?>
<?php foreach ($eventos as $key => $evento): ?>
    <div class="evento" >
        <a href="#!/" class="seta">
            <div class="line_l"></div>
            <div class="line_r"></div>
        </a>
        <div class="text">
            <div class="left">
                <?php 
                    $data = explode(' ',$evento->data);
                    $date = explode('-',$data[0]);
                    $time = explode(':',$data[1]);
                ?>
                <h1><?php echo $date[2].' de '.getMonthBR($date[1]).', '.$time[0].':'.$time[1]; ?></h1>
                <h2><?php echo $evento->titulo ?></h2>
            </div>
            <div class="right">
                <?php echo $evento->texto; ?>
            </div>
        </div>
    </div>
<?php endforeach ?>
<?php } ?>