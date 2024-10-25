<?php $this->load->view('gerenciador/_header'); ?>

<div class="page-header">
    <ol class="breadcrumb">
    	<li> <a href="<?php echo site_url('gerenciador/premiacoes')?>">Premiações</a> </li>
    	<li class="active"><?php echo empty($item->premiacao_id) ? 'Adicionar' : 'Editar' ?></li>
    </ol>
</div>

<?php echo form_open_multipart('gerenciador/premiacoes/save', array('class'=>'form-horizontal', 'role'=>'form'));?>
	<fieldset>
    	<div class="form-group">
            <label class="col-sm-1 control-label" for="title">Título:</label>
            <div class="col-xs-3">
                <input type="text" name="titulo" class="form-control" id="titulo" value="<?php echo empty($item->titulo) ? set_value('titulo') : $item->titulo?>" required />
            </div>
            <label class="col-sm-1 control-label" for="titulo_en">EN:</label>
            <div class="col-xs-3">
                 <input type="text" name="titulo_en" class="form-control" id="titulo_en" value="<?php echo empty($item->titulo_en) ? set_value('titulo_en') : $item->titulo_en?>" />
            </div>
            <label class="col-sm-1 control-label" for="titulo_es">ES:</label>
            <div class="col-xs-3">
                 <input type="text" name="titulo_es" class="form-control" id="titulo_es" value="<?php echo empty($item->titulo_es) ? set_value('titulo_es') : $item->titulo_es?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-1 control-label" for="description">Texto:</label>
            <div class="col-xs-11">
                <textarea name="texto"  id="txt"><?php echo empty($item->texto) ? set_value('texto') : $item->texto?></textarea><?php echo display_ckeditor($ck1); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-1 control-label" for="description">Texto EN:</label>
            <div class="col-xs-11">
                <textarea name="texto_en"  id="txt2"><?php echo empty($item->texto_en) ? set_value('texto_en') : $item->texto_en?></textarea><?php echo display_ckeditor($ck2); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-1 control-label" for="description">Texto ES:</label>
            <div class="col-xs-11">
                <textarea name="texto_es"  id="txt3"><?php echo empty($item->texto_es) ? set_value('texto_es') : $item->texto_es?></textarea><?php echo display_ckeditor($ck3); ?>
            </div>
        </div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<input type="hidden" name="premiacao_id" value="<?php echo empty($item->premiacao_id) ? '' : $item->premiacao_id; ?>" />
				<button class="btn btn-primary" type="submit">Salvar</button>
				<a href="<?php echo site_url('gerenciador/premiacoes')?>" class="btn btn-default">Voltar</a>
			</div>
		</div>
    </fieldset>
<?php echo form_close();?>

<?php $this->load->view('gerenciador/_footer')?>