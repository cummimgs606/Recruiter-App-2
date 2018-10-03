<?php
class Test_mail extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->library('email');
        $this->load->helper('form'); 
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('user_session');
        $this->load->helper('date');

        echo link_tag('frame-work/version-2016-r1-v2/css/button-as-text.css');
        echo link_tag('frame-work/version-2016-r1-v2/css/main.css');
        echo link_tag('frame-work/version-2016-r1-v2/javascripts/modernizr.custom.js');
    }


	public function send(){

		$this->user_session->set();


		if($this->input->post('reset') == 'Reset'){

			//echo 'RESET</p>';
			$this->session->set_userdata('default', NULL);
		};



		if($this->session->userdata('default') == NULL){

			//echo 'DEFAULT</p>';

			$data['from_email']		= 'mark.cummings@harveynash.com';
			$data['from_name']		= 'Mark Cummings';
			$data['to_email']		= 'mark.cummings@harveynash.com';
			$data['to_name']		= 'Mark Cummings';
			$data['subject']		= 'My Subject';
			$data['message']		= 'My Message';

			//

			$data['default']		= 'TRUE';
			$data['useragent']		= 'CodeIgniter';
			$data['protocol']		= 'sendmail';
			$data['mailpath']		= '/usr/sbin/sendmail';
			$data['smtp_host']		= '10.3.4.17'; 	
			$data['smtp_user']		= ''; 	
			$data['smtp_pass']		= ''; 	
			$data['smtp_port']		= '25'; 	
			$data['smtp_timeout']	= '5'; 	
			$data['smtp_keepalive']	= 'FALSE'; 	
			$data['smtp_crypto']	= ''; 	
			$data['wordwrap']		= 'TRUE'; 	
			$data['wrapchars']		= '76'; 	
			$data['mailtype']		= 'text'; 	
			$data['charset']		= $this->config->config['charset'];	
			$data['validate']		= 'FALSE'; 	
			$data['priority']		= 3; 	
			$data['crlf']			= '\n'; 	
			$data['newline']		= '\n'; 	
			$data['bcc_batch_mode']	= 'FALSE'; 	
			$data['bcc_batch_size']	= '200'; 	
			$data['dsn']			= 'FALSE'; 

		}else{

			//echo 'USER</p>';

			$data['from_email']		= $this->session->userdata('from_email');
			$data['from_name']		= $this->session->userdata('from_name');
			$data['to_email']		= $this->session->userdata('to_email');
			$data['to_name']		= $this->session->userdata('to_name');
			$data['subject']		= $this->session->userdata('subject');
			$data['message']		= $this->session->userdata('message');

			//

			$data['default']		= $this->session->userdata('default');
			$data['useragent']		= $this->session->userdata('useragent');
			$data['protocol']		= $this->session->userdata('protocol');
			$data['mailpath']		= $this->session->userdata('mailpath');
			$data['smtp_host']		= $this->session->userdata('smtp_host');
			$data['smtp_user']		= $this->session->userdata('smtp_user');
			$data['smtp_pass']		= $this->session->userdata('smtp_pass');
			$data['smtp_port']		= $this->session->userdata('smtp_port');	
			$data['smtp_timeout']	= $this->session->userdata('smtp_timeout');	
			$data['smtp_keepalive']	= $this->session->userdata('smtp_keepalive'); 	
			$data['smtp_crypto']	= $this->session->userdata('smtp_crypto');	
			$data['wordwrap']		= $this->session->userdata('wordwrap');	
			$data['wrapchars']		= $this->session->userdata('wrapchars'); 	
			$data['mailtype']		= $this->session->userdata('mailtype'); 	
			$data['charset']		= $this->session->userdata('charset');	
			$data['validate']		= $this->session->userdata('validate');	
			$data['priority']		= $this->session->userdata('priority');	
			$data['crlf']			= $this->session->userdata('crlf'); 	
			$data['newline']		= $this->session->userdata('newline');	
			$data['bcc_batch_mode']	= $this->session->userdata('bcc_batch_mode');	
			$data['bcc_batch_size']	= $this->session->userdata('bcc_batch_size');	
			$data['dsn']			= $this->session->userdata('dsn'); 
		}


		// ---------------------------------------------------------------------------
		// LOAD FORM
		// ---------------------------------------------------------------------------

		$this->load->view('forms/test_mail_form', $data);

		// ---------------------------------------------------------------------------
		// GET TIME
		// ---------------------------------------------------------------------------

		$datestring = '%Y/%m/%d - %h:%i';
		$time = time();
		$date_time = mdate($datestring, $time);	

		// ---------------------------------------------------------------------------
		// DO MAIL
		// ---------------------------------------------------------------------------


		if($this->input->post('submit') == 'Submit'){

			//echo 'SEND MAIL</p>';

			$this->email->initialize($data);

			$this->email->from(		$data['from_email'], 	$data['from_name']);
			$this->email->to(		$data['to_email'], 		$data['to_name']);
			$this->email->subject(	$data['subject'].' '.$date_time);
			$this->email->message(	$data['message'].' '.$date_time);
			//$this->email->attach('/path/to/photo1.jpg');

			$this->email->send();
			
		};


		
	}
}