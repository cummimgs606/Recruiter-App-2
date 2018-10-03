<?php
class Test_xml_send extends CI_Controller {

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

    public function send()
    {
        /*
        echo '*** send()</p>';

        if  (in_array  ('curl', get_loaded_extensions())) {

            echo "</p>CURL is available on your web server</p>";

        }  else {

            echo "</p>CURL is not available on your web server</p>";

        }
        */
        //echo 'Curl: ', function_exists('curl_version') ? 'Enabled' : 'Disabled</p>';

          $input_xml =   '<job>
                            <user_command>add</user_command>
                            <user_password>aafm9syz2n863mzu</user_password>
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

        //setting the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_URL, "http://10.3.5.56/index.php/broadbean/receive");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);

        $data = curl_exec($ch);
        curl_close($ch);

        $array_data = $data;

        $this->output->set_content_type('text/xml', 'utf-8');
        $this->output->set_header('<?xml version="1.0" encoding="UTF-8" standalone="no" ?>');
        $this->output->set_output($array_data); 

        //print_r('<pre>');
        //print_r($array_data);
        //print_r('</pre>');
    }
    // --------------------------------------------------------------------------------------------
    // FORM RULES
    // --------------------------------------------------------------------------------------------
}