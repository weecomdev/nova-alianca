<?php $this->load->view('gerenciador/_header')?>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="active">Usuários</li>
    </ol>
</div>
<div class="action-header">
    <a class="btn btn-primary" href="<?php echo site_url('gerenciador/users/add')?>"><i class="icon-plus icon-white"></i> Adicionar Usuário</a>
</div>
<table class="table table-striped">
	<thead>
		<tr>
            <th>Nome</th>
            <th width="350">Email</th>
            <th width="300">Nível</th>
        	<th width="100">Ações</th>
    	</tr>
    </thead>
    <tbody>
    	<?php if (!is_array($items) || count($items) == 0 || empty($items) ) {?>
    	   <tr> <td colspan="4" align="center"><?php echo $this->lang->line('message_no_items');?></td> </tr>
        <?php } else {
            foreach($items as $item){ ?>
                <tr>
                   	<td> <?php echo $item->name ?> </td>
                    <td> <?php echo $item->email ?> </td>
                    <td> <?php echo empty($item->level) ? 'Normal' : 'Administrador' ?> </td>
                    <td align="center">
                    	<a href="<?php echo site_url('gerenciador/users/edit/'.$item->user_id); ?>" class="btn btn-success" title="Editar" ><i class="glyphicon glyphicon-pencil icon-white"></i></a>
        			<a href="<?php echo site_url('gerenciador/users/delete/'.$item->user_id); ?>" class="btn btn-danger" onclick="return confirm('Deseja realmente remover este item? Essa operação não pode ser revertida.');" title="Remover" ><i class="glyphicon glyphicon-trash icon-white"></i></a>
                    </td>
                </tr>
            <?php }
        } ?>
	</tbody>
</table>

<?php $this->load->view('gerenciador/_footer')?>