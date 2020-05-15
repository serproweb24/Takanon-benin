<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(3);
	}

	
	public function index()
	{
		

		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Users';
		$data['pageName'] = 'users';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		$data['activePage'] = $activePage = $this->uri->segment(2);

		
		
		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);


		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'users', 'users/home_view', $data);
		}
	}//End index()________







}//End document


