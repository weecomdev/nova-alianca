<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Representantes extends MY_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('Banner');
		$this->load->model('MRepresentatives');
		$this->data['is_representante'] = true;
	}

	public function index()
	{
		$this->data['banners'] = $this->Banner->getAll();
		$this->data['estados'] = $this->MRepresentatives->getAllestados('regional_states');
		$this->load->view('representantes', $this->data);
	}
	public function getRepresentantes()
	{
		$this->data['estado'] = $this->MRepresentatives->get_state($this->input->post('estado'))->name; ;
		$this->data['representantes'] = $this->MRepresentatives->get_representativeState($this->input->post('estado'));
		echo $this->load->view('ajax_representantes', $this->data,  true);
	}
}
?>