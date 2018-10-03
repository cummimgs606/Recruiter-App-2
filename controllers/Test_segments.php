<?php
class Test_segments extends CI_Controller {



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

    function _remap($param) {
        $this->index($param);
    }

    function index($param){
        echo $param;
    }

    
}