<?php $this->load->view('_header');?>

<section class="section row" id="agenda">
    <div class="container responsive">
        <div class="header">
            <h1>olá, <?php echo $this->session->userdata('ar_user_name'); ?>!</h1>
            <h2>CONFIRA ABAIXO OS ÚLTIMOS EVENTOS<br/>DO NOSSO CALENDÁRIO DE ATIVIDADES</h2>
            <a class="logoff" title="sair" href="<?php echo site_url('area_restrita/do_logout'); ?>"><img src="<?php echo site_url(IMG.'logoff_ico.png'); ?>" alt=""></a>
        </div>
        <div class="subheader">
            <a class="seta_left" href="<?php echo site_url('area_restrita/agenda/'.$prev_year.'/'.$prev_month); ?>">
                <div class="line_l"></div>
                <div class="line_r"></div>
            </a>
            <h1><?php echo getMonthBR($month).' / '.$year; ?></h1>
            <a class="seta_right" href="<?php echo site_url('area_restrita/agenda/'.$next_year.'/'.$next_month); ?>">
                <div class="line_l"></div>
                <div class="line_r"></div>
            </a>
        </div>
        <?php echo $this->calendar->generate($year, $month, $data); ?>
        <div class="row eventos" id="eventos">
        
        </div>
        <div class="row loader"></div>
    </div>
</section>

<?php $this->load->view('_footer');?>
