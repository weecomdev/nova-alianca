<?php $this->load->view('_header');?>

<section class="section row" id="area_restrita">
    <div class="container responsive">
        <div class="header">
            <h1>olá, <?php echo $this->session->userdata('ar_user_name'); ?>!</h1>
            <h2>FILTRE OS ARQUIVOS AO LADO</h2>
            <ul>
                <li class="cat active" onclick="get_docs(0);">todos</li>
                <?php foreach ($categories as $key => $value): ?>
                    <li class="cat" onclick="get_docs(<?php echo $value->ar_file_category_id; ?>);"><?php echo $value->title ?></li>
                <?php endforeach ?>
            </ul>
            <a class="logoff" title="sair" href="<?php echo site_url('area_restrita/do_logout'); ?>"><img src="<?php echo site_url(IMG.'logoff_ico.png'); ?>" alt=""></a>
        </div>
        <div class="buscar">
            <form action="#" id="area_docs">
                <label for="buscar">
                <input type="text" id="buscar" placeholder="buscar">
                <input type="image" src="<?php echo site_url(IMG.'zoom.png') ?>">
                </label>
            </form>
        </div>
        <div class="docs">
            
        </div> 
        <div class="row loader"></div>
    </div>
</section>

<?php $this->load->view('_footer');?>
