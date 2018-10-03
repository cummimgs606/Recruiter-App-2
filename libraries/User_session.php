 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_session{


    // --------------------------------------------------------------


    public function set()
    {
        $CI     =& get_instance();
        $post   = $CI->input->post(NULL, TRUE);

        if($post != NULL)
        {
                
            $CI->session->set_userdata($post);

            unset($_SESSION["__ci_last_regenerate"]);
        }
        
        if($post == NULL)
        {

            $session_data = $CI->session->userdata;

            unset($session_data["__ci_last_regenerate"]);

            if($session_data != NULL)
            {
            
                foreach ($session_data as $key => $value) 
                {

                    $_POST[$key] = $value;
                }
            }
        }        
    }

    // --------------------------------------------------------------
}

