<?php $this->load->view('gerenciador/_header'); ?>
<div class="page-header">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('gerenciador/products_brands')?>">Marcas de Produtos</a>
        </li>
        <li class="active"><?php echo empty($item->product_brand_id) ? 'Adicionar' : 'Editar' ?> Marca</li>
    </ul>
</div>

<?php echo form_open_multipart('gerenciador/products_brands/save',array('class'=>'form-horizontal', 'role'=>'form'));?>
	<fieldset>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Nome:</label>
            <div class="col-xs-4">
                <input type="text" name="name" class="form-control" id="name" value="<?php echo empty($item->name) ? set_value('name') : $item->name?>" required />
            </div>
            <label class="col-sm-1 control-label" for="name_en">EN:</label>
            <div class="col-xs-4">
                 <input type="text" name="name_en" class="form-control" id="name_en" value="<?php echo empty($item->name_en) ? set_value('name_en') : $item->name_en?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="description">Descrição:</label>
            <div class="col-xs-4">
                <textarea name="description" class="form-control" id="description"><?php echo empty($item->description) ? set_value('description') : $item->description ?></textarea>
            </div>
            <label class="col-sm-1 control-label" for="description_en">EN:</label>
            <div class="col-xs-4">
                 <textarea name="description_en" class="form-control" id="description_en"><?php echo empty($item->description_en) ? set_value('description_en') : $item->description_en ?></textarea>
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
    			<input type="hidden" name="product_brand_id" value="<?php echo empty($item->product_brand_id) ? '' : $item->product_brand_id; ?>" />
    			<button class="btn btn-primary" type="submit">Salvar</button>
                <a href="<?php echo site_url('gerenciador/products_brands')?>" class="btn btn-default">Voltar</a>
            </div>
		</div>
    </fieldset>
<?php echo form_close();?>

<?php $this->load->view('gerenciador/_footer')?>