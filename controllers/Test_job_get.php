<?php
class Test_job_get extends CI_Controller {

    public $settings = array('base_url' => 'http://10.3.5.56/index.php/job_get/page',
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

        //session_unset ();

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

    public function page($page_number = 1)
    {
    

       

        $this->jobs_total_rows();
        $this->job_toggle_display_button();

        $this->paginator_init($page_number);
        $this->paginator_display_text();
        $this->paginator_display_controlls();

        $this->jobs_display();

        $this->paginator_init($page_number);
        $this->paginator_display_text();
        $this->paginator_display_controlls();

        //$this->user_session->set();
   
    }

    public function go($uri_data = NULL)
    {

        $page_number  = 1;

        $this->uri_last(); 

        $this->uri_store($uri_data);

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
            $job_button_text = 'Show Less';

        }else if($job_toggle == 1)
        {
            $job_button_text = 'Show More';

        }else if($job_toggle == 2)
        {
            $job_button_text = 'Back';
        }

        $toggle_view_data['job_button_text']    = $job_button_text;
        $toggle_view_data['job_toggle']         = $job_toggle;
        $toggle_view_data['uri_path']           = 'job_get/go/'.$this->session->userdata('uri_data');

        $this->session->set_userdata($toggle_view_data);
    }

    // --------------------------------------------------------------------------------------------
    // PREPARE PARAMETERS FOR JOB SEARCH FORM DATA-BASE
    // --------------------------------------------------------------------------------------------

    private function jobs_total_rows()
    {
        //echo '*** jobs_total_rows()</p>';

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


    private function jobs_display()
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
        $data['uri_path']   = 'job_get/page/';


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

    private function uri_store($uri_data = NULL){

        $array_explode = explode( '-', $uri_data);
        $array_implode = implode(",", $array_explode);

        if( $array_implode == ''){

            $array_implode = NULL;
        }

        $this->session->set_userdata(array('job_ids'  => $array_implode ));
        $this->session->set_userdata(array('uri_data'  => $uri_data));
    }
}


