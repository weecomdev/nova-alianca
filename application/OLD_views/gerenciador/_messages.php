<div class="notifications"> </div>

<?php if (!empty($this->session->userdata['msgSuccess'])){ ?>
	<script> $('.notifications').notify({ message: { text: '<?php echo str_replace("\n", "",  $this->session->userdata("msgSuccess")) ?>' }, type: 'success', fadeOut: { delay: 5000 } }).show(); </script>
	<?php $this->session->set_userdata('msgSuccess', "");
} ?>

<?php if (!empty($this->session->userdata['msgErrors'])){  ?>
	<script> $('.notifications').notify({ message: { text: '<?php echo str_replace("\n", "",  $this->session->userdata("msgErrors")) ?>' }, type: 'danger', fadeOut: { delay: 5000 } }).show(); </script>
	<?php $this->session->set_userdata('msgErrors', "");
} ?>

<?php if (!empty($this->session->userdata['msgInfos'])){ ?>
	<script> $('.notifications').notify({ message: { text: '<?php echo str_replace("\n", "",  $this->session->userdata("msgInfos")) ?>' }, type: 'info', fadeOut: { delay: 10000 } }).show(); </script>
	<?php $this->session->set_userdata('msgInfos', "");
} ?>

