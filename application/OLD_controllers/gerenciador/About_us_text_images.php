<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About_Us_Text_Images extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Text');
		$this->load->helper('ckeditor');
	}
	
	public function index()
	{

       $this->data['inst_image_1'] = $this->Text->getText('inst_image_1');
       $this->data['inst_image_2'] = $this->Text->getText('inst_image_2');
       $this->data['inst_image_3'] = $this->Text->getText('inst_image_3');
 
	   $this->load->view('gerenciador/about_us/images', $this->data);
	}
	
	public function save()
	{
        $this->load->library('image_moo');
        $base_dir = TEXT_IMAGES_PATH;

        $upload_data['inst_image_1'] = $this->do_upload('inst_image_1',$base_dir);
        $upload_data['inst_image_2'] = $this->do_upload('inst_image_2',$base_dir);
        $upload_data['inst_image_3'] = $this->do_upload('inst_image_3',$base_dir);


        if(!empty($upload_data['inst_image_1']['ok'])){
            resize_then_crop($base_dir . $upload_data['inst_image_1']['file'],$base_dir . $upload_data['inst_image_1']['file'],580, 580);
        }
        if(!empty($upload_data['inst_image_2']['ok'])){
            resize_then_crop($base_dir . $upload_data['inst_image_2']['file'],$base_dir . $upload_data['inst_image_2']['file'],580, 580);
        }
        if(!empty($upload_data['inst_image_3']['ok'])){
            resize_then_crop($base_dir . $upload_data['inst_image_3']['file'],$base_dir . $upload_data['inst_image_3']['file'],580, 580);
        }

        $data['inst_image_1'] = $upload_data['inst_image_1']['file'];
        $data['inst_image_2'] = $upload_data['inst_image_2']['file'];
        $data['inst_image_3'] = $upload_data['inst_image_3']['file'];

        		
		if($this->Text->save($data)) $this->setMessage($this->lang->line('message_item_updated'));
		else $this->setMessage($this->lang->line('message_item_updated_error'), true);
		
		redirect('gerenciador/about_us_text_images');
	}

} ?>