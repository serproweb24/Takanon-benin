<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forums extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(3);
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

		//infos user
		$data['user'] = $user = user_connected();


		

		//Avive page - sidebar
		$data['activePage'] = $activePage = $this->uri->segment(2);




		//==>Pagination=>1 (Variable)
		$pgt_limit = 12; 
		$pgt_urlSegment = 3;
		$data['pgt_offset'] = $pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		//$pgt_url = (isset($_GET['initiateur'])) ? base_url().'clients/forums?initiateur='.$_GET['initiateur']:base_url().'clients/forums';
		$pgt_url = base_url().'users/forums'.allUlrParametre();
		$like=array();


		//==>Pagination=>2 (Calcule)
		//$array = array('idUse'=>$user->idUse);
		$array = array('statut !='=>1);
		if(isset($_GET['sta'])):
			$statutForums = $_GET['sta'];
			$array['statut'] = $statutForums;
			$data['statutForums'] = $statutForums;
		endif;



		$data['pgt_totalResult'] = $pgt_totalResult = $this->spw_model->get_countAll_for_pagination('forums',$array,$like);
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
		

		//==>Pagination=>3 (Resultat)
		$data['forums'] =  $this->spw_model->get_limit_for_pagination('forums',$array,$pgt_limit,$pgt_offset,$like,'dateCreate','Desc');


		
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
			$this->template->loadTemplate('spw_template', 'default_view', true, 'users', 'users/forums_view', $data);
		}
	}//End index()________




	public function selection($idForum)
	{
		$section_BO = 'users';
		include ('application/controllers/back-office/forum.php');

	}


}//End document


