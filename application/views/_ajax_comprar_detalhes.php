<?php if(!empty($imagens)): ?>
<div class="banner">
    <ul>
    <?php foreach ($imagens as $key => $value): ?>
        <li class="<?php echo ($key == 0)? 'active' : 'next';?>" style="background:url(<?php echo site_url(COMPRAS_IMAGES_PATH.$value->image) ?>) no-repeat center center;"></li>
    <?php endforeach ?>
    </ul>
    <?php if(count($imagens)>1){ ?>
    <div class="seta_outer left">
        <div class="seta">
            <div class="line_l"></div>
            <div class="line_r"></div>
        </div>
    </div>
    <div class="seta_outer right">
        <div class="seta">
            <div class="line_l"></div>
            <div class="line_r"></div>
        </div>
    </div>
    <?php } ?>
</div>
<?php endif; ?>
<div class="text">
    <div class="left">
        <h2><?php echo $compra->titulo ?></h2>
    </div>
    <div class="right">
        <?php echo $compra->texto; ?>
    </div>
</div>