<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Repetiteur extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(2);
		$user = user_connected();
		if($user->idUseCat!=1):
			redirect(base_url().'clients');
		endif;
	}
	
	public function index()
	{

		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Repetiteur';
		$data['pageName'] = 'repetiteur';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		$data['activePage'] = $activePage = $this->uri->segment(2);


		//infos user
		$data['user'] = $user = user_connected();

		//liste Categories niveau d'enseignement 
		$data['optionCategorieNivEnseignement'] = categorie_niveau_enseignement('forSelect');
		//liste Categories niveau d'enseignement 
		$data['listCategorieNivEnseignement'] = categorie_niveau_enseignement('forList');

		//liste des matieres
		$data['optionMatieres'] = articles_matieres('forSelect');
		//liste des matieres
		$data['listMatieres'] = articles_matieres('forList');


		//Repetiteur
		$as = '*, repetiteurs.statut as statutRep';
		$lien = 'repetiteurs.idCatNiv = categories_niveau.idCatNiv';
		$data['repetiteurs'] = $repetiteurs = $this->spw_model->get_Double_Table('repetiteurs','categories_niveau',$as,$lien,array('idUse'=>$user->idUse),'','');
		if($repetiteurs):
			foreach($repetiteurs as $repetiteur):
				$data['idRep'] = $idRep = $repetiteur->idRep;
				$data['statutRep'] = $statutRep = $repetiteur->statutRep;
				$data['libCatNiv'] = $libCatNiv = $repetiteur->libCatNiv;
			endforeach;

			if(isset($idRep)):
				$as = '*, repetiteurs_offres.statut as statutOffre, repetiteurs_offres.idMat as idMatOffre,';
				$lien = 'repetiteurs_offres.idMat = matieres.idMat';
				$data['repetiteurMatieres'] = $repetiteurMatieres = $this->spw_model->get_Double_Table('repetiteurs_offres','matieres',$as,$lien,array('idRep'=>$idRep),'','');
				if($repetiteurMatieres):

					$listMat ='';
					foreach($repetiteurMatieres as $repetiteurMatiere):
						$idRepOff = $repetiteurMatiere->idRepOff;
						$idMat = $repetiteurMatiere->idMatOffre;
						$libMat = $repetiteurMatiere->libMat;
						$statutMat = $repetiteurMatiere->statutOffre;
						$prixRepOff = $repetiteurMatiere->price;
						$listMat .='  
						<li>
						<a href="#updatPriceMatierRepetiteur" class="js-open-poPup js-transfer_data" data-infos="'.$idRepOff.'@@'.$idMat.'@@'.$statutMat.'@@'.$prixRepOff.'">
						<span class="name">'.$libMat.'</span>
						<span class="price">'.number_format($prixRepOff, 0, ',', ' ').'f/ M</span>
						</a>
						</li>
						';
					endforeach;
					$data['listMat'] = '<ul  class="infos-matieres-list">'.$listMat.'</ul>';
				endif;
			endif;


		endif;




		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);

			//startRepetiteur
			if($ActiveAjax=='startRepetiteur'):
				//Verification
				$existe = verifyExist('repetiteurs',array(
					'idUse'=>$user->idUse
				));
				if($existe):
					//Return
					$statut = 'existe';
					$data = '';
					$message ='Désolé, vous existe déja en tant que répétiteur !!!';
					retourJS($statut,$message,$data,true);
				else:
					
					//Ajouter
					$this->db->trans_start();
					$dataAdd = array(
						"idUse" => $user->idUse,
						"idCatNiv" => $idCatNiv,
						"description" => $description,
						"statut" => 1,
						"dateCreate" => $maintenant
					);

					$this->spw_model->add_item('repetiteurs',$dataAdd);
					if($this->db->trans_complete()):
						//Return 
						$statut = 'success';
						$data = base_url().'clients/repetiteur';
						$message ='Votre  <strong>compte répétiteur</strong> a été bien créé !!!';
						retourJS($statut,$message,$data,true);
					endif;

				endif;

			//Ajouter une matiere
			elseif($ActiveAjax=='newMatierRepetiteur'):
				//Verification existe
				$existe = verifyExist('repetiteurs_offres',array(
					'idRep'=>$idRep,
					'idMat'=>$idMat
				));
				if($existe):
					//Return
					$statut = 'existe';
					$data = '';
					$message ='Désolé,  cette matiere est déja dans votre repertoir !!!';
					retourJS($statut,$message,$data,true);
				else:
					$resultat = verifyExist('repetiteurs_offres',array(
						'idRep'=>$idRep
					));
					if(count($resultat)>=2):
						//Return
						$statut = 'existe';
						$data = '';
						$message ='Désolé,  vous avez déja atteint la limite accordée d\'ajour de matière !!!';
						retourJS($statut,$message,$data);
					else:
						//Ajouter
						$this->db->trans_start();
						$dataAdd = array(
							"idRep" => $idRep,
							"idMat" => $idMat,
							"price" => $price,
							"statut" => 2,
							"dateCreate" => $maintenant
						);

						$this->spw_model->add_item('repetiteurs_offres',$dataAdd);
						if($this->db->trans_complete()):
							//Return 
							$statut = 'success';
							$data = base_url().'clients/repetiteur';
							$message ='Votre  <strong>compte répétiteur</strong> a été bien créé !!!';
							retourJS($statut,$message,$data,true);
						endif;

					endif;

				endif;
			else:
				echo "Une erreur est survenue, veuillez réessayer.";
			endif;
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'clients', 'clients/repetiteur_view', $data);
		}
	}//End index()________







}//End document


