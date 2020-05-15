<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller {

	function __construct() {
		parent::__construct();
		userIsLogin(2);
	}

	public function index()
	{

		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Clients';
		$data['pageName'] = 'clients';
		$data['pageKeywords'] = 'examen, concour, etude';
		$data['pageDescription'] = 'examen, concour, etude';
		$data['maintenant'] = $maintenant = now();

		$data['activePage'] = $activePage = $this->uri->segment(2);


		
		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);

			//register
			if($ActiveAjax=='registerForm'):
				if(isset($step)&&$step==1):
					$existe = verifyExist('users',array('telephone'=>$telephone));
					//Verifier si existe deja comme utilisateur
					if($existe):
						//Return
						$statut = 'existe';
						$data = '';
						$message ='Désolé, Le numero <strong>'.$telephone.'</strong> est deja associé à un compte!!!';
						echo retourJS($statut,$message,$data);
					else:

						//verifier si n'est pas blocquer en tant que pirate
						$pirate = verifyExist('users_register_pirate',array('telephone'=>$telephone));
						if($pirate):

							//Return
							$statut = 'piratage';
							$data = '';
							$message ='Désolé, le numéro '.$telephone.' a été bloqué pour tentative de piratage. Veillez contacter notre equipe technique pour plus d\'informations.';
							echo retourJS($statut,$message,$data);

						else:
							//Code
							$codeValidation = code_validation($telephone,6);
							$numero = str_replace(array('-','(',')', ' '),'',$telephone);
							$message = 'Code de validation: '.$codeValidation;
							sendSMS($numero,$message);


							//Return (Procesure de concervation du code de validation à modifier apres par les session)
							$statut = 'Success';
							$data = $codeValidation;
							$message ='';
							echo retourJS($statut,$message,$data);
						endif;

							//$this->session->userdata('register_code', $codeValidation);

					endif;

				elseif(isset($step)&&$step==2):

					

				endif;


			else:
				echo "Une erreur est survenue, veuillez réessayer.";
			endif;
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', true, 'clients', 'clients/home_view', $data);
		}
	}//End index()________







}//End document


