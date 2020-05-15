<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Boutique extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		userIsLogin(2);
	}
	
	public function index()
	{
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Boutique';
		$data['pageName'] = 'boutique';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		//infos user
		$data['user'] = $user = user_connected();

		//liste Categorie Article
		$data['optionCategorieArt'] = articles_categories('forSelect');
		//liste Categorie Article
		$data['listCategorieArt'] = articles_categories('forList');

		//liste Categorie Article
		$data['optionMatieres'] = articles_matieres('forSelect');
		$data['listMatieres'] = articles_matieres('forList');

		//liste Categorie Article
		$data['optionAnnees'] = articles_annees('forSelect');
		$data['listAnnees'] = articles_annees('forList');
		

		//Avive page - sidebar
		$data['activePage'] = $activePage = $this->uri->segment(2);




		//==>Pagination=>1 (Variable)
		$pgt_limit = 12; 
		$pgt_urlSegment = 3;
		$pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'clients/boutique';

		//==>Pagination=>2 (Calcule)
		$array['articles.idUse'] =  $user->idUse;
		if(isset($_GET['cat'])):
			$data['idArtCat'] = $idArtCat = $_GET['cat'];
			$array['articles.idArtCar'] = $idArtCat;
		endif;

		if(isset($_GET['sta'])):
			$data['statutArt'] = $statutArt = $_GET['sta'];
			$array['articles.statut'] = $statutArt;
		endif;


		$data['pgt_totalResult'] = $pgt_totalResult = lastPosts('forList',$pgt_limit,$pgt_offset,$like=array(),$array)->count;
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
		

		//==>Pagination=>3 (Resultat)
		$data['listePostes'] =  lastPosts('forList',$pgt_limit,$pgt_offset,$like=array(),$array)->list;




		
		

		
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
						$document = $this->spw_model->uploadFiles($destinationFiles,$userfile,'pdf');
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
								// le formulaire est désactivé donc la valeur n'est pas envoyer le script plante 
								// a ce niveau j'ai du remplacer le prix en dure pour deboguer
								"prix" => 0,
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
							$message ='Votre fichier n\'a pu être chargé, veuillez vérifier sa taille ou que son format soit en PDF.';
							retourJS($statut,$message,$data,true);
						endif;
					endif;
				endif;


			//updatePost
			elseif($ActiveAjax=='updatePost'):
				$this->db->trans_start();

				if(isset($idArtCar)&&!empty($idArtCar)):
					$dataItem['idArtCar'] = $idArtCar;
				endif;

				if(isset($idNiv)&&!empty($idNiv)):
					$dataItem['idNiv'] = $idNiv;
				endif;


				if(isset($idMat)&&!empty($idMat)):
					$dataItem['idMat'] = $idMat;
				endif;


				if(isset($idAnn)&&!empty($idAnn)):
					$dataItem['idAnn'] = $idAnn;
				endif;


				if(isset($libArt)&&!empty($libArt)):
					$dataItem['libArt'] = $libArt;
				endif;

				if(isset($prix)):
					$dataItem['prix'] = $prix;
				endif;

				if(isset($description)&&!empty($description)):
					$dataItem['description'] = $description;
				endif;
				
				$this->spw_model->update_item('articles',$dataItem,array('idArt'=>$idArt));
				$this->db->trans_complete();

				$statut = 'success';
				$data = base_url().'clients/boutique';
				//$message = $idArt.'@@'.$idArtCar.'@@'.$libArt.'@@'.$prix.'@@'.$description;
				$message ='Le document <strong>'.$libArt.'</strong> a été bien modifié!';
				retourJS($statut,$message,$data,true);

			else:
				//Return
				$statut = 'error';
				$data = '';
				$message ='Une erreur est survenue, veuillez réessayer.';
				retourJS($statut,$message,$data,true);
			endif;
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'clients', 'clients/boutique_view', $data);
		}
	}//End index()________






}//End document


