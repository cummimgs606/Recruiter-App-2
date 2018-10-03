<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_unset();

class Jobs extends CI_Controller {

    public $settings = array(   'total_rows'        => 0,
                                'per_page'          => 10,
                                'num_links'         => 0,
                                'first_link'        => FALSE,
                                'last_link'         => FALSE,
                                'prev_link'         => '',
                                'next_link'         => '',
                                'next_tag_open'     => '',
                                'next_tag_close'    => '',
                                'use_page_numbers'  => TRUE,
                                'display_pages'     => FALSE,
                                ); 
    
    protected $row_start                = 0;
    protected $row_amount               = 10;
    protected $row_total                = 0;

    protected $jobs_page_number         = 0;
    protected $jobs_start               = 0;
    protected $jobs_end                 = 0;
    protected $jobs_total               = 0;
    protected $base_path                = '';
    protected $validation               = '';

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
        $this->load->library('user_language');
        $this->load->helper('form'); 
        $this->load->helper('html');
        $this->load->helper('url'); 
        $this->load->model('procedures/job');

        //$this->user_language->set_by_iso2('jobs_lang', 'en');
    }

    // --------------------------------------------------------------------------------------------
    // WEB CONTROLS
    // --------------------------------------------------------------------------------------------
    public function search($page_number=1,$switch = NULL)
    {
        //echo '*** search()</p>';

        $this->set_language_search($page_number);
        $this->page_display_header();

        $this->uri_make_paginator_settings_search();
        $this->uri_make_switch_get();

        $this->uri_store_back();
        $this->uri_store_previous_method();
        $this->uri_make_page();

        $this->user_session->set();
        $this->switch_controller_generic($switch);

        $this->search_form_rules();
        $this->validation = $this->search_form_validate();
        $this->search_form_display();

        $this->page_display_search($page_number);
    }


    public function get($uri_data = 'all', $switch = NULL)
    {
        //echo '*** get()</p>';

        $this->set_language_get($switch);
        $this->page_display_header();

        $this->uri_store_back();
        $this->uri_store_previous_method();
        $this->uri_store_job_ids($uri_data);

        $this->uri_make_paginator_settings_get();
        $this->uri_make_switch_get();
        $this->uri_make_page(); 

        $this->user_session->set();
        $this->switch_controller_generic($switch);

        $this->page_display_get($switch);
    }

    public function page($page_number = 1, $switch = NULL)
    {
        //echo '*** page()</p>';

        $this->set_language_page();

        $this->page_display_header();

        $this->uri_make_paginator_settings_search();

        $this->switch_controller_page();

        $this->user_session->set();
        $this->page_display_page($page_number);
    }

    public function show($uri_data = 'all', $switch = NULL)
    {
        //echo '*** show()</p>';

        $this->set_language_page();
        $this->page_display_header();

        $this->uri_make_paginator_settings_get();
        $this->uri_make_switch_search();

        $this->uri_store_back();
        $this->uri_store_previous_method();
        $this->uri_store_job_ids($uri_data);
        $this->uri_make_page();

        $this->user_session->set();
        $this->session->set_userdata('total_rows',1);
        $this->session->set_userdata('switch', 2);

        $this->switch_controller_page();
        $this->page_display_show();
    }

    // --------------------------------------------------------------------------------------------
    // SET LANGUAGE
    // --------------------------------------------------------------------------------------------

    private function set_language_search($language_iso_2)
    {
        $this->user_language->set_by_mixed_input('jobs_lang', $language_iso_2);
    }

    private function set_language_get($language_iso_2)
    {
        if($language_iso_2 != 'switch')
        {
            $this->user_language->set_by_mixed_input('jobs_lang', $language_iso_2);
        }
    }  

    private function set_language_page()
    {
        $this->user_language->set_by_mixed_input('jobs_lang', $this->session->userdata('$language_iso_2'));
    }

    // --------------------------------------------------------------------------------------------
    // SWITCH CONTROLLER FOR PAGE LAYOUTS
    // --------------------------------------------------------------------------------------------

    private function switch_controller_generic($switch)
    {
        // --------------------------------------------------------------------------------------------

        if($this->session->userdata('switch') == ''){
            
            $data['switch'] = '1'; 
            $this->session->set_userdata($data); 
        }

        if($this->session->userdata('switch_old') == ''){
                
            $data['switch_old'] = '1';
            $this->session->set_userdata($data); 
        }

        // --------------------------------------------------------------------------------------------

        if($this->session->userdata('switch') == 2)
        {
            $data['switch'] = $this->session->userdata('switch_old');
            $this->session->set_userdata($data);  
        } 

        // -------------------------------------------------------------------------------------------- 

        if($switch == 'switch'){

            $page_number = 1;

            $data['switch']     = ($this->session->userdata('switch') == '1') ? '0' : '1';
            $data['switch_old'] =  $data['switch'];

            $this->session->set_userdata($data);
        }

        // --------------------------------------------------------------------------------------------

        if($this->session->userdata('switch') == '0')
        {
            $data['switch_button_text'] = $this->lang->line('button_show_less'); 
            $this->session->set_userdata($data);
        }

        if($this->session->userdata('switch') == '1')
        {
            $data['switch_button_text'] = $this->lang->line('button_show_more');
            $this->session->set_userdata($data);
        }

        // --------------------------------------------------------------------------------------------
    }

    private function switch_controller_page()
    {
        $data['switch']             = '2';
        $data['switch_button_text'] = $this->lang->line('button_back');
        $data['switch_button_url']  = $this->session->userdata('uri_back');

        $this->session->set_userdata($data);
    }

    // --------------------------------------------------------------------------------------------
    // DISPLAY HEADER - SEARCH - GET - PAGE
    // --------------------------------------------------------------------------------------------

    private function page_display_header()
    {
        echo link_tag('frame-work/version-2016-r1-v2/css/button-as-text.css');
        echo link_tag('frame-work/version-2016-r1-v2/css/main.css');
        echo link_tag('frame-work/version-2016-r1-v2/javascripts/modernizr.custom.js');

        $this->settings['prev_link']    = $this->lang->line('button_prev');
        $this->settings['next_link']    = $this->lang->line('button_next');

        $data['page_title_red']         = $this->lang->line('page_title_job');
        $data['page_title_black']      = $this->lang->line('page_title_search');

        $this->load->view('page/page_display_header', $data);
    }

    private function page_display_search($page_number)
    {
        //echo '*** page_display($page_number['.$page_number.'])</p>';

        if(!is_numeric($page_number)){
            $page_number = 1;
        }

        if($this->job_get_by_search_total_rows() == 0 || $this->validation == 'FAIL'){

            
            $data['message_result_none_header']     = $this->lang->line('message_result_none_header');
            $data['message_result_none_body']       = $this->lang->line('message_result_none_body');


            $this->load->view('job/job_display_none', $data);
        }
        else
        {
            $this->paginator_init($page_number);
            $this->paginator_display_controlls();

            $this->job_get_by_search();

            $this->paginator_init($page_number);
            $this->paginator_display_controlls();   
        }
    }

    private function page_display_get($page_number)
    {
        //echo '*** page_display($page_number['.$page_number.'])</p>';

        if(!is_numeric($page_number)){
            $page_number = 1;
        }

        if($this->job_get_by_id_total_rows() == 0){

            $this->load->view('job/job_display_none');
        }
        else
        {
            $this->job_get_by_id_total_rows();

            $this->paginator_init($page_number);
            $this->paginator_display_controlls();

            $this->job_get_by_id();

            $this->paginator_init($page_number);
            $this->paginator_display_controlls(); 
        } 
    }

    private function page_display_page($page_number)
    {
        //echo '*** page_display($page_number['.$page_number.'])</p>';

        $uri_previous_method = $this->session->userdata('uri_previous_method');

        if($uri_previous_method == 'search'){

            if($this->job_get_by_search_total_rows() == 0){

                $this->load->view('job/job_display_none');
            }
            else
            {
                $this->paginator_init($page_number);
                $this->paginator_display_controlls();

                $this->job_get_by_search();

                $this->paginator_init($page_number);
                $this->paginator_display_controlls();   
            }
        }

        if($uri_previous_method == 'get'){

            if($this->job_get_by_id_total_rows() == 0){

                $this->load->view('job/job_display_none');
            }
            else
            {
                $this->paginator_init($page_number);
                $this->paginator_display_controlls();

                $this->job_get_by_id();

                $this->paginator_init($page_number);
                $this->paginator_display_controlls();   
            }
        }
    }

    private function page_display_show()
    {
        //echo '*** page_display_show()</p>';
        if($this->job_get_by_id_total_rows() == 0){

            $data['message_result_none_header']     = $this->lang->line('message_result_none_header');
            $data['message_result_none_body']       = $this->lang->line('message_result_none_body');

            $this->load->view('job/job_display_none', $data);
        }
        else
        {
            $this->paginator_init(1);
            $this->paginator_display_controlls();

            $this->job_get_by_id();

            $this->paginator_init(1);
            $this->paginator_display_controlls();
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
                    'value'     => $this->session->userdata('job_type')
                    )
                );


        // VALUE FOR JOBTYPE MAY NEED TO BE CHANGED

        $this->form_validation->set_rules($config); 
    }

    private function search_form_validate()
    {
        if($this->input->post('sent') == 'true'){

            $this->session->unset_userdata('sent');

            if ($this->form_validation->run() == FALSE)
            {
                return 'FAIL';

            }else{

                return 'SUCCESS';
            }
        }else{

            return 'SUCCESS';
        }
    }

    private function search_form_display()
    {
        // --------------------------------------------------------------------------------------------
        // LOAD JOBS FORMS
        // --------------------------------------------------------------------------------------------

        $search_data['keyword']                 = $this->session->userdata('keyword');
        $search_data['location']                = $this->session->userdata('location');
        $search_data['job_type']                = $this->session->userdata('job_type');
        $search_data['uri_back']                = $this->session->userdata('uri_back');
        $search_data['validation']              = $this->validation;

        $search_data['search_form_keyword']             = $this->lang->line('search_form_keyword');
        $search_data['search_form_location']            = $this->lang->line('search_form_location');
        $search_data['search_form_job_type']            = $this->lang->line('search_form_job_type');
        $search_data['search_form_submit']              = $this->lang->line('search_form_submit');
        $search_data['search_form_drop_down_job_type']  = $this->lang->line('search_form_drop_down_job_type');
                
        $this->load->view('forms/form_job_search',$search_data );
    }

    // --------------------------------------------------------------------------------------------
    // PREPARE PARAMETERS FOR JOB SEARCH FROM DATA-BASE
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

        $data['row_index']              = $this->row_index;
        $data['uri_path']               = $this->session->userdata('uri_page');
        $data['button_apply']           = $this->lang->line('button_apply');
        $data['label_job_description']  = $this->lang->line('label_job_description');
        $data['label_job_job_type']     = $this->lang->line('label_job_job_type');
        $data['label_job_location']     = $this->lang->line('label_job_location');
        $data['label_job_salary']       = $this->lang->line('label_job_salary');
        
        $this->job_display_size($data);
        
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
    // PREPARE PARAMETERS FOR JOB GET FROM DATA-BASE
    // --------------------------------------------------------------------------------------------

    private function job_get_by_id()
    {
        $job_ids     = $this->session->userdata('job_ids');
        $deleted     = 0;
        $expired     = 0;
        $row_start   = $this->row_start; 
        $row_amount  = $this->row_amount;

        if($job_ids == 'all'){ $job_ids = '';}

        $this->load->model('procedures/job');

        $data['query']          = $this->job->get(  $job_ids, 
                                                    $deleted, 
                                                    $expired, 
                                                    $row_start, 
                                                    $row_amount);
        
        $data['row_index']              = $this->row_index;
        $data['uri_path']               = $this->session->userdata('uri_page');
        $data['button_apply']           = $this->lang->line('button_apply');
        $data['label_job_description']  = $this->lang->line('label_job_description');
        $data['label_job_job_type']     = $this->lang->line('label_job_job_type');
        $data['label_job_location']     = $this->lang->line('label_job_location');
        $data['label_job_salary']       = $this->lang->line('label_job_salary');

        $this->job_display_size($data);
    }

    private function job_get_by_id_total_rows()
    {
       //echo '*** job_get_by_id_total_rows()</p>';

        $job_ids     = $this->session->userdata('job_ids');
        $deleted    = 0;
        $expired    = 0;

        if($job_ids == 'all'){$job_ids = '';}

        $this->load->model('procedures/job');

        $total_rows = $this->job->get_row_count(    $job_ids,
                                                    $deleted,
                                                    $expired);

        $this->session->set_userdata(array('total_rows'  => $total_rows));

        $this->job->close();

        return $total_rows;
    }

    // -------------------------------------------------------------------------------------------
    // SEND JOB DATA FOR DISPLAY
    // -------------------------------------------------------------------------------------------

    private function job_display_size($data)
    {
        $switch = $this->session->userdata('switch');

        if($switch == 0)
        {
            $this->load->view('job/job_display_small', $data);  
        }

        if($switch == 1)
        {
            $this->load->view('job/job_display_medium', $data);
        }

        if($switch  == 2)
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

        // MAJAO
        //$page = $this->uri->segment(4, 1);
        //echo '$page  : '.$page.'</p>';

        $this->pagination->set_page($page_number);

        // -------------------------------------------------------------------------------------------
        // DEFINE PER PAGE VALUES
        // -------------------------------------------------------------------------------------------

        $switch = $this->session->userdata('switch');

        if($switch == 0){
        
          $this->settings['per_page'] = $this->settings['total_rows']; 

        }else if($switch == 1){

            $this->settings['per_page'] = 5; 

        }else if($switch == 2){

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
        $this->row_index    =  (($page_number - 1) *  $this->row_amount) + 1;

        // -------------------------------------------------------------------------------------------
        // CALCULATE JOBS TO LOAD
        // -------------------------------------------------------------------------------------------
    }


    private function paginator_display_controlls()
    {

        //echo '** paginator_display_controlls()';

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

        $data['paginator_page']         = $this->lang->line('paginator_page');
        $data['paginator_jobs']         = $this->lang->line('paginator_jobs');
        //
        $this->load->view('job/job_paginator_controls', $data);
    }

    // -------------------------------------------------------------------------------------------
    // SET URI CONTROL
    // -------------------------------------------------------------------------------------------

    private function uri_store_back()
    {
        $array = explode('/switch' , uri_string());
        $this->session->set_userdata(array('uri_back'  => $array[0]));
    }

    private function uri_store_previous_method()
    {
        $method= $this->uri->segment(2);

        $this->session->set_userdata(array('uri_previous_method'  => $method));
    }

    private function uri_store_job_ids($uri_data = NULL)
    {
        if($uri_data != 'all')
        {
            $array_explode = explode( '-', $uri_data);
            $array_implode = implode(",", $array_explode);

        }else{

            $array_implode = $uri_data;
        }

        $this->session->set_userdata(array('job_ids'        => $array_implode ));
        $this->session->set_userdata(array('uri_job_ids'    => $uri_data));

        //echo '$this->session->userdata(job_ids) : '.$this->session->userdata('job_ids').'</p>';
    }

    // -------------------------------------------------------------------------------------------  

    private function uri_make_paginator_settings_search()
    {
        $controller = $this->uri->segment(1);
        $method     = $this->uri->segment(2);

        $this->settings['base_url'] = site_url().'/'.$controller.'/'.$method;
    }

    private function uri_make_paginator_settings_get()
    {
        $controller = $this->uri->segment(1);
        $method     = $this->uri->segment(2);
        $job_ids    = $this->session->userdata('uri_job_ids');

        $this->settings['base_url'] = site_url().'/'.$controller.'/'.$method.'/'.$job_ids;
    }

    // -------------------------------------------------------------------------------------------

    private function uri_make_switch_search()
    {
        $site       = site_url();
        $controller = $this->uri->segment(1);
        $method     = $this->uri->segment(2);
        $page       = 1;

        $data['switch_button_url']  =  site_url().'/'.$controller.'/'.$method.'/'.$page.'/switch';

        $this->session->set_userdata($data);
    }

    private function uri_make_switch_get()
    {
        $site       = site_url();
        $controller = $this->uri->segment(1);
        $method     = $this->uri->segment(2);
        $job_ids    = $this->session->userdata('uri_job_ids');

        $data['switch_button_url']  =  site_url().'/'.$controller.'/'.$method.'/'.$job_ids.'/switch';

        $this->session->set_userdata($data);
    }

    // -------------------------------------------------------------------------------------------

    private function uri_make_page()
    {
        $site       = site_url();
        $controller = $this->uri->segment(1);
  
        $data['uri_page']  =  site_url().'/'.$controller.'/page';
        $this->session->set_userdata($data);
    }

    // -------------------------------------------------------------------------------------------
}


