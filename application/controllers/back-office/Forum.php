<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$data['idForumCripter'] = $idForumCripter = $idForum;
$data['idForum'] = $idForum = cripterId($idForum,1);

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

		//verification
$forumSelectonners = $this->spw_model->get_rows('forums',array('idFor'=>$idForum));

if($forumSelectonners&&!empty($forumSelectonners)):
	$data['forumSelectonners'] = $forumSelectonners;
	foreach($forumSelectonners as $forumSelectonner):
		$data['statutForum'] = $forumSelectonner->statut;
		$data['sujetForum'] = $forumSelectonner->libFor;
		$data['descriptionForum'] = $forumSelectonner->description;
		$data['idUseForum'] = $forumSelectonner->idUse;
		$data['dateCreateForum'] = $forumSelectonner->dateCreate;
	endforeach;
endif;


//Ajax
if($this->input->is_ajax_request()){
	extract($_POST);

	//NewCommentaire
	if($ActiveAjax=='NewCommentaire'):
		$this->db->trans_start();
		$dataAdd = array(
			"idFor" => $idForum,
			"idUse" => $user->idUse,
			"message" => $message,
			"statut" => 2,
			"dateCreate" => $maintenant
		);
		$this->spw_model->add_item('forums_content',$dataAdd);
		if($this->db->trans_complete()):
			//Return 
			$statut = 'success';
			$data = $returnUrl;
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
	$this->template->loadTemplate('spw_template', 'default_view', true,  $section_BO, 'back-office/forum_selectionner_view', $data);
}



?>