<?php
class Test_job_apply extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('form_validation');
        $this->load->library('session'); 
        $this->load->library('user_session');
        $this->load->library('user_session');
        $this->load->helper('form'); 
        $this->load->helper('url'); 
        $this->load->model('procedures/job');
    }

    // --------------------------------------------------------------------------------------------
    // PUBLIC METHODS
    // --------------------------------------------------------------------------------------------

    public function apply($job_id = NULL)
    {
    	//echo '*** apply()</p>';

        $upload_valid       = 'FALSE';
        $form_valid         = 'FALSE';

    	if($job_id == NULL)
    	{ 
    		//echo '*** Job : NO</p>';
    	}
        else
        {
            //echo '*** Job : YES</p>';

            if(count($this->input->post(NULL)) > 0){

                $this->upload_rules();
                $upload_valid = $this->upload_validate();
            }

            $data = $this->job_get($job_id);

            $this->job_display($data);
            $this->form_rules($data);
            $this->set_hidden_fields($data);

            $form_valid = $this->form_validate($data);

            if($form_valid == 'FALSE'){

                $this->form_fail($data);

                if($upload_valid == 'FALSE'){

                   if(count($this->input->post(NULL)) > 0)
                   {
                        $this->upload_fail();
                    }
                }
            }

            if($form_valid == 'TRUE'){

                if($upload_valid == 'NONE' || $upload_valid == 'TRUE' )
                {
                    $this->form_success();
                    $this->upload_success();

                    if($upload_valid == 'NONE')
                    {
                        echo 'Email: NO CV';
                    }

                    if($upload_valid == 'TRUE' )
                    {
                        echo 'Email: WITH CV';
                    }
                }

                if($upload_valid == 'FALSE')
                {
                    $this->form_fail($data);
                    $this->upload_fail();

                }
            }

            $this->user_session->set();
    	}
    }

    // --------------------------------------------------------------------------------------------
    // FORM RULES
    // --------------------------------------------------------------------------------------------

    private function form_rules($data)
    {
        //echo '*** form_rules()</p>';

        // --------------------------------------------------------------------------------------------
        // CONFIGURE FORM
        // --------------------------------------------------------------------------------------------

        $config = array(
            array(
                'field'     => 'candidate_first_name',
                'label'     => 'First Name',
                'rules'     => 'required|trim|min_length[3]|max_length[60]|regex_match[/^[a-zA-Z]*$/]',
                'errors'    => array(
                    'min_length'    => '%s must be 3 characters minimum',
                    'max_length'    => '%s must be 60 characters maximum',
                    'required'      => 'You must provide a %s',
                    'regex_match'   => 'Only alphabet characters are allowed for %s.'),
                'value'     => $this->session->userdata('candidate_first_name')
                ),
            array(
                'field'     => 'candidate_middle_name',
                'label'     => 'Middle Name',
                'rules'     => 'trim|min_length[3]|max_length[60]|regex_match[/^[a-zA-Z]*$/]',
                'errors'    => array(
                    'min_length'    => '%s must be 3 characters minimum',
                    'max_length'    => '%s must be 60 characters maximum',
                    'regex_match'   => 'Only alphabet characters are allowed for %s.'),
                'value'     => $this->session->userdata('candidate_middle_name')
                ),
            array(
                'field'     => 'candidate_last_name',
                'label'     => 'Last Name',
                'rules'     => 'required|trim|min_length[3]|max_length[60]|regex_match[/^[a-zA-Z]*$/]',
                'errors'    => array(
                    'min_length'    => '%s must be 3 characters minimum',
                    'max_length'    => '%s must be 60 characters maximum',
                    'required'      => 'You must provide a %s',
                    'regex_match'   => 'Only alphabet characters are allowed for %s.'),
                'value'     => $this->session->userdata('candidate_last_name')
                ),
            array(
                'field'     => 'candidate_salutation',
                'label'     => 'Salutation',
                'rules'     => 'trim|min_length[1]|max_length[4]|regex_match[/^[a-zA-Z]*$/]',
                'errors'    => array(
                    'min_length'    => '%s must be 3 characters minimum',
                    'max_length'    => '%s must be 60 characters maximum',
                    'regex_match'   => 'Only alphabet characters are allowed for %s.'),

                'value'     => $this->session->userdata('candidate_salutation')
                ),
            array(
                'field'     => 'candidate_email',
                'label'     => 'Email',
                'rules'     => 'required|trim|valid_email',
                'errors'    => array(
                    'required'      => 'You need to provide an email',
                    'trim'          => 'You must provide a valid %s',
                    'valid_email'   => 'You must provide a valid %s'),
                'value'     => $this->session->userdata('candidate_email')
                ),
            array(
                'field'     => 'candidate_phone_home',
                'label'     => 'Phone Number',
                'rules'     => 'trim|min_length[9]|max_length[14]|regex_match[/^[0-9 +]+$/]',
                'errors'    => array(
                    'min_length'    => 'You must provide a valid %s 9 digits minimum',
                    'max_length'    => 'You must provide a valid %s 14 digits maximum',
                    'regex_match'   => 'Only numbers + and spaces are allowed.'),
                'value'     => $this->session->userdata('candidate_phone_home')
                ),
            array(
                'field'     => 'candidate_phone_mobile',
                'label'     => 'Phone Number',
                'rules'     => 'trim|min_length[9]|max_length[14]|regex_match[/^[0-9 +]+$/]',
                'errors'    => array(
                    'min_length'    => 'You must provide a valid %s 9 digits minimum',
                    'max_length'    => 'You must provide a valid %s 14 digits maximum',
                    'regex_match'   => 'Only numbers + and spaces are allowed.'),
                'value'     => $this->session->userdata('candidate_phone_home')
                ),
            array(
                'field'     => 'candidate_cv',
                'label'     => 'Candidate CV',
                'rules'     => '',
                'errors'    => array(),
                'value'     => $this->session->userdata('candidate_cv')
                ),
            array(
                'field'     => 'job_application_campaign',
                'label'     => 'Job Campaign',
                'rules'     => 'trim|min_length[3]|max_length[60]|regex_match[/^[a-zA-Z0-9, ]*$/]',
                'errors'    => array(
                    'min_length'    => 'You must provide a %s with 3 characters minimum',
                    'max_length'    => 'You must provide a %s with 60 characters maximum',
                    'regex_match'   => 'For %s only characters, numbers and spaces are allowed.'),
                'value'     => $this->session->userdata('job_application_campaign')
                ),
            array(
                'field'     => 'job_application_Keyword',
                'label'     => 'Job Keyword',
                'rules'     => 'trim|min_length[3]|max_length[60]|regex_match[/^[a-zA-Z0-9,.!?+ ]*$/]',
                'errors'    => array(
                    'min_length'    => 'You must provide a %s with 3 characters minimum',
                    'max_length'    => 'You must provide a %s with 60 characters maximum',
                    'regex_match'   => 'For %s only characters, numbers and punctuation are allowed.'),
                'value'     => $this->session->userdata('job_application_Keyword')
                ),
            array(
                'field'     => 'job_application_location',
                'label'     => 'Job Location',
                'rules'     => 'trim|min_length[3]|max_length[60]|regex_match[/^[a-zA-Z0-9,.!? ]*$/]',
                'errors'    => array(
                    'min_length'    => 'You must provide a %s with 3 characters minimum',
                    'max_length'    => 'You must provide a %s with 60 characters maximum',
                    'regex_match'   => 'For %s only characters, numbers and spaces are allowed.'),
                'value'     => $this->session->userdata('job_application_location')
                ),
            array(
                'feild'     => 'job_title',
                'label'     => 'Job Title',
                'rules'     => 'required|trim|min_length[3]|max_length[60]|regex_match[/^[a-zA-Z0-9]*$/]',
                'errors'    => array(
                    'min_length'    => 'You must provide a %s with 3 characters minimum',
                    'max_length'    => 'You must provide a %s with 60 characters maximum',
                    'required'      => 'For %s required.',
                    'regex_match'   => 'For %s only characters, numbers and spaces are allowed.'),
                'value'     => $this->session->userdata('job_title')
                ),
            array(
                'feild'     => 'job_id',
                'label'     => 'Job ID',
                'rules'     => 'trim|min_length[1]|max_length[20]|regex_match[/^[0-9]*$/]',
                'errors'    => array(
                    'min_length'    => 'You must provide a %s with 1 characters minimum',
                    'max_length'    => 'You must provide a %s with 20 characters maximum',
                    'regex_match'   => 'For %s only numbers are allowed.'),
                'value'     => $this->session->userdata('job_id')
                ),
            array(
                'feild'     => 'job_type_id',
                'label'     => 'job_type_id',
                'rules'     => 'required|trim|min_length[1]|max_length[2]|regex_match[/^[0-9]*$/]',
                'errors'    => array(
                    'required' => 'Please provide a job type id.'),
                'value'     => $this->session->userdata('job_type_id')
                )
            );

        $this->form_validation->set_rules($config); 
    }

    // --------------------------------------------------------------------------------------------
    // FORM VALIDATE
    // --------------------------------------------------------------------------------------------
    
    private function form_validate($data)
    {
        //echo '*** form_validate()</p>';

        if ($this->form_validation->run() == FALSE)
        {
            return 'FALSE';

        }else{

            return 'TRUE';
        }
    }

    // --------------------------------------------------------------------------------------------
    // FORM FAIL
    // --------------------------------------------------------------------------------------------

    private function form_fail($data)
    {
        //echo '*** form_fail()</p>';
        $this->uri_back_button();

        echo '</p>';

        $this->form_display();
    }

    // --------------------------------------------------------------------------------------------
    // FORM SUCCESS
    // --------------------------------------------------------------------------------------------

    private function form_success()
    {
        //echo '*** form_success()</p>';

        $this->uri_back_button();

        echo '</p>';
    }

    // --------------------------------------------------------------------------------------------
    // DISPLAY
    // --------------------------------------------------------------------------------------------

    private function form_display()
    {
        //echo '*** form_display()</p>';

        // --------------------------------------------------------------------------------------------
        // LOAD JOBS FORMS
        // --------------------------------------------------------------------------------------------

        $apply_data['candidate_first_name']        = $this->session->userdata('candidate_first_name');        
        $apply_data['candidate_middle_name']       = $this->session->userdata('candidate_middle_name');        
        $apply_data['candidate_last_name']         = $this->session->userdata('candidate_last_name');             
        $apply_data['candidate_salutation']        = $this->session->userdata('candidate_salutation');          
        $apply_data['candidate_email']             = $this->session->userdata('candidate_email');  
        $apply_data['candidate_phone_home']        = $this->session->userdata('candidate_phone_home');          
        $apply_data['candidate_phone_mobile']      = $this->session->userdata('candidate_phone_mobile');          
        $apply_data['candidate_cv']                = $this->session->userdata('candidate_cv');   
        $apply_data['job_application_campaign']    = $this->session->userdata('job_application_campaign');      
        $apply_data['job_application_Keyword']     = $this->session->userdata('job_application_Keyword');       
        $apply_data['job_application_location']    = $this->session->userdata('job_application_location');       
        $apply_data['job_id']                      = $this->session->userdata('job_id');                        
        $apply_data['job_title']                   = $this->session->userdata('job_title');                     
        $apply_data['job_type_id']                 = $this->session->userdata('job_type_id');                  

        // --------------------------------------------------------------------------------------------
                
        $this->load->view('forms/form_apply',$apply_data );
    }

    // --------------------------------------------------------------------------------------------
    // UPLOAD RULES
    // --------------------------------------------------------------------------------------------
    
    private function upload_rules()
    {
        //echo '*** upload_rules()</p>';

        $this->config_upload['upload_path']       = './uploads/';
        $this->config_upload['allowed_types']     = 'gif|jpg|png';
        $this->config_upload['max_size']          = 1000;
        $this->config_upload['encrypt_name']      = TRUE;
    }

    // --------------------------------------------------------------------------------------------
    // UPLOAD VALIDATE
    // --------------------------------------------------------------------------------------------

    private function upload_validate()
    {
        //echo '*** upload_validate()</p>';

        $this->load->library('upload', $this->config_upload);

        if ( ! $this->upload->do_upload('candidate_cv'))
        {
            $file_name  = $this->upload->data('file_name'); 

            if($file_name  == ''){

                return 'NONE';

             }else{

                return 'FALSE';
             }
        }
        else
        {
            return 'TRUE';
        }
    }

    // --------------------------------------------------------------------------------------------
    // UPLOAD FAIL
    // --------------------------------------------------------------------------------------------

    private function upload_fail()
    {
        //echo '*** upload_fail()</p>';

        //echo '*** UPLOAD : ERROR : </p>';
        echo $this->upload->display_errors().'</p>';
    }

    // --------------------------------------------------------------------------------------------
    // UPLOAD SUCCESS
    // --------------------------------------------------------------------------------------------

    private function upload_success()
    {
        //echo '*** upload_success()</p>';   

        $data = array('upload_data' => $this->upload->data());

        $file_name  = $data['upload_data']['file_name'];

        echo '*** $file_name : '.$file_name.'</p>';
    }

    // --------------------------------------------------------------------------------------------
    // JOB GET
    // --------------------------------------------------------------------------------------------

    private function job_get($job_id)
    {
        //echo '*** job_get()</p>';

        $query = $this->job->get($job_id);

        $data = [];

        foreach ($query->result() as $row){

 
            $data['job_id']                     =   $row->job_id;
            $data['job_title']                  =   $row->job_title;
            $data['job_salary']                 =   $row->job_salary;
            $data['job_description']            =   $row->job_description;
            $data['job_featured']               =   $row->job_featured; 
            $data['job_start_date']             =   $row->job_start_date;
            $data['job_duration']               =   $row->job_duration;
            $data['job_expiry_date']            =   $row->job_expiry_date;
            $data['job_response_email']         =   $row->job_response_email; 
            $data['job_external_reference']     =   $row->job_external_reference;
            $data['job_location_text']          =   $row->job_location_text;
            $data['postal_code']                =   $row->postal_code;
            $data['job_type_id']                =   $row->job_type_id;
            $data['job_type_name']              =   $row->job_type_name;
            $data['consultant_id']              =   $row->consultant_id;
            $data['consultant_name']            =   $row->consultant_name;
            $data['consultant_phone_mobile']    =   $row->consultant_phone_mobile;
            $data['brand_id']                   =   $row->brand_id;
            $data['brand_name']                 =   $row->brand_name;
            $data['office_id']                  =   $row->office_id;
            $data['office_telephone']           =   $row->office_telephone;
            $data['language_id']                =   $row->language_id;
            $data['country_id']                 =   $row->country_id;
            $data['job_source_id']              =   $row->job_source_id;
        }

        return $data;
    }

    // --------------------------------------------------------------------------------------------
    // DISPLAY
    // --------------------------------------------------------------------------------------------

    private function job_display($data)
    {
        //echo '*** job_displays()</p>';
        $this->load->view('job/job_display_small_apply', $data);
    }

    // --------------------------------------------------------------------------------------------
    // SET HIDDEN FILEDS
    // --------------------------------------------------------------------------------------------

    private function set_hidden_fields($data)
    {
        //echo '*** set_hidden_fields()</p>';

        $session_data['job_application_campaign']    = 'Microsite Campaign 123';      
        $session_data['job_application_Keyword']     = $this->session->userdata('keyword');      
        $session_data['job_application_location']    = $this->session->userdata('location');     
        $session_data['job_id']                      = $data['job_id'];                        
        $session_data['job_title']                   = $data['job_title'];                     
        $session_data['job_type_id']                 = $data['job_type_id'];
        $session_data['job_toggle']                  = 0;

        $this->session->set_userdata($session_data);
    }

    // --------------------------------------------------------------------------------------------
    // SET HIDDEN FILEDS
    // --------------------------------------------------------------------------------------------

    private function uri_back_button()
    {
        //echo '*** uri_back_button()</p>';
        //echo '$this->session->userdata(uri_back) : '.$this->session->userdata('uri_back').'</p>';
        
        $segments = explode('/', $this->session->userdata('uri_back'));

        if(count($segments) == 3){

            $data['uri_back'] = $this->session->userdata('uri_back').'/1';

            $this->session->set_userdata($data); 

        }
        

        echo anchor($this->session->userdata('uri_back'), 'BACK');
    }
}