<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(1);
	}
	
	public function index()
	{
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Articles';
		$data['pageName'] = 'articles';
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
		$pgt_url = base_url().'admin/articles'.allUlrParametre();

		//==>Pagination=>2 (Calcule)
		$array = array();
		if(isset($_GET['cat'])):
			$data['idArtCat'] = $idArtCat = $_GET['cat'];
			$data['titleSection'] = '';
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
			$this->template->loadTemplate('spw_template', 'default_view', true, 'admin', 'admin/articles_view', $data);
		}
	}//End index()________






}//End document


