<?php $this->load->view('gerenciador/_header'); ?>
<div class="page-header">
    <ol class="breadcrumb">
    	<li class="active">Institucional</li>
    </ol>
</div>

<?php echo form_open('gerenciador/about_us_text/save',array('class'=>'form-horizontal', 'role'=>'form'));?>
	<fieldset>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inst_frase_p1">Frase Banner P1:</label>
            <div class="col-xs-4">
                <input type="text" name="inst_frase_p1" class="form-control" id="inst_frase_p1" value="<?php echo empty($inst_frase_p1) ? set_value('inst_frase_p1') : $inst_frase_p1?>" required />
            </div>
            <label class="col-sm-1 control-label" for="inst_frase_p1_en">EN:</label>
            <div class="col-xs-4">
                 <input type="text" name="inst_frase_p1_en" class="form-control" id="inst_frase_p1_en" value="<?php echo empty($inst_frase_p1_en) ? set_value('inst_frase_p1_en') : $inst_frase_p1_en?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inst_frase_p2">Frase Banner P2:</label>
            <div class="col-xs-4">
                <input type="text" name="inst_frase_p2" class="form-control" id="inst_frase_p2" value="<?php echo empty($inst_frase_p2) ? set_value('inst_frase_p2') : $inst_frase_p2?>" required />
            </div>
            <label class="col-sm-1 control-label" for="inst_frase_p2_en">EN:</label>
            <div class="col-xs-4">
                 <input type="text" name="inst_frase_p2_en" class="form-control" id="inst_frase_p2_en" value="<?php echo empty($inst_frase_p2_en) ? set_value('inst_frase_p2_en') : $inst_frase_p2_en?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inst_frase_p3">Frase Banner P3:</label>
            <div class="col-xs-4">
                <input type="text" name="inst_frase_p3" class="form-control" id="inst_frase_p3" value="<?php echo empty($inst_frase_p3) ? set_value('inst_frase_p3') : $inst_frase_p3?>" required />
            </div>
            <label class="col-sm-1 control-label" for="inst_frase_p3_en">EN:</label>
            <div class="col-xs-4">
                 <input type="text" name="inst_frase_p3_en" class="form-control" id="inst_frase_p3_en" value="<?php echo empty($inst_frase_p3_en) ? set_value('inst_frase_p3_en') : $inst_frase_p3_en?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inst_title11">Titulo 1 P1:</label>
            <div class="col-xs-4">
                <input type="text" name="inst_title11" class="form-control" id="inst_title11" value="<?php echo empty($inst_title11) ? set_value('inst_title11') : $inst_title11?>" required />
            </div>
            <label class="col-sm-1 control-label" for="inst_title11_en">EN:</label>
            <div class="col-xs-4">
                 <input type="text" name="inst_title11_en" class="form-control" id="inst_title11_en" value="<?php echo empty($inst_title11_en) ? set_value('inst_title11_en') : $inst_title11_en?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inst_title12">Titulo 1 P2:</label>
            <div class="col-xs-4">
                <input type="text" name="inst_title12" class="form-control" id="inst_title12" value="<?php echo empty($inst_title12) ? set_value('inst_title12') : $inst_title12?>" required />
            </div>
            <label class="col-sm-1 control-label" for="inst_title12_en">EN:</label>
            <div class="col-xs-4">
                <input type="text" name="inst_title12_en" class="form-control" id="inst_title12_en" value="<?php echo empty($inst_title12_en) ? set_value('inst_title12_en') : $inst_title12_en?>" />
            </div>
        </div>
    	<div class="form-group">
   			<label class="col-sm-2 control-label" for="inst_text1">Texto 1:</label>
   			<div class="col-xs-10">
   				<textarea name="inst_text1"  id="inst_text1"><?php echo empty($inst_text1) ? set_value('inst_text1') : $inst_text1?></textarea>
          <?php echo display_ckeditor($ck1); ?>
    		</div>
    	</div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inst_text1_en">Texto 1 EN:</label>
            <div class="col-xs-10">
                <textarea name="inst_text1_en"  id="inst_text1_en"><?php echo empty($inst_text1_en) ? set_value('inst_text1_en') : $inst_text1_en?></textarea>
          <?php echo display_ckeditor($ck1_en); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inst_title21">Titulo 2 P1:</label>
            <div class="col-xs-4">
                <input type="text" name="inst_title21" class="form-control" id="inst_title21" value="<?php echo empty($inst_title21) ? set_value('inst_title21') : $inst_title21?>" required />
            </div>
            <label class="col-sm-1 control-label" for="inst_title21_en">EN:</label>
            <div class="col-xs-4">
                <input type="text" name="inst_title21_en" class="form-control" id="inst_title21_en" value="<?php echo empty($inst_title21_en) ? set_value('inst_title21_en') : $inst_title21_en?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inst_title22">Titulo 2 P2:</label>
            <div class="col-xs-4">
                <input type="text" name="inst_title22" class="form-control" id="inst_title22" value="<?php echo empty($inst_title22) ? set_value('inst_title22') : $inst_title22?>" required />
            </div>
            <label class="col-sm-1 control-label" for="inst_title22_en">EN:</label>
            <div class="col-xs-4">
                <input type="text" name="inst_title22_en" class="form-control" id="inst_title22_en" value="<?php echo empty($inst_title22_en) ? set_value('inst_title22_en') : $inst_title22_en?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inst_text2">Texto 2:</label>
            <div class="col-xs-10">
                <textarea name="inst_text2"  id="inst_text2"><?php echo empty($inst_text2) ? set_value('inst_text2') : $inst_text2?></textarea>
          <?php echo display_ckeditor($ck2); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inst_text2_en">Texto 2 EN:</label>
            <div class="col-xs-10">
                <textarea name="inst_text2_en"  id="inst_text2_en"><?php echo empty($inst_text2_en) ? set_value('inst_text2_en') : $inst_text2_en?></textarea>
          <?php echo display_ckeditor($ck2_en); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inst_valores">Valores:</label>
            <div class="col-xs-10">
                <textarea name="inst_valores"  id="inst_valores"><?php echo empty($inst_valores) ? set_value('inst_valores') : $inst_valores?></textarea>
          <?php echo display_ckeditor($ck3); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inst_valores_en">Valores EN:</label>
            <div class="col-xs-10">
                <textarea name="inst_valores_en"  id="inst_valores_en"><?php echo empty($inst_valores_en) ? set_value('inst_valores_en') : $inst_valores_en?></textarea>
          <?php echo display_ckeditor($ck3_en); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inst_principios">Princípios:</label>
            <div class="col-xs-10">
                <textarea name="inst_principios"  id="inst_principios"><?php echo empty($inst_principios) ? set_value('inst_principios') : $inst_principios?></textarea>
          <?php echo display_ckeditor($ck4); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="inst_principios_en">Princípios EN:</label>
            <div class="col-xs-10">
                <textarea name="inst_principios_en"  id="inst_principios_en"><?php echo empty($inst_principios_en) ? set_value('inst_principios_en') : $inst_principios_en?></textarea>
          <?php echo display_ckeditor($ck4_en); ?>
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