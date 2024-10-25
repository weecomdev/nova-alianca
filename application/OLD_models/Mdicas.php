<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MDicas extends CI_Model {

   function __construct(){ parent::__construct(); }

   /* save data */
   
   public function save(){
      $id = $this->input->post('dica_id');
      $titulo = dateBRtoUS($this->input->post('titulo'));

      SetData('titulo');
      SetData('titulo_en');
      SetData('texto','html');
      SetData('texto_en','html');
      $this->db->set('dica_id',$id);      
      $this->db->set('alias',slugify($titulo));      
  
      if(!empty($id)){        
        $this->db->where('dica_id',$id);
        return $this->db->update('tbl_dicas');
      }else{
        $this->db->set('order',$this->getNextOrder());
        return $this->db->insert('tbl_dicas');
      }
    }
    
	public function reorder($items = null, $grid = true)
	{
		if(!$grid) $items = $this->getAll();
		$order = count($items);
		foreach($items as $item){
	 		$this->db->where('dica_id', ($grid) ? $item['item_id'] : $item->dica_id);
	 		$this->db->set('order', $order);
	 		if(!$this->db->update('tbl_dicas')) return false;
	 		$order--;
	 	}
	 	return true;
	}

   
   /* get data */
	
   public function getTags(){
      $tags = array();

      $dicas = $this->getAll();
      foreach ($dicas as $key => $dica) {
        $rt = explode(',', $dica->tags);
        foreach ($rt as $key => $value) {
          $tag = trim($value);
          if (array_key_exists($tag, $tags))
            $tags[$tag]['count'] = $tags[$tag]['count'] + 1;
          else
            $tags[$tag] = array('name'=>$tag, 'count'=>1);
        }
      }
      function compareOrder($a, $b)
      {
        return $a['count'] - $b['count'];
      }
      usort($tags, 'compareOrder');
      return array_reverse($tags, TRUE);
   }



	public function get($id=0){
		if(!empty($id)){
			$this->db->where('dica_id',$id);
   			$query = $this->db->get('tbl_dicas');
   			return $query->row();
		}
		return FALSE;
   	}

    public function getByAlias($alias=0){
    if(!empty($alias)){
        $this->db->select('*');
        if ($this->uri->segment('1') != 'gerenciador'){
            if($this->session->userdata('lang')=='en'){
                $this->db->select('titulo_en as titulo');
                $this->db->select('texto_en as texto');
            }
        }
        $this->db->where('alias', $alias);
        $query = $this->db->get('tbl_dicas');
        return $query->row();
    }
    return FALSE;
  }
   
   
   	public function getAll($limitTo=0, $limitFrom=0){
        $this->db->select('*');
        if ($this->uri->segment('1') != 'gerenciador'){
            if($this->session->userdata('lang')=='en'){
                $this->db->select('titulo_en as titulo');
                $this->db->select('texto_en as texto');
            }
        }
        $this->db->order_by('order','desc');
        
        if (!empty($limitTo))
            $query = $this->db->get('tbl_dicas', $limitTo, $limitFrom);
        else
            $query = $this->db->get('tbl_dicas');

        return $query->result();
    }
   	
	public function getByOrder($order=0){
		if(!empty($order)){
   			$this->db->where('order', $order);
        	$query = $this->db->get('tbl_dicas');
        	return $query->row();
        }
		return FALSE;
    }
    
	public function getNextOrder() {
		return count($this->getAll()) + 1;
	}
   	
   	/* delete data */
   	
   private function deleteImage($id){
    	if(!empty($id)){
	    	$item = $this->get($id);
			if(!empty($item->img)){	
				$img = DICAS_UPLOAD_PATH.$item->img;
				@unlink($img);
			}
			return TRUE;
    	}
    	return FALSE;
    }
    
	public function delete($id){
    	if(!empty($id)){
	    	//$this->deleteImage($id);
	    	$this->db->where('dica_id',$id);
	    	if ($this->db->delete('tbl_dicas')) {
	    		$this->reorder(null, false);
	    		return true;
	    	}
    	}
    	return FALSE;
    }

}