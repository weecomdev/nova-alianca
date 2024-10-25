<?php $this->load->view('gerenciador/_header'); ?>
<div class="page-header">
    <ol class="breadcrumb">
      	<li class="active">Contato</li>
    </ol>
</div>

<?php echo form_open_multipart('gerenciador/contact_data/save',array('class'=>'form-horizontal'));?>
	<fieldset>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="address">Endereço:</label>
            <div class="col-xs-5">
                <input type="text" name="address" class="form-control" id="address" value="<?php echo empty($item->address) ? set_value('address') : $item->address?>" required autofocus />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="address_number">Número:</label>
            <div class="col-xs-1">
                <input type="text" name="address_number" class="form-control number" id="address_number" value="<?php echo empty($item->address_number) ? set_value('address_number') : $item->address_number?>"  />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="address_complement">Complemento:</label>
            <div class="col-xs-2">
                <input type="text" name="address_complement" class="form-control" id="address_complement" value="<?php echo empty($item->address_complement) ? set_value('address_complement') : $item->address_complement?>"  />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="zip_code">CEP:</label>
            <div class="col-xs-2">
                <input type="text" name="zip_code" class="form-control zip_code" id="zip_code" value="<?php echo empty($item->zip_code) ? set_value('zip_code') : $item->zip_code ?>" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="phone">Telefone:</label>
            <div class="col-xs-2">
                <input type="text" name="phone" class="form-control phone" id="phone" value="<?php echo empty($item->phone) ? set_value('phone') : $item->phone?>" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="email">Email:</label>
            <div class="col-xs-4">
                <input type="text" name="email" class="form-control" id="email" value="<?php echo empty($item->email) ? set_value('email') : $item->email?>" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="state">Estado:</label>
            <div class="col-xs-1">
                <input type="text" name="state" class="form-control uf" id="state" value="<?php echo empty($item->state) ? set_value('state') : $item->state?>" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="city">Cidade:</label>
            <div class="col-xs-4">
                <input type="text" name="city" class="form-control" id="city" onBlur="google_map($(this).val())" value="<?php echo empty($item->city) ? set_value('city') : $item->city?>" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="district">Bairro:</label>
            <div class="col-xs-4">
                <input type="text" name="district" class="form-control" id="district" onBlur="google_map($(this).val())" value="<?php echo empty($item->district) ? set_value('district') : $item->district?>" required />
            </div>
        </div>
        <div class="form-group">
           <label class="col-sm-2 control-label">Ponto no Mapa:</label>
           <div class="col-xs-10" id="map_div"> </div>
        </div>
    	<div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name="latitude" id="latitude" value="<?php echo empty($item->latitude) ? '' : $item->latitude; ?>" />
                <input type="hidden" name="longitude" id="longitude" value="<?php echo empty($item->longitude) ? '' : $item->longitude; ?>" />
                <input type="hidden" name="contact_data_id" value="<?php echo empty($item->contact_data_id) ? '' : $item->contact_data_id; ?>" />
                <button class="btn btn-primary" type="submit">Salvar</button>
            </div>
        </div>
  </fieldset>
<?php echo form_close();?>

<?php $this->load->view('gerenciador/_footer')?>