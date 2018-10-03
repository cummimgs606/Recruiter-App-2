<?php

class Consultant extends CI_Controller {

    //protected $method          = '';
    //protected $method_value    = '';

	public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library('dropdown');
        $this->load->library('form_validation');
        $this->load->library('session'); 
        $this->load->library('user_session');
        $this->load->library('user_language');

        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('url'); 

        $this->load->model('procedures/brand_details');
        $this->load->model('procedures/country');
        $this->load->model('procedures/consultant_bio');
        $this->load->model('procedures/consultant_details');
        $this->load->model('procedures/consultant_practice');
        $this->load->model('procedures/office_details');
        $this->load->model('procedures/practice');
        $this->load->model('procedures/team_details');
        
        echo '<link rel = "stylesheet" type = "text/css"  href = "'.base_url().'css/codeignitor/colours.css"/>';
        echo '<link rel = "stylesheet" type = "text/css"  href = "'.base_url().'css/codeignitor/flex-list.css"/>';

        echo link_tag('frame-work/version-2016-r1-v2/css/button-as-text.css');
        echo link_tag('frame-work/version-2016-r1-v2/css/main.css');
        echo link_tag('frame-work/version-2016-r1-v2/javascripts/modernizr.custom.js');

        //$this->user_language->set_by_iso2('consultant_lang', 'en');
        //$this->page_display_header();
        
    }

    // --------------------------------------------------------------------------------------------
    // PAGE DISPLAY HEADER
    // --------------------------------------------------------------------------------------------

    private function page_display_header()
    {
        $data['page_title_red']         = $this->lang->line('page_title_consultant');
        $data['page_title_black']       = $this->lang->line('page_title_find');

        $this->load->view('page/page_display_header', $data);
    }

    private function set_language($language_iso_2)
    {
        $this->user_language->set_by_mixed_input('consultant_lang', $language_iso_2);

        return is_numeric ($language_iso_2) ? $language_iso_2 : 'NULL';
    }

    // --------------------------------------------------------------------------------------------
    // PUBLIC METHODS
    // --------------------------------------------------------------------------------------------


    public function find($language_iso_2 = 'NULL')
    {
        $this->set_language($language_iso_2);
        $this->page_display_header();

        $data['header_find_a_consultant']       = $this->lang->line('header_find_a_consultant');
        $data['header_find_brand']              = $this->lang->line('header_find_brand');
        $data['header_find_id']                 = $this->lang->line('header_find_id');
        $data['header_find_office']             = $this->lang->line('header_find_office');
        $data['header_find_practice']           = $this->lang->line('header_find_practice');
        $data['header_find_search']             = $this->lang->line('header_find_search');
        $data['header_find_team']               = $this->lang->line('header_find_team');
        $data['header_find_country_practice']   = $this->lang->line('header_find_country_practice');

        $this->load->view('consultant/consultant_list_find', $data); 
        $this->uri_last();
    }


    // --------------------------------------------------------------------------------------------
    // PUBLIC METHODS
    // --------------------------------------------------------------------------------------------

    public function find_by_brand($brand_id = 'NULL', $consultant_id  = 'NULL')
    {

        $brand_id = $this->set_language($brand_id);
        $this->page_display_header();

        $array_1 = [];
        $array_2 = [];

        echo '*** find_by_brand('.$brand_id.','.$consultant_id.')</p>';

        if($consultant_id != NULL)
        {
            $query_1 = $this->brand_details->get_by_consultant($consultant_id);
            $array_1 = new ArrayObject($query_1->result_array());

            $query_1->next_result(); 
            $query_1->free_result(); 
        }  

        if($brand_id != NULL)
        {
            $query_2 = $this->consultant_details->get_by_brand($brand_id, 'NULL');
            $array_2 = new ArrayObject($query_2->result_array());

            $query_2->next_result(); 
            $query_2->free_result(); 
        } 

        $data['result_1']       = $array_1;
        $data['result_2']       = $array_2;
        $data['page_header']    = $this->lang->line('header_find_brand');
        $data['page_header_1']  = $this->lang->line('label_brand');
        $data['page_header_2']  = $this->ArrayObject_get_value($array_1,'brand_id',$brand_id,'brand_name',$this->lang->line('label_brand'));
        $data['uri_back']       = 'consultant/find';
        $data['button_back']    = $this->lang->line('button_back');  

        $this->load->view('page/page_display_menu_back', $data);
        $this->load->view('page/page_display_header_sub', $data); 
        $this->load->view('lists/list_anchor_columns_two', $data);

        $this->uri_last();
    }

    public function find_by_office($office_id = 'NULL', $consultant_id  = 'NULL')
    {
        //echo '*** consultant::find_by_office()</p>';

        $office_id  = $this->set_language($office_id );
        $this->page_display_header();

        $array_1 = [];
        $array_2 = [];

        if($consultant_id != NULL)
        {
            $query_1 = $this->office_details->get_by_consultant($consultant_id);
            $array_1 = new ArrayObject($query_1->result_array());

            $query_1->next_result(); 
            $query_1->free_result(); 
        }  

        if($office_id != NULL)
        {
            $query_2 = $this->consultant_details->get_by_office($office_id, 'NULL');
            $array_2 = new ArrayObject($query_2->result_array());

            $query_2->next_result(); 
            $query_2->free_result(); 
        } 

        $data['result_1']       = $array_1;
        $data['result_2']       = $array_2;
        $data['page_header']    = $this->lang->line('header_find_office');
        $data['page_header_1']  = $this->lang->line('label_office');
        $data['page_header_2']  = $this->ArrayObject_get_value($array_1,'office_id',$office_id,'office_name',$this->lang->line('label_office'));
        $data['uri_back']       = 'consultant/find';
        $data['button_back']    = $this->lang->line('button_back');  
    
        $this->load->view('page/page_display_menu_back', $data);
        $this->load->view('page/page_display_header_sub', $data); 
        $this->load->view('lists/list_anchor_columns_two', $data);
        
        $this->uri_last();
    }
 
    public function find_by_team($team_id = 'NULL', $consultant_id  = 'NULL')
    {
        //echo '*** consultant::find_by_team()</p>';
        
        $team_id = $this->set_language($team_id);
        $this->page_display_header();

        $array_1 = [];
        $array_2 = [];

        if($consultant_id != NULL)
        {
            $query_1 = $this->team_details->get_by_consultant($consultant_id);
            $array_1 = new ArrayObject($query_1->result_array());

            $query_1->next_result(); 
            $query_1->free_result(); 
        }  

        if($team_id != NULL)
        {
            $query_2 = $this->consultant_details->get_by_team($team_id, 'NULL');
            $array_2 = new ArrayObject($query_2->result_array());

            $query_2->next_result(); 
            $query_2->free_result(); 
        } 

        $data['result_1']       = $array_1;
        $data['result_2']       = $array_2;
        $data['page_header']    = $this->lang->line('header_find_team');
        $data['page_header_1']  = $this->lang->line('label_team');
        $data['page_header_2']  = $this->ArrayObject_get_value($array_1,'team_id',$team_id,'team_name',$this->lang->line('label_team'));
        $data['uri_back']       = 'consultant/find';
        $data['button_back']    = $this->lang->line('button_back');  

        $this->load->view('page/page_display_menu_back', $data);
        $this->load->view('page/page_display_header_sub', $data); 
        $this->load->view('lists/list_anchor_columns_two', $data);

        $this->uri_last();
    }

    public function find_by_brand_country_paractice($country_id  = NULL, $practice_id = NULL)
    {
        //echo '*** find_by_brand_country_paractice()</p>';

        $country_id = $this->set_language($country_id );
        $this->page_display_header();

        $brand_id   = 3;

        $array_1    = [];
        $array_2    = [];
        $array_3    = [];

        if($brand_id != NULL)
        {
            $query_1 = $this->country->get_by_consultant_brand($brand_id);
            $array_1 = new ArrayObject($query_1->result_array());

            $query_1->next_result(); 
            $query_1->free_result(); 
        }        

        if($brand_id != NULL && $country_id != NULL)
        {
            $query_2 = $this->practice->get_by_consultant_brand_country($brand_id, $country_id);
            $array_2 = new ArrayObject($query_2->result_array());

            $query_2->next_result(); 
            $query_2->free_result(); 
        }

        if($brand_id != NULL && $country_id != NULL && $practice_id != NULL)
        {
            $query_3 = $this->consultant_details->get_by_brand_country_practice($brand_id, $country_id, $practice_id); 
            $array_3 = new ArrayObject($query_3->result_array());

            $query_3->next_result(); 
            $query_3->free_result(); 
        }

        $data['uri_back']       = 'consultant/find';
        $data['page_header']    = $this->lang->line('header_find_country_practice');
        $data['page_header_1']  = $this->lang->line('label_country');
        $data['page_header_2']  = $this->ArrayObject_get_value($array_1,'office_country_id',$country_id,'short_name_en',$this->lang->line('label_practice'));
        $data['page_header_3']  = $this->ArrayObject_get_value($array_2,'practice_id',$practice_id,'practice_name',$this->lang->line('label_consultants'));
        $data['button_back']    = $this->lang->line('button_back');  
        
        $data['result_1']       = $array_1;
        $data['result_2']       = $array_2;
        $data['result_3']       = $array_3;

        $this->load->view('page/page_display_menu_back', $data);
        $this->load->view('page/page_display_header_sub', $data); 
        $this->load->view('lists/list_anchor_columns_three', $data);
    }

    // --------------------------------------------------------------------------------------------
     // PUBLIC METHODS
    // --------------------------------------------------------------------------------------------

    public function find_by_search($language_iso_2 = 'NULL')
    {
        //echo '*** consultant::find_by_search()</p>';

        $this->set_language($language_iso_2);
        $this->page_display_header();

        $this->user_session->set();
        $this->search_form_rules();

        $data['uri_back']               = 'consultant/find';
        $data['page_header']            = $this->lang->line('header_find_search');
        $data['consultant_first_name']  = $this->session->userdata('consultant_first_name');
        $data['consultant_last_name']   = $this->session->userdata('consultant_last_name');
        $data['consultant_email']       = $this->session->userdata('consultant_email');
        $data['label_first_name']       = $this->lang->line('label_first_name'); 
        $data['label_last_name']        = $this->lang->line('label_last_name');          
        $data['label_email']            = $this->lang->line('label_email');           
        $data['button_submit']          = $this->lang->line('button_submit');
        $data['button_back']            = $this->lang->line('button_back');  

        $this->load->view('page/page_display_menu_back', $data); 
        $this->load->view('page/page_display_header_sub', $data); 
        $this->load->view('forms/form_consultant_search', $data); 

        $validation = $this->search_form_validate();

        if($validation == 'TRUE')
        {
            $this->consultant_get_by_search();
        }

        $this->uri_last();
    }
    
    public function find_by_practice($practice_id = 'NULL', $consultant_id  = 'NULL')
    {
        //echo '*** consultant::find_by_practice()</p>';

        $practice_id = $this->set_language($practice_id);
        $this->page_display_header();


        $practices_all              = $this->get_practices_all();
        $practices_user             = $this->get_practices_user($practice_id);
        $practices_linked           = $this->get_practices_linked(implode(',',$practices_user));
        $practices_merged           = $this->get_practices_merged($practices_all, $practices_user, $practices_linked);

        $data['uri_back']           = 'consultant/find';
        $data['uri_string']         = $this->uri_last_no_values();
        $data['button_back']        = $this->lang->line('button_back');
        $data['button_clear']       = $this->lang->line('button_clear');  
        $data['page_header']        = $this->lang->line('header_find_practice'); 
        $data['page_header']        = $this->lang->line('header_find_practice'); 
        $data['practices_merged']   = $practices_merged;
        $data['practices_user']     = $practices_user;

        $this->load->view('page/page_display_menu_back_clear', $data); 
        $this->load->view('practice/practice_list', $data); 

        $practice_ids = implode(',',$practices_linked);

        $this->consultant_get_by_practice($practice_ids);
        //echo $this->uri_last_no_values().'</p>';
    }

    public function find_by_id($consultant_id = 'NULL', $deleted = 'NULL')
    {
        $consultant_id = $this->set_language($consultant_id);
        $this->page_display_header();

        $data['uri_back']       = $this->session->userdata('uri_last');
        $data['button_back']    = $this->lang->line('button_back');
        $data['page_header']    = $this->lang->line('header_consultant_details');
        $data['query']          = $this->consultant_details->get($consultant_id, 'NULL');

        $this->load->view('page/page_display_menu_back', $data); 
        $this->load->view('page/page_display_header_sub', $data); 
        $this->load->view('consultant/consultant_gallery', $data); 

        $bio_brand_id       = 'NULL';
        $bio_language_id    = 'NULL';
        $bio_team_id        = 'NULL';
        $bio_deleted        = 0;

        $segment1 =  $this->uri_last_get_segment(1);
        $segment2 =  $this->uri_last_get_segment(2);
        $segment3 =  $this->uri_last_get_segment(3);

        if($segment2 == 'find_by_team')
        {
            $bio_team_id = $segment3;
        }

        if($segment2 == 'find_by_brand')
        {
            $bio_brand_id = $segment3;
        }


        $data['page_header']    = 'Consultant Bio';
        $data['query']          = $this->consultant_bio->get(   $consultant_id,
                                                                $bio_brand_id,
                                                                $bio_language_id,
                                                                $bio_team_id,
                                                                $bio_deleted);

        $this->load->view('consultant_bio/consultant_bios', $data);
    }

    // --------------------------------------------------------------------------------------------
    // PRIVATE METHODS PRACTICE
    // --------------------------------------------------------------------------------------------

    private function get_practices_all()
    {

        $query = $this->practice->get('NULL');

        $obj = $query->result();

        foreach($obj as $key => $value)
        {
            $obj[$key] = (array) $value;
        }   

        $query->next_result(); 
        $query->free_result();  

        return $obj;
    }

    private function get_practices_user($practice_id)
    {
        if($practice_id === '0')
        {
           $this->session->unset_userdata('list_user');

           $array = [];

           return $array;

        }

        $array = $this->session->userdata('list_user');

        if($array == NULL){

            $array = [];
        }

        if($practice_id != 'NULL')
        {
            if (in_array($practice_id, $array))
            {
                $array = array_diff($array,array($practice_id));
                $array = array_values ($array);
            }
            else
            {
                array_push($array , $practice_id);
            }
        }

        $this->session->set_userdata('list_user', $array);    

        return $array;
    }

    private function get_practices_linked($practice_ids)
    {
        $query = $this->practice->get_by_practice_linked($practice_ids);
        $obj   = $query->row(); 

        if($obj != NULL){

            $array = explode(',' , $obj->practice_ids);

        }else{

            $array = [];
        }

        $query->next_result(); 
        $query->free_result();  

        return $array;
    }

    private function get_practices_merged($practices_all, $practices_user, $practices_linked)
    {
        $practices_merged = $practices_all;
    

        foreach ($practices_merged as $key => $value)
        {
            $practice_id    = $practices_merged[$key]['practice_id'];

            $practices_merged[$key]['practice_user']    = '0';
            $practices_merged[$key]['practice_linked']  = '0';
            
            foreach ($practices_user as $item){

                if($practice_id == $item){

                    $practices_merged[$key]['practice_user'] = '1';

                    break;
                }
            }

            foreach ($practices_linked as $item){

                if($practice_id == $item){

                    $practices_merged[$key]['practice_linked'] = '1';

                    break;
                }
            }
        }

        return $practices_merged;
    }

    // --------------------------------------------------------------------------------------------
    // PRIVATE METHODS FOR FETCHING CONSULTANTS
    // --------------------------------------------------------------------------------------------


    private function consultant_get_by_practice($practice_ids)
    {
        //echo '*** consultant::consultant_get_by_practice()</p>';

        $data['page_header']    = 'Consultants';
        $data['query']          =  $this->consultant_practice->get_by_practice($practice_ids);


        $this->load->view('consultant/consultant_practices_list', $data); 
    }

    private function consultant_get_by_search()
    {
        //echo '*** consultant::consultant_get_by_search()</p>';

        $consultant_ids         = '';
        $consultant_first_name  = $this->session->userdata('consultant_first_name');
        $consultant_last_name   = $this->session->userdata('consultant_last_name');
        $consultant_email       = $this->session->userdata('consultant_email');
        $office_id              = 'NULL';
        $office_country_id      = 'NULL';
        $practice_id            = '';
        $team_id                = 'NULL';
        $brand_id               = 'NULL';
        $brand_country_id       = 'NULL';

        $query                  = $this->consultant_details->search($consultant_ids,
                                                                    $consultant_first_name,
                                                                    $consultant_last_name,
                                                                    $consultant_email,
                                                                    $office_id,
                                                                    $office_country_id,
                                                                    $practice_id,
                                                                    $team_id,
                                                                    $brand_id,
                                                                    $brand_country_id);


        $data['result_1']           = $query->result_array();
        $data['page_header_1']      = $this->lang->line('label_consultants');
        $data['error_no_results']   = $this->lang->line('error_no_results'); 
    
        $this->load->view('lists/list_anchor_columns_one', $data); 
    }

    // --------------------------------------------------------------------------------------------
    // PRIVATE METHODS VALIDATION
    // --------------------------------------------------------------------------------------------

    private function search_form_rules()
    {
        //echo '*** search_form_rules()</p>';

        $config = array(

                    array(
                        'field'     => 'consultant_first_name',
                        'label'     => 'First Name',
                        'rules'     => 'trim|min_length[2]|max_length[60]|regex_match[/^[a-zA-Z0-9,.!?+# ]*$/]',
                        'errors'    => array(
                                        'min_length' => 'You must provide a %s with 3 characters minimum',
                                        'max_length' => 'You must provide a %s with 60 characters maximum',
                                        'regex_match' => 'For %s only characters, numbers and punctuation are allowed.'),
                        'value'     => $this->session->userdata('consultant_first_name')
                        ),
                    array(
                        'field'     => 'consultant_last_name',
                        'label'     => 'Last Name',
                        'rules'     => 'trim|min_length[3]|max_length[60]|regex_match[/^[a-zA-Z0-9,.!? ]*$/]',
                        'errors'    => array(
                                        'min_length' => 'You must provide a %s with 3 characters minimum',
                                        'max_length' => 'You must provide a %s with 60 characters maximum',
                                        'regex_match' => 'For %s only characters, numbers and punctuation are allowed.'),
                        'value'     => $this->session->userdata('consultant_last_name')
                        ),
                    array(
                        'field'     => 'consultant_email',
                        'label'     => 'Email',
                        'rules'     => 'trim|valid_email',
                        'errors'    => array(
                            'trim'          => 'You must provide a valid %s',
                            'valid_email'   => 'You must provide a valid %s'),
                        'value'     => $this->session->userdata('consultant_email')
                        )
                    );

         $this->form_validation->set_rules($config); 
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
    // PRIVATE METHODS ARRAY OBJECT GET VALUE
    // --------------------------------------------------------------------------------------------

    private function ArrayObject_get_value($array, $key_name, $key_value, $key_return, $default){

        if(count($array) ==0 )
        {
            return $default;
        }

        $flag   = 0;
    
        foreach ($array as $index => $item) 
        {
            if($item[$key_name] == $key_value)
            {
                $flag = 1;
                $value = $default.' - '.$item[$key_return];
               
            }
        }  

        if($flag == 0){
            return $default;
        } 

        if($flag == 1){
            return $value;
        } 
    }

    // --------------------------------------------------------------------------------------------
    // PRIVATE METHODS URI
    // --------------------------------------------------------------------------------------------

    private function uri_last()
    {
        
        $this->session->set_userdata(array('uri_last' => uri_string()));
    }

    private function uri_last_no_values()
    {
        $controller = $this->uri->segment(1);
        $method     = $this->uri->segment(2);
        
        $uri_array  = [$controller, $method];
        $uri_string = implode("/", $uri_array);

        $this->session->set_userdata(array('uri_last' => $uri_string));

        return $uri_string;
    }

    private function uri_last_get_segment($index = 1)
    {
        $uri_last = $this->session->userdata('uri_last');
        $uri_array = explode('/' ,   $uri_last);

        if($index < 1)
        {
            $index = 1;
        }

        if($index-1 < count($uri_array)){
            return $uri_array[$index - 1]; 
        }
    }
}