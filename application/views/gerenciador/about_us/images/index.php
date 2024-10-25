<?php $this->load->view('gerenciador/_header')?>

<div class="page-header">
    <ol class="breadcrumb">
        <li>Institucional</li>
        <li class="active">Imagens</li>
    </ol>
</div>
<div class="action-header">
    <a class="btn btn-primary" href="<?php echo site_url('gerenciador/about_us_images/add')?>"><i class="icon-plus icon-white"></i> Adicionar Imagens</a>
</div>
<table class="table table-striped">
	<thead>
		<tr>
    		<th>Imagens</th>
        	<th width="80">Ações</th>
    	</tr>
    </thead>
    <tbody class="table-sortable">
    	<?php if (!is_array($items) || count($items) == 0 || empty($items) ) {?>
        	<tr> <td colspan="2" align="center">nenhuma imagem</td> </tr>
        <?php } else {
			foreach($items as $item){ ?>
                <tr class="ui-state-default" data-id="<?php echo $item->about_us_image_id; ?>">
                    <td> <img src="<?php echo site_url(ABOUT_US_IMAGES_PATH.$item->thumb_image); ?>" style="max-width: 300px;max-height:200px;" /> </td>
                    <td align="center">
                        <a href="<?php echo site_url('gerenciador/about_us_images/delete/'.$item->about_us_image_id); ?>" class="btn btn-danger" onclick="return confirm('Deseja realmente remover este item? Essa operação não pode ser revertida.');" title="Remover" ><i class="glyphicon glyphicon-trash icon-white"></i></a>
                    </td>
                </tr>
            <?php }
        } ?>
	</tbody>
</table>

<?php $this->load->view('gerenciador/_footer')?>