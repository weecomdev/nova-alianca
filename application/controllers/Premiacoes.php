<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Premiacoes extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('MPremiacoes');
        $this->load->model('MPremiacoes_imagem');
	}

	public function index()
	{
		$this->load->view('premiacoes', $this->data);
	}

    public function get($page=0)
    {
        $numPerPage = 6;
        $next = $page*$numPerPage;
        $premiacoes = $this->MPremiacoes->getAll($numPerPage,$next);
        if(!empty($premiacoes)){
            $this->data['premiacoes'] = $premiacoes;
        }else{
            $this->data['premiacoes'] = NULL;
        }
        $this->data['page'] = $page;
        $return['premiacoes'] = $this->load->view('_ajax_premiacoes', $this->data, true);
        //$return['premiacoes'] = $this->MPremiacoes->getAll($numPerPage,$next,$query);
        echo json_encode($return);
    }

    public function detalhes($slug)
    {
        $this->load->view('premiacoes', $this->data);
    }

    public function get_detalhes($slug)
    {
        $premiacao = $this->MPremiacoes->getByAlias($slug);
        $this->data['premiacao'] = $premiacao;
        $this->data['imagens'] = $this->MPremiacoes_imagem->getAll($premiacao->premiacao_id);
        $return = $this->load->view('_ajax_premiacoes_detalhes', $this->data, true);
        echo json_encode($return);
    }


} ?>