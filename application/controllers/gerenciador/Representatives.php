<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Representatives extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('MRepresentatives');
		$this->load->library('image_lib');
	}
	
	public function index()
	{
		$this->data['items'] = $this->MRepresentatives->getAll('tbl_representatives');
		$this->load->view('gerenciador/representatives/index', $this->data);
	}
	
	public function reorder($id=0)
	{
		$items = $this->input->post('data');
		if ($this->MRepresentatives->reorderRepresentative($items)) $this->output->set_output('1');
		else{ 
			$this->setMessage("Erro ao efetuar ordenação. Por favor, entre em contato com o suporte.", true);
			$this->output->set_output('0');
		}
	}
	
	public function add()
	{		
		$this->data['estados'] = $this->MRepresentatives->getAllestados('regional_states');

		$this->load->view('gerenciador/representatives/form', $this->data);
	}
	
	public function edit($id=0)
	{
		if(!empty($id))
		{	

			
            $this->data['estados'] = $this->MRepresentatives->getAllestados('regional_states');


			$this->data['item'] = $this->MRepresentatives->get_representative($id);
			
			
			
			$this->load->view('gerenciador/representatives/form', $this->data);
		}
		else
		{
			$this->setMessage($this->lang->line('message_invalid_id'), true);
			$this->index();
		}
	}
	
	
	public function save(){
		$val = $this->validacao();
		$id = $this->input->post('representative_id');
		if ($val !== TRUE)
		{

			$this->setMessage($val, true);
			(!empty($id))?$this->edit($id):$this->add();
		}
		else
		{

			
				if($this->MRepresentatives->saveRepresentative())
				{
					$this->setMessage($this->lang->line('message_item_saved'));
					redirect('gerenciador/representatives');
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
			if($this->MRepresentatives->deleteRepresentative($id))
			{
				$this->setMessage($this->lang->line('message_item_removed'));
				redirect('gerenciador/representatives');
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
		$this->form_validation->set_rules('name',    'Nome',   'required');
		$this->form_validation->set_rules('state',    'Estado',   'required');		
		$this->form_validation->set_rules('address',    'Endereço',   'required');
		$this->form_validation->set_rules('phone',    'Telefone',   'required');
		$this->form_validation->set_rules('email',    'E-mail',   'required');

		if ($this->form_validation->run() == FALSE) return validation_errors();
		else return TRUE;
	}

} ?>