	<footer id="footer" class="responsive container roll-inview">
		<div class="footer1">
			<div class="left">
				<a href="<?php echo site_url(); ?>" class="logo">
					<img src="<?php echo site_url(IMG . 'logo_footer.png'); ?>" alt="" />
				</a>
				<div class="address">
					<?php echo $this->lang->line('coop_nova_alianca'); ?><br />
					<?php echo $contact->address ?><br />
					<?php echo (empty($contact->address_number)) ? 'S/N °' : $contact->address_number;
					echo (empty($contact->address_complement)) ? '' : ' - ' . $contact->address_complement; ?><br />
					<?php echo $contact->district . ' - ' . $contact->city . ' - ' . $contact->state ?><br />
					<?php echo $this->lang->line('tel'); ?> <?php echo $contact->phone ?>
				</div>
				<a href="http://www.facebook.com/cooperativanovaalianca" target="_blank" class="social"><img src="<?php echo site_url(IMG . 'fb_ico_.png') ?>" alt=""></a>
				<a href="#!/area_restrita/login" class="social"><img src="<?php echo site_url(IMG . 'res_ico_.png') ?>" alt=""></a><br>
				<a href="http://www.deen.com.br" title="Deen" target="_blank" class="social">
					<svg version="1.1" id="deen" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="57px" height="20.011px" viewBox="0 0 57 20.011" enable-background="new 0 0 57 20.011" xml:space="preserve">
						<g>
							<path fill="none" stroke="#fff" stroke-width="3" class="path" stroke-miterlimit="10" d="M11.995,0v11.016
                                C9.946,8.75,7.971,7.813,5.959,8.165C3.619,8.594,1.241,10,1.021,12.852c-0.22,2.5,1.28,5.039,3.84,5.742
                                c2.451,0.625,5.084-0.078,7.572-1.133l13.754-6.015c-1.39-2.188-3.146-3.281-5.158-3.32c-2.268,0-4.316,1.563-4.938,3.008
                                c-0.731,1.875-0.695,3.71,0.512,5.312c1.133,1.484,2.45,2.305,4.06,2.344c2.926,0.156,5.597-0.977,8.413-2.187l11.705-4.961
                                c-1.682-2.5-3.584-3.789-5.779-3.437c-2.378,0.351-4.792,1.875-4.829,4.765c-0.073,3.085,1.61,5.079,4.719,5.703
                                c2.451,0.507,5.121-0.195,7.133-1.992c1.353-1.172,2.194-2.618,2.779-4.258c1.061-3.125,2.891-4.102,5.67-4.219
                                c2.596-0.117,5.56,2.304,5.523,5.077L55.926,20" />
						</g>
					</svg>
				</a>
			</div>
			<div class="center">


				<ul>
					<li><a href="javascript:void(0)">PRODUTOS</a></li>
					<li><a href="#!/produtos/sucos">Sucos</a></li>
					<li><a href="#!/produtos/vinhos-finos">Vinhos Finos</a></li>
					<li><a href="#!/produtos/vinhos-de-mesa">Vinhos de Mesa</a></li>
					<li><a href="#!/produtos/espumantes">Espumantes</a></li>
					<li><a href="#!/produtos/kits-promocionais">Kits Promocionais</a></li>
					<li><a href="#!/produtos/coolers-e-filtrados">Coolers e Filtrados</a></li>
				</ul>
				<ul>
					<li><a href="javascript:void(0)">Nossas marcas</a></li>
					<li><a href="#!/marcas/cerro-da-cruz">Cerro da Cruz</a></li>
					<li><a href="#!/marcas/nc-aliana">Néc Aliança</a></li>
					<li><a href="#!/marcas/santa-colina">Santa Colina</a></li>
					<li><a href="#!/marcas/aliana">Aliança</a></li>
					<li><a href="#!/marcas/collina-del-sole">Collina Del Sole</a></li>
				</ul>
			</div>
			<div class="right">

				<img src="<?php echo site_url(IMG . 'bnds.gif') ?>" alt="Nova Aliança" class="bnds">

				<ul>
					<li><a href="<?php echo site_url('institucional'); ?>/"><?php echo $this->lang->line('institucional'); ?></a></li>
					<li><a href="<?php echo site_url('institucional'); ?>/"><?php echo $this->lang->line('sobre_nos'); ?></a></li>
					<li><a href="<?php echo site_url('dicas') ?>/"><?php echo $this->lang->line('dicas'); ?></a></li>
					<li><a href="<?php echo site_url('noticias'); ?>/"><?php echo $this->lang->line('noticias'); ?></a></li>
					<li><a href="<?php echo site_url('premiacoes'); ?>/"><?php echo $this->lang->line('premiacoes'); ?></a></li>
					<li><a href="<?php echo site_url('onde_comprar') ?>/"><?php echo $this->lang->line('onde_comprar'); ?></a></li>
					<li><a href="https://webmail.novaalianca.coop.br/" target="_blank">Webmail</a></li>
				</ul>
				<ul>
					<li><a href="<?php echo site_url('contato') ?>"><?php echo $this->lang->line('contato'); ?></a></li>
					<li><a href="<?php echo site_url('contato/#fale_conosco') ?>"><?php echo $this->lang->line('fale_conosco'); ?></a></li>
					<li><a href="<?php echo site_url('contato/#map') ?>"><?php echo $this->lang->line('localizacao'); ?></a></li>
				</ul>
			</div>
		</div>
		<div class="footer2">
			<div class="left">
				<a href="<?php echo site_url(); ?>" class="logo">
					<img src="<?php echo site_url(IMG . 'logo_footer.png'); ?>" alt="" />
				</a>
			</div>
			<div class="right">
				<div class="address">
					<?php echo $this->lang->line('coop_nova_alianca'); ?><br />
					<?php echo $contact->address ?><br />
					<?php echo (empty($contact->address_number)) ? 'S/N °' : $contact->address_number;
					echo (empty($contact->address_complement)) ? '' : ' - ' . $contact->address_complement; ?><br />
					<?php echo $contact->district . ' - ' . $contact->city . ' - ' . $contact->state ?><br />
					<?php echo $this->lang->line('tel'); ?> <?php echo $contact->phone ?><br>
					<a href="https://webmail.novaalianca.coop.br/" target="_blank">Webmail</a>
				</div>
				<a href="http://pt-br.facebook.com/pages/Eco-Uva/139946486104950" target="_blank" class="social"><img src="<?php echo site_url(IMG . 'fb_ico_.png') ?>" alt=""></a>
				<a href="#!/area_restrita/login" class="social"><img src="<?php echo site_url(IMG . 'res_ico_.png') ?>" alt=""></a><br>
				<a href="http://www.deen.com.br" title="Deen" target="_blank">
					<svg version="1.1" id="deen" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="57px" height="20.011px" viewBox="0 0 57 20.011" enable-background="new 0 0 57 20.011" xml:space="preserve">
						<g>
							<path fill="none" stroke="#fff" stroke-width="3" class="path" stroke-miterlimit="10" d="M11.995,0v11.016
                                C9.946,8.75,7.971,7.813,5.959,8.165C3.619,8.594,1.241,10,1.021,12.852c-0.22,2.5,1.28,5.039,3.84,5.742
                                c2.451,0.625,5.084-0.078,7.572-1.133l13.754-6.015c-1.39-2.188-3.146-3.281-5.158-3.32c-2.268,0-4.316,1.563-4.938,3.008
                                c-0.731,1.875-0.695,3.71,0.512,5.312c1.133,1.484,2.45,2.305,4.06,2.344c2.926,0.156,5.597-0.977,8.413-2.187l11.705-4.961
                                c-1.682-2.5-3.584-3.789-5.779-3.437c-2.378,0.351-4.792,1.875-4.829,4.765c-0.073,3.085,1.61,5.079,4.719,5.703
                                c2.451,0.507,5.121-0.195,7.133-1.992c1.353-1.172,2.194-2.618,2.779-4.258c1.061-3.125,2.891-4.102,5.67-4.219
                                c2.596-0.117,5.56,2.304,5.523,5.077L55.926,20" />
						</g>
					</svg>
				</a>
			</div>
		</div>
	</footer>
	<script type="text/javascript" async src="https://d335luupugsy2.cloudfront.net/js/loader-scripts/1620a2f8-3cc7-469a-aa89-4ce7baa13866-loader.js"></script>
	<script src="<?php echo site_url('_assets/js/all.js') ?>?v=1" type="text/javascript"></script>
	<script>
		(function(i, s, o, g, r, a, m) {
			i['GoogleAnalyticsObject'] = r;
			i[r] = i[r] || function() {
				(i[r].q = i[r].q || []).push(arguments)
			}, i[r].l = 1 * new Date();
			a = s.createElement(o),
				m = s.getElementsByTagName(o)[0];
			a.async = 1;
			a.src = g;
			m.parentNode.insertBefore(a, m)
		})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

		ga('create', 'UA-67690466-1', 'auto');
		ga('send', 'pageview');
	</script>

	<!-- Cookie Consent by TermsFeed https://www.TermsFeed.com -->
	<script type="text/javascript" src="https://www.termsfeed.com/public/cookie-consent/4.1.0/cookie-consent.js" charset="UTF-8"></script>
	<script type="text/javascript" charset="UTF-8">
		document.addEventListener('DOMContentLoaded', function() {
			cookieconsent.run({
				"notice_banner_type": "simple",
				"consent_type": "express",
				"palette": "light",
				"language": "pt",
				"page_load_consent_levels": ["strictly-necessary", "performance", "marketing"],
				"notice_banner_reject_button_hide": false,
				"preferences_center_close_button_hide": false,
				"page_refresh_confirmation_buttons": false,
				"website_name": "Nova Aliança",
				"website_privacy_policy_url": "https://loja.novaalianca.coop.br/politica-de-privacidade",
				"cookie_categories": {
					"strictly-necessary": {
						"cookies": ["ci_session"],
						"description": "Esses cookies são necessários para o funcionamento do site."
					},
					"performance": {
						"cookies": ["_ga", "_gid", "_gat"],
						"description": "Esses cookies coletam informações sobre como os visitantes usam o site para melhorar seu desempenho."
					},
					"marketing": {
						"cookies": ["_fbp", "lastExternalReferrerTime", "lastExternalReferrer"],
						"description": "Esses cookies são usados para rastrear visitantes em sites com o objetivo de apresentar anúncios relevantes."
					}
				}
			});
		});
	</script>
	<!-- End Cookie Consent by TermsFeed https://www.TermsFeed.com -->

	</body>

	</html>