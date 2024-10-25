<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ar_User extends CI_Model {

    function __construct(){ parent::__construct(); }

    /* save data */
    public function save()
    {
        $user_id = $this->input->post('ar_user_id');
        SetData('name');
        SetData('email', 'lc');
        SetData('profile_id');

        if($this->input->post('password') != '') SetData('password', 'pass');

        if(!empty($user_id)) {
            $this->db->where('ar_user_id', $this->input->post('ar_user_id'));
            return $this->db->update('ar_users');
        } else {
            $this->db->set('record', time());
            return $this->db->insert('ar_users');
        }
    }

    /* get data */
    public function get($user_id)
    {
        if (isInt($user_id)) {
            $this->db->where('ar_user_id', $user_id);
            $query = $this->db->get('ar_users');
            return $query->row();
        }
        return FALSE;
    }

    public function getByUserName($email, $id)
    {
        if (!empty($email)) {
            $this->db->where('email', $email);
            if (!empty($id)) $this->db->where('ar_user_id !=', $id);
            $query = $this->db->get('ar_users');
            return $query->row();
        }
        return FALSE;
        }

    public function getAll()
    {
        $query = $this->db->get('ar_users');
        return $query->result();
    }

    public function getProfiles()
    {
        $query = $this->db->get('ar_users_profiles');
        return $query->result();
    }

    public function getProfile($profile_id)
    {
        if (isInt($profile_id)) {
            $this->db->where('ar_user_profile_id', $profile_id);
            $query = $this->db->get('ar_users_profiles');
            return $query->row();
        }
        return FALSE;
    }


    /* delete data */
    public function delete($user_id)
    {
        if (isInt($user_id)) {
            $this->db->where('ar_user_id', $user_id);
            return $this->db->delete('ar_users');
        }
        return FALSE;
    }

    /* helpers */
    /* Checa se o usuário e senha são váluser_idos */
    public function doLogin($email, $senha)
    {
        $this->db->where('email', $email)->where('password', md5($senha.$this->config->item('encryption_keyname')));
        $query = $this->db->get('ar_users');
        return $query->num_rows() == 1 ? $query->row() : FALSE;
    }

    /* Marca último acesso do usuario */
    public function setLastLogin($user_id)
    {
        $dados = array(
            'last_ip' => $_SERVER['REMOTE_ADDR'],
            'last_login' => time()
        );

        $this->db->where('ar_user_id', $user_id)
            ->update('ar_users', $dados);
    }
}
