<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products_Brands extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('ProductBrand');
	}
	
	public function index()
	{
		$this->data['items'] = $this->ProductBrand->getAll(false);
		$this->load->view('gerenciador/products/brands/index', $this->data);
	}

	public function reorder($id=0)
	{
		$items = $this->input->post('data');
		if ($this->ProductBrand->reorder($items)) $this->output->set_output('1');
		else{ 
			$this->setMessage("Erro ao efetuar ordenação. Por favor, entre em contato com o suporte.", true);
			$this->output->set_output('0');
		}
	}
	
	public function add()
	{
		$this->load->view('gerenciador/products/brands/form', $this->data);
	}
	
	public function edit($id=0)
	{
		if(!empty($id))
		{
			$this->data['item'] = $this->ProductBrand->get($id);
			$this->load->view('gerenciador/products/brands/form', $this->data);
		}
		else
		{
			$this->setMessage($this->lang->line('message_invalid_id'), true);
			$this->index();
		}
	}
	
	public function save(){
		$val = $this->validacao();
		$id = $this->input->post('product_category_id');
		
		if ($val !== TRUE)
		{
			$this->setMessage($val, true);
			(!empty($id))?$this->edit($id):$this->add();
		}
		else
		{
			if($this->ProductBrand->save())
			{
				$this->setMessage($this->lang->line('message_item_included'));
				redirect('gerenciador/products_brands');
			}
			else
			{
				$this->setMessage($this->lang->line('message_item_included_error'), true);
				(!empty($id)) ? $this->edit($id) : $this->add();
			}
		}
	}
	
	public function delete($id=0)
	{
		if(!empty($id))
		{
			if($this->ProductBrand->delete($id))
			{
				$this->setMessage($this->lang->line('message_item_removed'));
				redirect('gerenciador/products_brands');
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
		$this->form_validation->set_rules('description',    'Descrição',   'required');

		if ($this->form_validation->run() == FALSE)
			return validation_errors();
		else
			return TRUE;
	}
}

?>