<?php
class Login extends MY_Controller 
{
	var $check_session = false;

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (strpos("http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], site_url()) === false)
			redirect('gerenciador', 'refresh');
		
		if ($this->session->userdata('logado'))
			redirect('gerenciador/start', 'refresh');
		else
			$this->load->view('gerenciador/login', $this->data);
	}

	public function doLogin()
	{
		$this->load->model('User');
		$login = $this->input->post('login');
		$senha = $this->input->post('password');
        
		if ($usuario = $this->User->doLogin($login, $senha)) {
			// create session
			$this->session->set_userdata('logado', TRUE);
			$this->session->set_userdata('user_id', $usuario->user_id);
			$this->session->set_userdata('user_level', $usuario->level);
			$this->session->set_userdata('user_email', $usuario->email);
			$this->session->set_userdata('user_name', $usuario->name);
			$this->User->setLastLogin($usuario->user_id);
			
			if ($senha == '12345') {
				$this->setMessage('Para garantirmos a segurança do seu gerenciador, sugerimos que altere sua senha.', false, true);
				redirect('gerenciador/users/edit/'.$usuario->user_id);
			}
			elseif ($this->session->userdata('url') != '')
				redirect($this->session->userdata('url'), 'refresh');
			else
				redirect('gerenciador/', 'refresh');
		} else {
			$this->setMessage($this->lang->line('message_invalid_login'), true);
			redirect('gerenciador/login');
		}
	}

	public function doLogout()
	{
		$this->session->sess_destroy();
		redirect('gerenciador/', 'refresh');
	}
}