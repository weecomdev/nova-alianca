<?php $this->load->view('_header');?>

<section class="section row" id="produtos_detalhes">
	<div class="product container responsive" style="background: #e6e6e6;">
        <div class="desc">
            <h1><?php echo $product->name ?></h1>
            <h2><?php echo $product->type ?></h2>
            <?php echo $product->description ?>
            <?php 
            $lojas = json_decode($product->onde_comprar);
            if(!empty($lojas)){
             ?>
            <div class="comprar">
                <div class="selecter_comprar">
                    <select name="" id="" class="comprar_sel">
                    <?php
                    foreach($lojas as $k => $l):
                    ?>
                        <option value="<?php echo $l->link; ?>"><?php echo $l->loja; ?></option>
                    <?php
                    endforeach;
                    ?>
                    </select>
                </div>
            </div>
            <?php } ?>

            <?php if(!empty($product->options)){ ?>
            <?php $items = explode(',',$product->options); ?>
            <div class="embalagem">
                <?php echo $this->lang->line('disponivel_nas_embalagens');?>
                <ul>
                    <?php foreach ($items as $key => $v): ?>
                    <li class="types"><?php echo $v; ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
            <?php } ?>
        </div>
        <div class="bg">
            <img src="<?php echo site_url(PRODUCTS_PATH.$category->product_category_id.'/'.$product->img_bg); ?>" alt="">
        </div>
        <div class="product_img">
            <img src="<?php echo site_url(PRODUCTS_PATH.$category->product_category_id.'/'.$product->img); ?>" alt="">
        </div>
        <?php if(!empty($next)){ ?>
        <a class="seta_outer left" href="<?php echo site_url('produtos/'.$category->alias.'/'.$next->alias);?>" title="<?php echo $next->name.' '.$next->type; ?>">
            <div class="bootle">
                <img src="<?php echo site_url(PRODUCTS_PATH.$category->product_category_id.'/'.$next->img_bootle); ?>"  alt="">
            </div>
            <div class="seta">
                <div class="line_l"></div>
                <div class="line_r"></div>
            </div>
        </a>
        <?php } ?>
        <?php if(!empty($prev)){ ?>
        <a class="seta_outer right" href="<?php echo site_url('produtos/'.$category->alias.'/'.$prev->alias);?>" title="<?php echo $prev->name.' '.$prev->type; ?>">
            <div class="bootle">
            <img src="<?php echo site_url(PRODUCTS_PATH.$category->product_category_id.'/'.$prev->img_bootle); ?>"  alt="">
            </div>
            <div class="seta">
                <div class="line_l"></div>
                <div class="line_r"></div>
            </div>
        </a>
        <?php } ?>
    </div>
    <div class="image container responsive" style="background:url(<?php echo site_url(PRODUCTS_PATH.$category->product_category_id.'/'.$product->img_frase); ?>) no-repeat right top rgba(91,52,52,0.5);background-blend-mode:multiply;" data-stellar-background-ratio="0.5">
        <!-- <img class="img" src="<?php echo site_url(PRODUCTS_PATH.$category->product_category_id.'/'.$product->img_frase); ?>" alt="" data-stellar-ratio="0.5"> -->
        <h1><?php echo $product->frase_p3; ?></h1>
        <h2><?php echo $product->frase_p1; ?></h2>
        <h3><?php echo $product->frase_p2; ?></h3>
    </div>
</section>

<?php $this->load->view('_footer');?>
