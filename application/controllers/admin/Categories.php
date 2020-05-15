<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(1);
	}

	public function index() {
	/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Admin  Categories';
		$data['pageName'] = 'aides';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		//user connected;
		$data['user'] = $user = user_connected();
		$limit = 8;
		$table = 'matieres';
		$array = ["statut" => 2];
		$data['activePage'] = $activePage = $this->uri->segment(2);

		$data['listeAides'] = $this->spw_model->get_rows('categories_niveau', array('statut' => 2));
		$data['listeMatieres'] = $this->spw_model->get_rows($table,$array);


    $pgt_limit = 12;
		$pgt_urlSegment = 3;
		$pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'admin/matieres'.allUlrParametre();
		$limit = $pgt_limit;
		$offset = $pgt_offset;


		//==>Pagination=>2 (Calcule)
		$array = array();
		$like = array();
		if(isset($_GET['sta'])):
			$data['statutAid'] = $statutAid = $_GET['sta'];
			$array['matieres.statut'] = $statutAid;
		endif;


		$data['pgt_totalResult'] = $pgt_totalResult = $this->spw_model->get_countAll_for_pagination('matieres',$array,$like);
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
		
		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);

			//NewAide
			if($ActiveAjax=='newAid'):

				$this->db->trans_start();
				if(isset($libAid)&&isset($description)):
					$this->db->trans_start();
					$dataAdd = array(
						"libAid" => $libAid,
						"idUse" => $user->idUse,
						"content" => $description,
						"statut" => 1,
						"dateCreate" => $maintenant
					);
					$this->spw_model->add_item('aides',$dataAdd);
					if($this->db->trans_complete()):
						//Return 
						$statut = 'success';
						$data = base_url().'admin/aides';
						$message ='l\'aide <strong>'.$libAid.'</strong> a été bien enregistrée!';
						retourJS($statut,$message,$data,true);
					endif;
				else:
					$statut = 'error';
					$data = '';
					$message ="Veuillez renseigner tous les champs.";
					retourJS($statut,$message,$data);
				endif;
				
			//Update aide
			elseif($ActiveAjax=='updateAid'):
				$this->db->trans_start();
				//Update infos
				$dataItem['libAid'] = $libAid;
				$dataItem['content'] = $description;
				$this->spw_model->update_item('aides',$dataItem,array('idAid'=>$idAid));
				if($this->db->trans_complete()):
					//Return 
					$statut = 'success';
					$data = base_url().'admin/aides';
					$message ='l\'aide <strong>'.$libAid.'</strong> a été bien modifiée!';
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
			$this->template->loadTemplate('spw_template', 'default_view', true, 'admin', 'admin/categorie_view', $data);
		}
	}//End index()________

	public function delete() {

		$id = $this->uri->segment(4);
		$table = 'matieres';
		$dataItem = ["statut"=>1];
		$array = ["idMat"=>$id];
		$this->spw_model->update_item($table,$dataItem,$array);
		redirect(base_url("admin/categories"));
	}

	public function update() {

	}
}
