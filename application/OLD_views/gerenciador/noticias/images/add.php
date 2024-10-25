<?php $this->load->view('gerenciador/_header'); ?>
<div class="page-header">
    <ol class="breadcrumb">
	    <li><a href="<?php echo site_url('gerenciador/noticias')?>">Notícias</a></li>
        <li> <a href="<?php echo site_url('gerenciador/noticias_imagens/index').'/'.$id;?>">Imagens</a> </li>
	    <li class="active">Adicionar Imagens</li>
    </ol>
</div>
<br />
<form id="fileupload" action="<?php echo site_url('index.php/gerenciador/noticias_imagens/upload/').'/'.$id;?>" method="POST" enctype="multipart/form-data">
 <input type="hidden" name="product_id" value="<?php echo $id;?>">
    <div class="row fileupload-buttonbar">
        <div class="col-sm-10">        
            <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus icon-white"></i>
                <span>Adicionar Imagens (1800x900)</span>
                <input type="file" name="files[]" multiple>
            </span>
            <button type="submit" class="btn btn-primary start">
                <i class="glyphicon glyphicon-upload icon-white"></i>
                <span>Fazer upload</span>
            </button>
            <button type="reset" class="btn btn-warning cancel">
                <i class="glyphicon glyphicon-ban-circle icon-white"></i>
                <span>Cancelar upload</span>
            </button>
            <a href="<?php echo site_url('gerenciador/noticias_imagens/index').'/'.$id;?>" class="btn btn-default">Voltar</a>
        </div>
        <div class="col-sm-10 fileupload-progress fade">
            <div class="progress progress-success progress-striped active">
                <div class="bar" style="width:0%;"></div>
            </div>
            <div class="progress-extended">&nbsp;</div>
        </div>
    </div>
    <div class="fileupload-loading"></div>
    <br />
    <table class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
</form>
<br />
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
        	<td class="title"> </td>
            <td>
                <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="glyphicon glyphicon-upload icon-white"></i>
                    <span>Upload</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="glyphicon glyphicon-ban-circle icon-white"></i>
                <span>Cancelar</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.true_name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } %}
    </tr>
{% } %}
</script>
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> -->
<script src="<?php echo site_url(ASSETS_MANAGER.'upload/js/vendor/jquery.ui.widget.js');?>"></script>
<script src="<?php echo site_url(ASSETS_MANAGER.'upload/js/tmpl.min.js');?>"></script>
<script src="<?php echo site_url(ASSETS_MANAGER.'upload/js/load-image.min.js');?>"></script>
<script src="<?php echo site_url(ASSETS_MANAGER.'upload/js/canvas-to-blob.min.js');?>"></script>
<script src="<?php echo site_url(ASSETS_MANAGER.'upload/js/jquery.iframe-transport.js');?>"></script>
<script src="<?php echo site_url(ASSETS_MANAGER.'upload/js/jquery.fileupload.js');?>"></script>
<script src="<?php echo site_url(ASSETS_MANAGER.'upload/js/jquery.fileupload-fp.js')?>"></script>
<script src="<?php echo site_url(ASSETS_MANAGER.'upload/js/jquery.fileupload-ui.js');?>"></script>
<script src="<?php echo site_url(ASSETS_MANAGER.'upload/js/locale.js');?>"></script>
<script src="<?php echo site_url(ASSETS_MANAGER.'upload/js/main.js');?>"></script>

<?php $this->load->view('gerenciador/_footer')?>