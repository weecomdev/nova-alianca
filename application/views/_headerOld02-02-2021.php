<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7" xmlns="http://www.w3.org/1999/xhtml" lang="pt-br"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie10 lt-ie9 lt-ie8" xmlns="http://www.w3.org/1999/xhtml" lang="pt-br"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie10 lt-ie9" xmlns="http://www.w3.org/1999/xhtml" lang="pt-br"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10" xmlns="http://www.w3.org/1999/xhtml" lang="pt-br"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js ie-10" xmlns="http://www.w3.org/1999/xhtml" lang="pt-br"> <!--<![endif]-->
<head>
<!-- Facebook Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window,document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');

     fbq('init', '536589536872812'); 
    fbq('track', 'PageView');
    </script>
    <noscript>
     <img height="1" width="1" 
    src="https://www.facebook.com/tr?id=536589536872812&ev=PageView
    &noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->
    
    <title><?php echo (!empty($page_title)) ? $page_title.' | ' : '';?><?php echo SITE_TITLE;?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" >
    <meta content="width=device-width, initial-scale=1" name="viewport" />

    <link rel="stylesheet" type="text/css" href="<?php echo site_url('_assets/css/main.min.css')?>?d=7" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('_assets/js/fancybox/jquery.fancybox.css')?>" />

    <script src="<?php echo site_url('_assets/js/vendor/modernizr-2.6.2.min.js')?>" type="text/javascript"></script>
    <script type="text/javascript">
     site_url = '<?php echo site_url();?>'; 
     lang = '<?php echo $this->session->userdata('lang'); ?>'; 
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobubble/src/infobubble.js"></script>
    
    
    <meta name="author" content="Deen - Agência de Marketing Digital - http://www.deen.com.br"/>
    <meta name="description" content="<?php echo (!empty($page_desc)) ? substr(strip_tags($page_desc), 0, 155) : 'Vinhos, Espumantes, Sucos de Uva e Néctares de uma Cooperativa sustentada pelo esforço e dedicação de muitas famílias que mantêm pequenas propriedades, seguindo a tradição trazida pelos imigrantes italianos.';?>"/>
	<meta name="keywords" content=""/>
    <link rel="shortcut icon" type="image/ico" href="<?php echo site_url(IMG.'favicon.png');?>" />
    <link rel="apple-touch-icon" href="<?php echo site_url(IMG.'favicong.png');?>"/>
    <meta property="og:title" content="<?php echo (!empty($page_title)) ? $page_title.' | ' : '';?><?php echo SITE_TITLE;?>"/> 
    <meta property="og:image" content="<?php echo (!empty($page_img)) ? $page_img : site_url(IMG.'favicong.png');?>"/> 
    <meta property="og:type" content="website" />
  

    
    <script src="//use.typekit.net/ghd8hzs.js"></script>
    <script>try{Typekit.load();}catch(e){}</script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.5&appId=261443467217865";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</head>
