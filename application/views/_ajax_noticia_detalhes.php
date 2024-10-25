<?php if(!empty($imagens)): ?>
<div class="banner">
    <ul>
    <?php foreach ($imagens as $key => $value): ?>
        <li class="<?php echo ($key == 0)? 'active' : 'next';?>" style="background:url(<?php echo site_url(NOTICIAS_IMAGES_PATH.$value->image) ?>) no-repeat center center;"></li>
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
        <?php 
            $data = explode('-',$noticia->data);
        /*?>
        <?php if($this->session->userdata('lang') == 'en'){ ?>
        <h1><?php echo getMonthBR($data[1],false,false,$this->session->userdata('lang')).' '.$data[2]; ?></h1>
        <?php }else{ ?>
        <h1><?php echo $data[2].' '.getMonthBR($data[1],false,false,$this->session->userdata('lang')); ?></h1>
        <?php } */?>
        <h2><?php echo $noticia->titulo ?></h2>
    </div>
    <div class="right">
        <?php echo $noticia->texto; ?>
    </div>
    <div class="fb-share-button" data-href="<?php echo site_url("noticias/detalhes/{$noticia->alias}") ?>" data-layout="button" style="    float: right;"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    setTimeout(function() { FB.XFBML.parse(); }, 1000);
});
</script>