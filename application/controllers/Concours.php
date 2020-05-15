<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Concours extends CI_Controller {

	
	public function index()
	{
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Concours';
		$data['pageName']  = 'Concours';
		$data['pageKeywords'] = 'examen, concour, etude';
		$data['pageDescription'] = 'examen, concour, etude';

		$data['activePage'] = $activePage = $this->uri->segment(1);

		$data['maintenant'] = $maintenant = now();
		

		//Laste posts, limite 12
		$data['listPosts'] = lastPosts('forItemsSite',$limit=12,$offset='',$like=array(),$condition=array('articles.statut'=>2))->list;
		$table = 'concours';
		$data['listeConcours'] = $this->spw_model->get_rows($table,["statut" => 2]);
		
		$pgt_limit = 12;
		$pgt_urlSegment = 3;
		$pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'admin/matieres'.allUlrParametre();
		$limit = $pgt_limit;
		$offset = $pgt_offset;
		
		//==>Pagination=>2 (Calcule)
		$array = array();
		$like = array();
		if(isset($_GET['sta'])):
			$data['statutAid'] = $statutAid = $_GET['sta'];
			$array['concours.statut'] = $statutAid;
		endif;

		$data['pgt_totalResult'] = $pgt_totalResult = $this->spw_model->get_countAll_for_pagination('concours',$array,$like);
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
	

		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);
			//logoin
			if($ActiveAjax=='login'){
				echo userConnection($phone,$password,base_url().'home');
			}else{
				echo "Une erreur est survenue, veuillez renseigner";
			}
		}
		else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', False, 'site', 'site/concours_view', $data);
		}
	}//End index()________




	


}//End document


