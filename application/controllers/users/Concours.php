<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Concours extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(3);
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

		$data['activePage'] = $activePage = $this->uri->segment(2);

		//user connected;
		$data['user'] = $user = user_connected();

		//Count===============>
		$data['totalCC_passer'] = countConcourByPeriode(array('concours.dateEnd <='=>$maintenant));
		$data['totalCC_encours'] = countConcourByPeriode(array('concours.dateStart <='=>$maintenant, 'concours.dateEnd >='=>$maintenant));
		$data['totalCC_bientot'] = countConcourByPeriode(array('concours.dateStart >'=>$maintenant));
		$data['totalCC_mes'] = count($this->spw_model->get_rows('concours_participants', array('idUse'=>$user->idUse)));
		


		//==>Pagination=>1 (Variable)
		$pgt_limit = 6;
		$pgt_urlSegment = 3;
		$pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'users/concours'.allUlrParametre();
		$limit = $pgt_limit;
		$offset = $pgt_offset;
		$arrayCon['concours.statut'] = 2;
		$like = array();
		if(isset($_GET['pd'])):
			$periodeCC = $_GET['pd'];
			if(isset($segmentTrois)):
				$periodeDefault = explode("/", $periodeCC);
				$periodeCC = $periodeDefault[0];
			endif;
			 $data['periodeCC'] = $periodeCC;
			if(is_numeric($periodeCC)&& in_array($periodeCC, array(1,2,3,4))):
				if($periodeCC==1):
					$arrayCon['concours.dateEnd <='] = $maintenant;
				elseif($periodeCC==2):
					$arrayCon['concours.dateStart <='] = $maintenant;
					$arrayCon['concours.dateEnd >='] = $maintenant;
				elseif($periodeCC==3):
					$arrayCon['concours.dateStart >'] = $maintenant;
				elseif($periodeCC==4):
					$arrayCon['concours_participants.idUse'] = $user->idUse;
				endif;
			else:
				//Pour des raison de securite
				$arrayCon['concours.dateStart'] = $maintenant;
				$arrayCon['concours.dateEnd'] = $maintenant;
			endif;
			
		endif;

		//==>Pagination=>2 (Calcule)
		$as = '*';
		$lien = 'concours.idCon = concours_participants.idCon';
		$data['pgt_totalResult'] = $pgt_totalResult = count($this->spw_model->get_two_Tables_join_limit('concours','concours_participants',$as,$lien,$arrayCon,$count=false,$limit,$offset,'left','concours.dateCreate','concours.Desc'));
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);

		//==>Pagination=>3 (Resultat)
		$data['listeConcours'] =  $this->spw_model->get_two_Tables_join_limit('concours','concours_participants',$as,$lien,$arrayCon,$count=true,$limit,$offset,'left','concours.dateCreate','concours.Desc');

		
		

		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);

			//
			if($ActiveAjax=='registerForm'):
				


			else:
				echo "Une erreur est survenue, veuillez réessayer.";
			endif;
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'users', 'users/concours_view', $data);
		}
	}//End index()________




	public function encours(){
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Concours_encours';
		$data['pageName'] = 'concours_encours';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		$data['activePage'] = $activePage = $this->uri->segment(2);

		//user connected;
		$data['user'] = $user = user_connected();



		if(isset($_GET['c'])&&is_numeric($_GET['c'])):
			
			$data['ideConcour'] = $ideConcour = cripterId($_GET['c'],1);

			//==>1: Si le concours dans la session est diferrente du conours choisir
		if(isset($_SESSION['concours']['ideCon'])&&$ideConcour != $_SESSION['concours']['ideCon']):
				//Mettre le statut du concour de la session a clos
			$dataItem = array(
				'statut' => 3,
				'time_end' => $maintenant
			);
			$this->spw_model->update_item('concours_participants',$dataItem,array('idConPar'=>$_SESSION['concours']['ideConParticipant']));
				//Fermer le concour
			$this->session->unset_userdata('concours');
		endif;


			//==>2: Verifier si n'a pas deja jouer 
		$DejaJouer = $this->spw_model->get_rows('concours_participants',array('idUse'=>$user->idUse, 'idCon'=>$ideConcour, 'statut !='=>1));
		if($DejaJouer):
			redirect(base_url().'users/resultat?c='.cripterId($ideConcour,0));
			exit();
		endif;


			//==>Infos Concours
		$infosConEnc = infos_concours_encours($ideConcour);
		$data['libConcour'] = $infosConEnc[0]->libConcour;


			//==>Verifier si n'a pas deja participer
	else:
		redirect(base_url().'users/concours');
		exit();

	endif;







		//Ajax
	if($this->input->is_ajax_request()){ 
		extract($_POST);

			//startConcours
		if($ActiveAjax=='startConcours'):
			if(isset($this->session->concours)):
				if($ideConcour!=$_SESSION['concours']['ideCon']):
						//Fermer le concour
					$this->session->unset_userdata('concours');
				endif;
				$this->session->unset_userdata('concours');
				$statut = 'error';
				$message = 'Veuillez reprendre, la requête a échouée.';
			else:


					//==>1 Create participation user
				$dejaParticiper = $this->spw_model->get_rows('concours_participants',array('idUse'=>$user->idUse, 'idCon'=>$ideConcour));
				if($dejaParticiper):
						//Redireger vers sont resultat cas existe deja
					$this->session->unset_userdata('concours');
						//redirect(base_url().'users/concours/resultat?c=404');
						//redirect(base_url().'users/concours');
					$statut = 'success';
					$data = base_url().'users/resultat?c='.cripterId($ideConcour,0);
					$message = '';
					retourJS($statut,$message,$data,false);
					exit();



				else:
					$dataAdd = array(
						'idUse' => $user->idUse,
						'idCon' => $ideConcour,
						'time_start' => $maintenant,
						'time_end' => $maintenant,
						'statut' => 1,

					);
					$this->spw_model->add_item('concours_participants',$dataAdd);
					$newIdeConPar = $this->spw_model->last_id_insert('concours_participants');

						//==>1-a: Create session init
					$concours = array(
						'statut' => '1',
						'ideCon' => $ideConcour,
						'ideConParticipant' => $newIdeConPar,
						'timeStart' =>  $maintenant
					);
					$this->session->set_userdata('concours', $concours);

				endif;

				$statut = 'success';
				$message = 'Top, c\'est partir...';
			endif;

				//Return 
			$statut = $statut;
			$data = $Returnlink;
			$message = $message;
			retourJS($statut,$message,$data,true);

			//playConcours
		elseif($ActiveAjax=='playConcours'):
			if(isset($ideReponsChoisir)):
				if(isset($ideQuestionActive)):
					$ideQuestionActive = cripterId($ideQuestionActive,1);
					$ideReponsChoisir = cripterId($ideReponsChoisir,1);
						//Verifier n'existe pas deja
					$ideConParticipant = $_SESSION['concours']['ideConParticipant'];
					$verifyExist = $this->spw_model->get_rows('concours_participants_reponses', array('idConPar'=>$ideConParticipant, 'idAllQue'=>$ideQuestionActive));

					if($verifyExist):
						//existe deja
						//rediriger vers resultat

						//Return 
						$statut = 'error';
						$data = $Returnlink;
						$message = 'Une réponse à cette question existe déjà en votre nom. Veuiller reconcer au concours et reprendre.';
						retourJS($statut,$message,$data,false);

						exit();
					else:
						//n'existe pas encore
						//Ajout dans la pase de donnees
						$dataAdd = array(
							'idConPar' => $ideConParticipant,
							'idAllQue' => $ideQuestionActive,
							'idAllRep' => $ideReponsChoisir,
							'time_start' => (isset($_SESSION['concours']['timeStartQuestionActive']))? $_SESSION['concours']['timeStartQuestionActive']:$_SESSION['concours']['timeStart'],
							'time_end' => $maintenant,
							'statut' => 2,

						);
						$this->spw_model->add_item('concours_participants_reponses',$dataAdd);
							//Definir le nouveau time start
						$_SESSION['concours']['timeStartQuestionActive'] = $maintenant;

						//Return 
						$statut = 'success';
						$data = $Returnlink;
						$message = '';
						retourJS($statut,$message,$data,false);

					endif;


				else:

						//Return 
					$statut = 'error';
					$data = $Returnlink;
					$message = 'Une erreur est survenue lors de l\'enrégistrement de vore réponse, veuillez reprendre SVP.';
					retourJS($statut,$message,$data,true);

				endif;
			endif;


			//destoryConcours
		elseif($ActiveAjax=='destoryConcours'):
			//Mettre le statut a 3 (renoncer, abandonner , n'a pas fini)
			$dataItem = array(
				'statut' => 3,
				'time_end' => $maintenant
			);
			$this->spw_model->update_item('concours_participants',$dataItem,array('idConPar'=>$_SESSION['concours']['ideConParticipant']));
				//Fermer le concour
			$this->session->unset_userdata('concours');
				//Return 
			$statut = 'success';
			$data = $Returnlink;
			$message = 'Ce jeux vient d\'etre conciderer clos pour votre compte!!!';
			retourJS($statut,$message,$data,true);
		else:
			echo "Une erreur est survenue, veuillez réessayer.";
		endif;
	}else{
		/*--==Chargement du template==--*/
		$this->template->loadTemplate('spw_template', 'default_view', true, 'users', 'users/concours_encours_view', $data);
	}
}//End encours()


