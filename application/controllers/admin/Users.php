<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	function __construct() {
		parent::__construct();
		userIsLogin(1);
	}
	
	public function index()
	{

		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Users';
		$data['pageName'] = 'users';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';
		$data['maintenant'] = $maintenant = now();

		$data['activePage'] = $activePage = $this->uri->segment(2);

		

		//Liste user
		$userArray = array();
		//$data['all_users'] = $all_users = all_users($userArray);

		//==>Pagination=>1 (Variable)
		$pgt_limit = 12; 
		$pgt_urlSegment = 3;
		$data['pgt_offset'] = $pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'admin/users'.allUlrParametre();
		$limit = $pgt_limit;
		$offset = $pgt_offset;
		$like = array();



		//==>Pagination=>2 (Calcule)
		$array = array('users.idGrpUti !='=>1);
		if(isset($_GET['grp'])):
			$grpUsers = $_GET['grp'];
			$array['users.idGrpUti'] = $grpUsers;
			$data['grpUsers'] = $grpUsers;
		endif;
		if(isset($_GET['sta'])):
			$statutUsers = $_GET['sta'];
			$array['users.statut'] = $statutUsers;
			$data['statutUsers'] = $statutUsers;
		endif;
		

		$data['pgt_totalResult'] = $pgt_totalResult = $this->spw_model->get_countAll_for_pagination('users',$array,$like);
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
		

		//==>Pagination=>3 (Resultat)
		$as = '*, users.statut as statutUser, users.idUse as idUser, users.dateCreate as dateCreateUser';
		$lien = 'users.idUseCat = users_categories.idUseCat';
		$lienSecond = 'users_categories.idGrpUti = groupe_utilisateurs.idGrpUti';
		$data['all_users'] =  $this->spw_model->get_treeTables_limit_for_pagination('users','users_categories','groupe_utilisateurs',$as,$lien,$lienSecond,$limit,$offset,$array,$like,'users.nom','Asc');

		

		

		
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
			$this->template->loadTemplate('spw_template', 'default_view', true, 'admin', 'admin/users_view', $data);
		}
	}//End index()________







}//End document


