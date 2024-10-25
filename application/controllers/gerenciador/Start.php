<?php
class Start extends MY_Controller {
	var $get_text_menu = true;
	var $check_session = true;

   function __construct()
   {
      parent::__construct();
   }

   public function index()
   {
      $this->load->view('gerenciador/start', $this->data);
   }
}