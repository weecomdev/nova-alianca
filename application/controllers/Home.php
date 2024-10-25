<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

	function __construct()
	{
		parent::__construct();

        $this->load->model('Banner');
        $this->load->model('ProductBrand');
		$this->load->model('MNoticias');
        $this->load->model('InstagramImage');

	}

    public function language($lang='pt'){
        if($lang == 'pt'){
            $this->session->set_userdata('lang', 'pt');
        }
        else if($lang == 'en'){
            $this->session->set_userdata('lang', 'en');
        }
        else{
            $this->session->set_userdata('lang', 'es');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

	public function index()
	{
        $this->data['banners'] = $this->Banner->getAll();
        $this->data['brands'] = $this->ProductBrand->getAll();
		$this->data['news'] = $this->MNoticias->getAll(3,0);
        $this->data['instagram'] = $this->InstagramImage->getMedia(10);
		$this->load->view('home', $this->data);
	}
}
?>