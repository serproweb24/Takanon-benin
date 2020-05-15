<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aides extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(1);
	}
	
	public function index()
	{	
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Admin - Aides';
		$data['pageName'] = 'aides';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		//user connected;
		$data['user'] = $user = user_connected();

		$data['activePage'] = $activePage = $this->uri->segment(2);




		//==>Pagination=>1 (Variable)
		$pgt_limit = 12;
		$pgt_urlSegment = 3;
		$pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'admin/aides'.allUlrParametre();
		$limit = $pgt_limit;
		$offset = $pgt_offset;

		//==>Pagination=>2 (Calcule)
		$array = array();
		$like = array();
		if(isset($_GET['sta'])):
			$data['statutAid'] = $statutAid = $_GET['sta'];
			$array['aides.statut'] = $statutAid;
		endif;


		$data['pgt_totalResult'] = $pgt_totalResult = $this->spw_model->get_countAll_for_pagination('aides',$array,$like);
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
		
		//==>Pagination=>3 (Resultat)
		$data['listeAides'] =  $this->spw_model->get_limit_for_pagination('aides',$array,$limit,$offset,$like,'libAid','Asc');


		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);

			//NewAide
			if($ActiveAjax=='newAide'):

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
			elseif($ActiveAjax=='updateAide'):
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
			$this->template->loadTemplate('spw_template', 'default_view', true, 'admin', 'admin/aides_view', $data);
		}
	}//End index()________







}//End document


