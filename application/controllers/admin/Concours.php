<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Concours extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(1);
	}
	
	public function index()
	{

		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Concours';
		$data['pageName'] = 'concours';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		//user connected;
		$data['user'] = $user = user_connected();

		$data['activePage'] = $activePage = $this->uri->segment(2);
		$segmentTrois = $this->uri->segment(3);

		//Liste des matieres
		$data['allMatieres'] = $this->spw_model->get_rows_order('matieres',array('statut'=>2), 'libMat', 'Asc');


		//Count===============>
		$data['totalCC_passer'] = countConcourByPeriode(array('concours.dateEnd <='=>$maintenant));
		$data['totalCC_encours'] = countConcourByPeriode(array('concours.dateStart <='=>$maintenant, 'concours.dateEnd >='=>$maintenant));
		$data['totalCC_bientot'] = countConcourByPeriode(array('concours.dateStart >'=>$maintenant));
		



		//==>Pagination=>1 (Variable)
		$pgt_limit = 12;
		$pgt_urlSegment = 3;
		$pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'admin/concours'.allUlrParametre();
		$limit = $pgt_limit;
		$offset = $pgt_offset;
		$arrayCon = array();
		$like = array();
		if(isset($_GET['pd'])):
			$periodeCC = $_GET['pd'];
			if(isset($segmentTrois)):
				$periodeDefault = explode("/", $periodeCC);
				$periodeCC = $periodeDefault[0];
			endif;
			 $data['periodeCC'] = $periodeCC;
			if(is_numeric($periodeCC)&& in_array($periodeCC, array(1,2,3))):
				if($periodeCC==1):
					$arrayCon['concours.dateEnd <='] = $maintenant;
				elseif($periodeCC==2):
					$arrayCon['concours.dateStart <='] = $maintenant;
					$arrayCon['concours.dateEnd >='] = $maintenant;
				elseif($periodeCC==3):
					$arrayCon['concours.dateStart >'] = $maintenant;
				endif;
			else:
				//Pour des raison de securite
				$arrayCon['concours.dateStart'] = $maintenant;
				$arrayCon['concours.dateEnd'] = $maintenant;
			endif;
			
		endif;

		//==>Pagination=>2 (Calcule)
		$data['pgt_totalResult'] = $pgt_totalResult = count($this->spw_model->get_limit_for_pagination('concours',$arrayCon,$limit,$offset,$like,'dateCreate','Desc',$count=false));
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);

		//==>Pagination=>3 (Resultat)
		$data['listeConcours'] =  $this->spw_model->get_limit_for_pagination('concours',$arrayCon,$limit,$offset,$like,'dateCreate','Desc',$count=true);
		
		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);

			//newConcours
			if($ActiveAjax=='newConcours'):

				//Verifier
				$verifier = $this->spw_model->get_rows('concours',array('libCon'=>$libCon));
				if(!$verifier):
					$this->db->trans_start();
					$dataAdd['libCon'] = $libCon;
					$dataAdd['idUse'] = $user->idUse;
					$dataAdd['dateStart'] = $dateDebut.' '.$heureDebut;
					$dataAdd['dateEnd'] = $dateFin.' '.$heureFin;
					$dataAdd['statut'] = 2;
					$dataAdd['dateCreate'] = $maintenant;
					$this->spw_model->add_item('concours',$dataAdd);


					if($this->db->trans_complete()):
						//Return 
						$statut = 'success';
						$data = $Returnlink;
						$message ='Nouveau concours  enrégistré avec success!';
						retourJS($statut,$message,$data,true);
					endif;

				else:
					$statut = 'error';
					$data = '';
					$message ="Désolé! Ce concours existe déja.";
					retourJS($statut,$message,$data,true);
				endif;				
				

			//updateConcours
			elseif($ActiveAjax=='updateConcours'):

				$this->db->trans_start();

				$dataItem = array(
					"libCon" => $libCon
				);
				$this->spw_model->update_item('concours',$dataItem,array('idCon'=>cripterId($idCon,1)));
				if($this->db->trans_complete()):
					//Return 
					$statut = 'success';
					$data = $Returnlink;
					$message ='Le concours a été bien modifié!';
					retourJS($statut,$message,$data,true);
				endif;


			//newQuestionConcours
			elseif($ActiveAjax=='newQuestionConcours'):

				//Verifier
				$verifierExiste = $this->spw_model->get_rows('concours_content', array('idCon'=>cripterId($idCon,1), 'idAllQue'=>$idAllQue));
				//Verifier si existe de reposes definir a cette question
				$reponseExiste = $this->spw_model->get_rows('concours_all_reponses', array('idAllQue'=>$idAllQue, 'statut'=>2));

				//Verifier si existe de reposes vrai definir a cette question
				$vraiReponseExiste = $this->spw_model->get_rows('concours_all_reponses', array('idAllQue'=>$idAllQue, 'etat'=>1));

				if(!$verifierExiste):
					if($reponseExiste):
						if(count($reponseExiste)>=3):
							if($vraiReponseExiste):
								$this->db->trans_start();
								$dataAdd['idCon'] = cripterId($idCon,1);
								$dataAdd['idAllQue'] = $idAllQue;
								$dataAdd['idUse'] = $user->idUse;
								$dataAdd['statut'] = 2;
								$dataAdd['dateCreate'] = $maintenant;
								$this->spw_model->add_item('concours_content',$dataAdd);

								if($this->db->trans_complete()):
									//Return 
									$statut = 'success';
									$data = $Returnlink;
									$message ='Nouvelle question  enrégistrée avec success!';
									retourJS($statut,$message,$data,true);
								endif;
							else:
								$statut = 'error';
								$data = '';
								$message ="Désolé! Cette question ne contient pas au-moins une  propositions de réponses vrai.";
								retourJS($statut,$message,$data,true);
							endif;

						else:
							$statut = 'error';
							$data = '';
							$message ="Désolé! Cette question ne contient pas au-moins trois propositions de réponses.";
							retourJS($statut,$message,$data,true);
						endif;

					else:
						$statut = 'error';
						$data = '';
						$message ="Désolé! Aucune proposition de réponses n'a été définir  pour cette question .";
						retourJS($statut,$message,$data,true);
					endif;
				else:
					$statut = 'error';
					$data = '';
					$message ="Désolé! Cette question existe déja.";
					retourJS($statut,$message,$data,true);
				endif;				

			//Modifier periode
			elseif($ActiveAjax=='updatePeriodeConcours'):

				$this->db->trans_start();
				
				//Update periode
				$dataItem = array(
					"dateStart" => $dateDebut.' '.$heureDebut,
					"dateEnd" => $dateFin.' '.$heureFin
				);
				$this->spw_model->update_item('concours',$dataItem,array('idCon'=>cripterId($idCon,1)));
				if($this->db->trans_complete()):
					//Return 
					$statut = 'success';
					$data = $Returnlink;
					$message ='La période a été bien modifiée!';
					retourJS($statut,$message,$data,true);
				endif;

			else:
				echo "Une erreur est survenue, veuillez réessayer.";
			endif;
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'admin', 'admin/concours_view', $data);
		}
	}//End index()________







}//End document