public function resultat(){
	//NB: Dans la partie admin creer une page qui permet de mettre tous les statut = 1 a statut = 3, apres 24h d'existance

	/*-----------------------------------*\
	|*-------==Varibles Générale==-------*|
	\*-----------------------------------*/
	$data['pageTitle'] = 'Concours_encours';
	$data['pageName'] = 'concours_encours';
	$data['pageKeywords'] = '';
	$data['pageDescription'] = '';
	$data['maintenant'] = $maintenant = now();

	$data['activePage'] = $activePage = $this->uri->segment(2);

	//user connected;
	$data['user'] = $user = user_connected();


	if(isset($_GET['c'])):
		if(is_numeric($_GET['c'])):
			$data['ideConcour'] = $ideConcour = cripterId($_GET['c'],1);
			//==>1: Verifier ci a participer au jeux
			$data['VerifierParticipations'] = $VerifierParticipations = $this->spw_model->get_rows('concours_participants',array('idUse'=>$user->idUse, 'idCon'=>$ideConcour));

			if($VerifierParticipations):
				//==>Infos Concours
				$infosConEnc = infos_concours_encours($ideConcour);
				$data['libConcour'] = $infosConEnc[0]->libConcour;

				//==>Infos Participations
				foreach($VerifierParticipations as $VerifierParticipation):
					$data['ide_participation'] = $ide_participation = $VerifierParticipation->idConPar;
					$data['statut_participation'] = $statut_participation = $VerifierParticipation->statut;
					$data['timeStart_participation'] = $timeStart_participation = $VerifierParticipation->time_start;
					$data['timeEnd_participation'] = $timeEnd_participation = $VerifierParticipation->time_end;
				endforeach;
				$data['tempsMis'] = diffDate($timeEnd_participation, $timeStart_participation);


				//==>Infos content concours
				$contentConcoursInfos = $this->spw_model->get_rows('concours_content',array('idCon'=>$ideConcour));
				$data['nbrDeQuestions'] = count($contentConcoursInfos);



			//==>Infos Participant
				$data['participant'] = $participant = participant($user->idUse);


			//==>Infos reponses aux questions
				$participationReponseesInfos = $this->spw_model->get_rows('concours_participants_reponses',array('idConPar'=>$ide_participation));
				$data['nbrDeReponses'] = count($participationReponseesInfos);

			//==>Infos vrai reponses trouves
				$as = "*,concours_all_reponses.idAllRep as idRepGen, concours_participants_reponses.idAllRep as idRepUse";
				$lien = 'concours_participants_reponses.idAllQue = concours_all_reponses.idAllQue';
				$array = array('concours_participants_reponses.idConPar'=>$ide_participation, 'concours_all_reponses.etat'=>1);
				$repnsesTrouvesInfos = $this->spw_model->get_Double_Table('concours_participants_reponses','concours_all_reponses',$as,$lien,$array,'','');
				$vraiReponseTrouver = 0;
				if($repnsesTrouvesInfos):
					foreach($repnsesTrouvesInfos as $repnsesTrouvesInfo):
						if($repnsesTrouvesInfo->idRepGen==$repnsesTrouvesInfo->idRepUse):
							$vraiReponseTrouver++;
						endif;
					endforeach;
				endif;

				$data['vraiReponseTrouver'] = $vraiReponseTrouver;

			else:

			endif;

		else:

			redirect(base_url().'users/concours');
			exit();
		endif;

	endif;




	//Ajax
	if($this->input->is_ajax_request()){ 
		extract($_POST);

	}else{
		/*--==Chargement du template==--*/
		$this->template->loadTemplate('spw_template', 'default_view', true, 'users', 'users/concours_resultat_view', $data);
	}



}

