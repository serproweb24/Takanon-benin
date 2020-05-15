<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {

	
	public function index()
	{
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Services';
		$data['pageName']  = 'services';
		$data['pageKeywords'] = 'examen, concour, etude';
		$data['pageDescription'] = 'examen, concour, etude';

		$data['activePage'] = $activePage = $this->uri->segment(1);
		

		//Laste posts, limite 12
		$data['listPosts'] = lastPosts('forItemsSite',$limit=12,$offset='',$like=array(),$condition=array('articles.statut'=>2))->list;


		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);
			//logoin
			if($ActiveAjax=='login'){
				echo userConnection($phone,$password,base_url().'home');
			}else{
				echo "Une erreur est survenue, veuillez renseigner";
			}
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', False, 'site', 'site/services_view', $data);
		}
	}//End index()________




	


}//End document


