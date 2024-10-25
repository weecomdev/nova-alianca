<?php if(!empty($premiacoes)): ?>
        <?php foreach ($premiacoes as $key => $premiacao): ?>
        <li class="premiacoes" data-slug="<?php echo $premiacao->alias ?>">
            <a href="javascript:void(0);" onclick="App.premiacoes.open_premiacoes_click(event,'<?php echo $premiacao->alias ?>');" >
            <?php 
            $image = $this->MPremiacoes_imagem->getFirst($premiacao->premiacao_id);
            if(empty($image)) $image = IMG.'premiacoes.jpg';
            else $image = PREMIACOES_IMAGES_PATH.$image->thumb_image;
             ?>
                <div class="image" style="background:url(<?php echo site_url($image); ?>) center center;" ></div>
                <div class="title">
                    <div class="bg_title"></div>
                    <span>
                        <h2><?php echo $premiacao->titulo ?></h2>
                        <h3><?php echo $this->lang->line('veja_mais');?></h3>  
                    </span>
                </div>
                <div class="bg_title2"></div>
            </a>
        </li>
        <?php endforeach ?>
<?php endif; ?>