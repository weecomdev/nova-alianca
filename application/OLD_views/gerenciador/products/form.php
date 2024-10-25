<?php $this->load->view('gerenciador/_header'); ?>
<div class="page-header">
    <ul class="breadcrumb">
        <li><a href="<?php echo site_url('gerenciador/products/'.$category->product_category_id);?>" ><?php echo $category->name;?></a></li>
        <li class="active"><?php echo empty($item->product_id) ? 'Adicionar' : 'Editar' ?> Produto</li>
    </ul>
</div>

<?php echo form_open_multipart('gerenciador/products/save',array('class'=>'form-horizontal'));?>
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
            <label class="col-sm-2 control-label" for="type">Tipo:</label>
            <div class="col-xs-4">
                <input type="text" name="type" class="form-control" id="type" value="<?php echo empty($item->type) ? set_value('type') : $item->type?>" required />
            </div>
            <label class="col-sm-1 control-label" for="type_en">EN:</label>
            <div class="col-xs-4">
                 <input type="text" name="type_en" class="form-control" id="type_en" value="<?php echo empty($item->type_en) ? set_value('type_en') : $item->type_en?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="options">Opções (separadas por vírgula):</label>
            <div class="col-xs-5">
                <input type="text" name="options" class="form-control" id="options" value="<?php echo empty($item->options) ? set_value('options') : $item->options?>" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="description">Descrição:</label>
            <div class="col-xs-8">
                <textarea name="description" id="description" cols="30" rows="10"><?php echo empty($item->description) ? set_value('description') : $item->description?></textarea><?php echo display_ckeditor($ck1); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="description_en">Descrição EN:</label>
            <div class="col-xs-8">
                <textarea name="description_en" id="description_en" cols="30" rows="10"><?php echo empty($item->description_en) ? set_value('description_en') : $item->description_en?></textarea><?php echo display_ckeditor($ck2); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="description">Marca:</label>
            <div class="col-xs-5">
                <ul style="list-style-type:none;padding:0;">
                <?php foreach ($brands as $key => $brand): 
                        if(!empty($my_brands)){
                          if(in_array($brand->product_brand_id, $my_brands)) $sel = 'checked="checked"'; else $sel = ''; 
                        }else{
                          $sel = '';
                        }
                ?>
                    <li><input type="checkbox" name="brands[]" value="<?php echo $brand->product_brand_id; ?>" <?php echo $sel; ?>> <?php echo $brand->name ?></li>
                <?php endforeach ?>
                </ul>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="description">Onde Comprar:</label>
            <div class="col-xs-6">
                <ul class="buy" style="list-style-type:none;padding:0;">
                <?php if(!empty($item->onde_comprar)){
                        $array_comprar = json_decode($item->onde_comprar);
                        foreach($array_comprar as $k=>$v):
                 ?>
                    <li>Loja:<input type="text" name="loja[]" class="form-control" style="display:inline;width:30%;" value="<?php echo $v->loja; ?>"> Link:<input type="text" name="link[]" class="form-control" style="display:inline;width:30%;" value="<?php echo $v->link; ?>"><?php if($k>0): ?><div class="btn btn-danger remove" title="Remover Linha"><i class="glyphicon glyphicon-remove icon-white"></i></div><?php endif; ?></li>
                <?php 
                    endforeach;
                }else{ ?>
                    <li>Loja:<input type="text" name="loja[]" class="form-control" style="display:inline;width:30%;" value=""> Link:<input type="text" name="link[]" class="form-control" style="display:inline;width:30%;" value=""></li> 
                <?php } ?>
                </ul>
                <div class="btn btn-primary add" title="Adicionar Linha"><i class="glyphicon glyphicon-plus icon-white"></i></div> 
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label" for="fileInput">Imagem Principal:</label>
            <div class="col-xs-5">
                <input id="fileInput" name="img" class="input-file" type="file" <?php echo empty($item->img) ? 'required' : '' ?> />
                <p class="help-block">(*.png 1000x1030px)
                    <?php if (!empty($item->img)){ ?>
                        (<a href="<?php echo site_url(PRODUCTS_PATH.$category->product_category_id.'/'.$item->img); ?>" title="ver imagem atual" target="_blank">Ver Imagem Atual</a>)
                    <?php }?>
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="fileInput">Imagem Fundo:</label>
            <div class="col-xs-5">
                <input id="fileInput" name="img_bg" class="input-file" type="file" <?php echo empty($item->img_bg) ? 'required' : '' ?> />
                <p class="help-block">(*.jpg,*.png 960x960px)
                    <?php if (!empty($item->img_bg)){ ?>
                        (<a href="<?php echo site_url(PRODUCTS_PATH.$category->product_category_id.'/'.$item->img_bg); ?>" title="ver imagem atual" target="_blank">Ver Imagem Atual</a>)
                    <?php }?>
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="fileInput">Miniatura:</label>
            <div class="col-xs-5">
                <input id="fileInput" name="img_bootle" class="input-file" type="file" <?php echo empty($item->img_bootle) ? 'required' : '' ?> />
                <p class="help-block">(*.png 30x133px)
                    <?php if (!empty($item->img_bootle)){ ?>
                        (<a href="<?php echo site_url(PRODUCTS_PATH.$category->product_category_id.'/'.$item->img_bootle); ?>" title="ver imagem atual" target="_blank">Ver Imagem Atual</a>)
                    <?php }?>
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="fileInput">Frase:</label>
            <div class="col-xs-5">
                <input id="fileInput" name="img_frase" class="input-file" type="file" <?php echo empty($item->img_frase) ? 'required' : '' ?> />
                <p class="help-block">(*.jpg,*.png 1760x1150px)
                    <?php if (!empty($item->img_frase)){ ?>
                        (<a href="<?php echo site_url(PRODUCTS_PATH.$category->product_category_id.'/'.$item->img_frase); ?>" title="ver imagem atual" target="_blank">Ver Imagem Atual</a>)
                    <?php }?>
                </p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="frase_p1">Frase P1:</label>
            <div class="col-xs-4">
                <input type="text" name="frase_p1" class="form-control" id="frase_p1" value="<?php echo empty($item->frase_p1) ? set_value('frase_p1') : $item->frase_p1?>" required />
            </div>
            <label class="col-sm-1 control-label" for="frase_p1_en">EN:</label>
            <div class="col-xs-4">
                 <input type="text" name="frase_p1_en" class="form-control" id="frase_p1_en" value="<?php echo empty($item->frase_p1_en) ? set_value('frase_p1_en') : $item->frase_p1_en?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="frase_p2">Frase P2:</label>
            <div class="col-xs-4">
                <input type="text" name="frase_p2" class="form-control" id="frase_p2" value="<?php echo empty($item->frase_p2) ? set_value('frase_p2') : $item->frase_p2?>" required />
            </div>
            <label class="col-sm-1 control-label" for="frase_p2_en">EN:</label>
            <div class="col-xs-4">
                 <input type="text" name="frase_p2_en" class="form-control" id="frase_p2_en" value="<?php echo empty($item->frase_p2_en) ? set_value('frase_p2_en') : $item->frase_p2_en?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="frase_p3">Frase P3:</label>
            <div class="col-xs-4">
                <input type="text" name="frase_p3" class="form-control" id="frase_p3" value="<?php echo empty($item->frase_p3) ? set_value('frase_p3') : $item->frase_p3?>" required />
            </div>
            <label class="col-sm-1 control-label" for="frase_p3_en">EN:</label>
            <div class="col-xs-4">
                 <input type="text" name="frase_p3_en" class="form-control" id="frase_p3_en" value="<?php echo empty($item->frase_p3_en) ? set_value('frase_p3_en') : $item->frase_p3_en?>" />
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
                <input type="hidden" name="product_id" value="<?php echo empty($item->product_id) ? '' : $item->product_id; ?>" />
                <input type="hidden" name="product_category_id" value="<?php echo $category->product_category_id; ?>" />
                <button class="btn btn-primary" type="submit">Salvar</button>
                <a href="<?php echo site_url('gerenciador/products/'.$category->product_category_id)?>" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </fieldset>
<?php echo form_close();?>


<style type="text/css">
    .ck-category{width: 30%; padding-top: 0px; display: inline-block;}
</style>

<script>
    remove_line();
    $('.add').on('click',function(){
        $('.buy').append('<li>Loja:<input type="text" name="loja[]" class="form-control" style="display:inline;width:30%;" value=""> Link:<input type="text" name="link[]" class="form-control" style="display:inline;width:30%;" value=""><div class="btn btn-danger remove" title="Remover Linha"><i class="glyphicon glyphicon-remove icon-white"></i></div></li>');
        remove_line();
    });
    function remove_line() {
        $('.remove').on('click',function(){
            console.log('removvvvvvveeeeee');
            $(this).parent().remove();
        });
    }
</script>

<?php $this->load->view('gerenciador/_footer')?>