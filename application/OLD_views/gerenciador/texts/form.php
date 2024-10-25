<?php $this->load->view('gerenciador/_header'); ?>
<div class="page-header">
    <ol class="breadcrumb">
        <li class="active"><?php echo $txt->title;?></li>
    </ol>
</div>

<?php echo form_open('gerenciador/texts/save',array('class'=>'form-horizontal', 'role'=>'form'));?>
    <fieldset>
        <div class="form-group">
            <div class="col-xs-12">
                <textarea name="txt"  id="txt"><?php echo empty($txt->text) ? set_value('txt') : $txt->text?></textarea><?php echo display_ckeditor($ck1); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="hidden" name="id" value="<?php echo $txt->text_id;?>" />
                <input type="hidden" name="alias" value="<?php echo $txt->alias;?>" />
                <button class="btn btn-primary" type="submit">Salvar Texto</button>
            </div>
        </div>
    </fieldset>
<?php echo form_close();?>

<?php $this->load->view('gerenciador/_footer')?>