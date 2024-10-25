<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produtos extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('Product');
        $this->load->model('ProductBrand');
    }

	public function index()
	{
		$this->load->view('produtos', $this->data);
	}

    public function get_product_list($category_alias){
        $category = $this->ProductCategory->getByAlias($category_alias);
        $this->data['brands'] = $this->ProductCategory->getBrandsByCategory($category->product_category_id);
        $this->data['category'] = $category;
        $this->data['products'] = $this->Product->getAll(true,$category->product_category_id);
        $return['produtos'] = $this->load->view('_produtos_lista', $this->data, true);
        echo json_encode($return);
    }

    public function get_marcas_list($brand_alias){
        $brand = $this->ProductBrand->getByAlias($brand_alias);
        $this->data['categories'] = $this->ProductCategory->getAll();
        $this->data['brand'] = $brand;
        $this->data['products'] = $this->Product->getAll(true,0,$brand->product_brand_id);
        $return['produtos'] = $this->load->view('_marcas_lista', $this->data, true);
        echo json_encode($return);
    }

    public function detalhes($category='',$product='')
    {
        $category = $this->ProductCategory->getByAlias($category);

        if(empty($product)) $product = $this->Product->getFirst($category->product_category_id);
        else $product = $this->Product->getByAlias($product);

        $total = count($this->Product->getAll(true,$category->product_category_id));
        $order = $product->order;
        if(($order+1)<=$total){
            $next = $order + 1;
        }else{
            $next = 1;
        }
        if(($order-1) > 0){
            $prev = $order - 1;
        }else{
            $prev = $total;
        }
        $this->data['category'] = $category;
        $this->data['product'] = $product;
        $this->data['next'] = $this->Product->getByOrder($next,$category->product_category_id);
        $this->data['prev'] = $this->Product->getByOrder($prev,$category->product_category_id);
       // echo $order.' '.$prev.' '.$next.' '.$category->product_category_id;
       // var_dump( $this->data['prev']);var_dump( $this->data['next']);die;
        $this->load->view('produtos_detalhes', $this->data);
    }
}
?>