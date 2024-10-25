<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Administração | <?php echo SITE_TITLE;?></title>
	<link href="<?php echo site_url(ASSETS_MANAGER.'css/base.css')?>" rel="stylesheet" />
    <link href="<?php echo site_url(ASSETS_MANAGER.'css/sys.css')?>" rel="stylesheet" />
	<link href="<?php echo site_url(ASSETS_MANAGER.'bootstrap/css/bootstrap.min.css')?>" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo site_url(ASSETS_MANAGER.'upload/css/style.css');?>">
	<link rel="stylesheet" href="<?php echo site_url(ASSETS_MANAGER.'upload/css/jquery.fileupload-ui.css');?>">

	<link rel="stylesheet" href="<?php echo site_url(JS.'fancybox/jquery.fancybox.css?v=2.1.5');?>" type="text/css" media="screen" />

	
	<script src="<?php echo site_url(ASSETS_MANAGER.'js/plugins.js')?>"></script>
	<script type="text/javascript" src="<?php echo site_url(JS.'fancybox/jquery.fancybox.pack.js?v=2.1.5');?>"></script>
	<script type="text/javascript" src="<?php echo site_url(ASSETS_MANAGER."js/jquery-ui-1.10.3.custom.min.js") ?>"></script>
	<script src="<?php echo site_url(ASSETS_MANAGER.'bootstrap/js/bootstrap.min.js')?>"></script>
	<script src="//maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo site_url(ASSETS_MANAGER."js/manager.js") ?>"></script>

    <meta content="width=device-width, initial-scale=1" name="viewport" />
	
</head>
<body<?php if ($this->uri->segment(2) == 'start') { ?> class="start"<?php } ?>>
	<?php $this->load->view('gerenciador/_navigation_menu', $this->data); ?>
	<div class="container relative">
		<?php $this->load->view('gerenciador/_messages'); ?>
