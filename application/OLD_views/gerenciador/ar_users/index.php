<?php $this->load->view('gerenciador/_header')?>

<div class="page-header">
    <ol class="breadcrumb">
        <li class="active">Área Restrita - Usuários</li>
    </ol>
</div>
<div class="action-header">
    <a class="btn btn-primary" href="<?php echo site_url('gerenciador/ar_users/add')?>"><i class="icon-plus icon-white"></i> Adicionar Usuário</a>
</div>
<table class="table table-striped">
	<thead>
		<tr>
            <th>Nome</th>
            <th width="350">Email</th>
            <th width="300">Perfil</th>
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
                    <td> <?php echo $this->Ar_User->getProfile($item->profile_id)->name; ?> </td>
                    <td align="center">
                    	<a href="<?php echo site_url('gerenciador/ar_users/edit/'.$item->ar_user_id); ?>" class="btn btn-success" title="Editar" ><i class="glyphicon glyphicon-pencil icon-white"></i></a>
        			<a href="<?php echo site_url('gerenciador/ar_users/delete/'.$item->ar_user_id); ?>" class="btn btn-danger" onclick="return confirm('Deseja realmente remover este item? Essa operação não pode ser revertida.');" title="Remover" ><i class="glyphicon glyphicon-trash icon-white"></i></a>
                    </td>
                </tr>
            <?php }
        } ?>
	</tbody>
</table>

<?php $this->load->view('gerenciador/_footer')?>