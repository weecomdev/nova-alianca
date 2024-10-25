<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Onde_Comprar extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('MCompras');
        $this->load->model('MCompras_imagem');
	}

	public function index()
	{
		$this->load->view('onde_comprar', $this->data);
	}

    public function get($page=0)
    {
        $numPerPage = 6;
        $next = $page*$numPerPage;
        $comprar = $this->MCompras->getAll($numPerPage,$next);
        if(!empty($comprar)){
            $this->data['comprar'] = $comprar;
        }else{
            $this->data['comprar'] = NULL;
        }
        $this->data['page'] = $page;
        $return['comprar'] = $this->load->view('_ajax_comprar', $this->data, true);
        //$return['comprar'] = $this->MCompras->getAll($numPerPage,$next,$query);
        echo json_encode($return);
    }

    public function detalhes($slug)
    {
        $this->load->view('onde_comprar', $this->data);
    }

    public function get_detalhes($slug)
    {
        $compra = $this->MCompras->getByAlias($slug);
        $this->data['compra'] = $compra;
        $this->data['imagens'] = $this->MCompras_imagem->getAll($compra->compra_id);
        $return = $this->load->view('_ajax_comprar_detalhes', $this->data, true);
        echo json_encode($return);
    }


} ?>