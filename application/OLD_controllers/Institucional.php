<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Institucional extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('AboutUsImage');
    }

	public function index()
	{
		$this->data['imgs'] = $this->AboutUsImage->getAll();
		$this->load->view('institucional', $this->data);
	}
}
?>