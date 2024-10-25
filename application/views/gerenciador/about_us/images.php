<?php $this->load->view('gerenciador/_header'); ?>
<div class="page-header">
    <ol class="breadcrumb">
        <li class="active">Institucional</li>
    </ol>
</div>

<?php echo form_open_multipart('gerenciador/about_us_text_images/save', array('class' => 'form-horizontal', 'role' => 'form')); ?>
<fieldset>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="fileInput">Logo</label>
        <div class="col-xs-5">
            <input name="main_logo" class="input-file" type="file" <?php echo empty($main_logo) ? 'required' : '' ?> />
            <p class="help-block">(*.png *.jpg *.gif 197x33px)
                <?php if (!empty($main_logo)) { ?>
                    (<a href="<?php echo site_url(TEXT_IMAGES_PATH . $main_logo); ?>" title="ver image atual" target="_blank">Ver Imagem Atual</a>)
                <?php } ?>
            </p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="fileInput">Imagem 1:</label>
        <div class="col-xs-5">
            <input name="inst_image_1" class="input-file" type="file" <?php echo empty($inst_image_1) ? 'required' : '' ?> />
            <p class="help-block">(*.png *.jpg *.gif 560x560px)
                <?php if (!empty($inst_image_1)) { ?>
                    (<a href="<?php echo site_url(TEXT_IMAGES_PATH . $inst_image_1); ?>" title="ver image atual" target="_blank">Ver Imagem Atual</a>)
                <?php } ?>
            </p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="fileInput">Imagem 2:</label>
        <div class="col-xs-5">
            <input name="inst_image_2" class="input-file" type="file" <?php echo empty($inst_image_2) ? 'required' : '' ?> />
            <p class="help-block">(*.png *.jpg *.gif 560x560px)
                <?php if (!empty($inst_image_2)) { ?>
                    (<a href="<?php echo site_url(TEXT_IMAGES_PATH . $inst_image_2); ?>" title="ver image atual" target="_blank">Ver Imagem Atual</a>)
                <?php } ?>
            </p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="fileInput">Imagem 3:</label>
        <div class="col-xs-5">
            <input name="inst_image_3" class="input-file" type="file" <?php echo empty($inst_image_3) ? 'required' : '' ?> />
            <p class="help-block">(*.png *.jpg *.gif 560x560px)
                <?php if (!empty($inst_image_3)) { ?>
                    (<a href="<?php echo site_url(TEXT_IMAGES_PATH . $inst_image_3); ?>" title="ver image atual" target="_blank">Ver Imagem Atual</a>)
                <?php } ?>
            </p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button class="btn btn-primary" type="submit">Salvar</button>
        </div>
    </div>
</fieldset>
<?php echo form_close(); ?>

<?php $this->load->view('gerenciador/_footer') ?>