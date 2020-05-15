<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Achats extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(3);
	}
	
	public function index()
	{
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Achats';
		$data['pageName'] = 'achats';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();
		//Avive page - sidebar
		$data['activePage'] = $activePage = $this->uri->segment(2);

		//infos user
		$data['user'] = $user = user_connected();

		//liste Categorie Article
		$data['listCategorieArt'] = articles_categories('forList');

	
		

		


		//==>Pagination=>1 (Variable)
		$pgt_limit = 12; 
		$pgt_urlSegment = 3;
		$data['pgt_offset'] = $pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$offset = $pgt_offset;
		$limit = $pgt_limit;
		$pgt_url = base_url().'users/achats'.allUlrParametre();
		$like=array();

		//==>Pagination=>2 (Calcule)
		$array['paniers_content.idAcheteur'] =  $user->idUse;
		if(isset($_GET['cat'])):
			$data['idArtCat'] = $idArtCat = $_GET['cat'];
			$array['paniers_content.idArtCar'] = $idArtCat;
		endif;

		if(isset($_GET['sta'])):
			$data['statutArt'] = $statutArt = $_GET['sta'];
			$array['articles.statut'] = $statutArt;
		endif;


		$data['pgt_totalResult'] = $pgt_totalResult = $this->spw_model->get_countAll_for_pagination('paniers_content',$array,$like);
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
		

		//==>Pagination=>3 (Resultat)
		$as = '*, paniers.dateCreate as dateCreatePan';
		$lien = 'paniers_content.idArt = articles.idArt';
		$lienSecond = 'articles.idUse = users.idUse';
		$lienThird = 'paniers_content.idPan = paniers.idPan';
		$data['achats'] =  $this->spw_model->get_fourTables_limit_for_pagination('paniers_content','articles','users','paniers',$as,$lien,$lienSecond,$lienThird,$limit,$offset,$array,$like,'paniers_content.idPanCont','Desc');




		
		

		
		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);

			//newPost
			/*if($ActiveAjax=='newPost'):
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
			endif;*/
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'users', 'users/achats_view', $data);
		}
	}//End index()________






}//End document


