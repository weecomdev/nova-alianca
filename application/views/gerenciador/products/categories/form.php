<?php $this->load->view('gerenciador/_header'); ?>
<div class="page-header">
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url('gerenciador/products_categories')?>">Categorias de Produtos</a>
        </li>
        <li class="active"><?php echo empty($item->product_category_id) ? 'Adicionar' : 'Editar' ?> Categoria</li>
    </ul>
</div>

<?php echo form_open_multipart('gerenciador/products_categories/save',array('class'=>'form-horizontal', 'role'=>'form'));?>
	<fieldset>
        <div class="form-group">
            <label class="col-sm-1 control-label" for="name">Nome:</label>
            <div class="col-xs-3">
                <input type="text" name="name" class="form-control" id="name" value="<?php echo empty($item->name) ? set_value('name') : $item->name?>" required />
            </div>

            <label class="col-sm-1 control-label" for="name_en">EN:</label>
            <div class="col-xs-3">
                 <input type="text" name="name_en" class="form-control" id="name_en" value="<?php echo empty($item->name_en) ? set_value('name_en') : $item->name_en?>" />
            </div>
            <label class="col-sm-1 control-label" for="name_es">ES:</label>
            <div class="col-xs-3">
                 <input type="text" name="name_es" class="form-control" id="name_es" value="<?php echo empty($item->name_es) ? set_value('name_es') : $item->name_es?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Cor:</label>
            <div class="col-xs-5">
                <label class="colors" style="background-color:#8b4b4b;" for="color-1">
                <input type="radio" value="1" id="color-1" name="color" <?php echo (!empty($item->color) && $item->color == 1)? 'checked="checked"' : 'checked="checked"'; ?> />
                </label>
                <label class="colors" style="background-color:#88594a;" for="color-2">
                <input type="radio" value="2" id="color-2" name="color" <?php echo (!empty($item->color) && $item->color == 2)? 'checked="checked"' : ''; ?> />
                </label>
                <label class="colors" style="background-color:#827049;" for="color-3">
                <input type="radio" value="3" id="color-3" name="color" <?php echo (!empty($item->color) && $item->color == 3)? 'checked="checked"' : ''; ?> />
                </label>
                <label class="colors" style="background-color:#767d48;" for="color-4">
                <input type="radio" value="4" id="color-4" name="color" <?php echo (!empty($item->color) && $item->color == 4)? 'checked="checked"' : ''; ?> />
                </label>
                <label class="colors" style="background-color:#958f65;" for="color-5">
                <input type="radio" value="5" id="color-5" name="color" <?php echo (!empty($item->color) && $item->color == 5)? 'checked="checked"' : ''; ?> />
                </label>
                <label class="colors" style="background-color:#45567e;" for="color-6">
                <input type="radio" value="6" id="color-6" name="color" <?php echo (!empty($item->color) && $item->color == 6)? 'checked="checked"' : ''; ?> />
                </label>
                <label class="colors" style="background-color:#754b7f;" for="color-7">
                <input type="radio" value="7" id="color-7" name="color" <?php echo (!empty($item->color) && $item->color == 7)? 'checked="checked"' : ''; ?> />
                </label>
                <label class="colors" style="background-color:#8b4b7e;" for="color-8">
                <input type="radio" value="8" id="color-8" name="color" <?php echo (!empty($item->color) && $item->color == 8)? 'checked="checked"' : ''; ?> />
                </label>
                <label class="colors" style="background-color:#8b4b68;" for="color-9">
                <input type="radio" value="9" id="color-9" name="color" <?php echo (!empty($item->color) && $item->color == 9)? 'checked="checked"' : ''; ?> />
                </label>
                <label class="colors" style="background-color:#227d59;" for="color-10">
                <input type="radio" value="10" id="color-10" name="color" <?php echo (!empty($item->color) && $item->color == 10)? 'checked="checked"' : ''; ?> />
                </label>
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
    			<input type="hidden" name="product_category_id" value="<?php echo empty($item->product_category_id) ? '' : $item->product_category_id; ?>" />
    			<button class="btn btn-primary" type="submit">Salvar</button>
                <a href="<?php echo site_url('gerenciador/products_categories')?>" class="btn btn-default">Voltar</a>
            </div>
		</div>
    </fieldset>
<?php echo form_close();?>

<?php $this->load->view('gerenciador/_footer')?>