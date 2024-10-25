<?php $this->load->view('gerenciador/_header')?>

<div class="page-header">
    <ol class="breadcrumb">
    	<li class="active">Agenda</li>
    </ol>
</div>
<div class="action-header">
    <a class="btn btn-primary" href="<?php echo site_url('gerenciador/ar_agenda/add')?>"><i class="icon-plus icon-white"></i> Adicionar Evento</a>
    <a class="btn btn-danger remove-all" href="<?php echo site_url('gerenciador/ar_agenda/delete')?>"><i class="icon-plus icon-white"></i> Remover Selecionados</a>
</div>
<table class="table table-striped">
	<thead>
		<tr>
            <th  width="30"><input type="checkbox" name="selecctall" id="selecctall"></th>
    		<th  width="200">Data</th>
             <th>Evento</th>
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
			<tr class="ui-state-default" data-id="<?php echo $item->ar_agenda_id; ?>">
            <td><input type="checkbox" name="multipleExclusion" class="checkbox1" name="check[]" value="<?php echo $item->ar_agenda_id; ?>"></td>
                <?php $data = explode(' ',$item->data); ?>
                <td><?php echo dateUStoBR($data[0]).' '.timelongToShort($data[1]); ?></td>
				<td><?php echo $item->titulo; ?></td>
				<td align="center">
        			<a href="<?php echo site_url('gerenciador/ar_agenda/edit/'.$item->ar_agenda_id); ?>" class="btn btn-success" title="Editar" ><i class="glyphicon glyphicon-pencil icon-white"></i></a>
        			<a href="<?php echo site_url('gerenciador/ar_agenda/delete/'.$item->ar_agenda_id); ?>" class="btn btn-danger" onclick="return confirm('Deseja realmente remover este item? Essa operação não pode ser revertida.');" title="Remover" ><i class="glyphicon glyphicon-trash icon-white"></i></a>
    			</td>
       		</tr>
    	<?php }
    } ?>
	</tbody>
</table>

<?php $this->load->view('gerenciador/_footer')?>