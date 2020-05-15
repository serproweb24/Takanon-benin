<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends CI_Controller {
		function __construct() {
		parent::__construct();
		userIsLogin(1);
	}
	
	public function index()
	{
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Admin - Méssages';
		$data['pageName'] = 'messages';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		//user connected;
		$data['user'] = $user = user_connected();

		$data['activePage'] = $activePage = $this->uri->segment(2);


		

		

		//==>Pagination=>1 (Variable)
		$pgt_limit = 5; 
		$pgt_urlSegment = 3;
		$pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'admin/messages'.allUlrParametre();
		$limit = $pgt_limit;
		$offset = $pgt_offset;

		//==>Pagination=>2 (Calcule)
		$array = array();
		$like = array();
		if(isset($_GET['cat'])):
			$data['idArtCat'] = $idArtCat = $_GET['cat'];
			$data['titleSection'] = '';
			$array['articles.idArtCar'] = $idArtCat;
		endif;
		if(isset($_GET['sta'])):
			$data['statutArt'] = $statutArt = $_GET['sta'];
			$array['articles.statut'] = $statutArt;
		endif;


		$data['pgt_totalResult'] = $pgt_totalResult = $this->spw_model->get_countAll_for_pagination('messages',$array= array(),$like);
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
		
		//==>Pagination=>3 (Resultat)
		$data['messages'] =  $this->spw_model->get_limit_for_pagination('messages',$array,$limit,$offset,$like,'idMes','Desc');


		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);

			//===>404
			if($ActiveAjax=='404'):

		

			else:
				//Return
				$statut = 'error';
				$data = '';
				$message ='Une erreur est survenue, veuillez réessayer.';
				retourJS($statut,$message,$data,false);

			endif;


		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'admin', 'admin/messages_view', $data);
		}
	}//End index()________












}//End document


