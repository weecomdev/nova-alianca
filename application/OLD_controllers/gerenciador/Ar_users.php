<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ar_Users extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('User');
		$this->load->model('Ar_User');
		if (!$this->session->userdata('logado')){
			redirect('gerenciador/login');
			die;
		}

		//Testa se o usuário pode acessar essa área
		if($this->session->userdata('user_level') != 1){
			if($this->uri->segment('3') != 'edit' || ($this->uri->segment('3') == 'edit' && $this->session->userdata('user_id') != $this->uri->segment('4'))){
				if ($this->uri->segment('3') != 'save' || ($this->uri->segment('3') == 'save' && $this->session->userdata('user_id') != $this->input->post('user_id'))) {
					$this->setMessage('Você não tem permissão de acesso a esta sessão.', true);
					redirect('gerenciador');
				}
			}
		}
	}
	
	public function index()
	{
        $this->data['items'] = $this->Ar_User->getAll();
		$this->load->view('gerenciador/ar_users/index', $this->data);
	}
	
	public function add()
	{
        $this->data['profiles'] = $this->Ar_User->getProfiles();
		$this->load->view('gerenciador/ar_users/form', $this->data);
	}
	
	public function edit($id=0)
	{
		if(!empty($id))
		{
			$this->data['item'] = $this->Ar_User->get($id);
            $this->data['profiles'] = $this->Ar_User->getProfiles();
			$this->load->view('gerenciador/ar_users/form', $this->data);
		}
		else
		{
			$this->setMessage($this->lang->line('message_invalid_id'), true);
			redirect('gerenciador/ar_users');
		}
	}
	
	public function save()
	{
		$val = $this->validacao();
		$id = $this->input->post('ar_user_id');
		
		if ($val !== TRUE)
		{
			$this->setMessage($val, true);
			(!empty($id))?$this->edit($id):$this->add();
		}
		else
		{
			$user = $this->User->getByUserName($this->input->post('email'), $id);
			if (!empty($user)) //testa username existente
			{
				$this->setMessage('O Usuário "'.$this->input->post('email').'" já existe.', true);
				(!empty($id)) ? $this->edit($id) : $this->add();
			}
			else
			{
				if ($this->input->post('password') != $this->input->post('confirm_password')){
					$this->setMessage('As senhas não correspondem.', true);
					(!empty($id)) ? $this->edit($id) : $this->add();
				} else {
					if($this->Ar_User->save())
					{
						$this->setMessage($this->lang->line('message_item_saved'));
						if($this->session->userdata('user_level') == 1) redirect('gerenciador/ar_users');
						else redirect('gerenciador');
					}
					else
					{
						$this->setMessage($this->lang->line('message_item_saved_error'), true);
						(!empty($id)) ? $this->edit($id) : $this->add();
					}
				}
			}
		}
	}
	
	public function delete($id=0)
	{
		if(!empty($id))
		{
			if($this->Ar_User->delete($id))
			{
				$this->setMessage($this->lang->line('message_item_removed'));
				redirect('gerenciador/ar_users');
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
		$this->form_validation->set_rules('name', 'Nome', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');

		$password = $this->input->post('password');
		$id = $this->input->post('ar_user_id');
		if (!empty($password) || empty($id)) {
			$this->form_validation->set_rules('password', 'Senha', 'required');
			$this->form_validation->set_rules('confirm_password', 'Confirmação de Senha', 'required');
		}

		if ($this->form_validation->run() == FALSE) return validation_errors();
		else return TRUE;
   	}
}

?>