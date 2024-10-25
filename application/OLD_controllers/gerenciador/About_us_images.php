<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About_Us_Images extends MY_Controller {

   	public function __construct()
   	{
      	parent::__construct();
      	$this->load->model('AboutUsImage');
      	
      	$this->load->library("upload");
   	}

   	public function index()
   	{
   		$this->data['items'] = $this->AboutUsImage->getAll();
      	$this->load->view('gerenciador/about_us/images/index', $this->data);
   	}

   	public function reorder()
	{
		$items = $this->input->post('data');
		if ($this->AboutUsImage->reorder($items, true)) $this->output->set_output('1');
		else{
			$this->setMessage("Erro ao efetuar ordenação. Por favor, entre em contato com o suporte.", true);
			$this->output->set_output('0');
		}
	}
  	 
	public function add()
	{
		$this->load->view('gerenciador/about_us/images/add', $this->data);
	}

	function upload()
    {
 		if (!empty($_FILES['files']['name']))
		{
			$base_dir = ABOUT_US_IMAGES_UPLOAD_PATH;
			if (!is_dir($base_dir)) create_dirs_recursive($base_dir);
		
			$config['upload_path'] = $base_dir;
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']	= 0;
			$config['encrypt_name'] = true;

			$this->upload->initialize($config);


			$_FILES['files']['name'] = $_FILES['files']['name'][0];
			$_FILES['files']['type'] = $_FILES['files']['type'][0];
			$_FILES['files']['tmp_name'] = $_FILES['files']['tmp_name'][0];
			$_FILES['files']['error'] = $_FILES['files']['error'][0];
			$_FILES['files']['size'] = $_FILES['files']['size'][0]; 
	

			if (!$this->upload->do_upload('files'))
			{
				$error = $this->upload->display_errors();
				$error_message = ImageErrors($error);
				
				$this->setMessage($this->lang->line('message_upload_error').$error_message, true);
				
				return false;	
			}
			else
			{
				$data = $this->upload->data();
				
				$data['thumb_image'] = $thumb_image = $data['raw_name'].'_thumb'.$data['file_ext'];
				$data['image'] = $image = $data['file_name'];

				$this->load->library('image_moo');
				$this->image_moo->load($base_dir . $image)->resize_crop(1750, 900)->save($base_dir . $thumb_image);
				if ($this->image_moo->errors) print $this->image_moo->display_errors();

				$this->AboutUsImage->save($data);

				$data['true_name'] = 'true';
				$json = json_encode($data);
				echo true;
			}
		}
		return FALSE;

    }


    public function delete($gallery_image_id)
    {
    	if (!empty($gallery_image_id)) {
    		if ($this->AboutUsImage->delete($gallery_image_id)) {
    			$this->setMessage("Imagem excluída com sucesso!");
    			redirect('gerenciador/about_us_images');
    		}
    	}
		$this->setMessage("Item não encontrado.", true);
		redirect('gerenciador/about_us_images');
    }

}