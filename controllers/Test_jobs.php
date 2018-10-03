<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//session_unset();

class Jobs extends CI_Controller {

    public $settings = array(   'total_rows'        => 0,
                                'per_page'          => 10,
                                'num_links'         => 0,
                                'first_link'        => FALSE,
                                'last_link'         => FALSE,
                                'prev_link'         => 'PREVIOUS | ',
                                'next_link'         => 'NEXT | ',
                                'next_tag_open'     => '',
                                'next_tag_close'    => '',
                                'use_page_numbers'  => TRUE,
                                'display_pages'     => FALSE,
                                ); 

    protected $row_start        = 0;
    protected $row_amount       = 10;
    protected $row_total        = 0;

    protected $jobs_page_number = 0;
    protected $jobs_start       = 0;
    protected $jobs_end         = 0;
    protected $jobs_total       = 0;
    protected $base_path        = '';


    public function __construct()
    {
        parent::__construct();


        $this->load->database();
        $this->load->library('dropdown');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('session');
        $this->load->library('table'); 
        $this->load->library('user_session');
        $this->load->helper('form'); 
        $this->load->helper('html');
        $this->load->helper('url'); 

        echo link_tag('frame-work/version-2016-r1-v2/css/button-as-text.css');
        echo link_tag('frame-work/version-2016-r1-v2/css/main.css');
        echo link_tag('frame-work/version-2016-r1-v2/javascripts/modernizr.custom.js');

        $this->load->view('job/job_display_header_search');
        
        $this->load->model('procedures/job');
    }

    // --------------------------------------------------------------------------------------------
    // WEB CONTROLS
    // --------------------------------------------------------------------------------------------

    public function find_by_search($page_number=1,$switch = NULL)
    {

        $this->settings['base_url'] = 'http://10.3.5.56/index.php/jobs/find_by_search'; 

        $this->switch_controller($switch,'find_by_search');


        $this->uri_store_segments();
        $this->user_session->set();
        $this->search_form_rules();


        $validate = $this->search_form_validate();

        $this->search_form_display();

        
        if($validate == 'TRUE'){

            $this->page_display($page_number);

        }else{

            $this->page_display($page_number);
        }
    }

    public function find_by_id($uri_data = NULL, $switch = NULL)
    {
        //echo '*** find_by_id()</p>';
        $this->settings['base_url'] = 'http://10.3.5.56/index.php/jobs/find_by_id/'.$uri_data;

        $this->switch_controller($switch, 'find_by_id');

        if(!is_numeric($switch))
        {
            $page_number =  1;

        }else{

            $page_number =  $switch;
        }


        $this->uri_store_segments(); 
        $this->uri_store_job_ids($uri_data);
        $this->page_display($page_number );
    }

    public function page($page_number=1)
    {
        //echo '*** page()</p>';

        $this->settings['base_url'] = 'http://10.3.5.56/index.php/jobs/page'; 

        // -------------------------------------

        $this->switch_controller_for_page();

        // -------------------------------------

        echo 'uri_back : '.$this->session->userdata('uri_back').'</p>';
        echo 'uri_base : '.$this->session->userdata('uri_base').'</p>';


        $this->user_session->set();
        $this->page_display($page_number);
    }


    // --------------------------------------------------------------------------------------------
    // SWIRCH
    // --------------------------------------------------------------------------------------------

    private function switch_controller($switch, $method)
    {

        if($method == 'find_by_search'){

            $site       = site_url();
            $controller = $this->uri->segment(1);
            $method     = $this->uri->segment(2);
            $page       = 1;

            $data['switch_button_url']      =  site_url().'/'.$controller.'/'.$method.'/'.$page.'/switch';

            $this->session->set_userdata($data);
        }

        if($method == 'find_by_id'){

            $site       = site_url();
            $controller = $this->uri->segment(1);
            $method     = $this->uri->segment(2);
            $job_ids    = $this->uri->segment(3);

            $data['switch_button_url']      =  site_url().'/'.$controller.'/'.$method.'/'.$job_ids.'/switch';

            $this->session->set_userdata($data);
        }








        if($this->session->userdata('switch') == 2)
        {
            $data['switch']                 = $this->session->userdata('switch_old');
            $data['switch_button_text']     = $this->session->userdata('switch_button_text_old'); 

            $this->session->set_userdata($data);  
        }  


        if($switch == 'switch'){

            $page_number = 1;

            if($this->session->has_userdata('switch') == ''){

                $data['switch'] = '1';
                $data['switch_button_text']    = 'SWITCH ALL';

                $this->session->set_userdata($data);

            }else{

                $switch = $this->session->userdata('switch');

                if($switch == '1')
                {
                    $data['switch'] = '0';
                    $data['switch_button_text']    = 'SWITCH 5';
                }
                else if($switch == '0')
                {
                    $data['switch'] = '1';
                    $data['switch_button_text']    = 'SWITCH ALL';
            }
        }

        $data['switch_old']             =  $data['switch'];
        $data['switch_button_text_old'] =  $data['switch_button_text'];

        $this->session->set_userdata($data);

        }

        //echo 'Switch : '.$this->session->userdata('switch').'</p>';
        //echo 'SwitchOld : '.$this->session->userdata('switch_old').'</p>';
    }

