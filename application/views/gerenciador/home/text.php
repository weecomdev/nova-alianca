<?php $this->load->view('gerenciador/_header'); ?>
<div class="page-header">
    <ol class="breadcrumb">
    	<li class="active">Home Links</li>
    </ol>
</div>

<?php echo form_open('gerenciador/home/save',array('class'=>'form-horizontal', 'role'=>'form'));?>
	<fieldset>
        <h3>Link 1</h3>
        <div class="form-group">
            <label class="col-sm-1 control-label" for="home1_frase_p1">Frase P1:</label>
            <div class="col-xs-3">
                <input type="text" name="home1_frase_p1" class="form-control" id="home1_frase_p1" value="<?php echo empty($home1_frase_p1) ? set_value('home1_frase_p1') : $home1_frase_p1?>" required />
            </div>
            <label class="col-sm-1 control-label" for="home1_frase_p1_en">EN:</label>
            <div class="col-xs-3">
                 <input type="text" name="home1_frase_p1_en" class="form-control" id="home1_frase_p1_en" value="<?php echo empty($home1_frase_p1_en) ? set_value('home1_frase_p1_en') : $home1_frase_p1_en?>" />
            </div>
            <label class="col-sm-1 control-label" for="home1_frase_p1_es">ES:</label>
            <div class="col-xs-3">
                 <input type="text" name="home1_frase_p1_es" class="form-control" id="home1_frase_p1_es" value="<?php echo empty($home1_frase_p1_es) ? set_value('home1_frase_p1_es') : $home1_frase_p1_es?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-1 control-label" for="home1_frase_p2">Frase P2:</label>
            <div class="col-xs-3">
                <input type="text" name="home1_frase_p2" class="form-control" id="home1_frase_p2" value="<?php echo empty($home1_frase_p2) ? set_value('home1_frase_p2') : $home1_frase_p2?>" required />
            </div>
            <label class="col-sm-1 control-label" for="home1_frase_p2_en">EN:</label>
            <div class="col-xs-3">
                 <input type="text" name="home1_frase_p2_en" class="form-control" id="home1_frase_p2_en" value="<?php echo empty($home1_frase_p2_en) ? set_value('home1_frase_p2_en') : $home1_frase_p2_en?>" />
            </div>
            <label class="col-sm-1 control-label" for="home1_frase_p2_es">ES:</label>
            <div class="col-xs-3">
                 <input type="text" name="home1_frase_p2_es" class="form-control" id="home1_frase_p2_es" value="<?php echo empty($home1_frase_p2_es) ? set_value('home1_frase_p2_es') : $home1_frase_p2_es?>" />
            </div>
        </div>
    	<div class="form-group">
   			<label class="col-sm-1 control-label" for="home1_text">Texto:</label>
   			<div class="col-xs-3">
   				<textarea class="form-control" name="home1_text"  id="home1_text" rows="5" cols="48"><?php echo empty($home1_text) ? set_value('home1_text') : $home1_text?></textarea>
    		</div>
            <label class="col-sm-1 control-label" for="home1_text_en">EN:</label>
            <div class="col-xs-3">
                <textarea class="form-control" name="home1_text_en"  id="home1_text_en" rows="5" cols="48"><?php echo empty($home1_text_en) ? set_value('home1_text_en') : $home1_text_en?></textarea>
            </div>
            <label class="col-sm-1 control-label" for="home1_text_es">ES:</label>
            <div class="col-xs-3">
                <textarea class="form-control" name="home1_text_es"  id="home1_text_es" rows="5" cols="48"><?php echo empty($home1_text_es) ? set_value('home1_text_es') : $home1_text_es?></textarea>
            </div>
    	</div>
        <div class="form-group">
            <label class="col-sm-1 control-label" for="home1_link_title">Link Title:</label>
            <div class="col-xs-3">
                <input type="text" name="home1_link_title" class="form-control" id="home1_link_title" value="<?php echo empty($home1_link_title) ? set_value('home1_link_title') : $home1_link_title?>" required />
            </div>
            <label class="col-sm-1 control-label" for="home1_link_title_en">EN:</label>
            <div class="col-xs-3">
                 <input type="text" name="home1_link_title_en" class="form-control" id="home1_link_title_en" value="<?php echo empty($home1_link_title_en) ? set_value('home1_link_title_en') : $home1_link_title_en?>" />
            </div>
            <label class="col-sm-1 control-label" for="home1_link_title_es">ES:</label>
            <div class="col-xs-3">
                 <input type="text" name="home1_link_title_es" class="form-control" id="home1_link_title_es" value="<?php echo empty($home1_link_title_es) ? set_value('home1_link_title_es') : $home1_link_title_es?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-1 control-label" for="home1_link">Link:</label>
            <div class="col-xs-11">
                <input type="text" name="home1_link" class="form-control" id="home1_link" value="<?php echo empty($home1_link) ? set_value('home1_link') : $home1_link?>" required />
            </div>
        </div>

        <hr />
        <h3>Link 2</h3>
        <div class="form-group">
            <label class="col-sm-1 control-label" for="home2_frase_p1">Frase P1:</label>
            <div class="col-xs-3">
                <input type="text" name="home2_frase_p1" class="form-control" id="home2_frase_p1" value="<?php echo empty($home2_frase_p1) ? set_value('home2_frase_p1') : $home2_frase_p1?>" required />
            </div>
            <label class="col-sm-1 control-label" for="home2_frase_p1_en">EN:</label>
            <div class="col-xs-3">
                 <input type="text" name="home2_frase_p1_en" class="form-control" id="home2_frase_p1_en" value="<?php echo empty($home2_frase_p1_en) ? set_value('home2_frase_p1_en') : $home2_frase_p1_en?>" />
            </div>
            <label class="col-sm-1 control-label" for="home2_frase_p1_es">ES:</label>
            <div class="col-xs-3">
                 <input type="text" name="home2_frase_p1_es" class="form-control" id="home2_frase_p1_es" value="<?php echo empty($home2_frase_p1_es) ? set_value('home2_frase_p1_es') : $home2_frase_p1_es?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-1 control-label" for="home2_frase_p2">Frase P2:</label>
            <div class="col-xs-3">
                <input type="text" name="home2_frase_p2" class="form-control" id="home2_frase_p2" value="<?php echo empty($home2_frase_p2) ? set_value('home2_frase_p2') : $home2_frase_p2?>" required />
            </div>
            <label class="col-sm-1 control-label" for="home2_frase_p2_en">EN:</label>
            <div class="col-xs-3">
                 <input type="text" name="home2_frase_p2_en" class="form-control" id="home2_frase_p2_en" value="<?php echo empty($home2_frase_p2_en) ? set_value('home2_frase_p2_en') : $home2_frase_p2_en?>" />
            </div>
            <label class="col-sm-1 control-label" for="home2_frase_p2_es">ES:</label>
            <div class="col-xs-3">
                 <input type="text" name="home2_frase_p2_es" class="form-control" id="home2_frase_p2_es" value="<?php echo empty($home2_frase_p2_es) ? set_value('home2_frase_p2_es') : $home2_frase_p2_es?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-1 control-label" for="home2_text">Texto:</label>
            <div class="col-xs-3">
                <textarea class="form-control" name="home2_text"  id="home2_text" rows="5" cols="48"><?php echo empty($home2_text) ? set_value('home2_text') : $home2_text?></textarea>
            </div>
            <label class="col-sm-1 control-label" for="home2_text_en">EN:</label>
            <div class="col-xs-3">
                <textarea class="form-control" name="home2_text_en"  id="home2_text_en" rows="5" cols="48"><?php echo empty($home2_text_en) ? set_value('home2_text_en') : $home2_text_en?></textarea>
            </div>
            <label class="col-sm-1 control-label" for="home2_text_es">ES:</label>
            <div class="col-xs-3">
                <textarea class="form-control" name="home2_text_es"  id="home2_text_es" rows="5" cols="48"><?php echo empty($home2_text_es) ? set_value('home2_text_es') : $home2_text_es?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-1 control-label" for="home2_link_title">Link Title:</label>
            <div class="col-xs-3">
                <input type="text" name="home2_link_title" class="form-control" id="home2_link_title" value="<?php echo empty($home2_link_title) ? set_value('home2_link_title') : $home2_link_title?>" required />
            </div>
            <label class="col-sm-1 control-label" for="home2_link_title_en">EN:</label>
            <div class="col-xs-3">
                 <input type="text" name="home2_link_title_en" class="form-control" id="home2_link_title_en" value="<?php echo empty($home2_link_title_en) ? set_value('home2_link_title_en') : $home2_link_title_en?>" />
            </div>
            <label class="col-sm-1 control-label" for="home2_link_title_es">EN:</label>
            <div class="col-xs-3">
                 <input type="text" name="home2_link_title_es" class="form-control" id="home2_link_title_es" value="<?php echo empty($home2_link_title_es) ? set_value('home2_link_title_es') : $home2_link_title_es?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-1 control-label" for="home2_link">Link:</label>
            <div class="col-xs-11">
                <input type="text" name="home2_link" class="form-control" id="home2_link" value="<?php echo empty($home2_link) ? set_value('home2_link') : $home2_link?>" required />
            </div>
        </div>
       
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button class="btn btn-primary" type="submit">Salvar</button>
			</div>
		</div>
    </fieldset>
<?php echo form_close();?>

<?php $this->load->view('gerenciador/_footer')?>