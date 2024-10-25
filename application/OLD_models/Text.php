<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Text extends CI_Model {

   function __construct(){ parent::__construct(); }

   /* save data */
   public function save($data=null)
   {
        if(!empty($data)){
            foreach($data as $k=>$d){
                if(is_array($d)){
                    $this->db->set('text',$d['text'],'html');
                    $this->db->set('text_en',$d['text_en'],'html');
                    $this->db->where('alias', $k);
                    $this->db->update('tbl_texts');
                }else{
                    $img = TEXT_IMAGES_UPLOAD_PATH.$this->getText($k);
                    @unlink($img);
                    $this->db->set('text',$d,'html');
                    $this->db->where('alias', $k);
                    $this->db->update('tbl_texts');
                }
            }               
        }
        return true;
   }
   
   /* get data */
   
   public function getByAlias($txt_alias=null)
   {
        if (!empty($txt_alias)) {
            $this->db->where('alias', $txt_alias);
            $query = $this->db->get('tbl_texts');
             return $query->row();
        }
        return FALSE;
   }

   public function get($txt_alias=null,$only_pt=false)
   {
        if (!empty($txt_alias)) {
            $this->db->select('*');
            if ($this->uri->segment('1') != 'gerenciador'){
                if($this->session->userdata('lang')=='en'){
                    if(!$only_pt) $this->db->select('text_en as text');
                }
            }
             $this->db->where('alias', $txt_alias);
             $query = $this->db->get('tbl_texts');
             return $query->row();
        }
        return FALSE;
   }
   
    public function getText($txt_alias=null,$br=false,$only_pt=false)
   {
        if (!empty($txt_alias)) {
             $text = $this->get($txt_alias, $only_pt);
             if($br)
                return nl2br($text->text);
             else 
                return $text->text;
        }
        return FALSE;
   }

   public function getTextEn($txt_alias=null,$br=false)
   {
        if (!empty($txt_alias)) {
             $text = $this->get($txt_alias);
             if($br)
                return nl2br($text->text_en);
             else {
                return $text->text_en;
            }
        }
        return FALSE;
   }
   
   public function getByID($txt_id=0)
   {
      if (isInt($txt_id)) {
         $this->db->where('text_id', $txt_id);
         $query = $this->db->get('tbl_texts');
         return $query->row();
      }
      return FALSE;
   }

   public function getAll()
   {
      $query = $this->db->get('tbl_texts');
      return $query->result();
   }
}