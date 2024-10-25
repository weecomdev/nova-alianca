<?php $this->load->view('gerenciador/_header'); ?>
<div class="page-header">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('gerenciador/ar_files_categories/'.(empty($item->profile_id)? $profile_id : $item->profile_id))?>">Categorias de Arquivos</a>
        </li>
        <li class="active"><?php echo empty($item->ar_file_category_id) ? 'Adicionar' : 'Editar' ?> Categoria</li>
    </ul>
</div>

<?php echo form_open_multipart('gerenciador/ar_files_categories/save',array('class'=>'form-horizontal', 'role'=>'form'));?>
	<fieldset>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="title">Título:</label>
            <div class="col-xs-5">
                <input type="text" name="title" class="form-control" id="title" value="<?php echo empty($item->title) ? set_value('title') : $item->title?>" required />
            </div>
        </div>    
        <div class="form-group">
            <label class="col-sm-2 control-label" for="title">Visível:</label>
            <div class="col-xs-5">
                <input type="checkbox" value="1" name="visible" <?php echo (!empty($item->visible))? 'checked="checked"' : ''; ?> />
            </div>
        </div>
		<div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name="profile_id" value="<?php echo empty($item->profile_id) ? $profile_id : $item->profile_id;?>">
    			<input type="hidden" name="ar_file_category_id" value="<?php echo empty($item->ar_file_category_id) ? '' : $item->ar_file_category_id; ?>" />
    			<button class="btn btn-primary" type="submit">Salvar</button>
                <a href="<?php echo site_url('gerenciador/ar_files_categories/'.(empty($item->profile_id)? $profile_id : $item->profile_id))?>" class="btn btn-default">Voltar</a>
            </div>
		</div>
    </fieldset>
<?php echo form_close();?>

<?php $this->load->view('gerenciador/_footer')?>