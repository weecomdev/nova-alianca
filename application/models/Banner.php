<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends CI_Model {

   function __construct(){ parent::__construct(); }

   /* save data */
   
    public function save($upload_data){
    	$id = $this->input->post('banner_id');
    	
    	SetData('link');
    	
    	if(!empty($id)){
    		if(!empty($upload_data['img_bg']['file']))
            {
                $this->deleteImage($id,'img_bg');
                $this->db->set('img_bg',$upload_data['img_bg']['file']);
            }
            if(!empty($upload_data['img_en']['file']))
            {
                $this->deleteImage($id,'img_en');
                $this->db->set('img_en',$upload_data['img_en']['file']);
            }
            if(!empty($upload_data['img_es']['file']))
            {
                $this->deleteImage($id,'img_es');
                $this->db->set('img_es',$upload_data['img_es']['file']);
            }
            if(!empty($upload_data['img']['file']))
            {
                $this->deleteImage($id,'img');
                $this->db->set('img',$upload_data['img']['file']);
            }
    		$this->db->where('banner_id',$id);
    		return $this->db->update('tbl_banners');
    	}else{
    		$this->db->set('order',$this->getNextOrder());
            $this->db->set('img',$upload_data['img']['file']);
            $this->db->set('img_bg',$upload_data['img_bg']['file']);
        $this->db->set('img_en',$upload_data['img_en']['file']);
    		$this->db->set('img_es',$upload_data['img_es']['file']);
    		return $this->db->insert('tbl_banners');
    	}
    }
    
	public function reorder($items = null, $grid = true)
	{
		if(!$grid) $items = $this->getAll();
		$order = count($items);
		foreach($items as $item){
	 		$this->db->where('banner_id', ($grid) ? $item['item_id'] : $item->banner_id);
	 		$this->db->set('order', $order);
	 		if(!$this->db->update('tbl_banners')) return false;
	 		$order--;
	 	}
	 	return true;
	}

   
   /* get data */
	
	public function get($id=0){
		if(!empty($id)){
			$this->db->where('banner_id',$id);
   			$query = $this->db->get('tbl_banners');
   			return $query->row();
		}
		return FALSE;
   	}
   
   	public function getAll(){
   		$this->db->order_by('order', 'desc');
   		$query = $this->db->get('tbl_banners');
   		return $query->result();
   	}
   	
	public function getByOrder($order=0){
		if(!empty($order)){
   			$this->db->where('order', $order);
        	$query = $this->db->get('tbl_banners');
        	return $query->row();
        }
		return FALSE;
    }
    
	public function getNextOrder() {
		return count($this->getAll()) + 1;
	}
   	
   	/* delete data */
   	
   private function deleteImage($id,$spec=null){
    	if(!empty($id)){
	    	$item = $this->get($id);
			if($spec == null || $spec == 'img'){	
				$img = BANNERS_UPLOAD_PATH.$item->img;
				@unlink($img);
			}
            if($spec == null || $spec == 'img_bg'){    
                $img = BANNERS_UPLOAD_PATH.$item->img_bg;
                @unlink($img);
            }
            if($spec == null || $spec == 'img_en'){    
                $img = BANNERS_UPLOAD_PATH.$item->img_en;
                @unlink($img);
            }
			return TRUE;
    	}
    	return FALSE;
    }
    
	public function delete($id){
    	if(!empty($id)){
	    	$this->deleteImage($id);
	    	$this->db->where('banner_id',$id);
	    	if ($this->db->delete('tbl_banners')) {
	    		$this->reorder(null, false);
	    		return true;
	    	}
    	}
    	return FALSE;
    }

}