<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mes_forums extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(3);
	}
	
	public function index()
	{
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Mes_forums';
		$data['pageName'] = 'mes_forums';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		//infos user
		$data['user'] = $user = user_connected();


		

		//Avive page - sidebar
		$data['activePage'] = $activePage = $this->uri->segment(2);




		//==>Pagination=>1 (Variable)
		$pgt_limit = 12; 
		$pgt_urlSegment = 3;
		$data['pgt_offset'] = $pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'users/forums'.allUlrParametre();
		$like=array();
		$offset = $pgt_offset;
		$limit = $pgt_limit;


		//==>Pagination=>2 (Calcule)
		$array = array('forums.statut !='=>1, 'forums_content.idUse'=>$user->idUse);
		if(isset($_GET['sta'])):
			$statutForums = $_GET['sta'];
			$array['statut'] = $statutForums;
			$data['statutForums'] = $statutForums;
		endif;

		$as = '*,forums.statut as statutFor';
		$lien = 'forums_content.idFor = forums.idFor';
		$group_by = 'forums_content.idFor';
		


		$data['pgt_totalResult'] = $pgt_totalResult = count($this->spw_model->get_DoubleTable_GrpBY_limit_for_pagination('forums_content','forums',$as,$lien,$array,$group_by,$limit,$offset,$like,'forums.dateCreate','Desc',false));
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
		
		//==>Pagination=>3 (Resultat)
		$data['mes_forums'] =  $this->spw_model->get_DoubleTable_GrpBY_limit_for_pagination('forums_content','forums',$as,$lien,$array,$group_by,$limit,$offset,$like,'forums.dateCreate','Desc',true);


		
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
			$this->template->loadTemplate('spw_template', 'default_view', true, 'users', 'users/mes_forums_view', $data);
		}
	}//End index()________




}//End document


