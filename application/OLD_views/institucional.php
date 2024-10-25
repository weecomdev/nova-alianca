<?php $this->load->view('_header');?>

<section class="section row" id="institucional">
    <div class="image container responsive" >
        <!-- <img class="img" src="<?php echo site_url(IMG.'bg_institucional.jpg'); ?>" alt=""> -->
        <!--<video src="http://www.youtube.com/watch?v=xd9_EAMfyeg&autoplay=true" autoplay loop muted height="100%"></video> -->
        <iframe width="100%" height="100%" src="http://www.youtube.com/embed/xd9_EAMfyeg?autoplay=true&autohide=1&vq=large&rel=0"></iframe>
        <h1><?php echo $this->Text->getText('inst_frase_p3'); ?></h1>
        <h2><?php echo $this->Text->getText('inst_frase_p1'); ?></h2>
        <h3><?php echo $this->Text->getText('inst_frase_p2'); ?></h3>
    </div>
    <div class="text roll-inview">
        <div class="left">
            <h1><?php echo $this->Text->getText('inst_title11'); ?></h1>
            <h2><?php echo $this->Text->getText('inst_title12'); ?></h2>
        </div>
        <div class="right">
            <?php echo $this->Text->getText('inst_text1'); ?>
        </div>
    </div>
    <ul class="subtitle container responsive roll-inview">
        <li><img src="<?php echo site_url(TEXT_IMAGES_PATH.$this->Text->getText('inst_image_1',false,true)) ?>" alt=""></li>
        <li>
            <div class="text">
                <h1><?php echo $this->Text->getText('inst_title21'); ?></h1>
                <h2><?php echo $this->Text->getText('inst_title22'); ?></h2>
            </div>
        </li>
        <li><img src="<?php echo site_url(TEXT_IMAGES_PATH.$this->Text->getText('inst_image_2',false,true)) ?>" alt=""></li>
        <li class="white">
            <div class="text">
            <?php echo $this->Text->getText('inst_text2'); ?>
            </div>
        </li>
        <li class="white">
            <div class="text car">
                <div class="title active"><?php echo $this->lang->line('valores');?></div>
                <div class="title"><?php echo $this->lang->line('principios');?></div>
                <ul class="carousel">
                    <li class="item active">
                        <?php echo $this->Text->getText('inst_valores'); ?>
                    </li>
                    <li class="item next">
                        <?php echo $this->Text->getText('inst_principios'); ?>
                    </li>
                </ul>
            </div>
        </li>
        <li><img src="<?php echo site_url(TEXT_IMAGES_PATH.$this->Text->getText('inst_image_3',false,true)) ?>" alt=""></li>
    </ul>
    <div class="banner container responsive roll-inview">
        <ul>
            <?php foreach ($imgs as $key => $value): ?>
                <li class="<?php echo ($key == 0?'active':'next') ?>" style="background:url(<?php echo site_url(ABOUT_US_IMAGES_PATH.$value->image) ?>) no-repeat center center / cover;"></li>
            <?php endforeach ?>
        </ul>
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
    </div>
</section>

<?php $this->load->view('_footer');?>
