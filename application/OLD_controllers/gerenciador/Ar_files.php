<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ar_Files extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('Ar_FileCategory');
		$this->load->model('Ar_File');
		$this->load->helper('ckeditor');
		$this->data['ck1'] = array('id' => 'description', 'path' => '_assets/js/ckeditor');
	}
	
	public function index($category_id)
	{
		$this->data['category'] = $this->Ar_FileCategory->get($category_id);

		$this->data['items'] = $this->Ar_File->getAll($category_id,null,null,false);

		$this->load->view('gerenciador/ar_files/index', $this->data);
	}
	
	public function add($category_id=0)
	{
        $this->data['category'] = $this->Ar_FileCategory->get($category_id);

		$this->load->view('gerenciador/ar_files/form', $this->data);
	}

    public function reorder()
    {
        $items = $this->input->post('data');
        if ($this->Ar_File->reorder($items, true)) $this->output->set_output('1');
        else{
            $this->setMessage("Erro ao efetuar ordenação. Por favor, entre em contato com o suporte.", true);
            $this->output->set_output('0');
        }
    }
	
	public function edit($id=0)
	{
		if(!empty($id))
		{
			$item = $this->Ar_File->get($id);
			$this->data['category'] = $this->Ar_FileCategory->get($item->ar_file_category_id);
			$this->data['item'] = $item;
			$this->load->view('gerenciador/ar_files/form', $this->data);
		}
		else
		{
			$this->setMessage($this->lang->line('message_invalid_id'), true);
			$this->index();
		}
	}
	
	public function save(){
		$val = $this->validacao();
		$id = $this->input->post('ar_file_id');
		$category_id = $this->input->post('ar_file_category_id');
		
		if ($val !== TRUE)
		{
			$this->setMessage($val, true);
			(!empty($id))?$this->edit($id):$this->add($category_id);
		}
		else
		{
            $base_dir = AR_UPLOAD_PATH.$category_id.'/';

			$upload_data = $this->do_upload('file', $base_dir, '*');
            // if ($_SERVER['REMOTE_ADDR'] == '177.82.246.214') {
            //     var_dump($upload_data);
            //     die();
            // }
    
            if($this->Ar_File->save($upload_data))
			{
				$this->setMessage($this->lang->line('message_item_included'));
				redirect('gerenciador/ar_files/'.$category_id);
			}
			else
			{
				$this->setMessage($this->lang->line('message_item_included_error'), true);
				(!empty($id)) ? $this->edit($id) : $this->add($category_id);
			}
		}
	}
	
	public function delete($id=0)
	{
		if(!empty($id))
		{
			$item = $this->Ar_File->get($id);
			if($this->Ar_File->delete($id))
			{
				$this->setMessage($this->lang->line('message_item_removed'));
				redirect('gerenciador/ar_files/'.$item->ar_file_category_id);
			}
			else
			{
				$this->setMessage($this->lang->line('message_item_removed_error'), true);
				$this->index($item->ar_file_category_id);
			}
		}
		else
		{
			$this->setMessage($this->lang->line('message_invalid_id'), true);
			redirect('gerenciador');
		}
	}
	
	private function validacao()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', ' ');
        $this->form_validation->set_rules('name',    'Nome',   'required');

		if ($this->form_validation->run() == FALSE)
			return validation_errors();
		else
			return TRUE;
	}
}

?>