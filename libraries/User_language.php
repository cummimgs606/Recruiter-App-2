 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_language{


    // --------------------------------------------------------------

    public function set_by_iso2($language_file, $language_iso_2)
    {
        // --------------------------------------------------------------
        // --------------------------------------------------------------
        // EXPIRED 
        // --------------------------------------------------------------
        // --------------------------------------------------------------

        //echo '*** User_language::set_by_iso2('.$language_file.' ,'.$language_iso_2.')</p>';
        $CI =& get_instance();

        // SET LANGUAGE BY INPUT ISO2

        if(ctype_alpha($language_iso_2))
        {
            $CI->session->set_userdata(array('language_iso_2'  => $language_iso_2));
        }

        // SET LANGUAGE BY DEFUALT ISO2

        if(!$CI->session->userdata('language_iso_2'))
        {
            $CI->session->set_userdata(array('language_iso_2'  => 'en'));
        }

        // LOAD LANGUAGE FILES

        $CI->lang->load($language_file, $CI->session->userdata('language_iso_2'));

        //echo 'LANG : '.$CI->session->userdata('language_iso_2').'</p>';
    }

    // --------------------------------------------------------------

    public function set_by_job_language($language_file, $language_id = null)
    {
        //echo '*** User_language::set_by_job_language('.$language_file.' ,'.$language_id.')</p>';
        $CI =& get_instance();

        $query = $CI->language->get($language_id);

        $data = [];

        foreach($query->result() as $row){

            $data['language_iso_2']     =   $row->iso_2;
            $data['language_name_en']   =   $row->name_en;
        }

        // SET LANGUAGE BY JOB LANGUAGE ID OR DEFAULT EN

        if($data['language_iso_2'] == null){

            $data['language_iso_2'] = 'en';
        }

        $CI->lang->load($language_file, $data['language_iso_2']);

        //echo 'LANG : '.$data['language_iso_2'].'</p>';
    }  

    public function set_by_mixed_input($language_file, $language_iso_2 = 'NULL')
    {
        //echo '*** User_language::set_by_input('.$language_file.' ,'.$language_iso_2.')</p>';

        $CI =& get_instance();

        // SET SESSION LANGUAGE BY LANGUAGE ISO2

        if(ctype_alpha($language_iso_2) && $language_iso_2 !=  'NULL'){

            $CI->session->set_userdata(array('language_iso_2'  => $language_iso_2));

        }

        // SET SESSION LANGUAGE BY DEFAUALT

        if(!$CI->session->userdata('language_iso_2') || $CI->session->userdata('language_iso_2') == 'NULL')
        {
            $CI->session->set_userdata(array('language_iso_2'  => 'en'));
        }

        // LOAD LANGUAGE FILES

        $CI->lang->load($language_file, $CI->session->userdata('language_iso_2'));
    }    
}

