<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MCompras extends CI_Model {

   function __construct(){ parent::__construct(); }

   /* save data */
   
   public function save(){
      $id = $this->input->post('compra_id');
      $titulo = dateBRtoUS($this->input->post('titulo'));
      $tags = $this->input->post('tags');  

      SetData('titulo');
      SetData('titulo_en');
      SetData('texto','html');
      SetData('texto_en','html');
      $this->db->set('compra_id',$id);      
      $this->db->set('alias',slugify($titulo));      
  
      if(!empty($id)){        
        $this->db->where('compra_id',$id);
        return $this->db->update('tbl_compras');
      }else{
        $this->db->set('order',$this->getNextOrder());
        return $this->db->insert('tbl_compras');
      }
    }
    
	public function reorder($items = null, $grid = true)
	{
		if(!$grid) $items = $this->getAll();
		$order = count($items);
		foreach($items as $item){
	 		$this->db->where('compra_id', ($grid) ? $item['item_id'] : $item->compra_id);
	 		$this->db->set('order', $order);
	 		if(!$this->db->update('tbl_compras')) return false;
	 		$order--;
	 	}
	 	return true;
	}

   
   /* get data */
	
   public function getTags(){
      $tags = array();

      $premiacoes = $this->getAll();
      foreach ($premiacoes as $key => $premiacoe) {
        $rt = explode(',', $premiacoe->tags);
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
			$this->db->where('compra_id',$id);
   			$query = $this->db->get('tbl_compras');
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
        $query = $this->db->get('tbl_compras');
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
            $query = $this->db->get('tbl_compras', $limitTo, $limitFrom);
        else
            $query = $this->db->get('tbl_compras');

        return $query->result();
    }
   	
	public function getByOrder($order=0){
		if(!empty($order)){
   			$this->db->where('order', $order);
        	$query = $this->db->get('tbl_compras');
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
				$img = COMPRAS_UPLOAD_PATH.$item->img;
				@unlink($img);
			}
			return TRUE;
    	}
    	return FALSE;
    }
    
	public function delete($id){
    	if(!empty($id)){
	    	//$this->deleteImage($id);
	    	$this->db->where('compra_id',$id);
	    	if ($this->db->delete('tbl_compras')) {
	    		$this->reorder(null, false);
	    		return true;
	    	}
    	}
    	return FALSE;
    }

}