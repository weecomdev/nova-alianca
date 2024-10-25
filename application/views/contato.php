<?php $this->load->view('_header'); ?>

<section class="section row" id="contato">
    <div class="image container responsive">
        <img class="img" src="<?php echo site_url(IMG . 'bg_institucional.jpg'); ?>" alt="">
        <h1><?php echo $contact->phone ?></h1>
        <h2><?php echo $this->lang->line('fale_conosco'); ?></h2>
        <h3><?php echo $this->lang->line('central_de_atendimento'); ?></h3>
    </div>

    <div class="container">
        <div class="contact-info" style="display: none;">
            <h2>Canais de Atendimento</h2>

            <div class="canais">
                <div class="contato-canal">
                    <h3>SAC</h3>
                    <p>
                        Segunda a Sexta 08:00/12:00 e 13:30/17:30<br>
                        Email: sac@novaalianca.coop.br<br>
                        Telefone: 08009701931
                    </p>
                </div>
                <div class="contato-canal">
                    <h3>Matriz</h3>
                    <p>
                        Segunda a Sexta 07:30/12:30 e 13:30/17:18<br>
                        Email: comercial@novaalianca.coop.br<br>
                        Telefone: 054 3279-3400
                    </p>
                </div>
                <div class="contato-canal">
                    <h3> E-commerce </h3>
                    <a href="https://loja.novaalianca.coop.br/atendimento" target="_blank">Ir para o site</a>
                </div>
                <div class="contato-canal">
                    <h3> D.P.O.</h3>
                    <p>
                        Segunda a Sexta 08:00/12:00 e 13:30/17:30<br>
                        Email: sac@novaalianca.coop.br<br>
                        Telefone: 08009701931
                    </p>
                </div>
            </div>
        </div>


        <div class="new-form" style="display: none;">
            <form action="" method="post" name="form-contato">
                <div class="column">
                    <div class="input-row">
                        <span class="title-fields required">
                            <span class="obg">*</span> Departamento
                        </span>
                            <select name="atendimento_departamento" class="deptos" required>
                                <option value="">Selecione</option>
                                <option value="1">Vendas </option>
                                <option value="2">Reclamações</option>
                                <option value="3">SAC</option>
                                <option value="4">Trocas</option>
                            </select>
                    </div>
                    <div class="input-row">
                        <span class="title-fields required">
                            <span class="obg">*</span> Nome
                        </span>
                        <input type="text" name="atendimento_nome" class="field" required>
                    </div>
                    <div class="input-row">
                        <span class="title-fields required">
                            <span class="obg">*</span> E-mail
                        </span>
                        <input type="text" name="atendimento_email" class="field" required>
                    </div>
                    <div class="input-row">
                        <span class="title-fields no-bold"> Pedido</span>
                        <input type="text" name="atendimento_pedido" class="field">
                    </div>
                </div>

                <div class="column">
                    <div class="input-row">
                        <span class="title-fields required">
                            <span class="obg">*</span> Telefone
                        </span>
                        <input type="text" name="atendimento_telefone" class="field" required>
                    </div>
                    <div class="input-row">
                        <span class="title-fields required">
                            <span class="obg">*</span> Assunto
                        </span>
                        <input type="text" name="atendimento_assunto" class="field" required>
                    </div>
                    <div class="input-row">
                        <span class="title-fields required">
                            <span class="obg">*</span> Mensagem
                        </span>
                        <textarea name="atendimento_mensagem" class="message field" required></textarea>
                    </div>
<div class="input-row">
                    <input type="submit" class="button-submit" value="Enviar" title="Enviar Formulário">
                    </div>
                </div>

            </form>
        </div>

    </div>

    <!---------------Vou ADD Texto como plano B com as opções de contato---------------------------->

    <div class="text" id="fale_conosco">
        <div class="left">
            <h2>Opções de Contato:</h2>

            <h1>

                SAC <BR>
                Segunda a Sexta 08:00/12:00 e 13:30/17:30 <BR>
                Email: sac@novaalianca.coop.br <BR>
                Telefone: 08009701931<BR>
                <br><br><br>

                Comercial Matriz <BR>
                Segunda a Sexta 07:30/12:30 e 13:30/17:18 <BR>
                Email: comercial@novaalianca.coop.br <BR>
                Telefone: 054 3279-3400<BR>
            </h1>


            <!----------------------------------------- Vou remover o form de contato @fabiano.fernandes-06-03-2024             
        <form action="" id="form_contato">
            
            
            <h1><?php echo $this->lang->line('deseja_falar_conosco'); ?></h1>
            <h2><?php echo $this->lang->line('conte_nos_abaixo'); ?></h2>
            


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

------------------------------------------------- Até aqui-->

        </div>

        <!----------------------------------------- Vou remover o botão enviar @fabiano.fernandes-06-03-2024 
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
            <div class="name"><?php echo $this->lang->line('enviar'); ?></div>
            <div class="seta">
                <div class="line_l"></div>
                <div class="line_r"></div>
            </div>
        </div>
        
 ------------------------------------------------- Até aqui-->

    </div>




    <div class="map container responsive" id="map"></div>
</section>
<script>
    var lat = '<?php echo $contact->latitude; ?>';
    var lng = '<?php echo $contact->longitude; ?>';
    var local = '<?php echo $contact->address . ', ' . $contact->district . ', ' . $contact->city . ' - ' . $contact->state; ?>';
</script>
<?php $this->load->view('_footer'); ?>