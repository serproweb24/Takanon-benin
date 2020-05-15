<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forums extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(1);
	}
	
	public function index()
	{

		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Forums';
		$data['pageName'] = 'forums';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		$data['activePage'] = $activePage = $this->uri->segment(2);

		//infos user
		$data['user'] = $user = user_connected();

		//Count disponibilités
		$data['totalForum'] = infos_forums(array(),true);
		$data['activerForum'] = infos_forums(array('statut'=>2),true);
		$data['attenteForum'] = infos_forums(array('statut'=>1),true);
		$data['regeterForum'] = infos_forums(array('statut'=>3),true);
		$data['fermerForum'] = infos_forums(array('statut'=>0),true);




		//==>Pagination=>1 (Variable)
		$pgt_limit = 12; 
		$pgt_urlSegment = 3;
		$data['pgt_offset'] = $pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'admin/forums'.allUlrParametre();


		//==>Pagination=>2 (Calcule)
		$array = array();
		if(isset($_GET['sta'])):
			$statutForums = $_GET['sta'];
			$array['statut'] = $statutForums;
			$data['statutForums'] = $statutForums;
		endif;

		$data['pgt_totalResult'] = $pgt_totalResult = $this->spw_model->get_countAll_for_pagination('forums',$array,$like=array());
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
		

		//==>Pagination=>3 (Resultat)
		$data['forums'] =  $this->spw_model->get_limit_for_pagination('forums',$array,$pgt_limit,$pgt_offset,$like=array(),'dateCreate','Desc');



		
		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);

			//newForum
			if($ActiveAjax=='newForum'):

				$existe = verifyExist('forums',array(
					'libFor'=>$libFor,
					'description'=>$description,
					'idUse'=>$user->idUse
				));
				if($existe):
					//Return
					$statut = 'existe';
					$data = '';
					$message ='Désolé, il existe déja un forum <strong>'.$libFor.'</strong> à votre actif!!!';
					retourJS($statut,$message,$data,true);
				else:
					//Ajouter
					$this->db->trans_start();
					$dataAdd = array(
						'libFor'=>$libFor,
						'description'=>$description,
						"idUse" => $user->idUse,
						"statut" => 1,
						"dateCreate" => $maintenant
					);
					$this->spw_model->add_item('forums',$dataAdd);
					if($this->db->trans_complete()):
						//Return 
						$statut = 'success';
						$data = base_url().'admin/forums';
						$message ='Félicitation, votre nous sujet de forum à été bien enrégistré !!!';
						retourJS($statut,$message,$data,true);

					endif;
				endif;
			else:
				echo "Une erreur est survenue, veuillez réessayer.";
			endif;
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'admin', 'admin/forums_view', $data);
		}
	}//End index()________


	public function selection($idForum)
	{
		$data['idForumCripter'] = $idForumCripter = $idForum;
		$data['idForum'] = $idForum = cripterId($idForum,1);

		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Forums';
		$data['pageName'] = 'forum_selectionner';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		$data['activePage'] = $activePage = $this->uri->segment(2);

		//infos user
		$data['user'] = $user = user_connected();

		//verification
		$forumSelectonners = $this->spw_model->get_rows('forums',array('idFor'=>$idForum));

		if($forumSelectonners&&!empty($forumSelectonners)):
			$data['forumSelectonners'] = $forumSelectonners;
			foreach($forumSelectonners as $forumSelectonner):
				$idFor = $forumSelectonner->statut;
				$data['statutForum'] = $forumSelectonner->statut;
				$data['sujetForum'] = $forumSelectonner->libFor;
				$data['descriptionForum'] = $forumSelectonner->description;
				$data['idUseForum'] = $forumSelectonner->idUse;
				$data['dateCreateForum'] = $forumSelectonner->dateCreate;
			endforeach;

			//Commantaire forum
			//==>Pagination=>1 (Variable)
			$pgt_limit = 12; 
			$pgt_urlSegment = 5;
			$data['pgt_offset'] = $pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
			$pgt_url = base_url().'admin/forums/selection/'.cripterId($idForum,0);
			$limit = $pgt_limit;
			$offset = $pgt_offset;
			$like = array();


			//==>Pagination=>2 (Calcule)
			$array = array('idFor'=>$idForum);
			if(isset($_GET['sta'])):
				$array['statut'] = $_GET['sta'];
			endif;

			$data['pgt_totalResult'] = $pgt_totalResult = $this->spw_model->get_countAll_for_pagination('forums_content',$array,$like=array());
			$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);


			//==>Pagination=>3 (Resultat)
			$as = '*,forums_content.dateCreate as datePoste';
			$lien = 'forums_content.idUse = users.idUse';
			$data['forumPostes'] =  $this->spw_model->get_DoubleTables_limit_for_pagination('forums_content','users',$as,$lien,$array,$limit,$offset,$like,'forums_content.dateCreate','Desc');
			
		endif;


		//Ajax
		if($this->input->is_ajax_request()){
			extract($_POST);

			
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'admin', 'admin/forum_selectionner_view', $data);
		}


	}





}//End document


