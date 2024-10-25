<?php $this->load->view('gerenciador/_header'); ?>

<div class="page-header">
    <ol class="breadcrumb">
        <li> <a href="<?php echo site_url('gerenciador/ar_users')?>">Usuários</a> </li>
        <li class="active"><?php echo empty($item->ar_user_id) ? 'Adicionar' : 'Editar' ?> Usuário</li>
    </ol>
</div>

<?php echo form_open_multipart('gerenciador/ar_users/save', array('class'=>'form-horizontal', 'role'=>'form'));?>
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
                <input type="password" name="password" class="form-control" id="password" value="" <?php echo empty($item->ar_user_id) ? 'required' : '' ?> />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="confirm_password">Confirmar Senha:</label>
            <div class="col-xs-5">
                <input type="password" name="confirm_password" class="form-control" id="confirm_password" value="" <?php echo empty($item->ar_user_id) ? 'required' : '' ?> />
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="perfil_id">Perfil:</label>
            <div class="col-xs-5">
                <select name="profile_id" id="perfil_id" class="form-control">
                    <?php foreach ($profiles as $key => $profile): ?>
                        <option value="<?php echo $profile->ar_user_profile_id ?>" <?php if(!empty($item)){if($profile->ar_user_profile_id == $item->profile_id){ ?>selected="selected"<?php }} ?>><?php echo $profile->name ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name="ar_user_id" value="<?php echo empty($item->ar_user_id) ? '' : $item->ar_user_id; ?>" />
                <button class="btn btn-primary" type="submit">Salvar</button>
                <a href="<?php echo site_url('gerenciador/ar_users')?>" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </fieldset>
<?php echo form_close();?>

<?php $this->load->view('gerenciador/_footer')?>