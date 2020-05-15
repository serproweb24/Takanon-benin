<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actualites extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(1);
	}
	
	public function index()
	{	
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Admin - Actualites';
		$data['pageName'] = 'actualites';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		//user connected;
		$data['user'] = $user = user_connected();

		$data['activePage'] = $activePage = $this->uri->segment(2);


		//option Categorie Actualités
		$data['optionCategorieAct'] = actualites_categories('forSelect');

		//liste Categorie Actualités
		$data['listCategorieActs'] = actualites_categories('forList');



		//==>Pagination=>1 (Variable)
		$pgt_limit = 12;
		$pgt_urlSegment = 3;
		$pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'admin/actualites'.allUlrParametre();
		$limit = $pgt_limit;
		$offset = $pgt_offset;

		//==>Pagination=>2 (Calcule)
		$array = array();
		$like = array();
		if(isset($_GET['cat'])):
			$data['idActCatActive'] = $idActCatActive = $_GET['cat'];
			$array['actualites.idActCat'] = $idActCatActive;
		endif;
		if(isset($_GET['sta'])):
			$data['statutArt'] = $statutArt = $_GET['sta'];
			$array['actualites.statut'] = $statutArt;
		endif;


		$data['pgt_totalResult'] = $pgt_totalResult = $this->spw_model->get_countAll_for_pagination('actualites',$array,$like);
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
		
		//==>Pagination=>3 (Resultat)
		$as ='*, actualites.statut as statutAct, actualites.dateCreate as dateCreateAct, actualites.description as descriptionAct';
		$lien = 'actualites.idActCat = actualites_categories.idActCat';
		$lienSecond = 'actualites.idUse = users.idUse';
		$data['listeActualites'] =  $this->spw_model->get_treeTables_limit_for_pagination('actualites','actualites_categories','users',$as,$lien,$lienSecond,$limit,$offset,$array,$like,'actualites.idAct','Desc');


		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);

			//Modifier periodePub
			if($ActiveAjax=='periodePub'):

				$this->db->trans_start();

				//=>01
				$dataItem['dateDebut'] = $dateDebut.' 00:00:00';
				$dataItem['dateFin'] = $dateFin.' 23:59:59';
				$this->spw_model->update_item('actualites',$dataItem,array('idAct'=>$idAct));



				if($this->db->trans_complete()):
					//Return 
					$statut = 'success';
					$data = $Returnlink;
					$message ='Félicitation! Période modifiée avec success!';
					retourJS($statut,$message,$data,true);
				endif;


			else:
				$statut = 'error';
				$data = '';
				$message ="Une erreur est survenue, veuillez réessayer.";
				retourJS($statut,$message,$data);
			endif;

		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'admin', 'admin/actualites_view', $data);
		}
	}//End index()________



	public function modifier_actualite($idActualite)
	{
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Actualites';
		$data['pageName'] = 'modifier_actualite';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		//date et heure actuel
		$data['maintenant'] = $maintenant = now();

		$data['activePage'] = $activePage = $this->uri->segment(2);

		//option Categorie Actualités
		$data['optionCategorieAct'] = actualites_categories('forSelect');

		//liste Categorie Actualités
		$data['listCategorieActs'] = actualites_categories('forList');

		//infos user
		$data['user'] = $user = user_connected();


		$idActualite = cripterId($idActualite,1);
		//infos actualite
		$array = array('idAct'=>$idActualite);
		$data['actualites'] = $actualites = $this->spw_model->get_rows('actualites', $array);
		if($actualites):
			foreach($actualites as $actualite):
				$data['statut'] = $statut = $actualite->statut;
				$data['artTile'] = $artTile = $actualite->libAct;
				$data['artDescription'] = $artDescription = $actualite->description;
				$data['artidActCat'] = $artidActCat = $actualite->idActCat;
				$data['artDebut'] = $artDebut = $actualite->dateDebut;
				$data['artFin'] = $artFin= $actualite->dateFin;
				$artAffiche = $actualite->affiche;
			endforeach;
			if(isset($artAffiche)&&!empty($artAffiche)):
				$data['artAffiche'] = $artAffiche;
			else:
				$data['artAffiche'] = 'default.jpg';
			endif;
		else:

		endif;




		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);

			//Modifier actualité
			if($ActiveAjax=='modifierActualite'):
				$this->db->trans_start();

				if(isset($_FILES['file']['name'])):
					$destinationFiles = './assets/images/actualites';
					$userfile = 'file';
					$affiche = $this->spw_model->uploadFiles($destinationFiles,$userfile);
					if(isset($affiche)&&$affiche!='error'):
						$dataItem['affiche'] = $affiche;
					endif;
				endif;

				$statut = 2;

				/*if(date('d-m-Y H:i:00', strtotime($maintenant))>=date('d-m-Y H:i:00', strtotime($debut))):
					if(date('d-m-Y H:i:00', strtotime($maintenant))<date('d-m-Y H:i:00', strtotime($fin))):
						$statut = 2;
					else:
						$statut = 4;
					endif;
				elseif(date('d-m-Y H:i:00', strtotime($maintenant))>=date('d-m-Y H:i:00', strtotime($debut))):
					$statut = 1;
				endif;*/

				//Update infos
				$dataItem['libAct'] = $libAct;
				$dataItem['idActCat'] = $idActCat;
				$dataItem['dateDebut'] = date('Y-m-d  H:i:00', strtotime($debut));
				$dataItem['dateFin'] = date('Y-m-d H:i:00', strtotime($fin));
				$dataItem['description'] = $description;
				$dataItem['statut'] = $statut;
				$this->spw_model->update_item('actualites',$dataItem,array('idAct'=>$idActualite));
				if($this->db->trans_complete()):
					//Return 
					$statut = 'success';
					$data = base_url().'admin/actualites/modifier_actualite/'.cripterId($idActualite,0);
					$message ='Félicitation, opération réussie!!!';
					retourJS($statut,$message,$data,true);
				endif;

			else:
				//Return
				$statut = 'error';
				$data = '';
				$message ='Une erreur est survenue, veuillez réessayer.';
				retourJS($statut,$message,$data,false);
			endif;
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'admin', 'admin/modifier_actualite_view', $data);
		}


	}//End modifier_article()________









}//End document


