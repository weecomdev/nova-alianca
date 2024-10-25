<?php $this->load->view('gerenciador/_header')?>

<div class="page-header">
    <ul class="breadcrumb">
        <li class="active">Categorias de Arquivos</li>
    </ul>
</div>
<div class="action-header">
    <a class="btn btn-primary" href="<?php echo site_url('gerenciador/ar_files_categories/add/'.$profile_id)?>"><i class="icon-plus icon-white"></i> Adicionar Categoria</a>
</div>
<table class="table table-striped">
	<thead>
		<tr>
    		<th>Título</th>
        	<th width="100">Ações</th>
    	</tr>
    </thead>
    <tbody>
		<?php if (!is_array($items) || count($items) == 0 || empty($items) ) {?>
			<tr> <td colspan="2" align="center"><?php echo $this->lang->line('message_no_items');?></td> </tr>
    	<?php } else {
			foreach($items as $item){ ?>
       			<tr  data-id="<?php echo $item->ar_file_category_id; ?>" <?php if(empty($item->visible)){?>style="color:#aaa !important;"<?php }?>>
                    <td><?php echo $item->title ?></td>
        			<td align="center">
        	 			<a href="<?php echo site_url('gerenciador/ar_files_categories/edit/'.$item->ar_file_category_id); ?>" class="btn btn-success" title="Editar" ><i class="glyphicon glyphicon-pencil icon-white"></i></a>
        			</td>
        		</tr>
        	<?php }
        } ?>
	</tbody>
</table>

<?php $this->load->view('gerenciador/_footer')?>