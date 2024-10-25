<?php if(!empty($comprar)): ?>
        <?php foreach ($comprar as $key => $compra): ?>
        <li class="comprar" data-slug="<?php echo $compra->alias ?>">
            <a href="javascript:void(0);" onclick="App.comprar.open_comprar_click(event,'<?php echo $compra->alias ?>');" >
            <?php 
            $image = $this->MCompras_imagem->getFirst($compra->compra_id);
            if(empty($image)) $image = IMG.'compras.jpg';
            else $image = COMPRAS_IMAGES_PATH.$image->thumb_image;
             ?>
                <div class="image" style="background:url(<?php echo site_url($image); ?>) center center;" ></div>
                <div class="title">
                    <div class="bg_title"></div>
                    <span>
                        <h2><?php echo $compra->titulo ?></h2>
                        <h3><?php echo $this->lang->line('veja_mais');?></h3>  
                    </span>
                </div>
                <div class="bg_title2"></div>
            </a>
        </li>
        <?php endforeach ?>
<?php endif; ?>