    private function switch_controller_for_page()
    {
    

        //$site       = site_url();
        //$controller = $this->uri->segment(1);
        //$method     = $this->uri->segment(2);
        //$page       = 1;

        $data['switch']             = '2';
        $data['switch_button_text'] = 'BACK';
        $data['switch_button_url']  =  $this->session->userdata('uri_back');

             
        $this->session->set_userdata($data);

        //echo 'Switch : '.$this->session->userdata('switch').'</p>';
        //echo 'SwitchOld : '.$this->session->userdata('switch_old').'</p>';
    }

    // --------------------------------------------------------------------------------------------
    // SEARCH FORMS
    // --------------------------------------------------------------------------------------------

    private function page_display($page_number)
    {
        //echo '*** page_display($page_number['.$page_number.'])</p>';

        $uri_base = $this->session->userdata('uri_base');

        //echo '$uri_base = '.$uri_base.'</p>';

        if($uri_base == 'jobs/find_by_search')
        {
            $uri_path       = $this->session->userdata('uri_base');
            $total_rows     = $this->job_get_by_search_total_rows();

            if($total_rows == 0){

                $this->load->view('job/job_display_none');

            }
            else
            {
                $this->paginator_init($page_number);
                $this->paginator_display_controlls($uri_path );

                $this->job_get_by_search();

                $this->paginator_init($page_number);
                $this->paginator_display_controlls($uri_path);   
            }

    
        }

        if($uri_base == 'jobs/find_by_id')
        {
            $uri_back = $this->session->userdata('uri_back');

            $this->job_get_by_id_total_rows();

            $this->paginator_init($page_number);
            $this->paginator_display_controlls($uri_back);

            $this->job_get_by_id();

            $this->paginator_init($page_number);
            $this->paginator_display_controlls($uri_back);
        }
    }

    // --------------------------------------------------------------------------------------------
    // SEARCH FORMS
    // --------------------------------------------------------------------------------------------

    private function search_form_rules()
    {
        $config = array(

                    array(
                        'field'     => 'keyword',
                        'label'     => 'Keyword',
                        'rules'     => 'trim|min_length[2]|max_length[60]|regex_match[/^[a-zA-Z0-9,.!?+# ]*$/]',
                        'errors'    => array(
                                        'min_length' => 'You must provide a %s with 3 characters minimum',
                                        'max_length' => 'You must provide a %s with 60 characters maximum',
                                        'regex_match' => 'For %s only characters, numbers and punctuation are allowed.'),
                        'value'     => $this->session->userdata('keyword')
                        ),
                    array(
                        'field'     => 'location',
                        'label'     => 'Location',
                        'rules'     => 'trim|min_length[3]|max_length[60]|regex_match[/^[a-zA-Z0-9,.!? ]*$/]',
                        'errors'    => array(
                                        'min_length' => 'You must provide a %s with 3 characters minimum',
                                        'max_length' => 'You must provide a %s with 60 characters maximum',
                                        'regex_match' => 'For %s only characters, numbers and punctuation are allowed.'),
                        'value'     => $this->session->userdata('location')
                        ),
                    array(
                        'feild'     => 'job_type',
                        'label'     => 'job_type',
                        'rules'     => 'required',
                        'errors'    => array(
                                        'required' => 'Please select job type.'),
                        'value'     => $this->session->userdata('job_toggle')
                        )
                    );


        // VALUE FOR JOBTYPE MAY NEED TO BE CHANGED

         $this->form_validation->set_rules($config); 
    }

