<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dicas extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('MDicas');
        $this->load->model('MDicas_imagem');
	}

	public function index()
	{
		$this->load->view('dicas', $this->data);
	}

    public function get($page=0)
    {
        $numPerPage = 6;
        $next = $page*$numPerPage;
        $dicas = $this->MDicas->getAll($numPerPage,$next);
        if(!empty($dicas)){
            $this->data['dicas'] = $dicas;
        }else{
            $this->data['dicas'] = NULL;
        }
        $this->data['page'] = $page;
        $return['dicas'] = $this->load->view('_ajax_dicas', $this->data, true);
        //$return['dicas'] = $this->MDicas->getAll($numPerPage,$next,$query);
        echo json_encode($return);
    }

    public function detalhes($slug)
    {
        $this->load->view('dicas', $this->data);
    }

    public function get_detalhes($slug)
    {
        $dica = $this->MDicas->getByAlias($slug);
        $this->data['dica'] = $dica;
        $this->data['imagens'] = $this->MDicas_imagem->getAll($dica->dica_id);
        $return = $this->load->view('_ajax_dicas_detalhes', $this->data, true);
        echo json_encode($return);
    }


} ?>