public function load_concours_encours(){
	$maintenant = now();
	$result = '404';

	if(isset($this->session->concours)&&isset($_GET['c'])&&isset($_SESSION['concours']['ideConParticipant'])):
			//==>Infos
		$data['ideConcour'] = $ideConcour = cripterId($_GET['c'],1);

		//==>Infos Concours
	$infosConEnc = infos_concours_encours($ideConcour);

		//==>Questions Concours
	$ideConPar = $_SESSION['concours']['ideConParticipant'];
	$questionDispos = question_concours_encours($ideConcour,$ideConPar);
	if($questionDispos):
		foreach($questionDispos as $questionDispo):
			$ideQuestionActive = $questionDispo->idAllQue;
			$questionActive = $questionDispo->libAllQue;
		endforeach;
			//All reponses
		$allReponses = $this->spw_model->get_rows('concours_all_reponses',array('idAllQue'=>$ideQuestionActive, 'statut'=>2));
		$list_reponse = '';
		foreach($allReponses as $allReponse):
			$criptIdReponse = cripterId($allReponse->idAllRep,0);
			$list_reponse .='  
			<li class="i-form-row">
			<input type="radio" id="rep_'.$criptIdReponse.'" name="item_'.cripterId($ideConcour,0).'" value="'.$criptIdReponse.'">
			<label for="rep_'.$criptIdReponse.'">'.$allReponse->libAllRep.'</label>
			</li>
			';
		endforeach;


			//==>CountAllQuesion
		$totalQuestions = count( $this->spw_model->get_rows('concours_content',array('idCon'=>$ideConcour, 'statut'=>2)));
			//==>CountAllReponseEfeectuer
		$totalDejaRepondu = count( $this->spw_model->get_rows('concours_participants_reponses',array('idConPar'=>$ideConPar)));
		$totalDejaRepondu++;

		$result = '  
		<div class="text-center">
		<a href="#destoryConcours" class="i-btn big js-open-poPup">Renoncer au jeux</a>
		</div>
		<section class="cli-page-section concours-encours">
		<div class="concours-encours-head">
		'.$infosConEnc[0]->libConcour.'
		</div>
		<ul class="concours-encours-repaire" >
		<li id="zoneTimeEcouler">00:00:0</li>
		<li>'.$totalDejaRepondu.' / '.$totalQuestions.'</li>
		</ul>
		<div class="concours-encours-content">
		<div class="concours-encours-content-question">'.$questionActive.'</div>
		<ul class="concours-encours-content-reponses js-active-question-reponse" data-q="'.cripterId($ideQuestionActive,0).'">
		'.$list_reponse.'
		</ul>
		</div>
		<div class="concours-encours-bottom">
		<form method="POST" id="playConcoursForm">
		<button name="playConcoursBtn">Suivant</button>
		</form>
		</div>
		</section>
		';

		//Il n'y a plus de question
	else: 
			//==>Clos le jeux
		$dataItem = array(
			'statut' => 2,
			'time_end' => $maintenant
		);
		$this->spw_model->update_item('concours_participants',$dataItem,array('idConPar'=>$_SESSION['concours']['ideConParticipant']));
			//Fermer le concour
		$this->session->unset_userdata('concours');


			//View final
		$result = '  
		<section class="cli-page-section concours-encours">
		<div class="concours-encours-head">
		<strong>Fin du jeux!</strong>
		</div>
		<div class="concours-encours-bottom">
		<a href="'.base_url().'users/concours/resultat?c='.cripterId($ideConcour,0).'" class="i-btn big">Voir Mon Resultat</a>
		</div>
		</section>
		';



	endif;
endif;

echo $result;
}


//Temps écoulé
public function time_elapsed(){
	$return = 0;

	if(isset($_SESSION['concours']['timeStart'])):
		$LastDate = $_SESSION['concours']['timeStart'];
		$NewDate = now();
		$timeEcouler = diffDate($LastDate, $NewDate);
		$seconde = $timeEcouler->second;
		($seconde<10)? $seconde='0'.$seconde:$seconde=$seconde;

		$minutes = $timeEcouler->minutes;
		($minutes<10)? $minutes='0'.$minutes:$minutes=$minutes;

		$heures = $timeEcouler->heures;
		($heures<10)? $heures='0'.$heures:$heures=$heures;

		$return = $heures.':'.$minutes.':'.$seconde;
	endif;

	echo $return;
}




}//End document


