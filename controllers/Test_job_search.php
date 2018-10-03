<?php
class Test_job_search extends CI_Controller {

    public $settings = array('base_url' => 'http://10.3.5.56/index.php/job_search/page',
                                'total_rows'        => 0,
                                'per_page'          => 10,
                                'num_links'         => 0,
                                'first_link'        => FALSE,
                                'last_link'         => FALSE,
                                'next_link'         => 'NEXT',
                                'prev_link'         => 'PREV',
                                'next_tag_open'     => ' ',
                                'next_tag_close'    => ' ',
                                'use_page_numbers'  => TRUE,
                                'display_pages'     => FALSE,
                                ); 

    protected $row_start       = 0;
    protected $row_amount      = 10;
    protected $row_total       = 0;

    protected $jobs_page_number = 0;
    protected $jobs_start       = 0;
    protected $jobs_end         = 0;
    protected $jobs_total       = 0;


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
        $this->load->library('job_toggle');
        $this->load->helper('form'); 
        $this->load->helper('html');
        $this->load->helper('url'); 
        
        $this->load->model('procedures/job');

        echo link_tag('css/buttons.css');
    }

    // --------------------------------------------------------------------------------------------
    // WEB CONTROLS
    // --------------------------------------------------------------------------------------------

    public function index()
    {
        //echo '*** index()</p>';

        $this->uri_last();

        $this->user_session->set();

        $this->search_form_rules();
        $this->search_form_display();

        $validation = $this->search_form_validate();

        if($validation == 'TRUE')
        {
            $this->jobs_total_rows();

            $this->job_toggle_display_button();

            $this->paginator_init();
            $this->paginator_display_text();
            $this->paginator_display_controlls();

            $this->jobs_display();

            $this->paginator_init();
            $this->paginator_display_text();
            $this->paginator_display_controlls();

        }
    }

    public function page($page_number=1)
    {
        //echo '*** page()</p>';

        $this->uri_last();

        $this->user_session->set();

        $this->search_form_rules();
        $this->search_form_display();

        $this->jobs_total_rows();
        $this->job_toggle_display_button();

        $this->paginator_init($page_number);
        $this->paginator_display_text();
        $this->paginator_display_controlls();

        $this->jobs_display();

        $this->paginator_init($page_number);
        $this->paginator_display_text();
        $this->paginator_display_controlls();
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
                        'field'     => 'job_toggle',
                        'label'     => 'job_toggle',
                        'value'     => $this->session->userdata('job_toggle')
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

         $this->form_validation->set_rules($config); 
    }

    private function search_form_display()
    {
        // --------------------------------------------------------------------------------------------
        // LOAD JOBS FORMS
        // --------------------------------------------------------------------------------------------

        $search_data['keyword']    = $this->session->userdata('keyword');
        $search_data['location']   = $this->session->userdata('location');
        $search_data['job_type']   = $this->session->userdata('job_type');
                

        $this->load->view('forms/form_job_search',$search_data );
    }

    private function search_form_validate()
    {
        //echo '*** search_form_validate()</p>';

        if ($this->form_validation->run() == FALSE)
        {
            $error = validation_errors();
            echo $error;

            return 'FALSE';
            
        }else{

            return 'TRUE';
        }
    }

    // --------------------------------------------------------------------------------------------
    // JOB TOGGLE
    // --------------------------------------------------------------------------------------------
    
    private function job_toggle_display_button()
    {
        //echo '*** job_toggle_display_button()</p>';

        $this->job_toggle->by_post('job_toggle');

        // --------------------------------------------------------------------------------------------
        // END JOB TOGGLE
        // --------------------------------------------------------------------------------------------

        $job_toggle = $this->job_toggle->by_uri();

        if($job_toggle == 0)
        {
            $job_button_text = 'SHOW 5';

        }else if($job_toggle == 1)
        {
            $job_button_text = 'SHOW ALL';

        }else if($job_toggle == 2)
        {
            $job_button_text = 'BACK';
        }

        $toggle_view_data['job_button_text']    = $job_button_text;
        $toggle_view_data['job_toggle']         = $job_toggle;
        $toggle_view_data['uri_path']           = 'job_search';

        $this->session->set_userdata($toggle_view_data);
    }

    // --------------------------------------------------------------------------------------------
    // PREPARE PARAMETERS FOR JOB SEARCH FORM DATA-BASE
    // --------------------------------------------------------------------------------------------

    private function jobs_total_rows()
    {
        //echo '*** jobs_total_rows()</p>';

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


    private function jobs_display()
    {

        //echo '*** jobs_display()</p>';

    
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
        $data['uri_path']   = 'job_search/page/';


        $toggle = $this->job_toggle->by_uri();


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

        $toggle = $this->job_toggle->by_uri();

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
        $this->row_index    =  (($page_number - 1) *  $this->row_amount) +1;

        // -------------------------------------------------------------------------------------------
        // CALCULATE JOBS TO LOAD
        // -------------------------------------------------------------------------------------------
    }

    private function paginator_display_text()
    {
        $data['jobs_page_number']   = $this->jobs_page_number;
        $data['jobs_start']         = $this->jobs_start;
        $data['jobs_end']           = $this->jobs_end;
        $data['jobs_total']         = $this->jobs_total;
        //
        $data['job_toggle']         = $this->session->userdata('job_toggle');
        $data['job_button_text']    = $this->session->userdata('job_button_text');
        $data['uri_path']           = $this->session->userdata('uri_path');

        $this->load->view('job/job_paginator_text', $data);
    }

    private function paginator_display_controlls()
    {
        $data['pagination'] = $this->pagination;
        $data['settings']   = $this->settings;

        $this->load->view('job/job_paginator_controls', $data);
    }

    // -------------------------------------------------------------------------------------------
    // SET LAST URI
    // -------------------------------------------------------------------------------------------

    private function uri_last()
    {
        $this->session->set_userdata(array('uri_last' => uri_string()));
    }
}


