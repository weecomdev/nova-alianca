<?php $this->load->view('gerenciador/_header')?>

<div class="page-header">
    <ul class="breadcrumb">
        <li><?php echo $category->title;?></li>
        <li class="active">Arquivos</li>
    </ul>
</div>
<div class="action-header">
    <a class="btn btn-primary" href="<?php echo site_url('gerenciador/ar_files/add/'.$category->ar_file_category_id)?>"><i class="icon-plus icon-white"></i> Adicionar Arquivo</a>
</div>
<table class="table table-striped">
	<thead>
		<tr>
            <th>Nome</th>
        	<th width="100">Ações</th>
    	</tr>
    </thead>
    <tbody>
		<?php if (!is_array($items) || count($items) == 0 || empty($items) ) {?>
			<tr> <td colspan="4" align="center"><?php echo $this->lang->line('message_no_items');?></td> </tr>
    	<?php } else {
			foreach($items as $item){ ?>
       			<tr class="ui-state-default" data-id="<?php echo $item->ar_file_id; ?>">
                    <td><?php echo $item->name; ?></td>
        			<td align="center">
        	 			<a href="<?php echo site_url('gerenciador/ar_files/edit/'.$item->ar_file_id); ?>" class="btn btn-success" title="Editar" ><i class="glyphicon glyphicon-pencil icon-white"></i></a>
        			    <a href="<?php echo site_url('gerenciador/ar_files/delete/'.$item->ar_file_id); ?>" class="btn btn-danger" onclick="return confirm('Deseja realmente remover este item? Essa operação não pode ser revertida.');" title="Remover" ><i class="glyphicon glyphicon-trash icon-white"></i></a>
                    </td>
        		</tr>
        	<?php }
        } ?>
	</tbody>
</table>

<?php $this->load->view('gerenciador/_footer')?>