<?php
defined('BASEPATH') OR exit('No direct script access allowed');


		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Ticket_regets';
		$data['pageName'] = 'ticket_regets';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		//infos user
		$data['user'] = $user = user_connected();



		//Avive page - sidebar
		$data['activePage'] = $activePage = $this->uri->segment(2);


		if(isset($_GET['tck'])){
			$data['idTck'] = $idTck = cripterId($_GET['tck'],1);
		}

		//Infos Historique 
		$as = '*,historique_update.dateCreate as dateCreateHistory, historique_update.objet as objetHistory';
		$lien= 'tickets_regets.idHisUpd = historique_update.idHisUpd';
		$lienSecond = 'historique_update.idUse = users.idUse';
		$array = array('tickets_regets.idTicReg'=>$idTck);
		$data['historyElemUpdates'] = $historyElemUpdates	= $this->spw_model->get_tree_Table('tickets_regets','historique_update','users',$as,$lien,$lienSecond,$array,'historique_update.idHisUpd','Desc');
		if($historyElemUpdates):
			foreach($historyElemUpdates as $historyElemUpdate):
				$data['motif'] = $historyElemUpdate->objetHistory;
				$data['dateReget'] = date('d-m-Y à H:i:s', strtotime($historyElemUpdate->dateCreateHistory));
			endforeach;
		endif;





		//Infos messages
		$as = '*,tickets_regets_content.dateCreate as dateCreateMessage, tickets_regets_content.message as messageMessage';
		$lien= 'tickets_regets_content.idUse = users.idUse';
		$array = array('tickets_regets_content.idTicReg'=>$idTck);
		$data['listMessages'] = $listMessages	= $this->spw_model->get_Double_Table('tickets_regets_content','users',$as,$lien,$array,'tickets_regets_content.idTicRegCon','Asc');

		
		

		//Marquer comme vu
		$dataItem['statut'] = 2;
		$array = array('idUse !='=>$user->idUse, 'idTicReg'=>$idTck);
		$this->spw_model->update_item('tickets_regets_content',$dataItem,$array);
		
		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);

			//==>NewCommentaire
			if($ActiveAjax=='NewCommentaire'):


				$this->db->trans_start();
				$dataAdd = array(
					"idTicReg" => $idTck,
					"idUse" => $user->idUse,
					"message" => $message,
					"statut" => 1,
					"dateCreate" => $maintenant
				);
				$this->spw_model->add_item('tickets_regets_content',$dataAdd);
				if($this->db->trans_complete()):
					//Return 
					$statut = 'success';
					$data = $Returnlink;
					$message ='';
					retourJS($statut,$message,$data,false);
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
			$this->template->loadTemplate('spw_template', 'default_view', true, $section_BO, 'back-office/ticket_regets_view', $data);
		}
	//}//End index()________








//include ('system/application/controllers/home.php');