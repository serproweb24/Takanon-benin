<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_actualite extends CI_Controller {

	
	public function index()
	{
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Detail actualite';
		$data['pageName']  = 'detail_actualite';
		$data['pageKeywords'] = 'touver document, epreuve, livre';
		$data['pageDescription'] = 'Pour toutes vos recherches en documents, epreuves ou livre, Takanou vous accompagne.';

		$data['activePage'] = $activePage = $this->uri->segment(1);
		




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
			$this->template->loadTemplate('spw_template', 'default_view', False, 'site', 'site/detail_actualite_view', $data);
		}
	}//End index()________




	


}//End document


