<?php
class Broadbean extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('procedures/job');
    }

    private function xml_speifications_add()
    {
        $string =   '<job>
                        <user_command>add</user_command>
                        <user_password>p455w0rd</user_password>
                        <user_contact_email>usercontact@email.com</user_contact_email>
                        <job_title>XXX Financial Planner</job_title>
                        <job_salary_currency>GBP</job_salary_currency>
                        <job_salary_from>25000</job_salary_from>
                        <job_salary_to>30000</job_salary_to>
                        <job_salary_per>annum</job_salary_per>
                        <job_salary_benefits>Bonus and Pension</job_salary_benefits>
                        <job_salary>£20 to £45000 per annum</job_salary>
                        <job_description><![CDATA[This is a html description]]></job_description>
                        <job_featured>1</job_featured>
                        <job_start_date>ASAP</job_start_date>
                        <job_duration>6 Months</job_duration>
                        <job_expiry_date>2018-07-18</job_expiry_date>
                        <job_posted_date>2017-08-22</job_posted_date>
                        <job_response_email>siobhan.davoren.80000.781@harveynashcareers.com</job_response_email>
                        <job_external_reference>abc123</job_external_reference>
                        <job_source_id>4</job_source_id>
                        <job_location_text>Dublin</job_location_text>
                        <postal_code_id>NULL</postal_code_id>
                        <job_type_id>5</job_type_id>
                        <consultant_id>45</consultant_id>
                        <brand_id>7</brand_id>
                        <language_id>10</language_id>
                        <country_id>108</country_id>
                    </job>';

        return $string;
    }

    private function xml_speifications_amend()
    {
        $string =   '<job>
                        <user_command>amend</user_command>
                        <user_password>aafm9syz2n863mzu</user_password>
                        <user_contact_email>usercontact@email.com</user_contact_email>
                        <job_title>Amended Financial Planner</job_title>
                        <job_salary_currency>GBP</job_salary_currency>
                        <job_salary_from>25000</job_salary_from>
                        <job_salary_to>30000</job_salary_to>
                        <job_salary_per>annum</job_salary_per>
                        <job_salary_benefits>Bonus and Pension</job_salary_benefits>
                        <job_salary>£20 to £45000 per annum</job_salary>
                        <job_description><![CDATA[This is a html description]]></job_description>
                        <job_featured>1</job_featured>
                        <job_start_date>ASAP</job_start_date>
                        <job_duration>6 Months</job_duration>
                        <job_expiry_date>2018-07-18</job_expiry_date>
                        <job_posted_date>2017-08-22</job_posted_date>
                        <job_response_email>siobhan.davoren.80000.781@harveynashcareers.com</job_response_email>
                        <job_external_reference>abc123</job_external_reference>
                        <job_source_id>4</job_source_id>
                        <job_location_text>Dublin</job_location_text>
                        <postal_code_id>NULL</postal_code_id>
                        <job_type_id>5</job_type_id>
                        <consultant_id>45</consultant_id>
                        <brand_id>7</brand_id>
                        <language_id>10</language_id>
                        <country_id>108</country_id>
                    </job>';

        return $string;
    }

    private function xml_speifications_delete()
    {
        $string =   '<job>
                        <user_command>delete</user_command>
                        <user_password>p455w0rd</user_password>
                        <user_contact_email>usercontact@email.com</user_contact_email>
                        <job_title>XXX Financial Planner</job_title>
                        <job_external_reference>abc123</job_external_reference>
                    </job>';

        return $string;
    }

    // --------------------------------------------------------------------------------------------
    // PUBLIC METHODS
    // --------------------------------------------------------------------------------------------

    public function receive()
    {

        // USE DEBUG: ADD
        // $input_xml =   $this->xml_speifications_add();
        // END USE DEBUG

        // USE DEBUG: DELETE
        // $input_xml =  $this->xml_speifications_delete();
        // END USE DEBUG

        // USE DEBUG: AMEND
        //$input_xml =  $this->xml_speifications_amend();
        // END USE DEBUG

        // USE DEBUG
        // $xmlData     = simplexml_load_string($input_xml);
        // END USE DEBUG

        // USE FINALE
             
        $dataPOST    = trim(file_get_contents('php://input'));
        $xmlData     = simplexml_load_string($dataPOST);

        if(empty($xmlData)){
            $this->return_message('<message>ERROR : No Job data has been provided : use the XML specification provided and send the xml data to this URL, use the example within the job elements.</message>'.$this->xml_speifications_add());
            return;
        }

        // END USE FINALE
        

        $user_command           = $xmlData->user_command;
        $user_password          = $xmlData->user_password;
        $user_contact_email     = $xmlData->user_contact_email;
        $job_title              = $xmlData->job_title;
        //$job_salary_currency    = $xmlData->job_salary_currency;
        //$job_salary_from        = $xmlData->job_salary_from; 
        //$job_salary_to          = $xmlData->job_salary_to;
        //$job_salary_per         = $xmlData->job_salary_per;
        //$job_salary_benefits    = $xmlData->job_salary_benefits;
        $job_salary             = $xmlData->job_salary;
        $job_description        = $xmlData->job_description;
        $job_featured           = $xmlData->job_featured;
        $job_start_date         = $xmlData->job_start_date;
        $job_duration           = $xmlData->job_duration;
        $job_expiry_date        = $xmlData->job_expiry_date;
        //$job_posted_date        = $xmlData->job_posted_date;
        $job_response_email     = $xmlData->job_response_email; 
        $job_external_reference = $xmlData->job_external_reference; 
        $job_source_id          = $xmlData->job_source_id; 
        $job_location_text      = $xmlData->job_location_text;
        $postal_code_id         = $xmlData->postal_code_id;
        $job_type_id            = $xmlData->job_type_id;
        $consultant_id          = $xmlData->consultant_id;
        $brand_id               = $xmlData->brand_id;
        $language_id            = $xmlData->language_id;
        $country_id             = $xmlData->country_id; 


        if (!password_verify($user_password ,'$2y$10$yHmTxaPhyuXqMbuu9bzR1OapvorewADPoYbzUZb5s2tE3yL6xehfm')) 
        {
            $user_command = 'void';
            // $hash  = password_hash('aafm9syz2n863mzu', PASSWORD_BCRYPT, array("cost" => 10));
        }


        if($user_command == 'void'){

            $this->return_message('<message>ERROR : Username/Password not recognised : Contact the aministrator</message>');

            return;
        }

        // -----------------------------------------------------------------------------------------
        // ADD
        // -----------------------------------------------------------------------------------------

        if($user_command == 'add'){

            // VALIDATION

            if(!$this->validate_date($job_expiry_date)){
                
                $this->return_message('<message>ERROR : Job expiry date is formatted incorrectly : Format the date with YYYY-MM-DD</message>');

                return;
            };

            if(!$this->validate_email($job_response_email)){

                $this->return_message('<message>ERROR : The job response email from Applitrack is formatted incorrectly : Format the email with your.email@your.site.com</message>');

                return;
            }

            
            $query = $this->job->add(   $job_title,                       
                                        $job_salary,               
                                        $job_description,                       
                                        $job_featured,                           
                                        $job_start_date,                               
                                        $job_duration,                           
                                        $job_expiry_date,                       
                                        $job_response_email,                   
                                        $job_external_reference,   
                                        $job_source_id,       
                                        $job_location_text,                       
                                        $postal_code_id,                               
                                        $job_type_id,                           
                                        $consultant_id,                               
                                        $brand_id,                                                                       
                                        $language_id,                                   
                                        $country_id);

            $row = $query->row_array(1);

            if(isset($row)){

                $this->return_message('<message>SUCCESS : Your job has been created : The Job can be viewed from Broadbean</message>'.$this->make_link($row['job_id']));

            }else{

                $this->return_message('<message>ERROR : Your job was not entered into the databse : Contact the Administrator</message>');
            }
        }

        // -----------------------------------------------------------------------------------------
        // AMEND
        // -----------------------------------------------------------------------------------------

        if($user_command == 'amend'){

            // VALIDATION

            if(!$this->validate_date($job_expiry_date)){
                
                $this->return_message('<message>ERROR : Job expiry date is formatted incorrectly : Format the date with YYYY-MM-DD</message>');

                return;
            };

            if(!$this->validate_email($job_response_email)){

                $this->return_message('<message>ERROR : The job response email from Applitrack is formatted incorrectly : Format the email with your.email@your.site.com</message>');

                return;
            }

            
            $query = $this->job->amend_by_job_external_reference(   $job_title,                       
                                                                    $job_salary,               
                                                                    $job_description,                       
                                                                    $job_featured,                           
                                                                    $job_start_date,                               
                                                                    $job_duration,                           
                                                                    $job_expiry_date,                       
                                                                    $job_response_email,                   
                                                                    $job_external_reference,   
                                                                    $job_source_id,       
                                                                    $job_location_text,                       
                                                                    $postal_code_id,                               
                                                                    $job_type_id,                           
                                                                    $consultant_id,                               
                                                                    $brand_id,                                                                       
                                                                    $language_id,                                   
                                                                    $country_id);

            $row = $query->row_array(1);

            if(isset($row)){

                $this->return_message('<message>SUCCESS : Your job has been amended : The Job can be viewed from Broadbean</message>'.$this->make_link($row['job_id']));

            }else{

                $this->return_message('<message>ERROR : Your job was not amended : Contact the Administrator</message>');
            }
        }

        // -----------------------------------------------------------------------------------------
        // DELETE
        // -----------------------------------------------------------------------------------------

        if($user_command == 'delete'){

            $this->job->delete_by_job_external_reference($job_external_reference);

            $this->return_message('<message>SUCCESS : Your job has been deleted : Job reference - '.$job_external_reference.'</message>');
        }
    }

    private function make_link($id){

        $xml_string =   '<url>
                            xlink:type="simple"
                            xlink:href="http://10.3.5.56/index.php/jobs/show/'.$id.'"
                            xlink:show="new">A new job has been created with the id : '.$id.'
                        </url>';

        return $xml_string;

    }

    private function return_message($string){
        
        $xml_srtring = '<reponse>'.$string.'</reponse>';

        $this->output->set_content_type('text/xml', 'utf-8');
        $this->output->set_header('<?xml version="1.0" encoding="UTF-8" standalone="no" ?>');
        $this->output->set_output($xml_srtring); 
        
    }

    private function validate_date($date_string){

        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date_string)) {
            return true;
        } else {
            return false;
        }
    }

    private function validate_email($email){

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    // --------------------------------------------------------------------------------------------
    // FORM RULES
    // --------------------------------------------------------------------------------------------
}