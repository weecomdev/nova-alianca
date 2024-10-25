<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Noticias extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('MNoticias');
        $this->load->model('MNoticia_imagem');
	}

	public function index()
	{
		$this->load->view('noticias', $this->data);
	}

    public function get($page=0)
    {
        $numPerPage = 6;
        $next = $page*$numPerPage;
        $noticias = $this->MNoticias->getAll($numPerPage,$next);
        if(!empty($noticias)){
            $this->data['noticias'] = $noticias;
        }else{
            $this->data['noticias'] = NULL;
        }
        $this->data['page'] = $page;
        $return['noticias'] = $this->load->view('_ajax_noticias', $this->data, true);
        //$return['noticias'] = $this->MNoticias->getAll($numPerPage,$next,$query);
        echo json_encode($return);
    }

    public function detalhes($slug)
    {
        // die();
        $this->load->view('noticias', $this->data);
    }

    public function get_detalhes($slug)
    {
        $noticia = $this->MNoticias->getByAlias($slug);
        $this->data['noticia'] = $noticia;
        $this->data['imagens'] = $this->MNoticia_imagem->getAll($noticia->noticia_id);
        $return = $this->load->view('_ajax_noticia_detalhes', $this->data, true);
        echo json_encode($return);
    }


} ?>