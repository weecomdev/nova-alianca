<?php $this->load->view('_header');?>

<section class="section row" id="contato">
    <div class="image container responsive" >
        <img class="img" src="<?php echo site_url(IMG.'bg_institucional.jpg'); ?>" alt="">
        <h1><?php echo $contact->phone ?></h1>
        <h2><?php echo $this->lang->line('fale_conosco');?></h2>
        <h3><?php echo $this->lang->line('central_de_atendimento');?></h3>
    </div>
    <div class="text" id="fale_conosco">
        <div class="left">
        <form action="" id="form_contato">
            <h1><?php echo $this->lang->line('deseja_falar_conosco');?></h1>
            <h2><?php echo $this->lang->line('conte_nos_abaixo');?></h2>
            <div class="form">
                <div class="item small">
                    <label for="name">Nome</label>
                    <input id="name" type="text" name="name" required >                    
                </div>
                <div class="item small">
                    <label for="email">E-mail</label>
                    <input id="email" type="text" name="email"  required >                    
                </div>
                <div class="item small">
                    <label for="phone">Telefone</label>
                    <input id="phone" type="text" name="phone"  required >                    
                </div>
                <div class="item small">
                    <label for="name">estado</label>
                    <select class="filter_sel" required name="state">
                            <option value="ac">Acre</option> 
                            <option value="al">Alagoas</option> 
                            <option value="am">Amazonas</option> 
                            <option value="ap">Amapá</option> 
                            <option value="ba">Bahia</option> 
                            <option value="ce">Ceará</option> 
                            <option value="df">Distrito Federal</option> 
                            <option value="es">Espírito Santo</option> 
                            <option value="go">Goiás</option> 
                            <option value="ma">Maranhão</option> 
                            <option value="mt">Mato Grosso</option> 
                            <option value="ms">Mato Grosso do Sul</option> 
                            <option value="mg">Minas Gerais</option> 
                            <option value="pa">Pará</option> 
                            <option value="pb">Paraíba</option> 
                            <option value="pr">Paraná</option> 
                            <option value="pe">Pernambuco</option> 
                            <option value="pi">Piauí</option> 
                            <option value="rj">Rio de Janeiro</option> 
                            <option value="rn">Rio Grande do Norte</option> 
                            <option value="ro">Rondônia</option> 
                            <option value="rs">Rio Grande do Sul</option> 
                            <option value="rr">Roraima</option> 
                            <option value="sc">Santa Catarina</option> 
                            <option value="se">Sergipe</option> 
                            <option value="sp">São Paulo</option> 
                            <option value="to">Tocantins</option> 
                    </select>
                </div>
                <div class="item small">
                    <label for="city">cidade</label>
                    <input id="city" type="text" name="city"  required >                    
                </div>
                <div class="item small">
                    <label for="phone">setor</label>
                    <select class="filter_sel" name="setor">
                        <option value="novaalianca@novaalianca.coop.br">Geral</option>
                        <option value="sac@novaalianca.coop.br">Sac</option>
                    </select>                   
                </div>
                
                <div class="item ">
                    <label for="message">Mensagem</label>
                    <textarea id="message" name="message"></textarea>                  
                </div>
                
            </div>
        </form>
        </div>
        <div class="enviar">
            
            <div class="bg"></div>
            <svg width="38" height="38" viewBox="0 0 38 38" id="load-svg" xmlns="http://www.w3.org/2000/svg" stroke="#b2a66f">
                <g fill="none" fill-rule="evenodd">
                    <g transform="translate(1 1)" stroke-width="2">
                        <circle stroke-opacity=".5" cx="18" cy="18" r="18"/>
                        <path d="M36 18c0-9.94-8.06-18-18-18">
                            <animateTransform
                                attributeName="transform"
                                type="rotate"
                                from="0 18 18"
                                to="360 18 18"
                                dur="1s"
                                repeatCount="indefinite"/>
                        </path>
                    </g>
                </g>
            </svg>
            <div class="name"><?php echo $this->lang->line('enviar');?></div>
            <div class="seta">
                <div class="line_l"></div>
                <div class="line_r"></div>
            </div>
        </div>
    </div>
    <div class="map container responsive" id="map"></div>
</section>
<script>
    var lat = '<?php echo $contact->latitude; ?>';
    var lng = '<?php echo $contact->longitude; ?>';
    var local = '<?php echo $contact->address.', '.$contact->district.', '.$contact->city.' - '.$contact->state; ?>';
</script>
<?php $this->load->view('_footer');?>
