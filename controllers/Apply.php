<?php
class Apply extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->database();
 
        $this->load->library('email');
        $this->load->library('form_validation');
        $this->load->library('session'); 
        $this->load->library('user_session');
        $this->load->library('user_language');
        $this->load->library('hncom_mailer');
        $this->load->helper('form'); 
        $this->load->helper('html');
        $this->load->helper('url'); 
        $this->load->model('procedures/job');
        $this->load->model('procedures/language');
        $this->load->library('javascript');
        
        echo link_tag('frame-work/version-2016-r1-v2/css/button-as-text.css');
        echo link_tag('frame-work/version-2016-r1-v2/css/button_file_upload.css');
        echo link_tag('frame-work/version-2016-r1-v2/css/main.css');

        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
        echo '<script src="'.base_url().'frame-work/version-2016-r1-v2/javascripts/modernizr.custom.js"></script>';  
    }

  
    public function _remap($job_id, $language_iso_2) {

        if(!empty($language_iso_2)){
            $language_iso_2 = $language_iso_2[0];
        }else
        {
            $language_iso_2 = null;
        }
      
        $this->index($job_id, $language_iso_2);
    }
 

    // --------------------------------------------------------------------------------------------
    // PUBLIC METHODS
    // --------------------------------------------------------------------------------------------

    public function index($job_id = NULL, $language_iso_2 = null)
    {
    	//echo '*** index()</p>';

        $this->user_session->set();

        if($this->session->userdata('language_iso_2')){

            $this->user_language->set_by_mixed_input('apply_lang', $this->session->userdata('language_iso_2'));
        }

        if($language_iso_2 != null){

            $this->user_language->set_by_mixed_input('apply_lang', $language_iso_2);
        }

        // --------------------------------------------------------------------------------------------
        // RESET - VALIDATION
        // --------------------------------------------------------------------------------------------

        $upload_valid       = 'FALSE';
        $form_valid         = 'FALSE';

        // --------------------------------------------------------------------------------------------
        // PAGE HEADER - ERROR - NO ID
        // --------------------------------------------------------------------------------------------

    	if($job_id == 'index')
    	{ 
            $data['message_error_title']           = $this->lang->line('message_error_no_id_title');
            $data['message_error_body']            = $this->lang->line('message_error_no_id_body');

            $this->header_display();
            $this->job_display_error($data);

            return;
    	}
        else
        {
            // --------------------------------------------------------------------------------------------
            // GET JOB
            // --------------------------------------------------------------------------------------------

            $jobs_data = $this->job_get($job_id);

            // --------------------------------------------------------------------------------------------
            // PAGE HEADER - ERROR - NO JOB OR EXPIRED
            // --------------------------------------------------------------------------------------------

            if(count($jobs_data) == 0)
            {
                $data['message_error_title']       = $this->lang->line('message_error_no_job_title');
                $data['message_error_body']        = $this->lang->line('message_error_no_job_body');

                $this->header_display();
                $this->job_display_error($data);

                return;
            }

            // --------------------------------------------------------------------------------------------
            // SET LANGUAGE - BY JOB LANGUAGE
            // --------------------------------------------------------------------------------------------
            
            if(!$this->session->userdata('language_iso_2')){

                $this->user_language->set_by_job_language('apply_lang', $jobs_data['language_id']);
            }

            // --------------------------------------------------------------------------------------------
            // DISPLAY HEADER
            // --------------------------------------------------------------------------------------------

            $this->header_display();

            // --------------------------------------------------------------------------------------------
            // COLLECT DATA
            // --------------------------------------------------------------------------------------------

            $back_button                            = $this->uri_back_button();

            $data['back_button_uri']                = $back_button['back_button_uri'];
            $data['back_button_text']               = $back_button['back_button_text'];
            $data['page_title_job']                 = $this->lang->line('page_title_job');
            $data['page_title_apply']               = $this->lang->line('page_title_apply');
            $data['message_success_title']          = $this->lang->line('message_success_title');
            $data['message_success_body']           = $this->lang->line('message_success_body');
            $data['message_apply_title']            = $this->lang->line('message_apply_title');
            $data['page_title_apply']               = $this->lang->line('page_title_apply');
            $data['label_salary']                   = $this->lang->line('label_salary');
            $data['label_location']                 = $this->lang->line('label_location');
            $data['label_job_type']                 = $this->lang->line('label_job_type');
            $data['label_telephone']                = $this->lang->line('label_telephone');
            $data['label_email']                    = $this->lang->line('label_email');

            $data['job_id']                         = $jobs_data['job_id'];
            $data['job_type_id']                    = $jobs_data['job_type_id'];
            $data['job_title']                      = $jobs_data['job_title'];
            $data['job_salary']                     = $jobs_data['job_salary'];
            $data['job_location_text']              = $jobs_data['job_location_text'];
            $data['job_type_name']                  = $jobs_data['job_type_name']; 
            $data['office_telephone']               = $jobs_data['office_telephone']; 
            $data['job_response_email']             = $jobs_data['job_response_email'];
            $data['consultant_name']                = $jobs_data['consultant_name'];
            $data['job_external_reference']         = $jobs_data['job_external_reference'];

            // --------------------------------------------------------------------------------------------
            // VALIDATE UPLOAD
            // --------------------------------------------------------------------------------------------

            if(count($this->input->post(NULL)) > 0){

                $this->upload_rules();
                $upload_valid = $this->upload_validate();
            }

            // --------------------------------------------------------------------------------------------
            // VALIDATE FORM
            // --------------------------------------------------------------------------------------------

            $this->form_rules($data);
            $this->set_hidden_fields($data);

            $form_valid = $this->form_validate($data);

            // --------------------------------------------------------------------------------------------
            // DISPLAY - FORM FAIL - UPLOAD FAIL
            // --------------------------------------------------------------------------------------------

            if($form_valid == 'FALSE'){

                $this->job_display($data);
                
                if($upload_valid == 'FALSE'){

                    if(count($this->input->post(NULL)) > 0)
                    {
                        $this->upload_fail();
                    }
                }

                $this->form_display();
            }

            // --------------------------------------------------------------------------------------------
            // DISPLAY - FORM SUCCESS - UPLOAD NONE, FAIL, SUCCESS
            // --------------------------------------------------------------------------------------------         

            if($form_valid == 'TRUE'){

                if($upload_valid == 'NONE' || $upload_valid == 'TRUE' )
                {
                    $data = $this->job_display_success($data);

                    if($upload_valid == 'NONE')
                    {
                        $this->send_mail_no_cv($data);
                    }

                    if($upload_valid == 'TRUE' )
                    {
                        $this->send_mail_with_cv($data);
                    }

                    $this->store_data();
                }

                if($upload_valid == 'FALSE')
                {
                    $this->job_display($data);
                    $this->upload_fail();
                    $this->form_display();
                }
            }

            // --------------------------------------------------------------------------------------------
    	}
    }

    // --------------------------------------------------------------------------------------------
    // SEND MAIL
    // --------------------------------------------------------------------------------------------

    private function send_mail_no_cv($data)
    {
        //echo '*** send_mail_no_cv()</p>';
        $this->hncom_mailer->mail_no_cv($data);
    }

    private function send_mail_with_cv($data)
    {
        //echo '*** send_mail_with_cv()</p>';

        $file_name = $this->upload_success();

        $data['file_name'] = $file_name;

        $this->session->set_userdata('candidate_cv', $data['file_name']);
        $this->hncom_mailer->mail_with_cv($data);
    }

    // --------------------------------------------------------------------------------------------
    // STORE DATA
    // --------------------------------------------------------------------------------------------

    private function store_data()
    {
        //echo '*** store_data()</p>';

        $this->job->close();
        
        $this->job->apply(  $candidate_first_name       = $this->session->userdata('candidate_first_name'), 
                            $candidate_middle_name      = $this->session->userdata('candidate_middle_name') , 
                            $candidate_last_name        = $this->session->userdata('candidate_last_name'), 
                            $candidate_salutation       = $this->session->userdata('candidate_salutation'), 
                            $candidate_email            = $this->session->userdata('candidate_email'), 
                            $candidate_phone_home       = $this->session->userdata('candidate_phone_home'), 
                            $candidate_phone_mobile     = $this->session->userdata('candidate_phone_mobile'), 
                            $candidate_cv               = $this->session->userdata('candidate_cv'), 
                            $job_application_campaign   = $this->session->userdata('job_application_campaign'), 
                            $job_application_Keyword    = $this->session->userdata('job_application_Keyword'), 
                            $job_appication_location    = $this->session->userdata('job_application_location'), 
                            $job_id                     = $this->session->userdata('job_id'), 
                            $job_title                  = $this->session->userdata('job_title'), 
                            $job_type_id                = $this->session->userdata('job_type_id'));
    }

    // --------------------------------------------------------------------------------------------
    // FORM RULES
    // --------------------------------------------------------------------------------------------

    private function form_rules($data)
    {
        //echo '*** form_rules()</p>';

        $config = array(
            array(
                'field'     => 'candidate_first_name',
                'label'     => $this->lang->line('label_first_name'),
                'rules'     => 'required|trim|min_length[3]|max_length[60]|regex_match[/^[a-zA-Z]*$/]',
                'errors'    => array(
                    'min_length'    => '%s'.': '.$this->lang->line('error_validate_name_min'),
                    'max_length'    => '%s'.': '.$this->lang->line('error_validate_name_max'),
                    'required'      => '%s'.': '.$this->lang->line('error_validate_name_first'),
                    'regex_match'   => '%s'.': '.$this->lang->line('error_validate_name_alphabet')),
                'value'     => $this->session->userdata('candidate_first_name')
                ),
            array(
                'field'     => 'candidate_middle_name',
                'label'     => $this->lang->line('label_middle_name'),
                'rules'     => 'trim|min_length[3]|max_length[60]|regex_match[/^[a-zA-Z]*$/]',
                'errors'    => array(
                    'min_length'    => '%s'.': '.$this->lang->line('error_validate_name_min'),
                    'max_length'    => '%s'.': '.$this->lang->line('error_validate_name_max'),
                    'regex_match'   => '%s'.': '.$this->lang->line('error_validate_name_alphabet')),
                'value'     => $this->session->userdata('candidate_middle_name')
                ),
            array(
                'field'     => 'candidate_last_name',
                'label'     => $this->lang->line('label_last_name'),
                'rules'     => 'required|trim|min_length[3]|max_length[60]|regex_match[/^[a-zA-Z]*$/]',
                'errors'    => array(
                    'min_length'    => '%s'.': '.$this->lang->line('error_validate_name_min'),
                    'max_length'    => '%s'.': '.$this->lang->line('error_validate_name_max'),
                    'required'      => '%s'.': '.$this->lang->line('error_validate_name_last'),
                    'regex_match'   => '%s'.': '.$this->lang->line('error_validate_name_alphabet')),
                'value'     => $this->session->userdata('candidate_last_name')
                ),
            array(
                'field'     => 'candidate_salutation',
                'label'     => $this->lang->line('label_salutation'),
                'rules'     => 'trim|min_length[1]|max_length[4]|regex_match[/^[a-zA-Z]*$/]',
                'errors'    => array(
                    'min_length'    => '%s'.': '.$this->lang->line('error_validate_name_min'),
                    'max_length'    => '%s'.': '.$this->lang->line('error_validate_name_max'),
                    'regex_match'   => '%s'.': '.$this->lang->line('error_validate_name_alphabet')),

                'value'     => $this->session->userdata('candidate_salutation')
                ),
            array(
                'field'     => 'candidate_email',
                'label'     => $this->lang->line('label_email'),
                'rules'     => 'required|trim|valid_email',
                'errors'    => array(
                    'required'      => '%s'.': '.$this->lang->line('error_validate_email'),
                    'trim'          => '%s'.': '.$this->lang->line('error_validate_email'),
                    'valid_email'   => '%s'.': '.$this->lang->line('error_validate_email')),
                'value'     => $this->session->userdata('candidate_email')
                ),
            array(
                'field'     => 'candidate_phone_home',
                'label'     => $this->lang->line('label_phone_home'),
                'rules'     => 'trim|min_length[9]|max_length[14]|regex_match[/^[0-9 +]+$/]',
                'errors'    => array(
                    'min_length'    => '%s'.': '.$this->lang->line('error_validate_tel_min'),
                    'max_length'    => '%s'.': '.$this->lang->line('error_validate_tel_max'),
                    'regex_match'   => '%s'.': '.$this->lang->line('error_validate_tel_numbers')),
                'value'     => $this->session->userdata('candidate_phone_home')
                ),
            array(
                'field'     => 'candidate_phone_mobile',
                'label'     => $this->lang->line('label_phone_mobile'),
                'rules'     => 'trim|min_length[9]|max_length[14]|regex_match[/^[0-9 +]+$/]',
                'errors'    => array(
                    'min_length'    => '%s'.': '.$this->lang->line('error_validate_tel_min'),
                    'max_length'    => '%s'.': '.$this->lang->line('error_validate_tel_max'),
                    'regex_match'   => '%s'.': '.$this->lang->line('error_validate_tel_numbers')),
                'value'     => $this->session->userdata('candidate_phone_mobile')
                ),
            array(
                'field'     => 'candidate_cv',
                'label'     => $this->lang->line('label_cv'),
                'rules'     => '',
                'errors'    => array(),
                'value'     => $this->session->userdata('candidate_cv')
                ),
            array(
                'field'     => 'job_application_campaign',
                'label'     => 'Job Campaign',
                'rules'     => 'trim|min_length[3]|max_length[60]|regex_match[/^[a-zA-Z0-9, ]*$/]',
                'errors'    => array(
                    'min_length'    => 'ou must provide a %s with 3 characters minimum',
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
                ),
            array(
                'feild'     => 'consultant_name',
                'label'     => 'consultant_name',
                'rules'     => 'required|trim|min_length[3]|max_length[60]|regex_match[/^[a-zA-Z0-9]*$/]',
                'errors'    => array(
                    'min_length'    => 'You must provide a %s with 3 characters minimum',
                    'max_length'    => 'You must provide a %s with 60 characters maximum',
                    'required'      => 'For %s required.',
                    'regex_match'   => 'For %s only characters, numbers and spaces are allowed.'),
                'value'     => $this->session->userdata('consultant_name')
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
    // DISPLAY
    // --------------------------------------------------------------------------------------------

    private function form_display()
    {
        //echo '*** form_display()</p>';

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
        $apply_data['consultant_name']             = $this->session->userdata('consultant_name');    

        $apply_data['label_form_errors']           = $this->lang->line('label_form_errors');
        $apply_data['label_first_name']            = $this->lang->line('label_first_name');        
        $apply_data['label_middle_name']           = $this->lang->line('label_middle_name');
        $apply_data['label_last_name']             = $this->lang->line('label_last_name');
        $apply_data['label_salutation']            = $this->lang->line('label_salutation');
        $apply_data['label_email']                 = $this->lang->line('label_email');
        $apply_data['label_phone_home']            = $this->lang->line('label_phone_home');
        $apply_data['label_phone_mobile']          = $this->lang->line('label_phone_mobile');
        $apply_data['label_candidate_cv']          = $this->lang->line('label_candidate_cv');

        $apply_data['button_upload_cv']            = $this->lang->line('button_upload_cv');
        $apply_data['button_submit']               = $this->lang->line('button_submit');

        // --------------------------------------------------------------------------------------------
                
        $this->load->view('forms/form_apply',$apply_data);
    }

    // --------------------------------------------------------------------------------------------
    // UPLOAD RULES
    // --------------------------------------------------------------------------------------------
    
    private function upload_rules()
    {
        //echo '*** upload_rules()</p>';

        $this->config_upload['upload_path']       = './uploads/';
        $this->config_upload['allowed_types']     = 'pdf|txt|doc|docx';
        $this->config_upload['max_size']          = 4096;
        $this->config_upload['encrypt_name']      = TRUE;
    }

    // --------------------------------------------------------------------------------------------
    // UPLOAD VALIDATE
    // --------------------------------------------------------------------------------------------

    private function upload_validate()
    {
        //echo '*** upload_validate()</p>';

        $this->load->library('upload', $this->config_upload);

        if (!$this->upload->do_upload('candidate_cv'))
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

        $data['message_error_title']    = $this->lang->line('message_error_upload_fail');
        $data['message_error_body']     = $this->upload->display_errors();//'$message_error_title'//

        $this->load->view('job/job_display_error_upload', $data);
    }

    // --------------------------------------------------------------------------------------------
    // UPLOAD SUCCESS
    // --------------------------------------------------------------------------------------------

    private function upload_success()
    {
        //echo '*** upload_success()</p>';   

        $data = array('upload_data' => $this->upload->data());

        $file_name  = $data['upload_data']['file_name'];

        //echo '*** $file_name : '.$file_name.'</p>';

        return $file_name;
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

        $this->job->close();

        return $data;
    }

    // --------------------------------------------------------------------------------------------
    // DISPLAY
    // --------------------------------------------------------------------------------------------

    private function header_display()
    {
        $data['page_title_red']     = $this->lang->line('page_title_job');
        $data['page_title_black']   = $this->lang->line('page_title_apply');

        $this->load->view('page/page_display_header', $data);
    }

    // --------------------------------------------------------------------------------------------
    // DISPLAY
    // --------------------------------------------------------------------------------------------

    private function job_display($data)
    {
        //$this->load->view('page/page_display_header', $data);
        $this->load->view('job/job_display_small_apply', $data);
    }

    // --------------------------------------------------------------------------------------------
    // DISPLAY
    // --------------------------------------------------------------------------------------------

    private function job_display_error($data)
    {
        $this->load->view('job/job_display_error_apply', $data);
    }

    private function job_display_success($data)
    {
        //$this->load->view('page/page_display_header', $data);
        $this->load->view('job/job_display_success_apply', $data);

        $data['candidate_first_name']       = $this->session->userdata('candidate_first_name');
        $data['candidate_middle_name']      = $this->session->userdata('candidate_middle_name'); 
        $data['candidate_last_name']        = $this->session->userdata('candidate_last_name'); 
        $data['candidate_salutation']       = $this->session->userdata('candidate_salutation'); 
        $data['candidate_email']            = $this->session->userdata('candidate_email');
        $data['candidate_phone_home']       = $this->session->userdata('candidate_phone_home'); 
        $data['candidate_phone_mobile']     = $this->session->userdata('candidate_phone_mobile'); 
        $data['candidate_cv']               = $this->session->userdata('candidate_cv');
        $data['job_application_campaign']   = $this->session->userdata('job_application_campaign');
        $data['job_application_Keyword']    = $this->session->userdata('job_application_Keyword');
        $data['job_appication_location']    = $this->session->userdata('job_application_location'); 
        $data['job_id']                     = $this->session->userdata('job_id');
        $data['job_title']                  = $this->session->userdata('job_title'); 
        $data['job_type_id']                = $this->session->userdata('job_type_id');
        $data['consultant_name']            = $this->session->userdata('consultant_name');    

        return $data;
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
        $session_data['consultant_name']             = $data['consultant_name'];   

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

        $data['back_button_uri']    = $this->session->userdata('uri_back');
        $data['back_button_text']   = $this->lang->line('button_back');;

        return $data;
    }
}