<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Area_Restrita extends MY_Controller {

	function __construct()
	{
		parent::__construct();

        
        $prefs = array (
               'start_day'    => 'sunday',
               'month_type'   => 'long',
               'day_type'     => 'long',
               'template'     => '

       {table_open}<table border="0" cellpadding="0" cellspacing="0">{/table_open}
    
       {heading_row_start}<tr>{/heading_row_start}
    
       {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
       {heading_title_cell}{/heading_title_cell}
       {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
    
       {heading_row_end}</tr>{/heading_row_end}
    
       {week_row_start}<tr class="weekday">{/week_row_start}
       {week_day_cell}<td>{week_day}</td>{/week_day_cell}
       {week_row_end}</tr>{/week_row_end}
    
       {cal_row_start}<tr>{/cal_row_start}
       {cal_cell_start}<td>{/cal_cell_start}
    
       {cal_cell_content}<div class="day_content">
       <a href="{content}">
            {type}
            <div class="number">{day}</div>
       </a></div>
       {/cal_cell_content}
       {cal_cell_content_today}
       <div class="day_content">
       <a href="{content}">
            {type}
            <div class="number">{day}</div>
       </a></div>
       {/cal_cell_content_today}
    
       {cal_cell_no_content}<div class="day"><div class="number">{day}</div></div>{/cal_cell_no_content}
       {cal_cell_no_content_today}<div class="day"><div class="number">{day}</div></div>{/cal_cell_no_content_today}
    
       {cal_cell_blank}&nbsp;{/cal_cell_blank}
    
       {cal_cell_end}</td>{/cal_cell_end}
       {cal_row_end}</tr>{/cal_row_end}
    
       {table_close}</table>{/table_close}
        '
                
        );

        $this->load->library('calendar', $prefs);
        $this->load->model('Ar_MAgenda');
        $this->load->model('Ar_File');
        $this->load->model('Ar_FileCategory');
    }

    public function index()
    {
        if($this->test_access(2)) redirect('area_restrita/agenda');
        if($this->test_access(1) || $this->test_access(3)){ 
            $this->data['categories'] = $this->Ar_FileCategory->getAll($this->session->userdata('ar_user_profile'));
            $this->load->view('area_restrita', $this->data);
        }else{
            redirect('#!/area_restrita/login');
        }
    }

    public function get_docs(){
        if($this->test_access(1) || $this->test_access(3)){ 
            $category = $this->input->post('cat');
            if(empty($category)) $category = null;
            $query = $this->input->post('query');
            if(empty($query)) $query = null;

            $this->data['docs'] = $this->Ar_File->getAll($category,$this->session->userdata('ar_user_profile'),$query);

            echo $this->load->view('_ajax_docs', $this->data, true);
        }else{
            echo 0;
        }
       // echo json_encode($return);
    }

    public function agenda($year=0,$month=0)
    {     
        if(!$this->test_access(2)) redirect('#!/area_restrita/login');

        if((empty($year))&&(empty($month))){
            $year = date('Y');
            $month = date('m');
        }

        $this->data['year'] = $year;
        $this->data['month'] = $month;
        
        $this_month = $this->Ar_MAgenda->getAll($year,$month);
        $data = '';
        for ($day=1; $day < cal_days_in_month(CAL_GREGORIAN, $month, $year); $day++) { 
            $events = $this->Ar_MAgenda->getAll($year,$month,$day);
            if(!empty($events)){
                $e_str = '';
                foreach($events as $e){
                    $datetime = explode(' ',$e->data);
                    $time = explode(':',$datetime[1]);
                    $e_str .= '<div class="hora">'.$time[0].':'.$time[1].'</div><div class="title">'.$e->titulo.'</div>';
                }
                $data[$day] = array();
                $data[$day]['type'] = $e_str;
                $data[$day]['content'] = '#!/data/'.$year.'/'.$month.'/'.$day;
            }
        }

        $this->data['data'] = $data;
        $this->data['events'] = $this_month;

        if ($month == 12)
        {
           $next_month = 1;
           $next_year = $year+1;
        }else{
           $next_month = $month+1;
           $next_year = $year;
        }
        if ($month == 1)
        {
           $prev_month = 12;
           $prev_year = $year-1;
        }else{
           $prev_month = $month-1;
           $prev_year = $year;
        }

        $this->data['prev_year'] = $prev_year;
        $this->data['prev_month'] = $prev_month;
        $this->data['next_year'] = $next_year;
        $this->data['next_month'] = $next_month;

        $this->load->view('ar_agenda', $this->data);
    }

    public function agenda_get()
    {
        if(!$this->test_access(2)) echo 0;

        $day = $this->input->post('day');
        $year = $this->input->post('year');
        $month = $this->input->post('month');

        $this->data['eventos'] = $this->Ar_MAgenda->getAll($year,$month,$day);

        $return['result'] = $this->load->view('_ajax_agenda', $this->data, true);
        echo json_encode($return);
    }

	public function login()
	{
        $return['result'] = $this->load->view('_ajax_login', $this->data, true);
        echo json_encode($return);
	}

    public function do_login()
    {
        $this->load->model('Ar_User');
        $email = $this->input->post('email');
        $senha = $this->input->post('password');
        if ($usuario = $this->Ar_User->doLogin($email, $senha)) {
            // create session
            $this->session->set_userdata('logado', TRUE);
            $this->session->set_userdata('ar_user_id', $usuario->ar_user_id);
            $this->session->set_userdata('ar_user_profile', $usuario->profile_id);
            $this->session->set_userdata('ar_user_email', $usuario->email);
            $this->session->set_userdata('ar_user_name', $usuario->name);
            $this->Ar_User->setLastLogin($usuario->ar_user_id);
            
            echo 1;
        } else {
            echo 0;
        }

    }

    public function do_logout()
    {
        $this->session->sess_destroy();
        redirect('', 'refresh');
    }

    public function test_access($profile){
        $user_profile = $this->session->userdata('ar_user_profile');
        if($profile == $user_profile) return true;
        else return false;
    }
}
?>