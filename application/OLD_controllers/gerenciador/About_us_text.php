<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About_Us_Text extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Text');
		$this->load->helper('ckeditor');
	}
	
	public function index()
	{
       $this->data['inst_frase_p1'] = $this->Text->getText('inst_frase_p1');
       $this->data['inst_frase_p1_en'] = $this->Text->getTextEn('inst_frase_p1');
       $this->data['inst_frase_p2'] = $this->Text->getText('inst_frase_p2');
       $this->data['inst_frase_p2_en'] = $this->Text->getTextEn('inst_frase_p2');
       $this->data['inst_frase_p3'] = $this->Text->getText('inst_frase_p3');
       $this->data['inst_frase_p3_en'] = $this->Text->getTextEn('inst_frase_p3');
       $this->data['inst_title11'] = $this->Text->getText('inst_title11');
       $this->data['inst_title11_en'] = $this->Text->getTextEn('inst_title11');
       $this->data['inst_title12'] = $this->Text->getText('inst_title12');
       $this->data['inst_title12_en'] = $this->Text->getTextEn('inst_title12');
       $this->data['inst_text1'] = $this->Text->getText('inst_text1');
	   $this->data['inst_text1_en'] = $this->Text->getTextEn('inst_text1');
       $this->data['ck1'] = array('id' => 'inst_text1', 'path' => '_assets/js/ckeditor');
	   $this->data['ck1_en'] = array('id' => 'inst_text1_en', 'path' => '_assets/js/ckeditor');
       $this->data['inst_title21'] = $this->Text->getText('inst_title21');
       $this->data['inst_title21_en'] = $this->Text->getTextEn('inst_title21');
       $this->data['inst_title22'] = $this->Text->getText('inst_title22');
       $this->data['inst_title22_en'] = $this->Text->getTextEn('inst_title22');
       $this->data['inst_text2'] = $this->Text->getText('inst_text2');
       $this->data['inst_text2_en'] = $this->Text->getTextEn('inst_text2');
       $this->data['ck2'] = array('id' => 'inst_text2', 'path' => '_assets/js/ckeditor');
       $this->data['ck2_en'] = array('id' => 'inst_text2_en', 'path' => '_assets/js/ckeditor');
       $this->data['inst_valores'] = $this->Text->getText('inst_valores');
       $this->data['inst_valores_en'] = $this->Text->getTextEn('inst_valores');
       $this->data['ck3'] = array('id' => 'inst_valores', 'path' => '_assets/js/ckeditor');
       $this->data['ck3_en'] = array('id' => 'inst_valores_en', 'path' => '_assets/js/ckeditor');
       $this->data['inst_principios'] = $this->Text->getText('inst_principios');
       $this->data['inst_principios_en'] = $this->Text->getTextEn('inst_principios');
       $this->data['ck4'] = array('id' => 'inst_principios', 'path' => '_assets/js/ckeditor');
       $this->data['ck4_en'] = array('id' => 'inst_principios_en', 'path' => '_assets/js/ckeditor');
       
	   $this->load->view('gerenciador/about_us/text', $this->data);
	}
	
	public function save()
	{
        $data['inst_frase_p1']['text'] = $this->input->post('inst_frase_p1');
        $data['inst_frase_p1']['text_en'] = $this->input->post('inst_frase_p1_en');
        $data['inst_frase_p2']['text'] = $this->input->post('inst_frase_p2');
        $data['inst_frase_p2']['text_en'] = $this->input->post('inst_frase_p2_en');
        $data['inst_frase_p3']['text'] = $this->input->post('inst_frase_p3');
        $data['inst_frase_p3']['text_en'] = $this->input->post('inst_frase_p3_en');
        $data['inst_title11']['text'] = $this->input->post('inst_title11');
        $data['inst_title11']['text_en'] = $this->input->post('inst_title11_en');
        $data['inst_title12']['text'] = $this->input->post('inst_title12');
        $data['inst_title12']['text_en'] = $this->input->post('inst_title12_en');
        $data['inst_text1']['text'] = $this->input->post('inst_text1');
        $data['inst_text1']['text_en'] = $this->input->post('inst_text1_en');
        $data['inst_title21']['text'] = $this->input->post('inst_title21');
        $data['inst_title21']['text_en'] = $this->input->post('inst_title21_en');
        $data['inst_title22']['text'] = $this->input->post('inst_title22');
        $data['inst_title22']['text_en'] = $this->input->post('inst_title22_en');
        $data['inst_text2']['text'] = $this->input->post('inst_text2');
        $data['inst_text2']['text_en'] = $this->input->post('inst_text2_en');
        $data['inst_valores']['text'] = $this->input->post('inst_valores');
        $data['inst_valores']['text_en'] = $this->input->post('inst_valores_en');
        $data['inst_principios']['text'] = $this->input->post('inst_principios');
		$data['inst_principios']['text_en'] = $this->input->post('inst_principios_en');
		
		if($this->Text->save($data)) $this->setMessage($this->lang->line('message_item_updated'));
		else $this->setMessage($this->lang->line('message_item_updated_error'), true);
		
		redirect('gerenciador/about_us_text');
	}

} ?>