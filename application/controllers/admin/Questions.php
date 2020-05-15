<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questions extends CI_Controller {



	function __construct() {
		parent::__construct();
		userIsLogin(1);
	}
	
	public function index()
	{

		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Questions';
		$data['pageName'] = 'questions';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		//user connected;
		$data['user'] = $user = user_connected();

		$data['activePage'] = $activePage = $this->uri->segment(2);

		//Liste des matieres
		$data['allMatieres'] = $this->spw_model->get_rows_order('matieres',array('statut'=>2), 'libMat', 'Asc');

		//Liste des auteurs
		$data['allAuteurs'] = $this->spw_model->get_rows_order('users',array('idUseCat'=>1), 'nom', 'Asc');

		//==>Pagination=>1 (Variable)
		$pgt_limit = 12;
		$pgt_urlSegment = 3;
		$pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'admin/questions'.allUlrParametre();
		$limit = $pgt_limit;
		$offset = $pgt_offset;
		$like = array();

		$arrayMat = ["statut" => 2];

		
		//==>Pagination=>2 (Calcule)
		if(isset($_GET['sta'])):
			$data['statutAid'] = $statutAid = $_GET['sta'];
			$array['concours.statut'] = $statutAid;
		endif;

		$data['pgt_totalResult'] = $pgt_totalResult = count($this->spw_model->get_limit_for_pagination('matieres',$arrayMat,$limit,$offset,$like,'libMat','Asc',$count=false));
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);

		//==>Pagination=>3 (Resultat)
		$data['listeMatieres'] =  $this->spw_model->get_limit_for_pagination('matieres',$arrayMat,$limit,$offset,$like,'libMat','Asc',$count=true);
		
		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);

			// ajout de concours dans le db 
			if($ActiveAjax=='newConcours'):

				var_dump('ajout de concour');

			//newQuestion
			elseif($ActiveAjax=='newQuestion'):

				//Verifier
				$verifier = $this->spw_model->get_rows('concours_all_questions',array('idMat'=>$idMat, 'libAllQue'=>$libQue));
				if(!$verifier):
					$this->db->trans_start();
					$dataAdd['libAllQue'] = $libQue;
					$dataAdd['idAut'] = $idAut;
					$dataAdd['idUse'] = $user->idUse;
					$dataAdd['idMat'] = $idMat;
					$dataAdd['time'] = $time;
					$dataAdd['statut'] = 2;
					$dataAdd['dateCreate'] = $maintenant;
					$this->spw_model->add_item('concours_all_questions',$dataAdd);


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
					$message ="Désolé! Cette question existe déja.";
					retourJS($statut,$message,$data,true);
				endif;				

			//UpdateQuestion
			elseif($ActiveAjax=='updateQuestion'):
				//Verifier
				$verifier = $this->spw_model->get_rows('concours_all_questions',array('idMat'=>$idMat, 'libAllQue'=>$libAllQue, 'idAllQue !='=>$idAllQue));
				if(!$verifier):

					//Recuperer les infos actuele
					$lastValueRows = $this->spw_model->get_rows('concours_all_questions',array('idAllQue'=>$idAllQue));
					foreach($lastValueRows as $lastValueRow):
						$lastInfos = array(
							'libAllQue' => $lastValueRow->libAllQue,
							'idAut' => $lastValueRow->idAut,
							'idMat' => $lastValueRow->idMat,
							'time' => $lastValueRow->time,
						);
					endforeach;

					$this->db->trans_start();
					$dataItem['libAllQue'] = $libAllQue;
					$dataItem['idAut'] = $idAut;
					$dataItem['idMat'] = $idMat;
					$dataItem['time'] = $time;
					$this->spw_model->update_item('concours_all_questions',$dataItem,array('idAllQue'=>$idAllQue));

					//Enregidter l'operation
					$lotValue = valueLot('historique_update',array(),'idHisUpd'); //Le Lot
					foreach($dataItem as $key=>$item):
						$dataAdd['idUse'] = $user->idUse;
						$dataAdd['idRow'] = $idAllQue;
						$dataAdd['nameTable'] = 'concours_all_questions';
						$dataAdd['nameColum'] = $key;
						$dataAdd['lot'] = $lotValue;
						$dataAdd['lastValue'] = $lastInfos[$key];
						$dataAdd['newValue'] = $item;
						$dataAdd['statut'] = 2;
						$dataAdd['objet'] = 'Modification standard';
						$dataAdd['dateCreate'] = $maintenant;
						historyAllUpdate($dataAdd);
					endforeach;



					if($this->db->trans_complete()):
						//Return 
						$statut = 'success';
						$data = $Returnlink;
						$message ='Question  modifiée avec success!';
						retourJS($statut,$message,$data,true);
					endif;

				else:
					$statut = 'error';
					$data = '';
					$message ="Désolé! Cette question existe déja.";
					retourJS($statut,$message,$data,true);
				endif;


			//newReponses
			elseif($ActiveAjax=='newReponses'):

				//Verifier
				$verifier = $this->spw_model->get_rows('concours_all_reponses',array('idAllQue'=>$idAllQue, 'libAllRep'=>$libAllRep));
				if(!$verifier):
					$this->db->trans_start();
					$dataAdd['idAllQue'] = $idAllQue;
					$dataAdd['libAllRep'] = $libAllRep;
					$dataAdd['etat'] = $etat;
					$dataAdd['idUse'] = $user->idUse;
					$dataAdd['statut'] = 2;
					$dataAdd['dateCreate'] = $maintenant;
					$this->spw_model->add_item('concours_all_reponses',$dataAdd);


					if($this->db->trans_complete()):
						//Return 
						$statut = 'success';
						$data = $Returnlink;
						$message ='Nouvelle réponse  enrégistrée avec success!';
						retourJS($statut,$message,$data,true);
					endif;

				else:
					$statut = 'error';
					$data = '';
					$message ="Désolé! Cette réponse existe déja.";
					retourJS($statut,$message,$data,true);
				endif;				


			else:
				echo "Une erreur est survenue, veuillez réessayer.";
			endif;
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'admin', 'admin/questions_view', $data);
		}
	}//End index()________







}//End document


