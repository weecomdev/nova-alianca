<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MDicas_imagem extends CI_Model {

    function __construct(){ parent::__construct(); }

   
  /* save data */
  var $tbl_main = 'tbl_dicas_images';
  var $id_main = 'dica_image_id';
      
    public function save($data,$id){
        $this->db->set('image', $data['image']);
        $this->db->set('dica_id', $id);
        $this->db->set('thumb_image', $data['thumb_image']);
        $this->db->set('order',$this->getNextOrder($id));
        $this->db->insert($this->tbl_main);
    }
    
  public function reorder($items = null, $grid = true)
  {
    if(!$grid) $items = $this->getAll();
    $order = count($items);
    foreach($items as $item){
      $this->db->where($this->id_main, ($grid) ? $item['item_id'] : $item->about_us_image_id);
      $this->db->set('order', $order);
      if(!$this->db->update($this->tbl_main)) return false;
      $order--;
    }
    return true;
  }
   
    
    /* get data */
  public function get($id=0){
    if(!empty($id)){
      $this->db->where($this->id_main,$id);
        $query = $this->db->get($this->tbl_main);
        return $query->row();
    }
    return FALSE;
    }
   
    public function getAll($id=0){
      $this->db->where('dica_id', $id);
      $this->db->order_by('order', 'desc');
      $query = $this->db->get($this->tbl_main);
      return $query->result();
    }
    
  public function getByOrder($order=0){
    if(!empty($order)){
        $this->db->where('order', $order);
          $query = $this->db->get($this->tbl_main);
          return $query->row();
        }
    return FALSE;
    }

    public function getFirst($id){
        if(!empty($id)){
            $this->db->order_by('order', 'desc');
            $this->db->where('dica_id', $id);
            $query = $this->db->get($this->tbl_main);
            return $query->row();
        }
        return FALSE;
    }
    
  public function getNextOrder($id) {
    return count($this->getAll($id)) + 1;
  }
    
    public function count()
    {
        $this->db->select('count(*) as total');
      $query = $this->db->get($this->tbl_main);
        $row = $query->row();
    return $row->total;
    }

    public function countImages($dica_id)
    {
        $this->db->select('count(*) as total');
        $this->db->where('dica_id',$dica_id);
      $query = $this->db->get($this->tbl_main);
        $row = $query->row();
    return $row->total;
    }



    /* delete data */
    
    private function deleteImage($id){
      if(!empty($id)){
        $item = $this->get($id);
      if(!empty($item->image)){
        $img = DICAS_IMAGES_UPLOAD_PATH.$item->image;
        @unlink($img);
        $img = DICAS_IMAGES_UPLOAD_PATH.$item->thumb_image;
        @unlink($img);
      }
      return TRUE;
      }
      return FALSE;
    }
    
  public function delete($id){
    $item = $this->get($id);
      if(!empty($item)){
      $this->deleteImage($id);

        $this->db->where($this->id_main,$id);
        if($this->db->delete($this->tbl_main)){
          $this->reorder(null, false);
          return true;
        }
      }
      return FALSE;
    }  

}