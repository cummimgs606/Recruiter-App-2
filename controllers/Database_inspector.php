<?php

class Database_inspector extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('table'); 
    }

    public function index()
    {
        $path       = 'http://10.3.5.56/index.php/database_inspector/';
        $procedures = [ 'brand_details_get',
                        'brand_get_by_consultant',
                        'consultant_details_get',
                        'consultant_details_get_by_brand',
                        'consultant_details_get_by_office',
                        'consultant_details_get_by_team',
                        'consultant_details_search',
                        'consultant_bio_get',
                        'consultant_practice_get_by_consultant',
                        'consultant_practice_get_by_consultant_row_count',
                        'consultant_practice_get_by_practice',
                        'country_get',
                        'country_get_by_brand_consultant',
                        'country_get_by_office_consultant',
                        'job_apply',
                        'job_get',
                        'job_get_row_count',
                        'job_search',
                        'job_search_row_count',
                        'job_alert_compile',
                        'job_alert_get',
                        'job_alert_get_row_count',
                        'job_alert_subscribe',
                        'job_alert_unsubscribe',
                        'job_type',
                        'language_get',
                        'office_details_get',
                        'office_get_by_consultant',
                        'office_get_by_country',
                        'practice_get',
                        'practice_get_by_practice_linked',
                        'team_details_get',
                        'team_details_get_by_consultant'
                        ];

		echo  '<H1>Database Connector</H1>';
        echo '<ul>';

            foreach ($procedures as $value) {
                echo '<li><a href='.$path.$value.'>'.$value.'()</a></li>';  //$value;
            } 

        echo '</ul>';  
    }


    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//


    public function brand_details_get()
    {
        $brand_id        = 'NULL';
        $country_id      = 'NULL';
            
        $this->load->model('procedures/brand_details');

        $data['page_title']     = 'Brands';
        $data['page_header']    = 'Brands';
        $data['query']          = $this->brand_details->get($brand_id, 
                                                            $country_id);
        $this->load->view('procedures/table', $data);
    }


    public function brand_get_by_consultant($consultant_id = 'NULL')
    {

        $this->load->model('procedures/brand_details');

        $data['page_title']     = 'Brands_get_by_consultant';
        $data['page_header']    = 'Brands Get By Consultant';
        $data['query']          = $this->brand_details->get_by_consultant($consultant_id);
        $this->load->view('procedures/table', $data);
    }

    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//


    public function consultant_details_get($consultant_id = 'NULL')
    {
        $deleted                = 0; 

        $this->load->model('procedures/consultant_details');
            
        $data['page_title']     = 'Consultant_get';
        $data['page_header']    = 'Consultant Get';
        $data['query']          = $this->consultant_details->get(   $consultant_id, 
                                                                    $deleted );
        $this->load->view('procedures/table', $data);
    }
    
    public function consultant_details_get_by_brand($brand_id = 1)
    { 
        $deleted    = 0;

        $this->load->model('procedures/consultant_details');
            
        $data['page_title']     = 'Consultant_get_by_brand';
        $data['page_header']    = 'Consultant Get By Brand';
        $data['query']          = $this->consultant_details->get_by_brand(  $brand_id, 
                                                                            $deleted);

        $this->load->view('procedures/table', $data);
    }

    public function consultant_details_get_by_office($office_id = 2) 
    {
        $deleted        = 0;

        $this->load->model('procedures/consultant_details');
        
        $data['page_title']     = 'Consultant_get_by_office';
        $data['page_header']    = 'Consultant Get By Office';
        $data['query']          = $this->consultant_details->get_by_office( $office_id,
                                                                            $deleted);

        $this->load->view('procedures/table', $data);  
    }

    public function consultant_details_get_by_team($team_id  = 1) 
    {
        $deleted     = 0;

        $this->load->model('procedures/consultant_details');
            
        $data['page_title']     = 'Consultant_get_by_team';
        $data['page_header']    = 'Consultant Get By Team';
        $data['query']          = $this->consultant_details->get_by_team(   $team_id ,
                                                                            $deleted);

        $this->load->view('procedures/table', $data);  
    }

    public function consultant_details_search() 
    {
        $consultant_ids         = '';
        $consultant_first_name  = '';
        $consultant_last_name   = '';
        $consultant_email       = '';
        $office_id              = 'NULL';
        $office_country_id      = 'NULL';
        $practice_id            = '';
        $team_id                = 'NULL';
        $brand_id               = 'NULL';
        $brand_country_id       = 'NULL';

        $this->load->model('procedures/consultant_details');
            
        $data['page_title']     = 'Consultant_search';
        $data['page_header']    = 'Consultant Search';
        $data['query']          = $this->consultant_details->search(    $consultant_ids,
                                                                        $consultant_first_name,
                                                                        $consultant_last_name, 
                                                                        $consultant_email,
                                                                        $office_id, 
                                                                        $office_country_id, 
                                                                        $practice_id, 
                                                                        $team_id, 
                                                                        $brand_id, 
                                                                        $brand_country_id);

        $this->load->view('procedures/table', $data);
    }


    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//


    public function consultant_bio_get()
    {
        $consultant_id      = 'NULL';
        $bio_brand_id       = 'NULL';
        $bio_language_id    = 'NULL';
        $bio_team_id        = 'NULL';
        $bio_deleted        = 0;
        
        $this->load->model('procedures/consultant_bio');

        $data['page_title']     = 'Consultant_bio_get';
        $data['page_header']    = 'Consultant Bio Get';
        $data['query']          = $this->consultant_bio->get(   $consultant_id,
                                                                $bio_brand_id,
                                                                $bio_language_id,
                                                                $bio_team_id,
                                                                $bio_deleted);

        $this->load->view('procedures/table', $data);	
    }


    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//


    public function consultant_practice_get_by_consultant()
    {
        $consultant_id                    = '1,2,3,4';
        $consultant_practice_deleted      = 0;
        
        $this->load->model('procedures/consultant_practice');

        $data['page_title']     = 'Consultant_practice_get_by_consultant';
        $data['page_header']    = 'Consultant Practice Get By Consultant';
        $data['query']          = $this->consultant_practice->get_by_consultant(    $consultant_id,
                                                                                    $consultant_practice_deleted);

        $this->load->view('procedures/table', $data);   
    }
   
    public function consultant_practice_get_by_consultant_row_count()
    {
        $consultant_id                    = '1,2,3,4';
        $consultant_practice_deleted      = 0;
        
        $this->load->model('procedures/consultant_practice');


        $data['page_title']     = 'Consultant_practice_get_by_consultant';
        $data['page_header']    = 'Consultant Practice Get By Consultant';
        $data['query']          = $this->consultant_practice->get_by_consultant_row_count(  $consultant_id,
                                                                                            $consultant_practice_deleted);

        $this->load->view('procedures/table', $data);          
    }

    public function consultant_practice_get_by_practice()
    {
        $practice_ids = '1,2,3,4';

        $this->load->model('procedures/consultant_practice');

        $data['page_title']     = 'Consultant_practice_get_by_practice';
        $data['page_header']    = 'Consultant Practice Get By Practice';
        $data['query']          = $this->consultant_practice->get_by_practice(  $practice_ids);

        $this->load->view('procedures/table', $data);   
    }


    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//


    public function country_get()
    {
        $country_id = 'NULL';

        $this->load->model('procedures/country');

        $data['page_title']     = 'Country_get';
        $data['page_header']    = 'Country Get';
        $data['query']          = $this->country->get($country_id);

        $this->load->view('procedures/table', $data);   
    }

    public function country_get_by_brand_consultant()
    {
        $this->load->model('procedures/country');

        $data['page_title']     = 'Country_get_by_brand_consultant';
        $data['page_header']    = 'Country Get By Brand Consultant';
        $data['query']          = $this->country->get_by_brand_consultant();

        $this->load->view('procedures/table', $data);   
    }

    public function country_get_by_office_consultant()
    {
        $this->load->model('procedures/country');

        $data['page_title']     = 'Country_get_by_office_consultant';
        $data['page_header']    = 'Country Get By Office Consultant';
        $data['query']          = $this->country->get_by_office_consultan();

        $this->load->view('procedures/table', $data);   
    }


    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//


    public function job_apply()
    {
        $candidate_first_name       = '1FN'; 
        $candidate_middle_name      = '1MN'; 
        $candidate_last_name        = '1LN'; 
        $candidate_salutation       = '1MR'; 
        $candidate_email            = '1@e.com'; 
        $candidate_phone_home       = '12345'; 
        $candidate_phone_mobile     = '10987'; 
        $candidate_cv               = '1CV.doc'; 
        $job_application_campaign   = '1AP'; 
        $job_application_Keyword    = '1AK'; 
        $job_appication_location    = '1AL'; 
        $job_id                     = 11; 
        $job_title                  = '1JT'; 
        $job_type_id                = 3;

        $this->load->model('procedures/job');

        $data['page_title']     = 'Job_apply';
        $data['page_header']    = 'Job Apply';
        $data['query']          = $this->job->apply($candidate_first_name,
                                                    $candidate_middle_name, 
                                                    $candidate_last_name, 
                                                    $candidate_salutation, 
                                                    $candidate_email, 
                                                    $candidate_phone_home, 
                                                    $candidate_phone_mobile, 
                                                    $candidate_cv, 
                                                    $job_application_campaign, 
                                                    $job_application_Keyword, 
                                                    $job_appication_location, 
                                                    $job_id, 
                                                    $job_title, 
                                                    $job_type_id);

        $data['query']          = $this->job->apply();

        $this->load->view('procedures/table', $data);   
    }

    public function job_get()
    {

        $job_ids     = '';
        $deleted     = 0;
        $expired     = 0;
        $row_start   = 0; 
        $row_amount  = 'NULL';

        $this->load->model('procedures/job');

        $data['page_title']     = 'Job_get';
        $data['page_header']    = 'Job Get';
        $data['query']          = $this->job->get(  $job_ids, 
                                                    $deleted, 
                                                    $expired, 
                                                    $row_start, 
                                                    $row_amount);

        $this->load->view('procedures/table', $data); 
        //var_dump( $data['query']);
    }

    public function job_get_row_count()
    {
        $job_id     = '';
        $deleted    = 0;
        $expired    = 0;

        $this->load->model('procedures/job');

        $data['page_title']     = 'Job_get_row_count(';
        $data['page_header']    = 'Job Get Row Count';
        $data['query']          = $this->job->get_row_count(    $job_id,
                                                                $deleted,
                                                                $expired);
       

        $this->load->view('procedures/table', $data);  
        //var_dump( $data['query']);
    }

    public function job_search()
    {
        $keyword        = ''; 
        $location       = ''; 
        $country_id     = 'NULL'; 
        $job_type_id    = 'NULL'; 
        $brand_id       = 'NULL'; 
        $row_start      = 0; 
        $row_amount     = 'NULL';

        $this->load->model('procedures/job');

        $data['page_title']     = 'Job_search_row_count';
        $data['page_header']    = 'Job Search Row Count';
        $data['query']          = $this->job->search(   $keyword, 
                                                        $location, 
                                                        $country_id, 
                                                        $job_type_id, 
                                                        $brand_id, 
                                                        $row_start, 
                                                        $row_amount);

        $this->load->view('procedures/table', $data);   
    }     

    public function job_search_row_count()
    {
        $keyword        = '';
        $location       = '';
        $country_id     = 'NULL';
        $job_type_id    = 'NULL'; 
        $brand_id       = 'NULL'; 

        $this->load->model('procedures/job');

        $data['page_title']     = 'Job_search_row_count';
        $data['page_header']    = 'Job Search Row Count';
        $data['query']          = $this->job->search_row_count( $keyword,
                                                                $location,
                                                                $country_id,
                                                                $job_type_id, 
                                                                $brand_id);

        $this->load->view('procedures/table', $data);   
    }


    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//


    public function job_alert_compile()
    {
        $this->load->model('procedures/job_alert');

        $data['page_title']     = 'Job_alert_compile';
        $data['page_header']    = 'Job Alert Compile';
        $data['query']          = $this->job_alert->compile();

        $this->load->view('procedures/table', $data);   
    }

    public function job_alert_get()
    {
        $row_start      = 0; 
        $row_amount     = 'NULL';
   
        $this->load->model('procedures/job_alert');

        $data['page_title']     = 'Job_alert_get';
        $data['page_header']    = 'Job Alert Get';
        $data['query']          = $this->job_alert->get($row_start,
                                                        $row_amount);
        
        $this->load->view('procedures/table', $data);   
    } 

    public function job_alert_get_row_count() 
    {
        $this->load->model('procedures/job_alert');
                        
        $sql = "CALL pr_job_alert_get_row_count()";
                                                    
        $data['page_title']     = 'Job_alert_get';
        $data['page_header']    = 'Job Alert Get';
        $data['query']          = $this->job_alert->get_row_count();

        $this->load->view('procedures/table', $data); 
    }
    
    public function job_alert_subscribe() 
    {

        $index = 7;

        $candidate_first_name               = $index.'FN'; 
        $candidate_middle_name              = $index.'LN';  
        $candidate_last_name                = $index.'MN'; 
        $candidate_salutation               = $index.'S';  
        $candidate_email                    = $index.'@email.com';  
        $candidate_phone_home               = $index.'123456';  
        $candidate_phone_mobile             = $index.'654321';  
        $job_alert_subscription_keyword     = 'Junior';  
        $job_alert_subscription_location    = 'London';  
        $job_type_id                        = 'NULL';
        $brand_id                           = 'NULL';  
        $country_id                         = 'NULL';  
        $language_id                        = 'NULL';

        $this->load->model('procedures/job_alert');
                                                    
        $data['page_title']     = 'Job_alert_subscribe';
        $data['page_header']    = 'Job Alert Subscribe';
        $data['query']          = $this->job_alert->subscribe( $candidate_first_name, 
                                                                $candidate_middle_name,
                                                                $candidate_last_name,
                                                                $candidate_salutation,
                                                                $candidate_email,
                                                                $candidate_phone_home,
                                                                $candidate_phone_mobile,
                                                                $job_alert_subscription_keyword,
                                                                $job_alert_subscription_location,
                                                                $job_type_id,
                                                                $brand_id,
                                                                $country_id,
                                                                $language_id);

        $this->load->view('procedures/table', $data);   
    }

    public function job_alert_unsubscribe() 
    {
        $index              = 7;
        $candidate_email    = $index.'@email.com';  
 

        $this->load->model('procedures/job_alert');
                                                    
        $data['page_title']     = 'Job_alert_unsubscribe';
        $data['page_header']    = 'Job Alert Unsubscribe';
        $data['query']          = $this->job_alert->unsubscribe( $candidate_email);

        $this->load->view('procedures/table', $data);  
    }

    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//


    public function job_type()
    {
        $job_type_id = 'NULL';

        $this->load->model('procedures/job_type');

        $data['page_title']     = 'Job_type';
        $data['page_header']    = 'Job Type';
        $data['query']          = $this->job_type->get($job_type_id);

        $this->load->view('procedures/table', $data);   
    }


    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//


    public function language_get()
    {
        $this->load->model('procedures/language');

        $data['page_title']     = 'Language';
        $data['page_header']    = 'Language';
        $data['query']          = $this->language->get();

        $this->load->view('procedures/table', $data);   
    }


    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//


    public function office_details_get()
    {
        $office_id = 'NULL';

        $this->load->model('procedures/office_details');

        $data['page_title']     = 'Office_details';
        $data['page_header']    = 'Office Details';
        $data['query']          = $this->office_details->get($office_id);

        $this->load->view('procedures/table', $data);   
    }

    public function office_get_by_consultant($consultant_id = 'NULL')
    {

        $this->load->model('procedures/office_details');

        $data['page_title']     = 'Office_get_by_consultant';
        $data['page_header']    = 'Office Get By Consultant';
        $data['query']          = $this->office_details->get_by_consultant($consultant_id);

        $this->load->view('procedures/table', $data); 
    }

    public function office_get_by_country($country_id = 'NULL')
    {

        $this->load->model('procedures/office_details');

        $data['page_title']     = 'Office_get_by_country';
        $data['page_header']    = 'Office Get By Country';
        $data['query']          = $this->office_details->get_by_country($country_id);

        $this->load->view('procedures/table', $data); 
    }

    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//


    public function practice_get()
    {
        $practice_id = 'NULL';

        $this->load->model('procedures/practice');

        $data['page_title']     = 'Practice';
        $data['page_header']    = 'Practice';
        $data['query']          = $this->practice->get($practice_id);

        $this->load->view('procedures/table', $data);   
    }

    public function practice_get_by_practice_linked()
    {
        $practice_ids = '1';

        $this->load->model('procedures/practice');

        $data['page_title']     = 'Practice_get_by_practice_linked';
        $data['page_header']    = 'Practice Get By Practice Linked';
        $data['query']          = $this->practice->get_by_practice_linked($practice_ids);

        $this->load->view('procedures/table', $data);   
    }


    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//


    public function team_details_get()
    {
        $team_id    = 'NULL'; 
        $brand_id   = 'NULL';

        $this->load->model('procedures/team_details');

        $data['page_title']     = 'Team_details';
        $data['page_header']    = 'Team Details';
        $data['query']          = $this->team_details->get( $team_id,
                                                            $brand_id);

        $this->load->view('procedures/table', $data);   
    }

    public function team_details_get_by_consultant($consultant_id = 'NULL')
    {
        $this->load->model('procedures/team_details');

        $data['page_title']     = 'Team_details';
        $data['page_header']    = 'Team Details';
        $data['query']          = $this->team_details->get_by_consultant($consultant_id);

        $this->load->view('procedures/table', $data);   
    }


    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//
    //----------------------------------------------------------------------------------------------//
}