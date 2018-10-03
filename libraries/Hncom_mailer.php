<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hncom_mailer{


	public function mail_no_cv($data){

		$CI =& get_instance();
		$CI->load->library('email');
		$CI->load->helper('date');

		//

		$from_email	= $data['job_response_email'];
		$from_name	= $data['consultant_name'];
		$to_email	= $data['candidate_email'];
		$to_name	= $data['candidate_first_name'].' '.$data['candidate_last_name'];
		$subject	= $CI->lang->line('mail_no_cv_subject').''.$data['job_title'].' : '.$data['job_id'];
		$message	= $CI->lang->line('mail_no_cv_message_1').'
'.$data['job_title'].'
'.$CI->lang->line('mail_no_cv_message_2');

		$time_stamp	= $this->time_stamp();
		
		//

		$data['protocol']		= 'sendmail';
		$data['mailpath']		= '/usr/sbin/sendmail';
		$data['smtp_host']		= '10.3.4.17'; 	
		$data['smtp_port']		= '25'; 

		//

		$CI->email->from($from_email, $from_name);
		$CI->email->to($to_email, $to_name);
		$CI->email->subject($subject);
		$CI->email->message($message.' '.$time_stamp);

		$CI->email->send();
	}

	public function mail_with_cv($data){

		//echo '***  mail_with_cv()</p>';

		$CI =& get_instance();
		$CI->load->library('email');
		$CI->load->helper('date');

		//

		$from_email	= $data['candidate_email'];
		$from_name	= $data['candidate_first_name'].' '.$data['candidate_last_name'];
		$to_email	= $data['job_response_email'];//'mark.cummings@harveynash.com';
		$to_name	= $data['consultant_name'];
		$subject	= 'Job Application for: '.$data['job_title'].' : '.$data['job_id'];
		$message	= 'A canddidate has applied for a job.

job external reference : '.$data['job_external_reference'].'
jobid : '.$data['job_id'].'
Job Title : '.$data['job_title'].'
From : '.$data['job_application_campaign'].'
On :'.$this->time_stamp();
		
		//

		$data['protocol']		= 'sendmail';
		$data['mailpath']		= '/usr/sbin/sendmail';
		$data['smtp_host']		= '10.3.4.17'; 	
		$data['smtp_port']		= '25'; 

		//

		$CI->email->from($from_email, $from_name);
		$CI->email->to($to_email, $to_name);
		$CI->email->subject($subject);
		$CI->email->message($message);

		$CI->email->send();
	}


	private function time_stamp()
	{
		$datestring = '%Y/%m/%d %h:%i';
		$time = time();
		return mdate($datestring, $time);	
	}
	/*
	array(36) 
	{ 
		["page_title_red"]=> string(4) "~Job" 
		["page_title_black"]=> string(6) "~Apply" 
		["back_button_uri"]=> string(11) "jobs/search" 
		["back_button_text"]=> string(5) "~BACK" 
		["page_title_job"]=> string(4) "~Job" 
		["page_title_apply"]=> string(6) "~Apply" 
		["message_success_title"]=> string(8) "~Success" 
		["message_success_body"]=> string(72) "~Your application has been successfull you will receive an email shortly" 
		["message_apply_title"]=> string(16) "~Job Description" 
		["label_salary"]=> string(7) "~Salary" 
		["label_location"]=> string(9) "~Location" 
		["label_job_type"]=> string(9) "~Job Type" 
		["label_telephone"]=> string(14) "~Job Telephone" 
		["label_email"]=> string(6) "~Email" 
		["job_id"]=> string(3) "419" 
		["job_type_id"]=> string(1) "3" 
		["job_title"]=> string(36) "Finance Shared Services Project Lead" 
		["job_salary"]=> string(39) "€25000 - €30000 per annum" 
		["job_location_text"]=> string(6) "Dublin" 
		["job_type_name"]=> string(8) "Contract" 
		["office_telephone"]=> string(8) "10000004" 
		["job_response_email"]=> string(43) "David.Burke.67224.781@harveynashcareers.com" 
		["consultant_name"]=> string(11) "David Burke" 
		["job_external_reference"]=> string(8) "DBPMFSSS" 
		["candidate_first_name"]=> string(4) "Mark" 
		["candidate_middle_name"]=> string(0) "" 
		["candidate_last_name"]=> string(8) "Cummings" 
		["candidate_salutation"]=> string(2) "Mr" 
		["candidate_email"]=> string(28) "mark.cummings@harveynash.com" 
		["candidate_phone_home"]=> string(11) "07810863620" 
		["candidate_phone_mobile"]=> string(11) "07810863621" 
		["candidate_cv"]=> NULL ["job_application_campaign"]=> string(22) "Microsite Campaign 123" 
		["job_application_Keyword"]=> string(7) "manager" 
		["job_appication_location"]=> string(0) "" 
		["file_name"]=> string(36) "5ff89aa99a332ff74ed88c458359c1e5.jpg" 
	}
	*/
}