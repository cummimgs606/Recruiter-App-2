<?php
class Test_search extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('dropdown');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('table'); 
        $this->load->library('user_session');
        $this->load->helper('form'); 
        $this->load->helper('url'); 
    }

    public function index()
    {
        // --------------------------------------------------------------------------------------------
        // MANAGER USER SESSION
        // --------------------------------------------------------------------------------------------
  
        $this->user_session->set();

        // --------------------------------------------------------------------------------------------
        // START JOB TOGGLE
        // --------------------------------------------------------------------------------------------

        $this->user_session->toggle('job_toggle');

        // --------------------------------------------------------------------------------------------
        // END JOB TOGGLE
        // --------------------------------------------------------------------------------------------

        $config = array(

                    array(
                        'field'     => 'keyword',
                        'label'     => 'Keyword',
                        'rules'     => 'trim|min_length[3]|max_length[60]|regex_match[/^[a-zA-Z0-9,.!? ]*$/]',
                        'errors'    => array(
                                        'min_length' => 'You must provide a %s with 3 characters minimum',
                                        'max_length' => 'You must provide a %s with 60 characters maximum',
                                        'regex_match' => 'Only characters, numbers and punctuation are allowed.'),
                        'value'     => $this->session->userdata('keyword')
                        ),
                    array(
                        'field'     => 'location',
                        'label'     => 'Location',
                        'rules'     => 'trim|min_length[3]|max_length[60]|regex_match[/^[a-zA-Z0-9,.!? ]*$/]',
                        'errors'    => array(
                                        'min_length' => 'You must provide a %s with 3 characters minimum',
                                        'max_length' => 'You must provide a %s with 60 characters maximum',
                                        'regex_match' => 'Only characters, numbers and punctuation are allowed.'),
                        'value'     => $this->session->userdata('location')
                        ),
                    array(
                        'field'     => 'job_toggle',
                        'label'     => 'job_toggle',
                        'value'     => $this->session->userdata('job_toggle')
                        ),
                    array(
                        'feild'  => 'job_type',
                        'label'     => 'job_type',
                        'rules'     => 'required',
                        'errors'    => array(
                                        'required' => 'Please select job type.'),
                        'value'     => $this->session->userdata('job_toggle')
                        )
                    );


        $this->form_validation->set_rules($config);  

        // --------------------------------------------------------------------------------------------
        // EVALUATE RULES FOR SEARCH FORM
        // --------------------------------------------------------------------------------------------

        $this->load->view('forms/form_search');
        $this->load->view('forms/form_search_toggle_jobs');  

        if ($this->form_validation->run() != FALSE)
        {
            $job_view_size = $this->session->userdata('job_toggle');

            $this->display_jobs($job_view_size);

        }else{

            echo 'VALIDATION ERROR </p>';
        }
    }

    // --------------------------------------------------------------------------------------------
    // PREPARE PARAMETRS FOR JOB SEARCH
    // --------------------------------------------------------------------------------------------

    private function display_jobs($job_view_size)
    {
        $keyword        = $this->session->userdata('keyword');
        $location       = $this->session->userdata('location');
        $country_id     = 'NULL'; 
        $job_type_id    = $this->session->userdata('job_type') == NULL ? '1' : $this->session->userdata('job_type');
        $brand_id       = 'NULL'; 
        $row_start      = 0; 
        $row_amount     = 'NULL';

        $this->load->model('procedures/job');

        $data['page_header']    = 'Job Page Header';
        $data['query']          = $this->job->search(   $keyword, 
                                                        $location, 
                                                        $country_id, 
                                                        $job_type_id, 
                                                        $brand_id, 
                                                        $row_start, 
                                                        $row_amount);

        if($job_view_size == 0)
        {
            $this->load->view('job/job_small', $data);  
        }

        if($job_view_size == 1)
        {
            $this->load->view('job/job_medium', $data);
        }

        if($job_view_size == 2)
        {
            $this->load->view('job/job_large', $data);
        }
    }
}
