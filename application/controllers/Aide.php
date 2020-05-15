<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aide extends CI_Controller {

	
	public function index()
	{
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Aide';
		$data['pageName']  = 'Aide';
		$data['pageKeywords'] = 'examen, concour, etude';
		$data['pageDescription'] = 'examen, concour, etude';

		$data['activePage'] = $activePage = $this->uri->segment(1);
		
		//==>Pagination=>1 (Variable)
		$pgt_limit = 12;
		$pgt_urlSegment = 3;
		$pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'aide'.allUlrParametre();
		$limit = $pgt_limit;
		$offset = $pgt_offset;

		//==>Pagination=>2 (Calcule)
		$array = array('statut'=>2);
		$like = array();
		/*if(isset($_GET['sta'])):
			$data['statutAid'] = $statutAid = $_GET['sta'];
			$array['aides.statut'] = $statutAid;
		endif;*/


		$data['pgt_totalResult'] = $pgt_totalResult = $this->spw_model->get_countAll_for_pagination('aides',$array,$like);
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
		
		//==>Pagination=>3 (Resultat)
		$data['listeAides'] =  $this->spw_model->get_limit_for_pagination('aides',$array,$limit,$offset,$like,'libAid','Asc');



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
			$this->template->loadTemplate('spw_template', 'default_view', False, 'site', 'site/aide_view', $data);
		}
	}//End index()________




	


}//End document


