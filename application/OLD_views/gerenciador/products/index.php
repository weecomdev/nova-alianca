<?php $this->load->view('gerenciador/_header')?>

<div class="page-header">
    <ul class="breadcrumb">
        <li><?php echo $category->name;?></li>
        <li class="active">Produtos</li>
    </ul>
</div>
<div class="action-header">
    <a class="btn btn-primary" href="<?php echo site_url('gerenciador/products/add/'.$category->product_category_id)?>"><i class="icon-plus icon-white"></i> Adicionar Produto</a>
</div>
<table class="table table-striped">
	<thead>
		<tr>
            <th>Produto</th>
            <th>Nome</th>
        	<th width="100">Ações</th>
    	</tr>
    </thead>
    <tbody class="table-sortable">
		<?php if (!is_array($items) || count($items) == 0 || empty($items) ) {?>
			<tr> <td colspan="4" align="center"><?php echo $this->lang->line('message_no_items');?></td> </tr>
    	<?php } else {
			foreach($items as $item){ ?>
       			<tr <?php if(empty($item->visible)){?>style="color:#aaa !important;"<?php }?> class="ui-state-default" data-id="<?php echo $item->product_id; ?>">
                    <td><img src="<?php echo site_url(PRODUCTS_PATH.$item->product_category_id.'/'.$item->img); ?>" alt="" style="max-width:500px;max-height:200px;"></td>
                    <td><?php echo $item->name.' '.$item->type; ?></td>
        			<td align="center">
        	 			<a href="<?php echo site_url('gerenciador/products/edit/'.$item->product_id); ?>" class="btn btn-success" title="Editar" ><i class="glyphicon glyphicon-pencil icon-white"></i></a>
        			    <a href="<?php echo site_url('gerenciador/products/delete/'.$item->product_id); ?>" class="btn btn-danger" onclick="return confirm('Deseja realmente remover este item? Essa operação não pode ser revertida.');" title="Remover" ><i class="glyphicon glyphicon-trash icon-white"></i></a>
                    </td>
        		</tr>
        	<?php }
        } ?>
	</tbody>
</table>

<?php $this->load->view('gerenciador/_footer')?>