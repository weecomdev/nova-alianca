<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ar_Files_Categories extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Ar_FileCategory');
	}
	
	public function index($profile_id)
	{
        $this->data['profile_id'] = $profile_id;
		$this->data['items'] = $this->Ar_FileCategory->getAll($profile_id,false);
		$this->load->view('gerenciador/ar_files/categories/index', $this->data);
	}
	
	public function add($profile_id)
	{
        $this->data['profile_id'] = $profile_id;
		$this->load->view('gerenciador/ar_files/categories/form', $this->data);
	}
	
	public function edit($id=0)
	{
		if(!empty($id))
		{
            $item = $this->Ar_FileCategory->get($id);
			$this->data['item'] = $item;
			$this->load->view('gerenciador/ar_files/categories/form', $this->data);
		}
		else
		{
			$this->setMessage($this->lang->line('message_invalid_id'), true);
			$this->index($item->profile_id);
		}
	}
	
	public function save(){
		$val = $this->validacao();
		$id = $this->input->post('ar_file_category_id');
        $profile_id = $this->input->post('profile_id');
		
		if ($val !== TRUE)
		{
			$this->setMessage($val, true);
			(!empty($id))?$this->edit($id):$this->add();
		}
		else
		{
			if($this->Ar_FileCategory->save())
			{
				$this->setMessage($this->lang->line('message_item_included'));
				redirect('gerenciador/ar_files_categories/'.$profile_id);
			}
			else
			{
				$this->setMessage($this->lang->line('message_item_included_error'), true);
				(!empty($id)) ? $this->edit($id) : $this->add($profile_id);
			}
		}
	}
	
	public function delete($id=0)
	{
		if(!empty($id))
		{
            $item = $this->Ar_FileCategory->get($id);
			if($this->Ar_FileCategory->delete($id))
			{
				$this->setMessage($this->lang->line('message_item_removed'));
				redirect('gerenciador/ar_files_categories/'.$item->profile_id);
			}
			else
			{
				$this->setMessage($this->lang->line('message_item_removed_error'), true);
				$this->index($item->profile_id);
			}
		}
		else
		{
			$this->setMessage($this->lang->line('message_invalid_id'), true);
			$this->index($item->profile_id);
		}
	}
	
	private function validacao()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', ' ');
		$this->form_validation->set_rules('title',    'Título',   'required');

		if ($this->form_validation->run() == FALSE)
			return validation_errors();
		else
			return TRUE;
	}
}

?>