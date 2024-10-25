<?php if(!empty($noticias)): ?>
        <?php foreach ($noticias as $key => $new): ?>
        <li class="new" data-slug="<?php echo $new->alias ?>">
            <a href="javascript:void(0);" onclick="App.noticias.open_new_click(event,'<?php echo $new->alias ?>');" >
            <?php 
            $image = $this->MNoticia_imagem->getFirst($new->noticia_id);
            if(empty($image)) $image = IMG.'noticias.jpg';
            else $image = NOTICIAS_IMAGES_PATH.$image->thumb_image;
             ?>
                <div class="image" style="background:url(<?php echo site_url($image); ?>) center center;" ></div>
                <div class="title">
                    <div class="bg_title"></div>
                    <?php 
                        $data = explode('-',$new->data);
                    ?>
                    <span>
                        <?php /*if($this->session->userdata('lang') == 'en'){ ?>
                        <?php <h1><?php echo getMonthBR($data[1],true,false,$this->session->userdata('lang')).' '.$data[2]; ?></h1>
                        <?php }else{ ?>
                        <h1><?php echo $data[2].' '.getMonthBR($data[1],true,false,$this->session->userdata('lang')); ?></h1>
                        <?php } */?>
                        <h2><?php echo $new->titulo ?></h2>
                        <h3><?php echo $this->lang->line('veja_mais');?></h3>  
                    </span>
                </div>
                <div class="bg_title2"></div>
            </a>
        </li>
        <?php endforeach ?>
<?php endif; ?>