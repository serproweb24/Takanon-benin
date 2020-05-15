<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actualites extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(2);
	}

	
	public function index()
	{

		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Actualites';
		$data['pageName'] = 'actualites';
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


		//==>Pagination=>1 (Variable)
		$pgt_limit = 3; 
		$pgt_urlSegment = 3;
		$data['pgt_offset'] = $pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		//$pgt_url = (isset($_GET['actualite'])) ? base_url().'clients/actualites?actualite='.$_GET['actualite']:base_url().'clients/actualites';
		$pgt_url = base_url().'clients/actualites'.allUlrParametre();

		//==>Pagination=>2 (Calcule)
		$array['idUse'] = $user->idUse;
		if(isset($_GET['actualite'])):
			$data['idActCat'] = $actualite = $_GET['actualite'];
			$data['titleSection'] = '';
			$array['actualites.idActCat'] = $_GET['actualite'];
		else:
			
		endif;

		$data['pgt_totalResult'] = $pgt_totalResult = $this->spw_model->get_countAll_for_pagination('actualites',$array,$like=array());
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
		

		//==>Pagination=>3 (Resultat)
		$as = '*,actualites.statut as statutAct';
		$lien = 'actualites.idActCat = actualites_categories.idActCat';
		$data['actualites'] =  $this->spw_model->get_DoubleTables_limit_for_pagination('actualites','actualites_categories',$as,$lien,$array,$pgt_limit,$pgt_offset,$like=array(),'actualites.dateCreate','Desc');


		
		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);

			//Nouvelle actualité
			if($ActiveAjax=='newActualite'):
				//Ajouter
				if(isset($_FILES['file']['name'])):
					$destinationFiles = './assets/images/actualites';
					$file = 'file';
					$affiche = $this->spw_model->uploadFiles($destinationFiles,$file);
					if(isset($affiche)&&$affiche!='error'):
						$this->db->trans_start();
						$dataAdd = array(
							"idActCat" => $idActCat,
							"idUse" => $user->idUse,
							"libAct" => $libAct,
							"affiche" => $affiche,
							"description" => $description,
							"statut" => 1,
							"dateCreate" => $maintenant
						);
						$this->spw_model->add_item('actualites',$dataAdd);
						if($this->db->trans_complete()):
								//Return 
							$statut = 'success';
							$data = base_url().'clients/actualites';
							$message ='Votre actulité <strong>'.$libAct.'</strong> a été bien enregistrée !!!';
							retourJS($statut,$message,$data,true);
						endif;

					else:
							//Return
						$statut = 'error';
						$data = '';
						$message ='Le fichier n\'a pas été chargé, Soit a cause de sa taille ou de son format.  veillez ressayé.';
						retourJS($statut,$message,$data,true);
					endif;
				endif;

			else:
				echo "Une erreur est survenue, veuillez réessayer.";
			endif;
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'clients', 'clients/actualites_view', $data);
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

			//Nouvelle actualité
			if($ActiveAjax=='updateActualite'):
				//Ajouter
				if(isset($_FILES['file']['name'])):
					$destinationFiles = './assets/images/actualites';
					$file = 'file';
					$affiche = $this->spw_model->uploadFiles($destinationFiles,$file);
					if(isset($affiche)&&$affiche!='error'):
						$this->db->trans_start();
						$dataAdd = array(
							"idActCat" => $idActCat,
							"idUse" => $user->idUse,
							"libAct" => $libAct,
							"affiche" => $affiche,
							"description" => $description,
							"statut" => 1,
							"dateCreate" => $maintenant
						);
						$this->spw_model->add_item('actualites',$dataAdd);
						if($this->db->trans_complete()):
								//Return 
							$statut = 'success';
							$data = base_url().'clients/actualites';
							$message ='Votre actulité <strong>'.$libAct.'</strong> a été bien enregistrée !!!';
							retourJS($statut,$message,$data,true);
						endif;

					else:
							//Return
						$statut = 'error';
						$data = '';
						$message ='Le fichier n\'a pas été chargé, Soit a cause de sa taille ou de son format.  veillez ressayé.';
						retourJS($statut,$message,$data,true);
					endif;
				endif;

			//Modifier actualité
			elseif($ActiveAjax=='modifierActualite'):
				$this->db->trans_start();

				if(isset($_FILES['file']['name'])):
					$destinationFiles = './assets/images/actualites';
					$userfile = 'file';
					$affiche = $this->spw_model->uploadFiles($destinationFiles,$userfile);
					if(isset($affiche)&&$affiche!='error'):
						$dataItem['affiche'] = $affiche;
					endif;
				endif;

				//Update infos
				$dataItem['libAct'] = $libAct;
				$dataItem['description'] = $description;
				$this->spw_model->update_item('actualites',$dataItem,array('idAct'=>$idActualite));
				if($this->db->trans_complete()):
					//Return 
					$statut = 'success';
					$data = base_url().'clients/actualites/modifier_actualite/'.cripterId($idActualite,0);
					$message ='Félicitation, opération réussie!!!';
					retourJS($statut,$message,$data,true);
				endif;

			else:
				echo "Une erreur est survenue, veuillez réessayer.";
			endif;
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'clients', 'clients/modifier_actualite_view', $data);
		}


	}//End modifier_article()________




}//End document


