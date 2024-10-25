<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class ContactData extends CI_Model {

   function __construct(){ parent::__construct(); }

   /* save data */
   public function save()
   {
   		$id = $this->input->post('contact_data_id');

        SetData('address');
        SetData('address_number');
        SetData('address_complement');
        SetData('zip_code');
        SetData('phone');
        SetData('email');
        SetData('state');
        SetData('city');
        SetData('district');
        SetData('latitude');
        SetData('longitude');

        if(!empty($id)){
            $this->db->where('contact_data_id',$id);
            return $this->db->update('tbl_contact_data');
        }else return false;    
   }
   
   /* get data */
   public function get()
   {
   		$query = $this->db->get('tbl_contact_data');
			return $query->row();
   }

}