<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {

    function __construct(){ parent::__construct(); }

    /* save data */
    public function save()
    {
        $user_id = $this->input->post('user_id');
        SetData('name');
        SetData('email', 'lc');
        SetData('level');

        if($this->input->post('password') != '') SetData('password', 'pass');

        if(!empty($user_id)) {
            $this->db->where('user_id', $this->input->post('user_id'));
            return $this->db->update('tbl_users');
        } else {
            $this->db->set('record', time());
            return $this->db->insert('tbl_users');
        }
    }

    /* get data */
    public function get($user_id)
    {
        if (isInt($user_id)) {
            $this->db->where('user_id', $user_id);
            $query = $this->db->get('tbl_users');
            return $query->row();
        }
        return FALSE;
    }

    public function getByUserName($email, $id)
    {
        if (!empty($email)) {
            $this->db->where('email', $email);
            if (!empty($id)) $this->db->where('user_id !=', $id);
            $query = $this->db->get('tbl_users');
            return $query->row();
        }
        return FALSE;
        }

    public function getAll()
    {
        $query = $this->db->get('tbl_users');
        return $query->result();
    }


    /* delete data */
    public function delete($user_id)
    {
        if (isInt($user_id)) {
            $this->db->where('user_id', $user_id);
            return $this->db->delete('tbl_users');
        }
        return FALSE;
    }

    /* helpers */
    /* Checa se o usuário e senha são váluser_idos */
    public function doLogin($email, $senha)
    {
        $this->db->where('email', $email)->where('password', md5($senha.$this->config->item('encryption_keyname')));
        $query = $this->db->get('tbl_users');
        return $query->num_rows() == 1 ? $query->row() : FALSE;
    }

    /* Marca último acesso do usuario */
    public function setLastLogin($user_id)
    {
        $dados = array(
            'last_ip' => $_SERVER['REMOTE_ADDR'],
            'last_login' => time()
        );

        $this->db->where('user_id', $user_id)
            ->update('tbl_users', $dados);
    }
}
