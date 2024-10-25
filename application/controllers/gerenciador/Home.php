<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Text');
	}
	
	public function index()
	{
       $this->data['home1_frase_p1'] = $this->Text->getText('home1_frase_p1');
       $this->data['home1_frase_p1_en'] = $this->Text->getTextEn('home1_frase_p1');
       $this->data['home1_frase_p1_es'] = $this->Text->getTextEs('home1_frase_p1');
       $this->data['home1_frase_p2'] = $this->Text->getText('home1_frase_p2');
       $this->data['home1_frase_p2_en'] = $this->Text->getTextEn('home1_frase_p2'); 
       $this->data['home1_frase_p2_es'] = $this->Text->getTextEs('home1_frase_p2'); 
       $this->data['home1_text'] = $this->Text->getText('home1_text');
       $this->data['home1_text_en'] = $this->Text->getTextEn('home1_text');
       $this->data['home1_text_es'] = $this->Text->getTextEs('home1_text');
       $this->data['home1_link_title'] = $this->Text->getText('home1_link_title');
       $this->data['home1_link_title_en'] = $this->Text->getText('home1_link_title');
       $this->data['home1_link_title_es'] = $this->Text->getTextEs('home1_link_title');
       $this->data['home1_link'] = $this->Text->getText('home1_link');

       $this->data['home2_frase_p1'] = $this->Text->getText('home2_frase_p1');
       $this->data['home2_frase_p1_en'] = $this->Text->getTextEn('home2_frase_p1');
       $this->data['home2_frase_p1_es'] = $this->Text->getTextEs('home2_frase_p1');
       $this->data['home2_frase_p2'] = $this->Text->getText('home2_frase_p2');
       $this->data['home2_frase_p2_en'] = $this->Text->getTextEn('home2_frase_p2'); 
       $this->data['home2_frase_p2_es'] = $this->Text->getTextEs('home2_frase_p2'); 
       $this->data['home2_text'] = $this->Text->getText('home2_text');
       $this->data['home2_text_en'] = $this->Text->getTextEn('home2_text');
       $this->data['home2_text_es'] = $this->Text->getTextEs('home2_text');
       $this->data['home2_link_title'] = $this->Text->getText('home2_link_title');
       $this->data['home2_link_title_en'] = $this->Text->getText('home2_link_title');
       $this->data['home2_link_title_es'] = $this->Text->getTextEs('home2_link_title');
       $this->data['home2_link'] = $this->Text->getText('home2_link');
      
       
	   $this->load->view('gerenciador/home/text', $this->data);
	}
	
	public function save()
	{
        $data['home1_frase_p1']['text'] = $this->input->post('home1_frase_p1');
        $data['home1_frase_p1']['text_en'] = $this->input->post('home1_frase_p1_en');
        $data['home1_frase_p1']['text_es'] = $this->input->post('home1_frase_p1_es');
        $data['home1_frase_p2']['text'] = $this->input->post('home1_frase_p2');
        $data['home1_frase_p2']['text_en'] = $this->input->post('home1_frase_p2_en');
        $data['home1_frase_p2']['text_es'] = $this->input->post('home1_frase_p2_es');
        $data['home1_text']['text'] = $this->input->post('home1_text');
        $data['home1_text']['text_en'] = $this->input->post('home1_text_en');
        $data['home1_text']['text_es'] = $this->input->post('home1_text_ens');
        $data['home1_link_title']['text'] = $this->input->post('home1_link_title');
        $data['home1_link_title']['text_en'] = $this->input->post('home1_link_title_en');
        $data['home1_link_title']['text_es'] = $this->input->post('home1_link_title_es');
        $data['home1_link'] = $this->input->post('home1_link');

        $data['home2_frase_p1']['text'] = $this->input->post('home2_frase_p1');
        $data['home2_frase_p1']['text_en'] = $this->input->post('home2_frase_p1_en');
        $data['home2_frase_p1']['text_es'] = $this->input->post('home2_frase_p1_es');
        $data['home2_frase_p2']['text'] = $this->input->post('home2_frase_p2');
        $data['home2_frase_p2']['text_en'] = $this->input->post('home2_frase_p2_en');
        $data['home2_frase_p2']['text_es'] = $this->input->post('home2_frase_p2_es');
        $data['home2_text']['text'] = $this->input->post('home2_text');
        $data['home2_text']['text_en'] = $this->input->post('home2_text_en');
        $data['home2_text']['text_es'] = $this->input->post('home2_text_es');
        $data['home2_link_title']['text'] = $this->input->post('home2_link_title');
        $data['home2_link_title']['text_en'] = $this->input->post('home2_link_title_en');
        $data['home2_link_title']['text_es'] = $this->input->post('home2_link_title_es');
        $data['home2_link'] = $this->input->post('home2_link');
		
		if($this->Text->save($data)) $this->setMessage($this->lang->line('message_item_updated'));
		else $this->setMessage($this->lang->line('message_item_updated_error'), true);
		
		redirect('gerenciador/home');
	}

} ?>