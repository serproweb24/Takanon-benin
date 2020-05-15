<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mon_compte extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(2);
	}
	
	public function index()
	{
		$section_BO = 'clients';
		include ('application/controllers/back-office/Mon_compte.php');
	}//End index()________







}//End document


