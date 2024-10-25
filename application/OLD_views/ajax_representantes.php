
	
	<?php if(count($representantes) > 0){ ?>
	<div class="result">
	<h1 class="h1_estado">MOSTRANDO REPRESENTANTES NO<br><span><?php echo $estado ?></span></h1>
	<ul class="listagem">
		<?php foreach ($representantes as $key => $value): ?>
			<li>
				<div class="center">
					<h1><?php echo $value->name ?></h1>
					<p><?php echo $value->address ?></p>
					<p><a href="mailto:<?php echo $value->email ?>"><?php echo $value->email ?></a></p>
					<p><?php echo $value->phone ?></p>
				</div>
			</li>			
		<?php endforeach ?>
	</ul>
	</div>
	<?php }else{ ?>
		<h1 class="empty">nenhum representante cadastrado neste estado.</h1>
	<?php } ?>
