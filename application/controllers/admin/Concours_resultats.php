<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Concours_resultats extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(1);
	}

	public function index()
	{
		$section_BO = 'admin';

		require_once('application/controllers/back-office/concours_resultats.php');
	



	}//End index()________






}//End document


