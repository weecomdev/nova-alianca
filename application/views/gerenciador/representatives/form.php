<?php $this->load->view('gerenciador/_header'); ?>

<div class="page-header">
    <ol class="breadcrumb">
    	<li> <a href="<?php echo site_url('gerenciador/representatives')?>">Representantes</a> </li>
    	<li class="active"><?php echo empty($item->representative_id) ? 'Adicionar' : 'Editar' ?> Representante</li>
    </ol>
</div>

<?php echo form_open_multipart('gerenciador/representatives/save', array('class'=>'form-horizontal', 'role'=>'form', 'id'=>'send_form'));?>
	<fieldset>    	
    	<div class="form-group">
   			<label class="col-sm-2 control-label" for="title">Nome:</label>
   			<div class="col-xs-5">
   				<input type="text" name="name" class="form-control" id="name" value="<?php echo empty($item->name) ? set_value('name') : $item->name?>" required autofocus/>
   			</div>
    	</div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="title">Estado:</label>
        <div class="col-xs-5">
          <select name="state" id="state"  class="form-control" required>     
           <option value="">Selecione um estado</option>
          <?php foreach ($estados as $key => $value) : ?>       
            <option <?php  if(isset($item) && $item->state == $value->symbol) echo 'selected="selected"';?> value="<?php echo $value->symbol; ?>"><?php echo $value->name; ?></option>
          <?php endforeach; ?>          
          </select>
        </div>
      </div>        
      <div class="form-group">
        <label class="col-sm-2 control-label" for="title">Região:</label>
        <div class="col-xs-5">
          <input type="text" name="address" class="form-control" id="address" value="<?php echo empty($item->address) ? set_value('address') : $item->address?>" required />
        </div>
      </div>      
      <div class="form-group">
        <label class="col-sm-2 control-label" for="title">Telefone:</label>
        <div class="col-xs-5">
          <input type="text" name="phone" class="form-control" id="phone" value="<?php echo empty($item->phone) ? set_value('phone') : $item->phone?>" required />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="title">E-mail:</label>
        <div class="col-xs-5">
          <input type="text" name="email" class="form-control" id="email" value="<?php echo empty($item->email) ? set_value('email') : $item->email?>" required />
        </div>
      </div>          
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<input type="hidden" name="representative_id" value="<?php echo empty($item->representative_id) ? '' : $item->representative_id; ?>" />
				<button class="btn btn-primary" type="submit">Salvar</button>
				<a href="<?php echo site_url('gerenciador/representatives')?>" class="btn btn-default">Voltar</a>
			</div>
		</div>
    </fieldset>
<?php echo form_close();?>

<?php $this->load->view('gerenciador/_footer')?>