<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Concours_encours extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(3);
	}
	
	public function index()
	{

		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Concours_encours';
		$data['pageName'] = 'concours_encours';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		$data['activePage'] = $activePage = $this->uri->segment(2);

		//user connected;
		$data['user'] = $user = user_connected();


		//==>Pagination=>1 (Variable)
		$pgt_limit = 12;
		$pgt_urlSegment = 3;
		$pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'users/concours_encours'.allUlrParametre();
		$limit = $pgt_limit;
		$offset = $pgt_offset;
		$arrayCon = array('statut'=>2);
		$like = array();
		if(isset($_GET['sta'])):
			$data['statutAid'] = $statutAid = $_GET['sta'];
			$array['concours.statut'] = $statutAid;
		endif;

		//==>Pagination=>2 (Calcule)
		$data['pgt_totalResult'] = $pgt_totalResult = count($this->spw_model->get_limit_for_pagination('concours',$arrayCon,$limit,$offset,$like,'dateCreate','Desc',$count=true));
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);

		//==>Pagination=>3 (Resultat)
		$data['listeConcours'] =  $this->spw_model->get_limit_for_pagination('concours',$arrayCon,$limit,$offset,$like,'dateCreate','Desc',$count=true);

		
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
			$this->template->loadTemplate('spw_template', 'default_view', true, 'users', 'users/concours_encours_view', $data);
		}
	}//End index()________







}//End document


