<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('ProductCategory');
		$this->load->model('ProductBrand');
		$this->load->model('Product');
		$this->load->helper('ckeditor');
        $this->data['ck1'] = array('id' => 'description', 'path' => '_assets/js/ckeditor');
		$this->data['ck2'] = array('id' => 'description_en', 'path' => '_assets/js/ckeditor');
	}
	
	public function index($category_id)
	{
		$keyword = $this->input->post('keyword');
		$this->data['category'] = $this->ProductCategory->get($category_id);

		$this->data['items'] = $this->Product->getAll(false,$category_id);

		$this->load->view('gerenciador/products/index', $this->data);
	}
	
	public function add($category_id=0)
	{
        $this->data['category'] = $this->ProductCategory->get($category_id);
		$this->data['brands'] = $this->ProductBrand->getAll();
		$this->load->view('gerenciador/products/form', $this->data);
	}

    public function reorder()
    {
        $items = $this->input->post('data');
        if ($this->Product->reorder($items, true)) $this->output->set_output('1');
        else{
            $this->setMessage("Erro ao efetuar ordenação. Por favor, entre em contato com o suporte.", true);
            $this->output->set_output('0');
        }
    }
	
	public function edit($id=0)
	{
		if(!empty($id))
		{
			$item = $this->Product->get($id);
			$this->data['category'] = $this->ProductCategory->get($item->product_category_id);
            $this->data['brands'] = $this->ProductBrand->getAll();
            $this->data['my_brands'] = $this->Product->getMyBrands($item->product_id);
			$this->data['item'] = $item;
			$this->load->view('gerenciador/products/form', $this->data);
		}
		else
		{
			$this->setMessage($this->lang->line('message_invalid_id'), true);
			$this->index();
		}
	}
	
	public function save(){
		$val = $this->validacao();
		$id = $this->input->post('product_id');
		$category_id = $this->input->post('product_category_id');
		
		if ($val !== TRUE)
		{
			$this->setMessage($val, true);
			(!empty($id))?$this->edit($id):$this->add($category_id);
		}
		else
		{
            $this->load->library('image_moo');
            $base_dir = PRODUCTS_UPLOAD_PATH.$category_id.'/';

			$upload_data['img'] = $this->do_upload('img', $base_dir);
            $upload_data['img_bg'] = $this->do_upload('img_bg', $base_dir);
            $upload_data['img_bootle'] = $this->do_upload('img_bootle', $base_dir);
            $upload_data['img_frase'] = $this->do_upload('img_frase', $base_dir);
            
            if(!empty($upload_data['img']['ok'])){

                $upload_data['img_thumb']['file'] = $upload_data['img']['name'].'_thumb'.$upload_data['img']['ext'];

                $this->image_moo->load($base_dir . $upload_data['img']['file'])->resize(1000, 1030)->save($base_dir . $upload_data['img']['file'],true);
                $this->image_moo->load($base_dir . $upload_data['img']['file'])->resize(270, 270)->save($base_dir . $upload_data['img_thumb']['file']);
                if ($this->image_moo->errors) print $this->image_moo->display_errors();
            }
            if(!empty($upload_data['img_bootle']['ok'])){
                $this->image_moo->load($base_dir . $upload_data['img_bootle']['file'])->resize(60, 100)->save($base_dir . $upload_data['img_bootle']['file'],true);
                if ($this->image_moo->errors) print $this->image_moo->display_errors();
            }
            if(!empty($upload_data['img_bg']['ok'])){
                $this->image_moo->load($base_dir . $upload_data['img_bg']['file'])->resize(960, 960)->save($base_dir . $upload_data['img_bg']['file'],true);
                if ($this->image_moo->errors) print $this->image_moo->display_errors();
            }
            if(!empty($upload_data['img_frase']['ok'])){
                resize_then_crop($base_dir.$upload_data['img_frase']['file'],$base_dir.$upload_data['img_frase']['file'],1760,1150);
            }
            if($this->Product->save($upload_data))
			{
				$this->setMessage($this->lang->line('message_item_included'));
				redirect('gerenciador/products/'.$category_id);
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
			$item = $this->Product->get($id);
			if($this->Product->delete($id))
			{
				$this->setMessage($this->lang->line('message_item_removed'));
				redirect('gerenciador/products/'.$item->product_category_id);
			}
			else
			{
				$this->setMessage($this->lang->line('message_item_removed_error'), true);
				$this->index($item->product_category_id);
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
        $this->form_validation->set_rules('type',    'Tipo',   'required');
		$this->form_validation->set_rules('description',    'Descrição',   'required');

		if ($this->form_validation->run() == FALSE)
			return validation_errors();
		else
			return TRUE;
	}
}

?>