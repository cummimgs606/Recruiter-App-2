<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Pagination extends CI_Pagination
{
    public function  __construct()
    {
        parent::__construct();
        //load libraries and model which you use inside your controller.  
    }

    // --------------------------------------------------------------------
	/**
	 * Set page - jump to page.
	 *
	 * @link	http://www.w3.org/TR/html5/links.html#linkTypes
	 * @param	string	$page
	 * @return	void
	 */	
	// --------------------------------------------------------------------
	
	public function set_page($page){
		$this->cur_page = $page;
	}

}

