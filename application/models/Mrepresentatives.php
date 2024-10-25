<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MRepresentatives extends CI_Model
{
    
    function __construct() {
        parent::__construct();
    }
    
    /* save data */    
  
    
    public function saveRepresentative() {
        $id = $this->input->post('representative_id');
        
        if (!empty($id)) {
            
            $this->db->set('name', $this->input->post('name'));
            $this->db->set('state', $this->input->post('state'));;
            $this->db->set('address', $this->input->post('address'));
            $this->db->set('phone', $this->input->post('phone'));
            $this->db->set('email', $this->input->post('email'));
            $this->db->where('representative_id', $id);
            return $this->db->update('tbl_representatives');
        } 
        else {
            
            $this->db->set('name', $this->input->post('name'));
            $this->db->set('state', $this->input->post('state'));;
            $this->db->set('address', $this->input->post('address'));
            $this->db->set('phone', $this->input->post('phone'));
            $this->db->set('email', $this->input->post('email'));
            $this->db->set('order', $this->getNextOrder('tbl_representatives'));
            $order = $this->getNextOrder('tbl_representatives');
            return $this->db->insert('tbl_representatives');
        }
    }
    
    
    public function reorderRepresentative($items = null, $grid = true) {
        if (!$grid) $items = $this->getAll('tbl_representatives');
        $order = count($items);
        foreach ($items as $item) {

            $this->db->where('representative_id', ($grid) ? $item['item_id'] : $item->representative_id);
            $this->db->set('order', $order);
            if (!$this->db->update('tbl_representatives')) return false;
            
            $order--;
        }
        return true;
    }
    
    
    
    public function get_state($estado = null) {
        if (!empty($estado)) {
            $this->db->where('symbol', $estado);
            $query = $this->db->get('regional_states');
            return $query->row();
        }
        return FALSE;
    }
    
    
    
    public function getAll($tbl = null) {
        $this->db->order_by('order', 'desc');
        $query = $this->db->get($tbl);
        return $query->result();
    }
    
    public function getAllestados($tbl = null) {
        $query = $this->db->get($tbl);
        return $query->result();
    }

      public function get_representative($id = 0) {
        if (!empty($id)) {
            $this->db->where('representative_id', $id);
            $query = $this->db->get('tbl_representatives');
            return $query->row();
        }
        return FALSE;
    }
    

    public function get_representativeState($estado = null) {
        if (!empty($estado)) {
            $this->db->where('state', $estado);
            $query = $this->db->get('tbl_representatives');
            return $query->result();
        }
        return FALSE;
    }
    public function getByOrder($order = 0) {
        if (!empty($order)) {
            $this->db->where('order', $order);
            $query = $this->db->get('tbl_banners');
            return $query->row();
        }
        return FALSE;
    }
    
    public function getNextOrder($tbl) {
        return count($this->getAll($tbl)) + 1;
    }
    
    /* delete data */
   
    
    public function deleteRepresentative($id) {
        if (!empty($id)) {
            if ($this->db->delete('tbl_representatives', array(
                'representative_id' => $id
            ))) {
                $this->reorderRepresentative(null, false);
                return true;
            }
        }
        return FALSE;
    }
}
