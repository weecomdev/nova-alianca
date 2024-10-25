<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Administração</title>
		<link href="<?php echo site_url(ASSETS_MANAGER."bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo site_url(ASSETS_MANAGER."css/signin.css") ?>" rel="stylesheet" type="text/css" />
	</head>

	<body>
	   <div class="container">
	        <?php echo form_open('gerenciador/login/doLogin', array('class'=>'form-signin', 'role'=>"form"));?>
				<h1 class="form-signin-heading">Administr<strong>ação</strong></h1>
                <input name="login" type="email" class="form-control" placeholder="Usuário" required autofocus />
                <input name="password" type="password" class="form-control" placeholder="Senha" required />
            	<?php if (!empty($this->session->userdata['msgErrors'])) { ?>
					<div class="error"><?php echo $this->session->userdata('msgErrors')?></div>
					<?php $this->session->set_userdata('msgErrors', "");
				} ?>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
        	<?php echo form_close();?>
    	</div>
	</body>
</html>
