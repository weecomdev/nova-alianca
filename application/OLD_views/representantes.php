<?php $this->load->view('_header');?>
<section class="responsive container roll-inview show" id="representantes" >
	<div class="center">
		<h1>Estado</h1>
		<h2>selecione seu</h2>
		<select onchange="getRepresentantes()" id="sel_representantes">
			<?php foreach ($estados as $key => $value) : ?>      
				<option value="<?php echo $value->symbol; ?>"><?php echo $value->name; ?></option> 
			<?php endforeach; ?>          
		</select>
	</div>
</section>
<section class="responsive container roll-inview show" id="representantes_listagem">
	<div class="loader">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
	<div class="append_representantes">
	
	</div>
</section>

<?php $this->load->view('_footer');?>
