<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ar_Agenda extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Ar_MAgenda');
		$this->load->helper('ckeditor');
		$this->data['ck1'] = array('id' => 'txt', 'path' => '_assets/js/ckeditor');
	}
	
	public function index()
	{
		$this->data['items'] = $this->Ar_MAgenda->getAll();
		$this->load->view('gerenciador/ar_agenda/index', $this->data);
	}
	
	public function reorder($id=0)
	{
		$items = $this->input->post('data');
		if ($this->Ar_MAgenda->reorder($items)) $this->output->set_output('1');
		else{ 
			$this->setMessage("Erro ao efetuar ordenação. Por favor, entre em contato com o suporte.", true);
			$this->output->set_output('0');
		}
	}
	
	public function add()
	{
		$this->load->view('gerenciador/ar_agenda/form', $this->data);
	}
	
	public function edit($id=0)
	{
		if(!empty($id))
		{
			$this->data['item'] = $this->Ar_MAgenda->get($id);
			$this->load->view('gerenciador/ar_agenda/form', $this->data);
		}
		else
		{
			$this->setMessage($this->lang->line('message_invalid_id'), true);
			$this->index();
		}
	}
	
	public function save(){
		$val = $this->validacao();
		$id = $this->input->post('ar_agenda_id');
		if ($val !== TRUE)
		{
			$this->setMessage($val, true);
			(!empty($id))?$this->edit($id):$this->add();
		}
		else
		{
				if($this->Ar_MAgenda->save())
				{
					$this->setMessage($this->lang->line('message_item_saved'));
					redirect('gerenciador/ar_agenda');
				}
				else
				{
					$this->setMessage($this->lang->line('message_item_saved_error'), true);
					(!empty($id)) ? $this->edit($id) : $this->add();
				}
		}
	}

	
	public function delete($id=0)
	{
		if(!empty($id))
		{
			if($this->Ar_MAgenda->delete($id))
			{
				$this->setMessage($this->lang->line('message_item_removed'));
				redirect('gerenciador/ar_agenda');
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
        $this->form_validation->set_rules('dia',    'dia',   'required');
		$this->form_validation->set_rules('hora',    'hora',   'required');
		$this->form_validation->set_rules('texto',    'Texto',   'required');

		if ($this->form_validation->run() == FALSE) return validation_errors();
		else return TRUE;
	}

} ?>