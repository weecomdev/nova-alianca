<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banners extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Banner');
        $this->load->library('image_lib');
    }
    
    public function index()
    {
        $this->data['items'] = $this->Banner->getAll();
        $this->load->view('gerenciador/banners/index', $this->data);
    }
    
    public function reorder($id=0)
    {
        $items = $this->input->post('data');
        if ($this->Banner->reorder($items)) $this->output->set_output('1');
        else{ 
            $this->setMessage("Erro ao efetuar ordenação. Por favor, entre em contato com o suporte.", true);
            $this->output->set_output('0');
        }
    }
    
    public function add()
    {
        $this->load->view('gerenciador/banners/form', $this->data);
    }
    
    public function edit($id=0)
    {
        if(!empty($id))
        {
            $this->data['item'] = $this->Banner->get($id);
            $this->load->view('gerenciador/banners/form', $this->data);
        }
        else
        {
            $this->setMessage($this->lang->line('message_invalid_id'), true);
            $this->index();
        }
    }
    
    public function save(){
        $this->load->library('image_moo');
        $val = $this->validacao();
        $id = $this->input->post('banner_id');
        if ($val !== TRUE)
        {
            $this->setMessage($val, true);
            (!empty($id))?$this->edit($id):$this->add();
        }
        else
        {
            $upload_data['img'] = $this->do_upload('img', BANNERS_UPLOAD_PATH);
            $upload_data['img_en'] = $this->do_upload('img_en', BANNERS_UPLOAD_PATH);
            $upload_data['img_bg'] = $this->do_upload('img_bg', BANNERS_UPLOAD_PATH);

            if(!empty($upload_data['img']['file'])){
                $this->image_moo->load($base_dir . $upload_data['img']['file'])->resize(700, 700)->save($base_dir . $upload_data['img']['file'],true);
            }
            if(!empty($upload_data['img_en']['file'])){
                $this->image_moo->load($base_dir . $upload_data['img_en']['file'])->resize(700, 700)->save($base_dir . $upload_data['img_en']['file'],true);
            }
            if(!empty($upload_data['img_bg']['file'])){
                resize_then_crop(BANNERS_UPLOAD_PATH.$upload_data['img_bg']['file'],BANNERS_UPLOAD_PATH.$upload_data['img_bg']['file'],1750,900);
            }

            if($this->Banner->save($upload_data))
            {
                $this->setMessage($this->lang->line('message_item_saved'));
                redirect('gerenciador/banners');
            }
            else
            {
                $this->setMessage($this->lang->line('message_item_saved_error'), true);
                (!empty($id)) ? $this->edit($id) : $this->add();
            }
        }
    }
    
    public function delete($id=0)
    {
        if(!empty($id))
        {
            if($this->Banner->delete($id))
            {
                $this->setMessage($this->lang->line('message_item_removed'));
                redirect('gerenciador/banners');
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
        $this->form_validation->set_rules('link',    'Link',   'required');

        if ($this->form_validation->run() == FALSE) return validation_errors();
        else return TRUE;
    }

} ?>