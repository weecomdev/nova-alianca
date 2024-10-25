<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Texts extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Text');
		$this->load->helper('ckeditor');
	}
	
	public function index()
	{
		$tid = $this->input->get('t');
		$this->data['txt'] = $this->Text->getByAlias($tid);
		$this->data['ck1'] = array('id' => 'txt', 'path' => '_assets/js/ckeditor');
		
		$this->load->view('gerenciador/texts/form', $this->data);
	}

	public function ajuda_editor() 
	{
		$this->load->view('gerenciador/ajuda_editor', $this->data);
	}
	
	public function save()
	{
		$val = $this->validacao();
		
		if ($val !== TRUE) $this->setMessage($val, true);
		else 
		{
			$alias = $this->input->post('alias');
			$id = $this->input->post('id');

			$data[$alias] = $this->input->post('txt');
			
			if($this->Text->save($data)) $this->setMessage($this->lang->line('message_item_updated'));
			else $this->setMessage($this->lang->line('message_item_updated_error'), true);
			redirect('gerenciador/texts?t='.$alias);
		}
		
	}
	
	private function validacao()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', ' ');
		$this->form_validation->set_rules('txt',    'Texto',   'required');

		if ($this->form_validation->run() == FALSE) return validation_errors();
		else return TRUE;
	}

} ?>