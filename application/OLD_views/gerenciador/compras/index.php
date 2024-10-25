<?php $this->load->view('gerenciador/_header')?>

<div class="page-header">
    <ol class="breadcrumb">
    	<li class="active">Compras</li>
    </ol>
</div>
<div class="action-header">
    <a class="btn btn-primary" href="<?php echo site_url('gerenciador/compras/add')?>"><i class="icon-plus icon-white"></i> Adicionar Compras</a>
    <a class="btn btn-danger remove-all" href="<?php echo site_url('gerenciador/compras/delete')?>"><i class="icon-plus icon-white"></i> Remover Selecionados</a>
</div>
<table class="table table-striped">
	<thead>
		<tr>
            <th  width="30"><input type="checkbox" name="selecctall" id="selecctall"></th>
    		<th>Compras</th>
             <th width="200">Imagens</th>
        	<th width="160">Ações</th>
    	</tr>
    </thead>
    <tbody class="table-sortable">
	<?php if (!is_array($items) || count($items) == 0 || empty($items) ) {?>
		<tr>
	    	<td colspan="4" align="center"><?php echo $this->lang->line('message_no_items');?></td>
	    </tr>
    <?php } else {
		foreach($items as $item){ ?>
			<tr class="ui-state-default" data-id="<?php echo $item->compra_id; ?>">
            <td><input type="checkbox" name="multipleExclusion" class="checkbox1" name="check[]" value="<?php echo $item->compra_id; ?>"></td>
				<td><?php echo $item->titulo; ?></td>
                <td>
                   <a class="btn btn-primary" href="<?php echo site_url('gerenciador/compras_imagens/add/'.$item->compra_id)?>" title="Adicionar Imagem" ><i class="glyphicon glyphicon-plus"></i></a> 
                   <a class="btn btn-success" href="<?php echo site_url('gerenciador/compras_imagens/index/'.$item->compra_id)?>" title="Listar Imagens" > <i class="glyphicon glyphicon-list"></i> <?php echo $this->MCompras_imagem->countImages($item->compra_id);?></a>
                </td>
				<td align="center">
        			<a href="<?php echo site_url('gerenciador/compras/edit/'.$item->compra_id); ?>" class="btn btn-success" title="Editar" ><i class="glyphicon glyphicon-pencil icon-white"></i></a>
        			<a href="<?php echo site_url('gerenciador/compras/delete/'.$item->compra_id); ?>" class="btn btn-danger" onclick="return confirm('Deseja realmente remover este item? Essa operação não pode ser revertida.');" title="Remover" ><i class="glyphicon glyphicon-trash icon-white"></i></a>
    			</td>
       		</tr>
    	<?php }
    } ?>
	</tbody>
</table>

<?php $this->load->view('gerenciador/_footer')?>