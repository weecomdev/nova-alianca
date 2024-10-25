<?php $this->load->view('gerenciador/_header'); ?>
<div class="page-header">
    <ul class="breadcrumb">
        <li><a href="<?php echo site_url('gerenciador/ar_files/'.$category->ar_file_category_id);?>" ><?php echo $category->title;?></a></li>
        <li class="active"><?php echo empty($item->ar_file_id) ? 'Adicionar' : 'Editar' ?> Arquivo</li>
    </ul>
</div>

<?php echo form_open_multipart('gerenciador/ar_files/save',array('class'=>'form-horizontal'));?>
	<fieldset>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Nome:</label>
            <div class="col-xs-5">
                <input type="text" name="name" class="form-control" id="name" value="<?php echo empty($item->name) ? set_value('name') : $item->name?>" required />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label" for="fileInput">Arquivo:</label>
            <div class="col-xs-5">
                <input id="fileInput" name="file" class="input-file" type="file" <?php echo empty($item->file) ? 'required' : '' ?> />
                <p class="help-block">
                    <?php if (!empty($item->file)){ ?>
                        (<a href="<?php echo site_url(AR_PATH.$category->ar_file_category_id.'/'.$item->file); ?>" title="ver doc atual" target="_blank">Baixar Doc Atual</a>)
                    <?php }?>
                </p>
            </div>
        </div>
       
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name="ar_file_id" value="<?php echo empty($item->ar_file_id) ? '' : $item->ar_file_id; ?>" />
                <input type="hidden" name="ar_file_category_id" value="<?php echo $category->ar_file_category_id; ?>" />
                <button class="btn btn-primary" type="submit">Salvar</button>
                <a href="<?php echo site_url('gerenciador/ar_files/'.$category->ar_file_category_id)?>" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </fieldset>
<?php echo form_close();?>


<style type="text/css">
    .ck-category{width: 30%; padding-top: 0px; display: inline-block;}
</style>

<?php $this->load->view('gerenciador/_footer')?>