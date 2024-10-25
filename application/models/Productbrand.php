<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class ProductBrand extends CI_Model {

   function __construct(){ parent::__construct(); }

   /* save data */
   
    public function save(){
    	$id = $this->input->post('product_brand_id');
        $name = $this->input->post('name');
    	
        SetData('name');
        SetData('name_en');
        SetData('name_es');
        SetData('description');
        SetData('description_en');
    	SetData('description_es');
        SetData('visible');
        $this->db->set('alias',slugify($name));
            	    	
    	if(!empty($id)){
    		$this->db->where('product_brand_id',$id);
    		return $this->db->update('tbl_products_brands');
    	}else{
            $this->db->set('order',$this->getNextOrder());
    		return $this->db->insert('tbl_products_brands');
    	}
    }

    public function reorder($items = null, $grid = true)
    {
        if(!$grid) $items = $this->getAll();
        $order = count($items);
        foreach($items as $item){
            $this->db->where('product_brand_id', ($grid) ? $item['item_id'] : $item->product_brand_id);
            $this->db->set('order', $order);
            if(!$this->db->update('tbl_products_brands')) return false;
            $order--;
        }
        return true;
    }
    
	/* get data */
	
	public function get($id=0){
		if(!empty($id)){
			$this->db->where('product_brand_id',$id);
   			$query = $this->db->get('tbl_products_brands');
   			return $query->row();
		}
		return FALSE;
   	}

    public function getByAlias($alias=0){
        if(!empty($alias)){
            $this->db->select('*');
            if ($this->uri->segment('1') != 'gerenciador'){
                if($this->session->userdata('lang')=='en'){
                    $this->db->select('name_en as name');
                    $this->db->select('description_en as description');
                }
                if($this->session->userdata('lang')=='es'){
                    $this->db->select('name_es as name');
                    $this->db->select('description_es as description');
                }
            }
            $this->db->where('alias', $alias);
            $query = $this->db->get('tbl_products_brands');
            return $query->row();
        }
        return FALSE;
      }
   
   	public function getAll($visible=true){
        $this->db->select('*');
        if ($this->uri->segment('1') != 'gerenciador'){
            if($this->session->userdata('lang')=='en'){
                $this->db->select('name_en as name');
                $this->db->select('description_en as description');
            }
            if($this->session->userdata('lang')=='es'){
                $this->db->select('name_es as name');
                $this->db->select('description_es as description');
            }
        }
   		$this->db->order_by('order', 'desc');
        if($visible) $this->db->where('visible',1);
   		$query = $this->db->get('tbl_products_brands');
   		return $query->result();
   	}

    public function getNextOrder() {
        return count($this->getAll()) + 1;
    }
   	
	/* delete data */
   	public function delete($id){
    	if(!empty($id)){
            $this->db->where('product_brand_id',$id);
            $this->db->delete('tbl_products_brands_rel');

	    	$this->db->where('product_brand_id',$id);
	    	return $this->db->delete('tbl_products_brands');
    	}
    	return FALSE;
    }
}