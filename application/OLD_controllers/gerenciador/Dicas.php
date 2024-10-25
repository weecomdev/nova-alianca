<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dicas extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('MDicas');
		$this->load->model('MDicas_imagem');
		$this->load->library('image_lib');
		$this->load->helper('ckeditor');
        $this->data['ck1'] = array('id' => 'txt', 'path' => '_assets/js/ckeditor');
		$this->data['ck2'] = array('id' => 'txt2', 'path' => '_assets/js/ckeditor');
	}
	
	public function index()
	{
		$this->data['items'] = $this->MDicas->getAll();
		$this->load->view('gerenciador/dicas/index', $this->data);
	}
	
	public function reorder($id=0)
	{
		$items = $this->input->post('data');
		if ($this->MDicas->reorder($items)) $this->output->set_output('1');
		else{ 
			$this->setMessage("Erro ao efetuar ordenação. Por favor, entre em contato com o suporte.", true);
			$this->output->set_output('0');
		}
	}
	
	public function add()
	{
		$this->load->view('gerenciador/dicas/form', $this->data);
	}
	
	public function edit($id=0)
	{
		if(!empty($id))
		{
			$this->data['item'] = $this->MDicas->get($id);
			$this->load->view('gerenciador/dicas/form', $this->data);
		}
		else
		{
			$this->setMessage($this->lang->line('message_invalid_id'), true);
			$this->index();
		}
	}
	
	public function save(){
		$val = $this->validacao();
		$id = $this->input->post('dica_id');
		if ($val !== TRUE)
		{
			$this->setMessage($val, true);
			(!empty($id))?$this->edit($id):$this->add();
		}
		else
		{
			// $upload_data = $this->do_upload();
			// if($upload_data)
			// {
				if($this->MDicas->save())
				{
					$this->setMessage($this->lang->line('message_item_saved'));
					redirect('gerenciador/dicas');
				}
				else
				{
					$this->setMessage($this->lang->line('message_item_saved_error'), true);
					(!empty($id)) ? $this->edit($id) : $this->add();
				}
			// }
			// else
			// 	(!empty($id)) ? $this->edit($id) : $this->add();
		}
	}
	
	public function delete($id=0)
	{
		if(!empty($id))
		{
			if($this->MDicas->delete($id))
			{
				$this->setMessage($this->lang->line('message_item_removed'));
				redirect('gerenciador/dicas');
			}
			else
			{
				$this->setMessage($this->lang->line('message_item_removed_error'), true);
				$this->index();
			}
		}
		else
		{
			$this->setMessage($this->lang->line('message_invalid_id'), true);
			$this->index();
		}
	}
	
	private function validacao()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', ' ');
		$this->form_validation->set_rules('titulo',    'Título',   'required');
		$this->form_validation->set_rules('texto',    'Texto',   'required');

		if ($this->form_validation->run() == FALSE) return validation_errors();
		else return TRUE;
	}

} ?>