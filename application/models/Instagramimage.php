<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class InstagramImage extends CI_Model {

    function __construct(){ parent::__construct(); }

    var $tbl_main = 'tbl_instagram';
    var $id_main = 'image_id';
    
    /* save data */
    public function save($data){
      	$this->db->set('image_id', $data['image_id']);
        $this->db->set('img', $data['img']);
        $this->db->set('date', $data['time']);
        $this->db->set('likes', $data['likes']);
        $this->db->set('comments', $data['comments']);
        $this->db->set('profile_pic', $data['profile_pic']);
        $this->db->set('user_name', $data['user_name']);
        $this->db->set('link', $data['link']);
        $this->db->set('black_list',1);
      	return $this->db->insert($this->tbl_main);
    }

    public function update($data){
        $this->db->where('image_id', $data['image_id']);
        $this->db->set('likes', $data['likes']);
        $this->db->set('comments', $data['comments']);
        return $this->db->update($this->tbl_main);
    }

     public function get($id=0){
        if(!empty($id)){
         $this->db->where($this->id_main,$id);
         $query = $this->db->get($this->tbl_main);
         return $query->row();
       }
       return FALSE;
     }
 
     public function getAll($diff_id = 0){
        if(!empty($diff_id)) $this->db->where('instagram_id >' ,$diff_id);
        $this->db->order_by('instagram_id', 'desc');
        $query = $this->db->get($this->tbl_main);

        return $query->result();
            echo $this->db->last_query();
        die;
     }

     public function getMedia($limit=31){
        $this->db->order_by('instagram_id', 'desc');
        $this->db->where('black_list',0);
        $this->db->limit($limit);
        $query = $this->db->get($this->tbl_main);

        return $query->result();
            echo $this->db->last_query();
        die;
     }

     public function isInBlackList($id){
        $this->db->select('count(*) as total');
        $this->db->where('image_id', $id);
        $this->db->where('black_list', 1);
        $query = $this->db->get($this->tbl_main);
        return $query->row()->total;
     }

     public function saveBlackList($image_id, $value){
        $this->db->where('image_id', $image_id);
        $this->db->set('black_list', $value);
        return $this->db->update($this->tbl_main);
    }
}