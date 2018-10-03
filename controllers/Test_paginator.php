<?php
class Test_paginator extends CI_Controller {

    protected $settings = array('base_url'          => 'http://10.3.5.56/index.php/paginator/page/',
                                'total_rows'        => 57,
                                'per_page'          => 10,
                                'num_links'         => 0,
                                'first_link'        => FALSE,
                                'last_link'         => FALSE,
                                'next_link'         => 'NEXT',
                                'prev_link'         => 'PREV',
                                'next_tag_open'     => ' ',
                                'next_tag_close'    => ' ',
                                'use_page_numbers'  => TRUE,
                                'display_pages'     => FALSE); 

    public function index()
    {
        $this->init_paginator();
    }

    public function page($page_number=1){


        $start  =  ($this->settings['per_page'] * ($page_number -1));
        $end    =  ($this->settings['per_page'] * $page_number) - 1;
        $total  =  $this->settings['total_rows'];

        $start == 0 ? $start = 1: $start; 
        $end > $total ? $end = $total : $end;

        echo 'Page '.$page_number.' / Row '.$start.' - '.$end.'</p>';
        $this->init_paginator();
        
    }

    private function init_paginator(){

        $this->load->library('pagination');

        $this->pagination->initialize($this->settings);

        echo $this->pagination->create_links();
    }



}
