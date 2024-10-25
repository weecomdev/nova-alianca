<?php
class MY_Controller extends CI_Controller
{
    var $check_session = false;
    var $permitted_access = array('login');

    function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('logado') !== TRUE && ($this->check_session || $this->_checkPermittedAccess())) {
            $this->session->set_userdata('url', uri_string());
            redirect(site_url('gerenciador'), 'refresh');
        }

        if (!empty($this->session->userdata['lang'])) {
            if ($this->session->userdata['lang'] == 'es')
                $this->lang->load('home', 'spanish');
            else  if ($this->session->userdata['lang'] == 'en')
                $this->lang->load('home', 'english');
            else
                $this->lang->load('home', 'pt-br');
        } else {
            $this->session->set_userdata('lang', 'pt');
            $this->lang->load('home', 'pt-br');
        }

        // general use
        $this->load->model('ProductCategory');
        $this->load->model('Ar_FileCategory');
        $this->load->model('Product');
        $this->load->model('ContactData');
        if ($this->uri->segment('1') == 'gerenciador' && $this->_checkPermittedAccess())
            $this->data['texts'] = $this->Text->getAll();
        $this->data['page_title'] = '';
        $this->data['contact'] = $this->ContactData->get();

        $this->load->model('Product');
    }

    function setMessage($msg, $error = false, $info = false)
    {
        if ($error) {
            if (empty($this->session->userdata['msgErrors'])) $this->session->set_userdata('msgErrors', $msg);
            else $this->session->set_userdata('msgErrors', $this->session->userdata('msgErrors') . ". " . $msg);
        } elseif ($info) {
            if (empty($this->session->userdata['msgInfos'])) $this->session->set_userdata('msgInfos', $msg);
            else $this->session->set_userdata('msgInfos', $this->session->userdata('msgInfos') . ". " . $msg);
        } else {
            if (empty($this->session->userdata['msgSuccess'])) $this->session->set_userdata('msgSuccess', $msg);
            else $this->session->set_userdata('msgSuccess', $this->session->userdata('msgSuccess') . ". " . $msg);
        }
    }

    private function _checkPermittedAccess()
    {
        if ($this->uri->segment('1') == 'gerenciador') {
            if (array_search($this->router->class, $this->permitted_access) === FALSE)
                return TRUE;
        } else
            return FALSE;
    }

    public function do_upload($name, $base_dir, $allowed_types = '*', $max_size = 0)
    {
        if (!empty($_FILES[$name]['name'])) {
            if (!is_dir($base_dir)) create_dirs_recursive($base_dir);

            $config['upload_path'] = $base_dir;
            $config['allowed_types'] = $allowed_types;
            $config['max_size'] = $max_size;
            $config['encrypt_name'] = true;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($name)) {
                $error = $this->upload->display_errors();

                return array('ok' => false, 'msg' => $error);

                $this->setMessage($this->lang->line('message_upload_error') . $error_message, true);

                return false;
            } else {
                $data = $this->upload->data();

                return array('ok' => true, 'msg' => '', 'file' => $data['file_name'], 'name' => $data['raw_name'], 'ext' => $data['file_ext']);
            }
        }
    }
}
