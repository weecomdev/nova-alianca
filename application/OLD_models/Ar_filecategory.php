<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ar_fileCategory extends CI_Model {

   function __construct(){ parent::__construct(); }

   /* save data */
   
    public function save(){
        $id = $this->input->post('ar_file_category_id');
    	$title = $this->input->post('title');
    	
        SetData('title');
    	SetData('profile_id');
        SetData('visible');
            	    	
    	if(!empty($id)){
    		$this->db->where('ar_file_category_id',$id);
    		return $this->db->update('ar_files_categories');
    	}else{
    		return $this->db->insert('ar_files_categories');
    	}
    }
    
	/* get data */
	
	public function get($id=0){
		if(!empty($id)){
			$this->db->where('ar_file_category_id',$id);
   			$query = $this->db->get('ar_files_categories');
   			return $query->row();
		}
		return FALSE;
   	}
   
   	public function getAll($profile=0,$visible=true){
   		$this->db->order_by('title', 'asc');
        if($visible) $this->db->where('visible',1);
        if($profile) $this->db->where('profile_id',$profile);
   		$query = $this->db->get('ar_files_categories');
   		return $query->result();
   	}
   	
	/* delete data */
   	public function delete($id){
    	if(!empty($id)){
	    	$this->db->where('ar_file_category_id',$id);
	    	return $this->db->delete('ar_files_categories');
    	}
    	return FALSE;
    }
}