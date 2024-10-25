<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Mobile menu</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo site_url('gerenciador');?>"><?php echo SITE_TITLE;?></a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Área Restrita<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="navbar-text">Representantes</li>
                         <?php 
                            $categories = $this->Ar_FileCategory->getAll(1,false);
                            if(!empty($categories)):
                                foreach($categories as $category):?>
                        <li><a href="<?php echo site_url('gerenciador/ar_files/'.$category->ar_file_category_id);?>" <?php if(empty($category->visible)){?>style="color:#aaa !important;"<?php }?>> - <?php echo $category->title;?></a></li>
                            <?php endforeach; ?>
                        <?php endif;?>
                        <li><a href="<?php echo site_url('gerenciador/ar_files_categories/1');?>">Categorias</a></li>
                        <li class="divider"></li>
                        <li class="navbar-text">Conselheiros</li>
                        <?php 
                            $categories = $this->Ar_FileCategory->getAll(3,false);
                            if(!empty($categories)):
                                foreach($categories as $category):?>
                        <li><a href="<?php echo site_url('gerenciador/ar_files/'.$category->ar_file_category_id);?>" <?php if(empty($category->visible)){?>style="color:#aaa !important;"<?php }?>> - <?php echo $category->title;?></a></li>
                            <?php endforeach; ?>
                        <?php endif;?>
                        <li><a href="<?php echo site_url('gerenciador/ar_files_categories/3');?>">Categorias</a></li>
                        <li class="divider"></li>
                        <li class="navbar-text">Associados</li>
                        <li><a href="<?php echo site_url('gerenciador/ar_agenda/');?>">Agenda</a></li>
                    </ul>
                </li>
                <li class=""><a href="<?php echo site_url('gerenciador/instagram_media');?>">Instagram</a></li>
                <li><a href="<?php echo site_url('gerenciador/banners');?>">Banners</a></li>
                <li><a href="<?php echo site_url('gerenciador/home');?>">Home Links</a></li>
                <li><a href="<?php echo site_url('gerenciador/noticias');?>">Notícias</a></li>
                <li><a href="<?php echo site_url('gerenciador/dicas');?>">Dicas</a></li>
                <li><a href="<?php echo site_url('gerenciador/premiacoes');?>">Premiações</a></li>
                <li><a href="<?php echo site_url('gerenciador/representatives');?>">Onde Comprar</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Produtos<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php 
                            $categories = $this->ProductCategory->getAll(false);
                            if(!empty($categories)):
                                foreach($categories as $category):?>
                        <li><a href="<?php echo site_url('gerenciador/products/'.$category->product_category_id);?>" <?php if(empty($category->visible)){?>style="color:#aaa !important;"<?php }?>><?php echo $category->name;?></a></li>
                            <?php endforeach; ?>
                        <li class="divider"></li>
                        <?php endif;?>
                        <li><a href="<?php echo site_url('gerenciador/products_categories');?>">Categorias</a></li>
                        <li><a href="<?php echo site_url('gerenciador/products_brands');?>">Marcas</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Institucional<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo site_url('gerenciador/about_us_text');?>">Textos</a></li>
                        <li><a href="<?php echo site_url('gerenciador/about_us_images');?>">Banner</a></li>
                        <li><a href="<?php echo site_url('gerenciador/about_us_text_images');?>">Imagens</a></li>
                    </ul>
                </li>
                <!-- <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Textos <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php foreach($texts as $t) { ?>
                        <li><a href="<?php echo site_url('gerenciador/texts?t='.$t->alias);?>">Texto</a></li>
                        <?php } ?>
                    </ul>
                </li> -->
        		<li class=""><a href="<?php echo site_url('gerenciador/contact_data');?>">Contato</a></li>
			</ul>
      
  			<ul class="nav navbar-nav navbar-right">
  				<?php if ($this->session->userdata('user_level') == 1){ ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuários<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                         <li><a href="<?php echo site_url('gerenciador/users');?>">Gerenciador</a></li>
  					     <li><a href="<?php echo site_url('gerenciador/ar_users');?>">Área Restrita</a></li>
                    </ul>
                </li>
  				<?php } ?>
  				<li class="dropdown">
          			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->session->userdata('user_name') ?><b class="caret"></b></a>
      				<ul class="dropdown-menu">
  						<li><a href="<?php echo site_url('gerenciador/users/edit/'.$this->session->userdata('user_id'));?>">Editar conta</a></li>
  						<li><a href="<?php echo site_url('gerenciador/login/doLogout');?>">Sair</a></li>
      				</ul>
        		</li>
      		</ul>
    	</div>
  	</div>
</nav>