<body>
<div id="fb-root"></div>


    <div id="outdated">
        <h6>Seu navegador está desatualizado!</h6>
        <!-- <p>Atualize o seu navegador para uma melhor visualização do site. <a id="btnUpdate" target="_blank" href="http://outdatedbrowser.com/">Atualizar agora!</a></p> -->
        <p>Atualize o seu navegador para uma melhor visualização do site. <a id="btnUpdate" target="_blank" href="https://www.google.com/chrome/browser/">Atualizar agora!</a></p>
        <p id="btnClose"><a href="#">X</a></p>
    </div>
    <div class="institucional_lista">
        <div class="institucional_box">
            <div class="header">
                <h1><?php echo $this->lang->line('institucional'); ?></h1>
                <h2>
                <a href="#!/">
                    <div class="close_top">
                        <div class="line_l"></div>
                        <div class="line_r"></div>
                    </div>
                    <div class="close_bottom">
                        <div class="line_l"></div>
                        <div class="line_r"></div>
                    </div>
                </a>
                </h2>
            </div>
            <ul class="box">
                <li class="first">
                    <a href="<?php echo site_url('institucional') ?>/">
                        <div class="text">
                            <h1><?php echo $this->lang->line('sobre_nos'); ?></h1>
                            <h2><?php echo $this->lang->line('menu_inst_1'); ?></h2>
                            <?php echo $this->Text->getText('inst_text2'); ?>
                            <div class="saiba">
                                <?php echo $this->lang->line('saiba_mais'); ?>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <ul>
                        <li class="a">
                            <a href="<?php echo site_url('dicas') ?>/">
                                <div class="text">
                                    <h1><?php echo $this->lang->line('dicas'); ?></h1>
                                    <h2><?php echo $this->lang->line('menu_inst_2'); ?></h2>
                                    <div class="saiba">
                                        <?php echo $this->lang->line('saiba_mais'); ?>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="b">
                            <a href="<?php echo site_url('premiacoes') ?>/">
                                <div class="text">
                                    <h1><?php echo $this->lang->line('premiacoes'); ?></h1>
                                    <h2><?php echo $this->lang->line('menu_inst_3'); ?></h2>
                                    <div class="saiba">
                                        <?php echo $this->lang->line('saiba_mais'); ?>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul>
                        <li class="b">
                            <a href="<?php echo site_url('noticias') ?>/">
                                <div class="text">
                                    <h1><?php echo $this->lang->line('noticias'); ?></h1>
                                    <h2><?php echo $this->lang->line('menu_inst_4'); ?></h2>
                                    <div class="saiba">
                                        <?php echo $this->lang->line('saiba_mais'); ?>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="a">
                            <a href="<?php echo site_url('representantes') ?>/">
                                <div class="text">
                                    <h1><?php echo $this->lang->line('onde_comprar'); ?></h1>
                                    <h2><?php echo $this->lang->line('menu_inst_5'); ?></h2>
                                    <div class="saiba">
                                        <?php echo $this->lang->line('saiba_mais'); ?>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="contact_lista">
        <div class="contact_box">
            <div class="header">
                <h1><?php echo $this->lang->line('contato'); ?></h1>
                <h2>
                <a href="#!/">
                    <div class="close_top">
                        <div class="line_l"></div>
                        <div class="line_r"></div>
                    </div>
                    <div class="close_bottom">
                        <div class="line_l"></div>
                        <div class="line_r"></div>
                    </div>
                </a>
                </h2>
            </div>
            <ul class="box">
                <li>
                    <ul>
                        <li class="a">
                            <a href="<?php echo site_url('contato') ?>/">
                                <div class="text">
                                    <h1><?php echo $this->lang->line('contato'); ?></h1>
                                    <!-- <h2><?php echo $this->lang->line('menu_inst_2'); ?></h2> -->
                                    <div class="saiba">
                                        <?php echo $this->lang->line('saiba_mais'); ?>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul>
                        <li class="a">
                            <a href="http://www.novaalianca.coop.br/metadados/curriculoweb/" target="_blank">
                                <div class="text">
                                    <h1><?php echo $this->lang->line('trabalhe_conosco'); ?></h1>
                                    <!-- <h2><?php echo $this->lang->line('menu_inst_2'); ?></h2> -->
                                    <div class="saiba">
                                        <?php echo $this->lang->line('saiba_mais'); ?>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="produtos_lista">
        <div class="produtos_box">
        </div>            
    </div>
    <div class="marcas_lista">
        <div class="produtos_box">
        </div>            
    </div>
    <div class="restricted_login">
        <div class="login_box">
        </div>
    </div>
    <header id="header">
        <div class="mobile_menu mobile block">
            <a href="<?php echo site_url(); ?>"><img src="<?php echo site_url(IMG.'logo.png'); ?>" alt="Nova Aliança"></a>
            <div class="menu_trigger">
                <a href="#" class="ball"><img src="<?php echo site_url(IMG.'mobile_menu_open.png'); ?>" alt="Abrir menu"></a>
                <ul class="inside_menu closed">
                    <?php 
                    $categories = $this->ProductCategory->getAll();
                    foreach ($categories as $category): ?>
                    <li class="color-<?php echo $category->color ?>">
                        <a href="#" title="<?php echo $category->name ?>" class="main">
                        <?php echo $category->name ?>
                        </a>
                        <ul class="submenu">
                            <?php 
                            $products = $this->Product->getAll(true,$category->product_category_id);
                            foreach ($products as $k => $value): 
                                $brands = $this->Product->getMyBrands($value->product_id);
                                $brands_string = '';
                                if(!empty($brands)){
                                    foreach($brands as $b){
                                        $brands_string .= $b.' ';
                                    }
                                }
                            ?>
                            <li class="p_item active"  data-brands="<?php echo $brands_string; ?>">
                                <a href="<?php echo site_url('produtos/'.$category->alias.'/'.$value->alias);?>">
                                    <img src="<?php echo site_url(PRODUCTS_PATH.$category->product_category_id.'/'.$value->img_thumb); ?>" alt="" />
                                    <div class="text">
                                        <h1><?php echo $value->name; ?></h1>
                                        <h2><?php echo $value->type; ?></h2>
                                        <?php if(!empty($value->options)){ ?>
                                        <?php $items = explode(',',$value->options); ?>
                                        <div class="options">
                                            <?php foreach ($items as $key => $v): ?>
                                            <div class="types"><?php echo $v; ?></div>
                                            <?php endforeach ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>    
                    <?php endforeach ?>
                    <li class="inst">
                        <a href="<?php echo '#!/institucional/' ?>" title="Institucional" class="main">
                        <?php echo $this->lang->line('institucional'); ?>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="<?php echo site_url('dicas') ?>/">
                                    <div class="text">
                                        <h1><?php echo $this->lang->line('dicas'); ?></h1>
                                        <h2><?php echo $this->lang->line('menu_inst_2'); ?></h2>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('premiacoes') ?>/">
                                    <div class="text">
                                        <h1><?php echo $this->lang->line('premiacoes'); ?></h1>
                                        <h2><?php echo $this->lang->line('menu_inst_3'); ?></h2>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('noticias') ?>/">
                                    <div class="text">
                                        <h1><?php echo $this->lang->line('noticias'); ?></h1>
                                        <h2><?php echo $this->lang->line('menu_inst_4'); ?></h2>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('representantes') ?>/">
                                    <div class="text">
                                        <h1><?php echo $this->lang->line('onde_comprar'); ?></h1>
                                        <h2><?php echo $this->lang->line('menu_inst_5'); ?></h2>
                                    </div>
                                </a>
                            </li>
                        </ul>
                   </li>
                   <li class="cont">
                        <a href="#!/contato/" title="Contato" class="main">
                        <?php echo $this->lang->line('contato'); ?>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="<?php echo site_url('contato') ?>/">
                                    <div class="text">
                                        <h1><?php echo $this->lang->line('dicas'); ?></h1>
                                       <!--  <h2><?php echo $this->lang->line('menu_inst_2'); ?></h2> -->
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="http://www.novaalianca.coop.br/metadados/curriculoweb/" target="_blank">
                                    <div class="text">
                                        <h1><?php echo $this->lang->line('trabalhe_conosco'); ?></h1>
                                       <!--  <h2><?php echo $this->lang->line('menu_inst_3'); ?></h2> -->
                                    </div>
                                </a>
                            </li>
                        </ul>
                   </li>
                </ul>
            </div>
        </div>
        <div class="menu container responsive fixed">
           <div class="left">
               <a href="<?php echo site_url(); ?>"><img src="<?php echo site_url(IMG.'logo.png'); ?>" alt=""></a>
           </div>
           <div class="right">
               <ul>
               <?php 
                    $categories = $this->ProductCategory->getAll();
                    foreach ($categories as $key => $value): ?>
                   <li>
                        <a href="<?php echo '#!/produtos/'.$value->alias; ?>" >
                        <!-- onclick="getProductList(event,'<?php echo $value->alias?>');" -->
                        <?php echo $value->name ?>
                        <div class="seta">
                            <div class="line_l"></div>
                            <div class="line_r"></div>
                        </div>
                        </a>
                   </li>    
               <?php endforeach ?>
                   <li class="inst">
                        <a href="<?php echo '#!/institucional/' ?>">
                        <?php echo $this->lang->line('institucional'); ?>
                         <div class="seta">
                            <div class="line_l"></div>
                            <div class="line_r"></div>
                        </div>
                        </a>
                   </li>
                   <li class="cont">
                        <a href="#!/contato/">
                        <?php echo $this->lang->line('contato'); ?>
                        <div class="seta">
                            <div class="line_l"></div>
                            <div class="line_r"></div>
                        </div>
                        </a>
                   </li>
                   <li class="social">
                        <a href="http://www.facebook.com/cooperativanovaalianca" target="_blank">
                        <img src="<?php echo site_url(IMG.'fb_ico.png') ?>" alt="">
                        <div class="seta">
                            <div class="line_l"></div>
                            <div class="line_r"></div>
                        </div>
                        </a>
                    </li>
                    <li class="social">
                        <a href="#!/area_restrita/login">
                        <img src="<?php echo site_url(IMG.'res_ico.png') ?>" alt="">
                        <div class="seta">
                            <div class="line_l"></div>
                            <div class="line_r"></div>
                        </div>
                        </a>
                    </li>
                    <li class="social">
                        <div class="langs">
                            <div class="item">
                                <a href="<?php echo site_url('home/language/pt'); ?>" title="Português" class="<?php echo ($this->session->userdata['lang'] == 'pt') ? 'active' : '' ?>">
                                    <img src="<?php echo site_url(IMG.'ico_brhuehue.png') ?>" alt="">
                                    <div class="seta">
                                        <div class="line_l"></div>
                                        <div class="line_r"></div>
                                    </div>
                                </a>
                                <a href="<?php echo site_url('home/language/en'); ?>" title="English" class="<?php echo ($this->session->userdata['lang'] == 'en') ? 'active' : '' ?>">
                                    <img src="<?php echo site_url(IMG.'ico_en.png') ?>" alt="">
                                    <div class="seta">
                                        <div class="line_l"></div>
                                        <div class="line_r"></div>
                                    </div>
                                </a>
                                <a href="<?php echo site_url('home/language/es'); ?>" title="Spanish" class="<?php echo ($this->session->userdata['lang'] == 'es') ? 'active' : '' ?>">
                                    <img src="<?php echo site_url(IMG.'spain.png') ?>" alt="">
                                    <div class="seta">
                                        <div class="line_l"></div>
                                        <div class="line_r"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
               </ul>
           </div>
        </div>
    </header>