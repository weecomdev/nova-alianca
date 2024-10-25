<?php $this->load->view('gerenciador/_header'); ?>

<div class="page-header">
    <ol class="breadcrumb">
        <li> <a href="<?php echo site_url('gerenciador/users')?>">Usuários</a> </li>
        <li class="active"><?php echo empty($item->user_id) ? 'Adicionar' : 'Editar' ?> Usuário</li>
    </ol>
</div>

<?php echo form_open_multipart('gerenciador/users/save', array('class'=>'form-horizontal', 'role'=>'form'));?>
    <fieldset>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Nome:</label>
            <div class="col-xs-5">
                <input type="text" name="name" class="form-control" id="name" value="<?php echo empty($item->name) ? set_value('name') : $item->name?>" required autofocus />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="email">Email:</label>
            <div class="col-xs-5">
                <input type="text" name="email" class="form-control" id="email" value="<?php echo empty($item->email) ? set_value('email') : $item->email?>" required />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="password">Senha:</label>
            <div class="col-xs-5">
                <input type="password" name="password" class="form-control" id="password" value="" <?php echo empty($item->user_id) ? 'required' : '' ?> />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="confirm_password">Confirmar Senha:</label>
            <div class="col-xs-5">
                <input type="password" name="confirm_password" class="form-control" id="confirm_password" value="" <?php echo empty($item->user_id) ? 'required' : '' ?> />
            </div>
        </div>
        <?php if ($this->session->userdata('user_level') == 1){ ?>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label for="level"> <input type="checkbox" name="level" id="level" value="1" <?php echo empty($item->level) ? '' : 'checked="checked"'; ?>> Pode gerenciar usuários? </label>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name="user_id" value="<?php echo empty($item->user_id) ? '' : $item->user_id; ?>" />
                <button class="btn btn-primary" type="submit">Salvar</button>
                <a href="<?php echo site_url('gerenciador/users')?>" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </fieldset>
<?php echo form_close();?>

<?php $this->load->view('gerenciador/_footer')?>