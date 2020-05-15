<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Repetiteurs extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(1);
	}
	
	public function index()
	{
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Repetiteurs';
		$data['pageName'] = 'repetiteurs';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		//infos user
		$data['user'] = $user = user_connected();

		//Active page - sidebar
		$data['activePage'] = $activePage = $this->uri->segment(2);

		//liste Categorie Niveaux etude
		$data['categorieNiveaux'] = categorie_niveau_enseignement('forList');






		//==>Pagination=>1 (Variable)
		$pgt_limit = 12; 
		$pgt_urlSegment = 3;
		$pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'admin/repetiteurs'.allUlrParametre();
		$limit = $pgt_limit;
		$offset = $pgt_offset;
		$like = array();

		//==>Pagination=>2 (Calcule)
		$array = array();
		if(isset($_GET['cat'])):
			$data['idCatNivActive'] = $idCatNivActive = $_GET['cat'];
			$data['titleSection'] = '';
			$array['repetiteurs.idCatNiv'] = $idCatNivActive;
		endif;
		if(isset($_GET['sta'])):
			$data['statutRep'] = $statutRep = $_GET['sta'];
			$array['repetiteurs.statut'] = $statutRep;
		endif;



		$data['pgt_totalResult'] = $pgt_totalResult = $this->spw_model->get_countAll_for_pagination('repetiteurs',$array,$like);
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
		

		//==>Pagination=>3 (Resultat)
		$as ='*, repetiteurs.statut as statutRep, repetiteurs.dateCreate as dateCreateRep, repetiteurs.description as descriptionRep';
		$lien = 'repetiteurs.idCatNiv = categories_niveau.idCatNiv';
		$lienSecond = 'repetiteurs.idUse = users.idUse';
		$data['repetiteurs'] =  $this->spw_model->get_treeTables_limit_for_pagination('repetiteurs','categories_niveau','users',$as,$lien,$lienSecond,$limit,$offset,$array,$like,'users.nom','Asc');





		


		
		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);

			//newPost
			if($ActiveAjax=='newPost'):
				$existe = verifyExist('articles',array(
					'libArt'=>$libArt,
					'idArtCar'=>$idArtCar,
					'idNiv'=>$idNiv,
					'idMat'=>$idMat,
					'idAnn'=>$idAnn,
					'idUse'=>$user->idUse
				));

				if($existe):
					//Return
					$statut = 'existe';
					$data = '';
					$message ='Désolé, Le document <strong>'.$libArt.'</strong> existe déja dans votre Boutique !!!';
				else:
					//Ajouter
					if(isset($_FILES['file']['name'])):
						$destinationFiles = './assets/documents/posts';
						$userfile = 'file';
						$document = $this->spw_model->uploadFiles($destinationFiles,$userfile);
						if(isset($document)&&$document!='error'):
							$this->db->trans_start();
							$dataAdd = array(
								"libArt" => $libArt,
								"nomDoc" => $document,
								"idArtCar" => $idArtCar,
								"idNiv" => $idNiv,
								"idMat" => $idMat,
								"idAnn" => $idAnn,
								"idUse" => $user->idUse,
								"prix" => $prix,
								"description" => $description,
								"statut" => 1,
								"dateCreate" => $maintenant
							);
							$this->spw_model->add_item('articles',$dataAdd);
							if($this->db->trans_complete()):
								//Return 
								$statut = 'success';
								$data = base_url().'clients/boutique';
								$message ='Le document <strong>'.$libArt.'</strong> a été bien enregistré !!!';
								retourJS($statut,$message,$data,true);
							endif;

						else:
							//Return
							$statut = 'error';
							$data = '';
							$message ='Le fichier n\'a pas été chargé, veillez ressayé.';
							retourJS($statut,$message,$data,true);
						endif;
					endif;
				endif;

			else:
				//Return
				$statut = 'error';
				$data = '';
				$message ='Une erreur est survenue, veuillez réessayer.';
				retourJS($statut,$message,$data,true);
			endif;
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'admin', 'admin/repetiteurs_view', $data);
		}
	}//End index()________






}//End document