    private function search_form_display()
    {
        // --------------------------------------------------------------------------------------------
        // LOAD JOBS FORMS
        // --------------------------------------------------------------------------------------------

        $search_data['keyword']     = $this->session->userdata('keyword');
        $search_data['location']    = $this->session->userdata('location');
        $search_data['job_type']    = $this->session->userdata('job_type');
                
        $this->load->view('forms/form_job_search',$search_data );
    }

    private function search_form_validate()
    {

        if ($this->form_validation->run() == FALSE)
        {
            $error = validation_errors();

            return 'FALSE';
            
        }else{

            return 'TRUE';
        }
    }

    // --------------------------------------------------------------------------------------------
    // PREPARE PARAMETERS FOR JOB SEARCH FORM DATA-BASE
    // --------------------------------------------------------------------------------------------

    private function job_get_by_search()
    {
        //echo '*** job_get_by_search()</p>';
    
        $keyword        = $this->session->userdata('keyword');
        $location       = $this->session->userdata('location');
        $country_id     = 'NULL'; 
        $job_type_id    = $this->session->userdata('job_type') == NULL ? '1' : $this->session->userdata('job_type');
        $brand_id       = 'NULL'; 
        $row_start      = $this->row_start; 
        $row_amount     = $this->row_amount;

        
        $data['query']      = $this->job->search(   $keyword, 
                                                    $location, 
                                                    $country_id, 
                                                    $job_type_id, 
                                                    $brand_id, 
                                                    $row_start, 
                                                    $row_amount);

        
        $data['row_index']  = $this->row_index;
        $data['uri_path']   = 'jobs/page';

        $this->job_display_selection($data);
    }

    private function job_get_by_search_total_rows()
    {
        //echo '*** job_get_by_search_total_rows()</p>';

        $keyword        = $this->session->userdata('keyword');
        $location       = $this->session->userdata('location');
        $country_id     = 'NULL'; 
        $job_type_id    = $this->session->userdata('job_type') == NULL ? '1' : $this->session->userdata('job_type');
        $brand_id       = 'NULL'; 


        $total_rows     =  $this->job->search_row_count(    $keyword, 
                                                            $location, 
                                                            $country_id, 
                                                            $job_type_id, 
                                                            $brand_id);

        $this->session->set_userdata(array('total_rows'  => $total_rows));

        $this->job->close();

        return $total_rows;
    }

    // --------------------------------------------------------------------------------------------
    // PREPARE PARAMETERS FOR JOB GET FORM DATA-BASE
    // --------------------------------------------------------------------------------------------

    private function job_get_by_id()
    {
        $job_ids     = $this->session->userdata('job_ids');
        $deleted     = 0;
        $expired     = 0;
        $row_start   = $this->row_start; 
        $row_amount  = $this->row_amount;

        $this->load->model('procedures/job');

        $data['query']          = $this->job->get(  $job_ids, 
                                                    $deleted, 
                                                    $expired, 
                                                    $row_start, 
                                                    $row_amount);
        
        $data['row_index']  = $this->row_index;
        $data['uri_path']   = 'jobs/page';

        $this->job_display_selection($data);
    }

    private function job_get_by_id_total_rows()
    {
       //echo '*** job_get_by_id_total_rows()</p>';

        $job_id     = $this->session->userdata('job_ids');
        $deleted    = 0;
        $expired    = 0;

        $this->load->model('procedures/job');

        $total_rows = $this->job->get_row_count(    $job_id,
                                                    $deleted,
                                                    $expired);

        $this->session->set_userdata(array('total_rows'  => $total_rows));

        $this->job->close();

        return $total_rows;
    }

    // -------------------------------------------------------------------------------------------
    // SEND JOB DATA FOR DISPLAY
    // -------------------------------------------------------------------------------------------

    private function job_display_selection($data)
    {
        $toggle = $this->session->userdata('switch');

        if($toggle == 0)
        {
            $this->load->view('job/job_display_small', $data);  
        }

        if($toggle == 1)
        {
            $this->load->view('job/job_display_medium', $data);
        }

        if($toggle  == 2)
        {
            $this->load->view('job/job_display_large', $data);
        }
    }  

    // -------------------------------------------------------------------------------------------
    // DISPLAY PAGE AND PAGINATOR
    // -------------------------------------------------------------------------------------------


