<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ar_File extends MY_Model {

   function __construct(){ parent::__construct(); }

   /* save data */
   
    public function save($upload_data)
    {
          $category = $this->input->post('ar_file_category_id');     
          $id = $this->input->post('ar_file_id');   
          //
          SetData('ar_file_category_id');
          SetData('name');  
          $this->db->set('date',date('Y-m-d'));     

    	if(!empty($id)){
            if(!empty($upload_data['file']))
            {
                $this->deleteImage($id);
                $this->db->set('file',$upload_data['file']); 
            }
    		$this->db->where('ar_file_id',$id);
    		return $this->db->update('ar_files');
            
    	}else{
            $this->db->set('file',$upload_data['file']);
    		return $this->db->insert('ar_files');
    	}
    }
    
	/* get data */

	public function get($id=0){
		if(!empty($id)){
			 $this->db->where('ar_file_id',$id);
   			$query = $this->db->get('ar_files');
   			return $query->row();
		}
		return FALSE;
    }
   
 	public function getAll($category=0,$profile=0,$query=null,$visible=true){
 		$this->db->from('ar_files AS P');
        $this->db->distinct();
        $this->db->select('P.*');
        $this->db->order_by('P.name', 'asc');
 
        if(!empty($profile)){
            $this->db->join('ar_files_categories as R','P.ar_file_category_id = R.ar_file_category_id');
            $this->db->where('profile_id',$profile);
        }
        if(!empty($query)){
            $this->db->like('P.name',$query);
        }
        if($visible){
            $this->db->where('R.visible',1);
        }
        if(!empty($category)) $this->db->where('P.ar_file_category_id',$category);
        
        if(empty($max)) $query = $this->db->get('ar_files');
        else $query = $this->db->get('ar_files',$max,0);

 		return $query->result();
 	}

	/* delete data */
   	public function delete($id){
    	if(!empty($id)){
            $this->deleteImage($id);
	    	$this->db->where('ar_file_id',$id);
	    	return $this->db->delete('ar_files');
    	}
    	return FALSE;
    }

    private function deleteImage($id){
          if(!empty($id)){
            $item = $this->get($id);
            
            $img = AR_UPLOAD_PATH.$item->ar_file_category_id.'/'.$item->file;
            @unlink($img);
          }
          return TRUE;
    }
}