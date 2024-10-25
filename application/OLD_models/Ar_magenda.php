<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ar_MAgenda extends CI_Model {

   function __construct(){ parent::__construct(); }

   /* save data */
   
   public function save(){
      $id = $this->input->post('ar_agenda_id');
      $dia = $this->input->post('dia');
      $hora = $this->input->post('hora');
      

      //var_dump($dia.' '.$hora);die;

      $this->db->set('data',dateBRtoUS($dia).' '.$hora.':00');
      SetData('titulo');
      SetData('texto','html');
  
  
      if(!empty($id)){        
        $this->db->where('ar_agenda_id',$id);
        return $this->db->update('ar_agenda');
      }else{
        return $this->db->insert('ar_agenda');
      }
    }
   
   /* get data */
	public function get($id=0){
		if(!empty($id)){
			$this->db->where('ar_agenda_id',$id);
   			$query = $this->db->get('ar_agenda');
   			return $query->row();
		}
		return FALSE;
   	}   
   
   	public function getAll($year=0, $month=0, $day=0){
        $this->db->order_by('data','desc');
        
        if(!empty($year) && empty($day)) $this->db->where('((data >= "'.$year.'-'.$month.'-01" AND data <= "'.$year.'-'.$month.'-31"))',null,false);
        if(!empty($year) && !empty($day)) $this->db->where('(data >= "'.$year.'-'.$month.'-'.$day.' 00:00:00 " AND data <= "'.$year.'-'.$month.'-'.$day.' 23:59:59 ")',null,false);

        $query = $this->db->get('ar_agenda');
        //echo $this->db->last_query();die;
        return $query->result();

    }
   	
   	/* delete data */
   	   
	public function delete($id){
    	if(!empty($id)){
	    	$this->db->where('ar_agenda_id',$id);
	    	return $this->db->delete('ar_agenda');
    	}
    	return FALSE;
    }

}