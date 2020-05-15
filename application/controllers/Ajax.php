<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Ajax extends CI_Controller {

	function index(){
		extract($_POST);
		//Ajax
		if($this->input->is_ajax_request())
		{
			if($TypeAjax == "alertSession"){
				unset($_SESSION[$ContentSession]) ;
				echo "Succes";
			}

		}
	}



}

?>