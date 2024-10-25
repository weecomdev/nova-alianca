<?php $this->load->view('gerenciador/_header'); ?>

<div class="page-header">
    <ol class="breadcrumb">
    	<li> <a href="<?php echo site_url('gerenciador/noticias')?>">Notícias</a> </li>
    	<li class="active"><?php echo empty($item->noticia_id) ? 'Adicionar' : 'Editar' ?></li>
    </ol>
</div>

<?php echo form_open_multipart('gerenciador/noticias/save', array('class'=>'form-horizontal', 'role'=>'form'));?>
	<fieldset>
    
    	<div class="form-group">
   			<label class="col-sm-2 control-label" for="title">Título:</label>
   			<div class="col-xs-4">
                <input type="text" name="titulo" class="form-control" id="titulo" value="<?php echo empty($item->titulo) ? set_value('titulo') : $item->titulo?>" required />
            </div>
   			<label class="col-sm-1 control-label" for="titulo_en">EN:</label>
            <div class="col-xs-4">
                 <input type="text" name="titulo_en" class="form-control" id="titulo_en" value="<?php echo empty($item->titulo_en) ? set_value('titulo_en') : $item->titulo_en?>" />
   			</div>
    	</div>
        <div class="form-group">
        <label class="col-sm-2 control-label" for="data">Data:</label>
        <div class="col-xs-5">
          <input type="text" name="data" class="form-control date" id="data" value="<?php echo empty($item->data) ? set_value('data') : dateUStoBR($item->data) ?>" required autofocus />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="subtitulo">Linha de Apoio:</label>
        <div class="col-xs-4">
             <textarea name="subtitulo" class="form-control" id="subtitulo" rows="10"><?php echo empty($item->subtitulo) ? set_value('subtitulo') : $item->subtitulo?></textarea>
        </div>
        <label class="col-sm-1 control-label" for="subtitulo_en">EN:</label>
        <div class="col-xs-4">
             <textarea name="subtitulo_en" class="form-control" id="subtitulo_en" rows="10"><?php echo empty($item->subtitulo_en) ? set_value('subtitulo_en') : $item->subtitulo_en?></textarea>
        </div>
      </div>
    	<div class="form-group">
   			<label class="col-sm-2 control-label" for="description">Texto:</label>
   			<div class="col-xs-10">
   				<textarea name="texto"  id="txt"><?php echo empty($item->texto) ? set_value('texto') : $item->texto?></textarea><?php echo display_ckeditor($ck1); ?>
   			</div>
    	</div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="description">Texto EN:</label>
            <div class="col-xs-10">
                <textarea name="texto_en"  id="txt2"><?php echo empty($item->texto_en) ? set_value('texto_en') : $item->texto_en?></textarea><?php echo display_ckeditor($ck2); ?>
            </div>
        </div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<input type="hidden" name="noticia_id" value="<?php echo empty($item->noticia_id) ? '' : $item->noticia_id; ?>" />
				<button class="btn btn-primary" type="submit">Salvar</button>
				<a href="<?php echo site_url('gerenciador/noticias')?>" class="btn btn-default">Voltar</a>
			</div>
		</div>
    </fieldset>
<?php echo form_close();?>

<?php $this->load->view('gerenciador/_footer')?>