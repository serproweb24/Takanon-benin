<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends CI_Controller {

	
	public function index()
	{
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Contacts';
		$data['pageName']  = 'Contacts';
		$data['pageKeywords'] = 'examen, concour, etude';
		$data['pageDescription'] = 'examen, concour, etude';
		$data['maintenant'] = $maintenant = now();

		$data['activePage'] = $activePage = $this->uri->segment(1);
		




		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);
			
			//Nouveau messsage
			if($ActiveAjax=='newMessage'):

				$this->db->trans_start();
				$dataAdd = array(
					"nom_prenoms" => $nom_prenoms,
					"phone" => $phone,
					"email" => $email,
					"objet" => $objet,
					"messages" => $messages,
					"statut" => 1,
					"dateCreate" => $maintenant
				);
				$this->spw_model->add_item('messages',$dataAdd);
				if($this->db->trans_complete()):
					//Return 
					$statut = 'success';
					$data = base_url().'contacts';
					$message ='<div class="alert-succes">
					<h5 class="title">Message Success !</h5>
					<strong class="text-green">'.$nom_prenoms.'</strong>, votre message a été bien envoyé. Notre service de communication se chargera d\'en prendre connaissance  !!! <p>Merci.</p></div>';
					retourJS($statut,$message,$data,false);
				endif;

			else:
				//Return
				$statut = 'error';
				$data = '';
				$message ='Une erreur est survenue, veuillez réseller';
				retourJS($statut,$message,$data,true);
			endif;

		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', False, 'site', 'site/contacts_view', $data);
		}
	}//End index()________




	


}//End document


