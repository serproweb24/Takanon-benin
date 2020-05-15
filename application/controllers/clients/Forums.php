<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forums extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(2);
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

		//Les forums du user connecter
		$data['totalForum'] = infos_forums(array('idUse'=>$user->idUse),true);
		$data['activerForum'] = infos_forums(array('statut'=>2,'idUse'=>$user->idUse),true);
		$data['attenteForum'] = infos_forums(array('statut'=>1,'idUse'=>$user->idUse),true);
		$data['regeterForum'] = infos_forums(array('statut'=>3,'idUse'=>$user->idUse),true);
		$data['fermerForum'] = infos_forums(array('statut'=>0,'idUse'=>$user->idUse),true);

		//==>Pagination=>1 (Variable)
		$pgt_limit = 12; 
		$pgt_urlSegment = 3;
		$data['pgt_offset'] = $pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		//$pgt_url = (isset($_GET['initiateur'])) ? base_url().'clients/forums?initiateur='.$_GET['initiateur']:base_url().'clients/forums';
		$pgt_url = base_url().'clients/forums'.allUlrParametre();
		$like=array();


		//==>Pagination=>2 (Calcule)
		$array = array('idUse'=>$user->idUse);
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
						$data = base_url().'clients/forums';
						$message ='Félicitation, votre nous sujet de forum à été bien enrégistré !!!';
						retourJS($statut,$message,$data,true);

					endif;
				endif;
			else:
				echo "Une erreur est survenue, veuillez réessayer.";
			endif;
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'clients', 'clients/forums_view', $data);
		}
	}//End index()________




	public function selection($idForum)
	{
		$section_BO = 'clients';
		include ('application/controllers/back-office/forum.php');

	}

}//End document