    private function paginator_init($page_number=1)
    {
        //echo '*** paginator_init()</p>';

        $this->settings['total_rows'] = $this->session->userdata('total_rows');

        $page = $this->uri->segment(3, 1);

        $this->pagination->set_page($page);

        // -------------------------------------------------------------------------------------------
        // DEFINE PER PAGE VALUES
        // -------------------------------------------------------------------------------------------

        $toggle = $this->session->userdata('switch');

        if($toggle == 0){
        
          $this->settings['per_page'] = $this->settings['total_rows']; 

        }else if($toggle == 1){

            $this->settings['per_page'] = 5; 

        }else if($toggle == 2){

            $this->settings['per_page'] = 1; 
        }

        // -------------------------------------------------------------------------------------------
        // END DEFINE PER PAGE VALUES
        // -------------------------------------------------------------------------------------------

        // -------------------------------------------------------------------------------------------
        // CALCULATE DISPLAY DETAILS
        // -------------------------------------------------------------------------------------------

        $start  =  ($this->settings['per_page'] * ($page_number - 1) + 1);
        $end    =  ($this->settings['per_page'] * $page_number);
        $total  =  $this->settings['total_rows'];

        $start == 0  ? $start = 1: $start; 
        $end > $total ? $end = $total : $end;

        // -------------------------------------------------------------------------------------------
        // END CALCULATE DISPLAY DETAILS
        // -------------------------------------------------------------------------------------------

        // -------------------------------------------------------------------------------------------
        // PREPARE DISPLAY DETAILS
        // -------------------------------------------------------------------------------------------


        $this->jobs_page_number = $page_number;
        $this->jobs_start       = $start;
        $this->jobs_end         = $end;
        $this->jobs_total       = $total;

        // -------------------------------------------------------------------------------------------
        // END PREPARE DISPLAY DETAILS
        // -------------------------------------------------------------------------------------------

        // -------------------------------------------------------------------------------------------
        // CALCULATE JOBS TO LOAD
        // -------------------------------------------------------------------------------------------

        $this->row_start    =  $start-1;
        $this->row_amount   =  $this->settings['per_page'];
        $this->row_index    =  (($page_number - 1) *  $this->row_amount) ;

        // -------------------------------------------------------------------------------------------
        // CALCULATE JOBS TO LOAD
        // -------------------------------------------------------------------------------------------
    }


    private function paginator_display_controlls($uri_path)
    {

        $data['switch_button_text']     = $this->session->userdata('switch_button_text');
        $data['switch_button_url']      = $this->session->userdata('switch_button_url');
        $data['jobs_per_page']          = $this->row_amount;
        $data['jobs_page_number']       = $this->jobs_page_number;
        $data['jobs_start']             = $this->jobs_start;
        $data['jobs_end']               = $this->jobs_end;
        $data['jobs_total']             = $this->jobs_total;
        //
        $data['pagination']             = $this->pagination;
        $data['settings']               = $this->settings;
        //
        $data['uri_path']               = $uri_path;


        $this->load->view('job/job_paginator_controls', $data);
    }

    // -------------------------------------------------------------------------------------------
    // SET URI CONTROL
    // -------------------------------------------------------------------------------------------

    private function uri_store_segments()
    {
        $controller = $this->uri->segment(1);
        $method     = $this->uri->segment(2);
        $data       = $this->uri->segment(3,0);

        $this->session->set_userdata(array('uri_back'  => uri_string()));
        $this->session->set_userdata(array('uri_base' => $controller.'/'.$method));
    }

    private function uri_store_job_ids($uri_data = NULL)
    {

        //echo '*** uri_store_job_ids()</p>';

        if($uri_data != NULL)
        {

            $array_explode = explode( '-', $uri_data);
            $array_implode = implode(",", $array_explode);

        }else{

            $array_implode = NULL;
        }

        //echo '$array_implode:[] = '.$array_implode.'</p>';

        $this->session->set_userdata(array('job_ids'  => $array_implode ));
    }

    private function uri_for_paginator_settings()
    {
        $controller = $this->uri->segment(1);
        $method     = $this->uri->segment(2);
        //$data       = $this->uri->segment(3,0);

        echo site_url().$controller.'/'.$method;

        $this->settings['base_url'] = site_url().'/'.$controller.'/'.$method;

        //$this->session->set_userdata(array('uri_back'  => uri_string()));
        //$this->session->set_userdata(array('uri_base' => $controller.'/'.$method)); 
    }
}


