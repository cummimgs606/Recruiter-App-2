<?php
class Test_xml_receive extends CI_Controller {

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

    public function receive()
    {
       $dataPOST    = trim(file_get_contents('php://input'));
       $xmlData     = simplexml_load_string($dataPOST);

       echo '<reponse>';
       echo $dataPOST;
       echo '<receiver>'.$xmlData->sender_data.'</receiver>';//.$xmlData;
       echo '</reponse>';
    }

    // --------------------------------------------------------------------------------------------
    // FORM RULES
    // --------------------------------------------------------------------------------------------
}