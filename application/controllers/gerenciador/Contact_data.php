<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_Data extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('ContactData');
	}
	
	public function index()
	{
		$this->data['item'] = $this->ContactData->get();
		$this->load->view('gerenciador/contact/data', $this->data);
	}
	
	function save(){
		$val = $this->validacao();
		$id = $this->input->post('contact_data_id');
		
		if ($val !== TRUE)
		{
			$this->setMessage($val, true);
			$this->index($id);
		}
		else
		{
			if($this->ContactData->save())
			{
				$this->setMessage($this->lang->line('message_item_updated'));
				redirect('gerenciador/contact_data');
			}
			else
			{
				$this->setMessage($this->lang->line('message_item_updated_error'), true);
				$this->index($id);
			}
		}
	}
	
	private function validacao()
   	{
   		$this->load->library('form_validation');
   		$this->form_validation->set_error_delimiters('', ' ');
   		$this->form_validation->set_rules('address', 'Endereço', 'required');
   		$this->form_validation->set_rules('phone', 'Telefone', 'required');
   		$this->form_validation->set_rules('email', 'Email', 'required');
   		$this->form_validation->set_rules('state', 'Estado', 'required');
        $this->form_validation->set_rules('city', 'Cidade', 'required');
   		$this->form_validation->set_rules('district', 'Bairro', 'required');
   		$this->form_validation->set_rules('latitude',    'Ponto no Mapa',   'required');

   		if ($this->form_validation->run() == FALSE) return validation_errors();
   		else return TRUE;
   	}
}

?>