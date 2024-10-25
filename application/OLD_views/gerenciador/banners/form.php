<?php $this->load->view('gerenciador/_header'); ?>

<div class="page-header">
    <ol class="breadcrumb">
    	<li> <a href="<?php echo site_url('gerenciador/banners')?>">Banners</a> </li>
    	<li class="active"><?php echo empty($item->banner_id) ? 'Adicionar' : 'Editar' ?> Banner</li>
    </ol>
</div>

<?php echo form_open_multipart('gerenciador/banners/save', array('class'=>'form-horizontal', 'role'=>'form'));?>
	<fieldset>
    	<div class="form-group">
   			<label class="col-sm-2 control-label" for="link">Link:</label>
   			<div class="col-xs-5">
   				<input type="text" name="link" class="form-control" id="link" value="<?php echo empty($item->link) ? set_value('link') : $item->link?>" required autofocus />
   			</div>
    	</div>
    	<div class="form-group">
			<label class="col-sm-2 control-label" for="fileInput">Imagem Fundo:</label>
			<div class="col-xs-5">
				<input id="fileInput" name="img_bg" class="input-file" type="file" <?php echo empty($item->banner_id) ? 'required' : '' ?> />
				<p class="help-block">(*.png *.jpg *.gif 1750x900)
					<?php if (!empty($item->banner_id)){ ?>
						(<a href="<?php echo site_url(BANNERS_PATH.$item->img_bg); ?>" title="ver imagem atual" target="_blank">Ver Imagem Atual</a>)
					<?php }?>
				</p>
			</div>
		</div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="fileInput">Imagem Principal:</label>
            <div class="col-xs-5">
                <input id="fileInput" name="img" class="input-file" type="file" <?php echo empty($item->banner_id) ? 'required' : '' ?> />
                <p class="help-block">(*.png *.jpg *.gif 700x700)
                    <?php if (!empty($item->banner_id)){ ?>
                        (<a href="<?php echo site_url(BANNERS_PATH.$item->img); ?>" title="ver imagem atual" target="_blank">Ver Imagem Atual</a>)
                    <?php }?>
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="fileInput">Imagem Principal EN (opcional):</label>
            <div class="col-xs-5">
                <input id="fileInput" name="img_en" class="input-file" type="file" />
                <p class="help-block">(*.png *.jpg *.gif 700x700)
                    <?php if (!empty($item->img_en)){ ?>
                        (<a href="<?php echo site_url(BANNERS_PATH.$item->img_en); ?>" title="ver imagem atual" target="_blank">Ver Imagem Atual</a>)
                    <?php }?>
                </p>
            </div>
        </div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<input type="hidden" name="banner_id" value="<?php echo empty($item->banner_id) ? '' : $item->banner_id; ?>" />
				<button class="btn btn-primary" type="submit">Salvar</button>
				<a href="<?php echo site_url('gerenciador/banners')?>" class="btn btn-default">Voltar</a>
			</div>
		</div>
    </fieldset>
<?php echo form_close();?>

<?php $this->load->view('gerenciador/_footer')?>