<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*-----------------------------------*\
|*-------==Varibles Générale==-------*|
\*-----------------------------------*/
$data['pageTitle'] = 'Résultat de concours';
$data['pageName'] = 'concours_resultat';
$data['pageKeywords'] = '';
$data['pageDescription'] = '';
$data['maintenant'] = $maintenant = now();
$idUser = $this->session->user_connected['idUse'];


//infos user
$data['user'] = user_connected();

//Avive page - sidebar
$data['activePage'] = $activePage = $this->uri->segment(2);


if(isset($_GET['c'])&&is_numeric($_GET['c'])):

	$data['ideConcour'] = $ideConcour = cripterId($_GET['c'],1);

//==>Infos Concours
$infosConEnc = infos_concours_encours($ideConcour);
$data['libConcour'] = $infosConEnc[0]->libConcour;

//==>Listes des paricipant
$data['allParticipants'] = $allParticipants = $this->spw_model->get_rows('concours_participants',array('idCon'=>$ideConcour));




endif;

//Ajax
if($this->input->is_ajax_request()){ 
	extract($_POST);

	//==> Modification infomation compte
	if($ActiveAjax=='modifier_mon_compte'):




	else:
		//Return
		$statut = 'error';
		$data = '';
		$message ='Une erreur est survenue, veuillez réessayer.';
		retourJS($statut,$message,$data);
	endif;
}else{
	/*--==Chargement du template==--*/
	$this->template->loadTemplate('spw_template', 'default_view', true, $section_BO, 'back-office/concours_resultat_view', $data);
}


