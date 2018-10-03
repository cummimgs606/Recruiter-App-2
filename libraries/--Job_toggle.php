 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_toggle{


    // --------------------------------------------------------------


    public function by_post()
    {
         //echo '*** job_toggle::by_post()</p>';

        $CI =& get_instance();

        $length = count($CI->input->post(NULL, TRUE));

        if ($length == 1){

            $job_toggle_on      = $CI->input->post('job_toggle_on');
            $job_toggle_off     = $CI->input->post('job_toggle_off');

            if($job_toggle_on == '1' || $job_toggle_on == '0'){

                $CI->session->userdata('job_toggle') == '1' ? $toggle = '0' :  $toggle = '1';

                $data['job_toggle']      = $toggle;
                $data['job_toggle_old']  = $toggle;

                $CI->session->set_userdata($data); 
            }


            if($CI->session->userdata('job_toggle') == NULL){

                $data['job_toggle'] = 0;
                $CI->session->set_userdata($data); 
            }

            if($job_toggle_on == '2'){

                $data['job_toggle'] = $CI->session->userdata('job_toggle_old');
                $CI->session->set_userdata($data); 
            }

            if($job_toggle_off == '2'){

                $data['job_toggle'] = 2;
                $CI->session->set_userdata($data); 
            }
        }
    }

    
    // --------------------------------------------------------------
    

    public function by_uri(){

        //echo '*** job_toggle::by_uri()</p>';

        $CI =& get_instance();

        $job_toggle = $CI->session->userdata('job_toggle');
        $toggle     = $CI->uri->segment(4, $job_toggle );

        $CI->session->set_userdata(array('job_toggle' => $toggle));

        return $toggle;
    }
}

