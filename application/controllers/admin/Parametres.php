<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parametres extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(1);
	}
	
	public function index()
	{

		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Parametres';
		$data['pageName'] = 'parametres';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		$data['activePage'] = $activePage = $this->uri->segment(2);
		
		/*//for ($i=1990; $i < 2020; $i++) { 
			
	

			$dataAdd = array(
				'libAnn' => $i,
				'statut' => 2,
				'dateCreate' => $maintenant
			);
			$this->spw_model->add_item('annees',$dataAdd);
		
		//	}*/
		
		
		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);

			//
			if($ActiveAjax=='registerForm'):



			else:
				echo "Une erreur est survenue, veuillez réessayer.";
			endif;
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'admin', 'admin/parametres_view', $data);
		}
	}//End index()________







}//End document


