<?php $this->load->view('_header');?>

<section class="section row" id="home">
	<div class="banner container responsive">
		<ul>
        <?php foreach ($banners as $key => $b): ?>
			<li class="<?php echo ($key == 0)? 'active' : 'next'; ?>" style="background:url(<?php echo site_url(BANNERS_PATH.$b->img_bg); ?>) center center no-repeat;" >
				<a href="<?php echo $b->link ?>">
                <div class="left"></div>
				<div class="center">
                <?php if($this->session->userdata['lang'] == 'en'): ?>
                <img src="<?php echo (!empty($b->img_en))? site_url(BANNERS_PATH.$b->img_en) : site_url(BANNERS_PATH.$b->img); ?>" alt="">
                <?php else: ?>
                <img src="<?php echo site_url(BANNERS_PATH.$b->img); ?>" alt="">
                <?php endif; ?>
                </div>
				<div class="right"></div>
                </a>
			</li>
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
	<div class="history container responsive">
		<div class="col left">
			<div class="box">
				<a class="text" href="<?php echo $this->Text->getText('home1_link'); ?>">
					<h1><?php echo $this->Text->getText('home1_frase_p1'); ?></h1>
					<h2><?php echo $this->Text->getText('home1_frase_p2'); ?></h2>
					<p>
						<?php echo $this->Text->getText('home1_text'); ?>
						<br/><br/>
						<div class="mais"><div class="bg"></div><div class="leia"><?php echo $this->Text->getText('home1_link_title'); ?></div></div>
					</p>
				</a>
			</div>
			<div class="box">
                <video src="<?php echo site_url(IMG.'video_home1.mp4'); ?>" autoplay loop muted height="100%"></video>         
            </div>
			<div class="box">
                <video src="<?php echo site_url(IMG.'video_home2.mp4'); ?>" autoplay loop muted height="100%"></video>           
            </div>
			<div class="box">
				<a class="text" href="<?php echo $this->Text->getText('home2_link'); ?>">
                    <h1><?php echo $this->Text->getText('home2_frase_p1'); ?></h1>
                    <h2><?php echo $this->Text->getText('home2_frase_p2'); ?></h2>
                    <p>
                        <?php echo $this->Text->getText('home2_text'); ?>
                        <br/><br/>
                        <div class="mais"><div class="bg"></div><div class="leia"><?php echo $this->Text->getText('home2_link_title'); ?></div></div>
                    </p>
                </a>
			</div>
		</div>
		<div class="col right" >
			
		</div>
	</div>
	<div class="brands container responsive" id="marcas" data-stellar-background-ratio="0.5">
		<h1><?php echo $this->lang->line('marcas');?></h1>
		<h2><?php echo $this->lang->line('conheca_as');?></h2>
		<h3><?php echo $this->lang->line('nossas');?></h3>
		<div class="carousel">
			<ul class="">
            <?php foreach ($brands as $key => $b): 
                    if($key == 0) $class = 'prev no-view';
                    if($key == 1) $class = 'prev inview';
                    if($key == 2) $class = 'active';
                    if($key == 3) $class = 'next inview';
                    if($key == 4) $class = 'next no-view';
                    if($key > 4) $class = 'next';
                    $products = $this->Product->getAll(true,null,$b->product_brand_id,5);
            ?>
				<li class="<?php echo $class; ?>">
					<div class="circle">
						<div class="text"><?php echo $b->name; ?></div>
						<div class="mask">
							<div class="border_ext"></div>
						</div>
					</div>
					<div class="content">
						<p>
						<?php echo $b->description ?>
						</p>
						<a href="#!/marcas/<?php echo $b->alias ?>"><?php echo $this->lang->line('conheca_a_linha_de_produtos');?></a>
						<div class="bootles">
                        <?php if(!empty($products)){
                                foreach($products as $k=>$p){ 
                                    if($k<5){
                                    ?>
							<img src="<?php echo site_url(PRODUCTS_PATH.$p->product_category_id.'/'.$p->img_bootle); ?>" alt="">
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
						</div>
					</div>
				</li>
            <?php endforeach ?>
			</ul>
		</div>
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
	<div class="noticias container responsive small roll-inview">
		<ul>
        <?php foreach ($news as $key => $new): ?>
            <?php 
                $data = explode('-',$new->data);
            ?>
			<li>
				<a href="<?php echo site_url('noticias/detalhes/'.$new->alias); ?>">
                    <?php if($this->session->userdata('lang') == 'en'){ ?>
					<h1><?php echo getMonthBR($data[1],true,false,$this->session->userdata('lang')).' '.$data[2]; ?></h1>
                    <?php }else{ ?>
                    <h1><?php echo $data[2].' '.getMonthBR($data[1],true,false,$this->session->userdata('lang')); ?></h1>
                    <?php } ?>
					<h2><?php echo $new->titulo ?></h2>
					<p><?php echo $new->subtitulo ?></p>
					<div class="mais"><div class="bg"></div><div class="leia"><?php echo $this->lang->line('leia_mais');?></div></div>
				</a>
			</li>
        <?php endforeach ?>
		</ul>
	</div>
	<div class="instagram container responsive roll-inview">
		<ul class="first">
        <?php foreach ($instagram as $key => $value): ?>
			<li style="background:url(<?php echo $value->img ?>) no-repeat center center ;background-size:cover;">
                <a href="<?php echo $value->link ?>" target="_blank" >
                    <img src="<?php echo $value->profile_pic ?>" alt="" width="50"><br/><?php echo '@'.$value->user_name; ?>
                </a>
            </li>
            <?php if($key==1){ ?>
            </ul>
            <div class="title">
                <div class="cont">
                    <h1>
                        <?php echo $this->lang->line('veja_quem_consome');?>
                    </h1>
                    <h2>
                        <?php echo $this->lang->line('poste_sua_foto');?>
                    </h2>
                </div>
            </div>
            <ul class="second">
            <?php } ?>
        <?php endforeach ?>
		</ul>
	</div>
</section>

<?php $this->load->view('_footer');?>
