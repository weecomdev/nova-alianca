<?php $this->load->view('gerenciador/_header'); ?>

<div class="page-header">
    <ol class="breadcrumb">
    	<li> <a href="<?php echo site_url('gerenciador/ar_agenda')?>">Agenda</a> </li>
    	<li class="active"><?php echo empty($item->ar_agenda_id) ? 'Adicionar' : 'Editar' ?></li>
    </ol>
</div>

<?php echo form_open_multipart('gerenciador/ar_agenda/save', array('class'=>'form-horizontal', 'role'=>'form'));?>
	<fieldset>
    
    	<div class="form-group">
   			<label class="col-sm-2 control-label" for="title">Título:</label>
   			<div class="col-xs-5">
   				<input type="text" name="titulo" class="form-control" id="titulo" value="<?php echo empty($item->titulo) ? set_value('titulo') : $item->titulo?>" required autofocus/>
   			</div>
    	</div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="data">Data:</label>
            <?php
                if(!empty($item->data)) $data = explode(' ',$item->data);
             ?>
            <div class="col-xs-2">
              <input type="text" name="dia" class="form-control date" id="data" value="<?php echo empty($data[0]) ? set_value('dia') : dateUStoBR($data[0]) ?>" required />
            </div>
            <div class="col-xs-1">
              <input type="text" name="hora" class="form-control time" id="time" value="<?php echo empty($data[1]) ? set_value('hora') : timelongToShort($data[1]) ?>" required />
            </div>
        </div>
    	<div class="form-group">
   			<label class="col-sm-2 control-label" for="description">Texto:</label>
   			<div class="col-xs-10">
   				<textarea name="texto"  id="txt"><?php echo empty($item->texto) ? set_value('texto') : $item->texto?></textarea><?php echo display_ckeditor($ck1); ?>
   			</div>
    	</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<input type="hidden" name="ar_agenda_id" value="<?php echo empty($item->ar_agenda_id) ? '' : $item->ar_agenda_id; ?>" />
				<button class="btn btn-primary" type="submit">Salvar</button>
				<a href="<?php echo site_url('gerenciador/ar_agenda')?>" class="btn btn-default">Voltar</a>
			</div>
		</div>
    </fieldset>
<?php echo form_close();?>

<?php $this->load->view('gerenciador/_footer')?>