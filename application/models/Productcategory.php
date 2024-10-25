<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class ProductCategory extends CI_Model {

   function __construct(){ parent::__construct(); }

   /* save data */
   
    public function save(){
        $id = $this->input->post('product_category_id');
    	$name = $this->input->post('name');
    	
        SetData('name');
        SetData('name_en');
        SetData('name_es');
    	SetData('color');
        SetData('visible');
        $this->db->set('alias',slugify($name));
            	    	
    	if(!empty($id)){
    		$this->db->where('product_category_id',$id);
    		return $this->db->update('tbl_products_categories');
    	}else{
            $this->db->set('order',$this->getNextOrder());
    		return $this->db->insert('tbl_products_categories');
    	}
    }

    public function reorder($items = null, $grid = true)
    {
        if(!$grid) $items = $this->getAll();
        $order = count($items);
        foreach($items as $item){
            $this->db->where('product_category_id', ($grid) ? $item['item_id'] : $item->product_category_id);
            $this->db->set('order', $order);
            if(!$this->db->update('tbl_products_categories')) return false;
            $order--;
        }
        return true;
    }
    
	/* get data */
	
	public function get($id=0){
		if(!empty($id)){
            $this->db->select('*');
            if ($this->uri->segment('1') != 'gerenciador'){
                if($this->session->userdata('lang')=='en'){
                    $this->db->select('name_en as name');
                }
                if($this->session->userdata('lang')=='es'){
                    $this->db->select('name_es as name');
                }
            }
			$this->db->where('product_category_id',$id);
   			$query = $this->db->get('tbl_products_categories');
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
                }
                if($this->session->userdata('lang')=='es'){
                    $this->db->select('name_es as name');
                }
            }
            $this->db->where('alias', $alias);
            $query = $this->db->get('tbl_products_categories');
            return $query->row();
        }
        return FALSE;
      }

    public function getBrandsByCategory($category){
        if ($this->uri->segment('1') != 'gerenciador'){
            if($this->session->userdata('lang')=='en'){
                $this->db->select('B.product_brand_id,C.name_en as name');
            }else{
                $this->db->select('B.product_brand_id,C.name');
            }
        }else{
            $this->db->select('B.product_brand_id,C.name');
        }
        $this->db->distinct();
        $this->db->from('tbl_products_brands_rel AS B');
        $this->db->join('tbl_products AS P','P.product_id = B.product_id');
        $this->db->join('tbl_products_brands AS C','C.product_brand_id = B.product_brand_id');
        $this->db->where('product_category_id',$category);
        $query = $this->db->get();
        return $query->result();
    }
   
   	public function getAll($visible=true){
        $this->db->select('*');
            if ($this->uri->segment('1') != 'gerenciador'){
                if($this->session->userdata('lang')=='en'){
                    $this->db->select('name_en as name');
                }
                if($this->session->userdata('lang')=='es'){
                    $this->db->select('name_es as name');
                }
            }
   		$this->db->order_by('order', 'desc');
        if($visible) $this->db->where('visible',1);
   		$query = $this->db->get('tbl_products_categories');
   		return $query->result();
   	}

    public function getNextOrder() {
        return count($this->getAll()) + 1;
    }
   	
	/* delete data */
   	public function delete($id){
    	if(!empty($id)){
            $this->load->model('Product');
            $this->Product->deleteAllByCategory($id);

	    	$this->db->where('product_category_id',$id);
	    	return $this->db->delete('tbl_products_categories');
    	}
    	return FALSE;
    }
}