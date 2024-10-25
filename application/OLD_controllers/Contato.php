<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contato extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('contato', $this->data);
	}

	public function send()
	{
		$val = $this->validate_form();
		if ($val !== TRUE) {
			$this->setMessage($val, true);
			$this->index();

			echo($val);
		}else {
			$this->load->library('email');

			$this->email->from('disparo@deen.com.br', $this->input->post('name'));
			$this->email->reply_to($this->input->post('email'), $this->input->post('name'));
            //$this->email->to('cleber.andreazza@deen.com.br');
			$this->email->to($this->input->post('setor'));
			$this->email->bcc('disparo@deen.com.br');
			$this->email->subject('Nova Aliança | Contato');
			
			// email body
			$dados = array();
			$dados['name'] = $this->input->post('name');
			$dados['email'] = $this->input->post('email');
            $dados['phone'] = $this->input->post('phone');
            $dados['setor'] = $this->input->post('setor');
			$dados['city'] = $this->input->post('city');
			$dados['state'] = $this->input->post('state');
			$dados['message'] = $this->input->post('message');
			
			$email_content = $this->load->view('emails/contact', $dados, true);

			$this->email->message($email_content);
			
			if ($this->email->send()) {
				$this->setMessage("Mensagem enviada com sucesso!");
				$data = 1;
				echo $data;
			} else {
				$this->setMessage("Erro ao enviar a mensagem!", true);
				$data = 0;
				echo 0;
				echo $this->email->print_debugger();
			}
		}
	}

	private function validate_form()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', ' ');
		$this->form_validation->set_rules('name', 'Nome', 'required|max_length[250]');
		$this->form_validation->set_rules('email', 'E-mail', 'required');
		$this->form_validation->set_rules('message', 'Mensagem', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			return validation_errors();
		} else {
			return TRUE;
		}
	}

} ?>