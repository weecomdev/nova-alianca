<?php if(!empty($dicas)): ?>
        <?php foreach ($dicas as $key => $dica): ?>
        <li class="dicas" data-slug="<?php echo $dica->alias ?>">
            <a href="javascript:void(0);" onclick="App.dicas.open_dicas_click(event,'<?php echo $dica->alias ?>');" >
            <?php 
            $image = $this->MDicas_imagem->getFirst($dica->dica_id);
            if(empty($image)) $image = IMG.'dicas.jpg';
            else $image = DICAS_IMAGES_PATH.$image->thumb_image;
             ?>
                <div class="image" style="background:url(<?php echo site_url($image); ?>) center center;" ></div>
                <div class="title">
                    <div class="bg_title"></div>
                    <span>
                        <h2><?php echo $dica->titulo ?></h2>
                        <h3><?php echo $this->lang->line('veja_mais');?></h3>  
                    </span>
                </div>
                <div class="bg_title2"></div>
            </a>
        </li>
        <?php endforeach ?>
<?php endif; ?>