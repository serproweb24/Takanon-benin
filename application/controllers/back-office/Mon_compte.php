<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*-----------------------------------*\
|*-------==Varibles Générale==-------*|
\*-----------------------------------*/
$data['pageTitle'] = 'Mon compte';
$data['pageName'] = 'mon_compte';
$data['pageKeywords'] = '';
$data['pageDescription'] = '';
$data['maintenant'] = $maintenant = now();
$idUser = $this->session->user_connected['idUse'];


//infos user
$data['user'] = user_connected();

//Avive page - sidebar
$data['activePage'] = $activePage = $this->uri->segment(2);

//Ajax
if($this->input->is_ajax_request()){ 
	extract($_POST);

	//==> Modification infomation compte
	if($ActiveAjax=='modifier_mon_compte'):
		$existe = verifyExist('users',array('telephone'=>$telephone, 'idUse !='=>$idUser));
		if($existe):
			//Return
			$statut = 'existe';
			$data = '';
			$message ='Désolé, Le numero <strong>'.$telephone.'</strong> est deja associé à un compte!!!';
			retourJS($statut,$message,$data);
		else:
			$this->db->trans_start();
			//Update infos
			$dataItem = array(
				"nom" => $nom,
				"prenoms" => $prenoms,
				"telephone" => $telephone,
				"email" => $email,
				"adresse" => $adresse,
				"description" => $description
			);
			$this->spw_model->update_item('users',$dataItem,array('idUse'=>$idUser));
			if($this->db->trans_complete()):
				//Return 
				$statut = 'success';
				$data = base_url().'clients/mon_compte';
				$message ='Vos information ont été bien mis à jour';
				retourJS($statut,$message,$data);
			endif;
		endif;

	//==> Modification avatar
	elseif($ActiveAjax=='modifier_avatar'):
		if(isset($_FILES['file']['name'])):
			$destinationFiles = './assets/images/users';
			$userfile = 'file';
			$avatar = $this->spw_model->uploadFiles($destinationFiles,$userfile);
			if(isset($avatar)&&$avatar!='error'):
				$dataItem = array(
					'avatar' => $avatar
				);
				$this->db->trans_start();
				$this->spw_model->update_item('users',$dataItem,array('idUse'=>$idUser));
				if($this->db->trans_complete()):
					//Return 
					$statut = 'success';
					$data = base_url().'clients/mon_compte';
					$message ='Vos photo de profil a été bien modifié';
					retourJS($statut,$message,$data);
				endif;
			else:
				//Return
				$statut = 'error';
				$data = '';
				$message ='La taille de votre fichier est tres grande son farmat n\'est pas autorisé !!!';
				retourJS($statut,$message,$data);
			endif;

		else:
			//Return
			$statut = 'existe';
			$data = '';
			$message ='Désolé, le chargement du fichié a échoué !!!';
			retourJS($statut,$message,$data);
		endif;

	//==> Verification de mot de passe
	elseif($ActiveAjax=='verifier_password'):
				//Verify existe
		$verify = verifyExist('users',array('password'=>sha1($password),'idUse'=>$idUser));
		if($verify):
					//Return
			$statut = 'success';
			$data = '';
			$message ='';
			retourJS($statut,$message,$data);
		else:

					//Return
			$statut = 'error';
			$data = '';
			$message ='Désolé, Le mot de passe est incorrect !!!';
			retourJS($statut,$message,$data);

		endif;

			//==> Modification de mot de passe
	elseif($ActiveAjax=='modifier_password'):
				//Verify existe
		$verify = verifyExist('users',array('password'=>sha1($password),'idUse'=>$idUser));
		if($verify):
					//Return
			$statut = 'Existe';
			$data = '';
			$message ='Désolé, Le mot de passe est resté le même !!!';
			retourJS($statut,$message,$data);
		else:

			$this->db->trans_start();
			$dataItem = array(
				'password' => sha1($password)
			);
			$this->spw_model->update_item('users',$dataItem,array('idUse'=>$idUser));
			if($this->db->trans_complete()):
						//Return 
				$statut = 'success';
				$data = base_url().'clients/mon_compte';
				$message ='Votre mot de passe a été bien modifié !!!';
				retourJS($statut,$message,$data,true);
			endif;


		endif;

	else:
				//Return
		$statut = 'error';
		$data = '';
		$message ='Une erreur est survenue, veuillez réessayer.';
		retourJS($statut,$message,$data);
	endif;
}else{
	/*--==Chargement du template==--*/
	$this->template->loadTemplate('spw_template', 'default_view', true, $section_BO, 'back-office/mon_compte_view', $data);
}


