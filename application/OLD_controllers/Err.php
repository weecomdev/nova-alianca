<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Err extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Erro';
	}

	public function err_404()
	{
		$this->data['page_title'] .= ' 404 - Página não encontrada';
		$this->load->view('_404', $this->data);
	}
}
?>