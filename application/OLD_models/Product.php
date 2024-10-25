<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends MY_Model {

   function __construct(){ parent::__construct(); }

   /* save data */
   
    public function save($upload_data)
    {
          $category = $this->input->post('product_category_id');     
          $id = $this->input->post('product_id');   
          $array_loja = $this->input->post('loja');
          $array_link = $this->input->post('link');
          $name = $this->input->post('name');
          $type = $this->input->post('type');

          if(!empty($array_loja)){
            foreach($array_loja as $k=>$a)
            {
              if($a != ''){
                $array_compras[$k]['loja'] = $a;
                $array_compras[$k]['link'] = $array_link[$k];
              }
            }
          }
          $string_compras = '';
          if(!empty($array_compras)){
            $string_compras = json_encode($array_compras);
          }
          //
          SetData('product_category_id');
          $this->db->set('alias',slugify($name.' '.$type));
          SetData('name');
          SetData('name_en');
          SetData('type');
          SetData('type_en');
          SetData('description','html');
          SetData('description_en','html');
          SetData('options');          
          SetData('visible');
          SetData('frase_p1');
          SetData('frase_p1_en');
          SetData('frase_p2');
          SetData('frase_p2_en');
          SetData('frase_p3');
          SetData('frase_p3_en');
          $this->db->set('onde_comprar',$string_compras);

    	if(!empty($id)){
            if(!empty($upload_data['img']['file']))
            {
                $this->deleteImage($id,'img');
                $this->deleteImage($id,'img_thumb');
                $this->db->set('img',$upload_data['img']['file']); 
                $this->db->set('img_thumb',$upload_data['img_thumb']['file']); 
            }
            if(!empty($upload_data['img_bg']['file']))
            {
                $this->deleteImage($id,'img_bg');
                $this->db->set('img_bg',$upload_data['img_bg']['file']);
            }
            if(!empty($upload_data['img_bootle']['file']))
            {
                $this->deleteImage($id,'img_bootle');
                $this->db->set('img_bootle',$upload_data['img_bootle']['file']);
            }
            if(!empty($upload_data['img_frase']['file']))
            {
                $this->deleteImage($id,'img_frase');
                $this->db->set('img_frase',$upload_data['img_frase']['file']);
            }
    		$this->db->where('product_id',$id);
    		if($this->db->update('tbl_products'))
              return $this->saveBrands($id);
            else
              return false;
    	}else{
            $this->db->set('img',$upload_data['img']['file']);
            $this->db->set('img_bg',$upload_data['img_bg']['file']);
            $this->db->set('img_thumb',$upload_data['img_thumb']['file']); 
            $this->db->set('img_bootle',$upload_data['img_bootle']['file']);
            $this->db->set('img_frase',$upload_data['img_frase']['file']);
            $this->db->set('order',$this->getNextOrder($category));
    		$this->db->insert('tbl_products');
            $id = $this->db->insert_id();
            if(!empty($id))
              return $this->saveBrands($id);
            else
              return false;
    	}
    }

    public function reorder($items = null, $grid = true)
      {
        if(!$grid) $items = $this->getAll();
        $order = count($items);
        foreach($items as $item){
          $this->db->where('product_id', ($grid) ? $item['item_id'] : $item->product_id);
          $this->db->set('order', $order);
          if(!$this->db->update('tbl_products')) return false;
          $order--;
        }
        return true;
      }

    public function saveBrands($product_id)
    {
      //var_dump($_POST);die;
      $array_brands = $this->input->post('brands');
      //$array_qtde = $this->input->post('size_quantity');
      $this->db->where('product_id',$product_id);
      $this->db->delete('tbl_products_brands_rel');
      if(!empty($array_brands)){
        foreach($array_brands as $k=>$a)
        {
          if($a != ''){
            $this->db->set('product_id',$product_id);
            $this->db->set('product_brand_id',$a);
            $this->db->insert('tbl_products_brands_rel');
          }
        }
      }
      return true;
    }
    
	/* get data */
	
    public function getByAlias($alias=0){
        if(!empty($alias)){
            $this->db->select('P.*');
            if ($this->uri->segment('1') != 'gerenciador'){
                if($this->session->userdata('lang')=='en'){
                    $this->db->select('P.name_en as name');
                    $this->db->select('P.type_en as type');
                    $this->db->select('P.description_en as description');
                    $this->db->select('P.frase_p1_en as frase_p1');
                    $this->db->select('P.frase_p2_en as frase_p2');
                    $this->db->select('P.frase_p3_en as frase_p3');
                }
            }
            $this->db->from('tbl_products AS P');
            $this->db->where('P.alias', $alias);
            $query = $this->db->get('tbl_products');
            return $query->row();
        }
        return FALSE;
      }

      public function getByOrder($order=0,$category=0){
        if(!empty($order)){
            $this->db->where('product_category_id',$category);
            $this->db->where('order', $order);
            $query = $this->db->get('tbl_products');
            return $query->row();
        }
        return FALSE;
    }

	public function get($id=0){
		if(!empty($id)){
			$this->db->where('product_id',$id);
   			$query = $this->db->get('tbl_products');
   			return $query->row();
		}
		return FALSE;
    }

    public function getFirst($category=0){
        if(!empty($category)){
            $this->db->order_by('order', 'desc');
            $this->db->where('product_category_id',$category);
            $query = $this->db->get('tbl_products');
            return $query->row();
        }
        return FALSE;
    }
   
 	public function getAll($visible=true,$category=0,$brand=0,$max=null){
        $this->db->distinct();
        $this->db->select('P.*');
        if ($this->uri->segment('1') != 'gerenciador'){
            if($this->session->userdata('lang')=='en'){
                $this->db->select('P.name_en as name');
                $this->db->select('P.type_en as type');
                $this->db->select('P.description_en as description');
                $this->db->select('P.frase_p1_en as frase_p1');
                $this->db->select('P.frase_p2_en as frase_p2');
                $this->db->select('P.frase_p3_en as frase_p3');
            }
        }
 		$this->db->from('tbl_products AS P');
        $this->db->order_by('P.order', 'desc');

        if(!empty($brand)){
            $this->db->join('tbl_products_brands_rel as R','P.product_id = R.product_id');
            $this->db->where('product_brand_id',$brand);
        }    
        if($visible) $this->db->where('P.visible',1);
        if(!empty($category)) $this->db->where('P.product_category_id',$category);

        if(!empty($max)) $query = $this->db->get('tbl_products');
        else $query = $this->db->get('tbl_products',$max,0);

 		return $query->result();
 	}

    public function getNextOrder($category) {
        return count($this->getAll(false,$category)) + 1;
    }    
   	
    public function getMyBrands($product_id){
       $ret = null;
       $this->db->where('product_id',$product_id);
       $query = $this->db->get('tbl_products_brands_rel');
       $retorno = $query->result();
       if(!empty($retorno)){
         foreach($retorno as $r){
            $ret[] = $r->product_brand_id;
         }
       }
       return $ret;
    }

	/* delete data */

    public function deleteAllByCategory($id){
        if(!empty($id)){
            $products = $this->getAll(false,$id);
            if(!empty($products)){
                foreach ($products as $key => $p) {
                    $this->delete($p->product_id);
                }
            }
            return true;
        }
        return FALSE;
    }


   	public function delete($id){
    	if(!empty($id)){
            $this->deleteImage($id);
	    	$this->db->where('product_id',$id);
	    	return $this->db->delete('tbl_products');
    	}
    	return FALSE;
    }

    private function deleteImage($id,$spec=null){
          if(!empty($id)){

            $item = $this->get($id);
            
            if($spec == null || $spec == 'img')
            {
                $img = PRODUCTS_UPLOAD_PATH.$item->product_category_id.'/'.$item->img;
                @unlink($img);
            }
            if($spec == null || $spec == 'img_thumb')
            {
                $img = PRODUCTS_UPLOAD_PATH.$item->product_category_id.'/'.$item->img_thumb;
                @unlink($img);
            }
            if($spec == null || $spec == 'img_bg')
            {
                $img = PRODUCTS_UPLOAD_PATH.$item->product_category_id.'/'.$item->img_bg;
                @unlink($img);
            }
            if($spec == null || $spec == 'img_frase')
            {
                $img = PRODUCTS_UPLOAD_PATH.$item->product_category_id.'/'.$item->img_frase;
                @unlink($img);
            }
            if($spec == null || $spec == 'img_bootle')
            {
                $img = PRODUCTS_UPLOAD_PATH.$item->product_category_id.'/'.$item->img_bootle;
                @unlink($img);
            }

          }
          return TRUE;
    }
}