<?php $this->load->view('gerenciador/_header')?>

<div class="page-header">
    <ol class="breadcrumb">
        <li> <a href="<?php echo site_url('gerenciador/compras')?>">Compras</a></li>
        <li class="active">Imagens</li>
    </ol>
</div>
<div class="action-header">
    <a class="btn btn-primary" href="<?php echo site_url('gerenciador/compras_imagens/add').'/'.$id?>"><i class="icon-plus icon-white"></i> Adicionar Imagens</a>
    <a class="btn btn-danger remove-all" href="<?php echo site_url('gerenciador/compras_imagens/delete')?>"><i class="icon-plus icon-white"></i> Remover Selecionados</a>
</div>
<table class="table table-striped">
	<thead>
		<tr>
            <th  width="30"><input type="checkbox" name="selecctall" id="selecctall"></th>
    		<th>Imagens</th>
        	<th width="80">Ações</th>
    	</tr>
    </thead>
    <tbody class="table-sortable">
    	<?php if (!is_array($items) || count($items) == 0 || empty($items) ) {?>
        	<tr> <td colspan="3" align="center">nenhuma imagem</td> </tr>
        <?php } else {
			foreach($items as $item){ ?>
                <tr class="ui-state-default" data-id="<?php echo $item->compra_image_id; ?>">
                 <td><input type="checkbox" name="multipleExclusion" class="checkbox1" name="check[]" value="<?php echo $item->compra_image_id; ?>"></td>
                    <td><a href="<?php echo site_url(COMPRAS_IMAGES_PATH.$item->image); ?>"   class="fancybox" rel="group" >  <img src="<?php echo site_url(COMPRAS_IMAGES_PATH.$item->thumb_image); ?>" style="max-width: 300px;max-height:200px;" /> </a></td>
                    <td align="center">
                        <a href="<?php echo site_url('gerenciador/compras_imagens/delete/'.$item->compra_image_id.'/'.$id); ?>" class="btn btn-danger" onclick="return confirm('Deseja realmente remover este item? Essa operação não pode ser revertida.');" title="Remover" ><i class="glyphicon glyphicon-trash icon-white"></i></a>
                    </td>
                </tr>
            <?php }
        } ?>
	</tbody>
</table>

<?php $this->load->view('gerenciador/_footer')?>