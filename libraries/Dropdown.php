<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dropdown{


        // --------------------------------------------------------------


        public function brand()
        {
	        $brand_id       = 'NULL';
	        $country_id     = 'NULL';

	        $CI =& get_instance();

	        $CI->load->model('procedures/brand');
	            
	        $query = $CI->brand->get(	$brand_id, 
	                                            $country_id);
			
			foreach ($query->result_array() as $row)
			{
			    $options[$row['brand_id']] = $row['brand_name'];
			}	

            $query->next_result(); 
            $query->free_result(); 

			echo form_dropdown('brand', $options , 1);
        }

        // --------------------------------------------------------------


        public function brand_by_consultant($consultant_id = 'NULL')
        {
            $CI =& get_instance();

            $CI->load->model('procedures/brand_get_by');
                
            $query = $CI->brand_get_by->consultant($consultant_id);
            
            foreach ($query->result_array() as $row)
            {
                $options[$row['brand_id']] = $row['brand_name'];
            }   

            $query->next_result(); 
            $query->free_result(); 

            echo form_dropdown('brand', $options , 1);
        }



        // --------------------------------------------------------------


        public function country_by_office_consultant()
        {
            $CI =& get_instance();

            $CI->load->model('procedures/country');
                
            $query = $CI->country->get_by_office_consultan();
            
            foreach ($query->result_array() as $row)
            {
                $options[$row['office_country_id']] = $row['short_name_en'];
            }

            $query->next_result(); 
            $query->free_result();  

            echo form_dropdown('country', $options , 1);
        }


        // --------------------------------------------------------------


        public function country_by_brand_consultant()
        {
            $CI =& get_instance();

            $CI->load->model('procedures/country');
                
            $query = $CI->country->get_by_brand_consultant();
            
            foreach ($query->result_array() as $row)
            {
                $options[$row['brand_country_id']] = $row['short_name_en'];
            }

            $query->next_result(); 
            $query->free_result();   

            echo form_dropdown('country', $options , 1);
        }


        // --------------------------------------------------------------


        public function job_type($select_value, $search_form_drop_down_job_type)
        {

            // echo '$search_form_drop_down_job_type : </p>';
            //var_dump($search_form_drop_down_job_type);
            //echo '</p>';

            if($select_value == NULL){

                $select_value = 1;
            }

          

            $CI =& get_instance();
            
            /*
            // DB VARIBLES
            $CI->load->model('procedures/job_type'); 
            $query = $CI->job_type->get();
            foreach ($query->result_array() as $row)
            {$options[$row['job_type_id']] = $row['job_type_name'];}
            $query->next_result(); 
            $query->free_result();  
            */

            $index = 1;
    
            foreach ($search_form_drop_down_job_type as $value){
                 $options[$index] = $value;

                 $index++;
            }


            $newdata = array('job_type' => $select_value);

            $CI->session->set_userdata($newdata);

            echo form_dropdown('job_type', $options , $select_value, 'class="form-select"');
        }


        // --------------------------------------------------------------


        public function team($select_value = 1)
        {

            echo '*** dropdown::team()</p>';
            
            if($select_value == NULL){

                $select_value = 1;
            }

            $CI =& get_instance();

                
            $team_id    = 'NULL'; 
            $brand_id   = 'NULL';

            $CI->load->model('procedures/team_details');


            $query = $CI->team_details->get(   $team_id,
                                               $brand_id);

            foreach ($query->result_array() as $row)
            {
                $options[$row['team_id']] = $row['team_name'];
            }

         
            $query->next_result(); 
            $query->free_result();  

            $newdata = array('team_id' => $select_value);

            $CI->session->set_userdata($newdata);

            echo form_dropdown('team_id', $options , $select_value);
        
        }


        // --------------------------------------------------------------


        public function office_by_consultant($consultant_id = 'NULL')
        {
            $CI =& get_instance();

            $CI->load->model('procedures/office_get_by');
                
            $query = $CI->office_get_by->consultant($consultant_id);
            
            foreach ($query->result_array() as $row)
            {
                $options[$row['office_id']] = $row['office_name'];
            }   

            $query->next_result(); 
            $query->free_result(); 

            echo form_dropdown('office', $options , 1);
        }    

}

