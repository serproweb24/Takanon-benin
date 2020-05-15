	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spw extends CI_Controller {

	
	public function index()
	{
		//include APPPATH.'controllers/all.php';
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Accueil';
		$data['pageName'] = 'home';
		$data['pageKeywords'] = 'examen, concour, etude';
		$data['pageDescription'] = 'examen, concour, etude';
		$data['maintenant'] = $maintenant = now();

		$data['activePage'] = $activePage = $this->uri->segment(1);

		//Statistique
		$data['total___cours'] = forStatistiqueCount('articles',array('idArtCar'=>1));
		$data['total___examens'] = forStatistiqueCount('articles',array('idArtCar'=>3));
		$data['total___epreuves'] = forStatistiqueCount('articles',array('idArtCar'=>7));
		$data['total___repetiteurs'] = forStatistiqueCount('repetiteurs',array('statut'=>2));



		//liste Categorie Article
		$data['optionCategorieArt'] = articles_categories('forSelect');
		//liste Categorie Article
		$data['listCategorieArt'] = articles_categories('forList');

		//liste Categorie Article
		$data['optionMatieres'] = articles_matieres('forSelect');
		$data['listMatieres'] = articles_matieres('forList');

		//liste Categorie Article
		$data['optionAnnees'] = articles_annees('forSelect');
		$data['listAnnees'] = articles_annees('forList');



		//Laste posts, limite 12
		$data['listPosts'] = lastPosts('forItemsSite',$limit=12,$offset='',$like=array(),$condition=array('articles.statut'=>2))->list;

		//Actualites actives
		$data['actualites'] = $this->spw_model->get_rows('actualites', 
			array('statut'=>2,
				'DATE_FORMAT(dateDebut,"%Y-%m-%d 00%:00%:00%") <='=> date('Y-m-d H:i:s', strtotime($maintenant)),
				'DATE_FORMAT(dateFin,"%Y-%m-%d 00%:00%:00%") >='=> date('Y-m-d H:i:s', strtotime($maintenant))
			));



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
						retourJS($statut,$message,$data);
					else:

						//verifier si n'est pas blocquer en tant que pirate
						$pirate = verifyExist('users_register_pirate',array('telephone'=>$telephone));
						if($pirate):

							//Return
							$statut = 'piratage';
							$data = '';
							$message ='Désolé, le numéro '.$telephone.' a été bloqué pour tentative de piratage. Veillez contacter notre equipe technique pour plus d\'informations.';
							retourJS($statut,$message,$data);

						else:
							//Code
							$numero = str_replace(array('-','(',')', ' '),'',$telephone);
							$codeValidation = code_validation($numero,6);
							$message = 'Code de validation: '.$codeValidation;
							//Envois sms
							sendSMS($numero,$message);

							$emailRecep = $email;

							//Envois email
							sendEmail('TAKANON-BENIN','contacts@takanon-benin.com',$emailRecep,"Code de confirmation TAKANON-BENIN",$message);


							//Return (Procesure de concervation du code de validation à modifier apres par les session)
							$statut = 'success';
							$data = $codeValidation;
							$message ='';
							retourJS($statut,$message,$data);
						endif;

							//$this->session->userdata('register_code', $codeValidation);

					endif;

				elseif(isset($step)&&$step==2):

					

				endif;

			//enregistrement du user	
			elseif($ActiveAjax=='saveUser'):
				//Definir le idGrpUti
				$infosIscrps = $this->spw_model->get_rows('users_categories', array('idUseCat'=>$idUseCat));
				if($infosIscrps):

					foreach($infosIscrps as $infosIscrp):
						$idGrpUti = $infosIscrp->idGrpUti;
					endforeach;

					$this->db->trans_start();
					$dataAdd = array();
					$dataAdd['nom'] = $nom;
					$dataAdd['prenoms'] = $prenoms;
					$dataAdd['telephone'] = $telephone;
					$dataAdd['email'] = $email;
					$dataAdd['password'] = sha1($password);
					$dataAdd['idUseCat'] = $idUseCat;
					$dataAdd['idGrpUti'] = $idGrpUti;
					$dataAdd['statut'] = 2;
					$dataAdd['dateCreate'] = $maintenant;
					$this->spw_model->add_item('users',$dataAdd);
					if($this->db->trans_complete()):
						//Return 
						$statut = 'success';
						$data = '';
						$message ='';
						retourJS($statut,$message,$data);
					endif;

				else:
					//Return
					$statut = 'piratage';
					$data = '';
					$message ='Désolé, une erreur est survenue, veillez recommancer.';
					retourJS($statut,$message,$data,true);

				endif;


			//Prigatage lors de l'enregistrement	
			elseif($ActiveAjax=='registerPiratage'):
				$this->db->trans_start();
				$dataAdd = array();
				$dataAdd['nom'] = $nom;
				$dataAdd['prenoms'] = $prenoms;
				$dataAdd['telephone'] = $telephone;
				$dataAdd['email'] = $email;
				$dataAdd['password'] = sha1($password);
				$dataAdd['idUseCat'] = $idUseCat;
				$dataAdd['statut'] = 1;
				$dataAdd['dateCreate'] = $maintenant;
				$this->spw_model->add_item('users_register_pirate',$dataAdd);
				$this->db->trans_complete();

				//Return 
				$statut = 'success';
				if(isset($activePage)):
					$data = base_url().''.$activePage;
				else:
					$data = base_url();
				endif;
				$message ='';
				retourJS($statut,$message,$data);

			//Mot de passe oublier step 1
			elseif($ActiveAjax=='forgetPass'):
				if(isset($email)):
					//verifier si email existe
					$existe = verifyExist('users',array('email'=>$email));
					if($existe):
						//infos user
						foreach($existe as $infosUser):
							$idUser = $infosUser->idUse;
							$phoneUser = $infosUser->telephone;
						endforeach;

						//Générer un code
						$codeValidation = code_validation('',6);

						//renseigner la table forget_password
						$this->db->trans_start();
						$dataAdd['idUse'] = $idUser;
						$dataAdd['code'] = $codeValidation;
						$dataAdd['statut'] = 1;
						$dataAdd['dateCreate'] = $maintenant;
						$this->spw_model->add_item('forget_password',$dataAdd);
						$this->db->trans_complete();

						

						//Envoyé email
						$emailRecep = $email;
						$sujet = "Processus de réinitialisation de mot de passe";
						$message = "Code de validation: <strong>".$codeValidation."</strong>";
						if(sendEmail('Takanon-benin','contacts@takanon-benin.com',$emailRecep,$sujet,$message)):
							//Creation de la session
							$forget_password['code'] = $codeValidation;
							$this->session->set_userdata('forget_password', $forget_password);

							$statut = 'success';
							$data = $codeValidation;
							$message ='';
							retourJS($statut,$message,$data);
						else:
							$this->session->unset_userdata('forget_password');
							redirect(base_url());
						endif;

					else:
						//Return
						$statut = 'error';
						$data = '';
						$message ='Désolé! Votre email ne correspond à accun compte TAKANON-BENIN.';
						retourJS($statut,$message,$data);
					endif;

				else:
					//Return
					$statut = 'error';
					$data = '';
					$message ='Le champs email ne peut être vide.';
					retourJS($statut,$message,$data);
				endif;

			//Mot de passe oublier step 2 = validation
			elseif($ActiveAjax=='forgetPassValidation'):
				if(isset($this->session->forget_password)&&isset($this->session->forget_password['code'])):
					if($this->session->forget_password['code']==$code):
						$statut = 'success';
						$data = '';
						$message ='';
						retourJS($statut,$message,$data);

					else:
						//Return
						$statut = 'error';
						$data = '404';
						$message ='Désolé! Votre code n\'est pas valide!';
						retourJS($statut,$message,$data);
					endif;

				else:
					//Return
					$statut = 'error';
					$data = '';
					$message ='';
					retourJS($statut,$message,$data);
				endif;

			//Mot de passe oublier step 3 = nouveau mot de passe
			elseif($ActiveAjax=='forgetPassUpdatePass'):
				if(isset($this->session->forget_password)&&isset($this->session->forget_password['code'])):
					//recuperer les infos de la table  forget_password
					$existe = verifyExist('forget_password',array('code'=>$this->session->forget_password['code']));
					if($existe):
						//infos user
						foreach($existe as $infosUser):
							$idForPas = $infosUser->idForPas;
							$idUser = $infosUser->idUse;
						endforeach;

						//Modifier le mot de passe du user
						$this->db->trans_start();
						$dataItem['password'] = sha1($password);
						$this->spw_model->update_item('users',$dataItem,array('idUse'=>$idUser));
						
						//Modifier statut forget_password
						$dataItem = array();
						$dataItem['statut'] = 2;
						$this->spw_model->update_item('forget_password',$dataItem,array('idForPas'=>$idForPas));

						$this->db->trans_complete();

						$statut = 'success';
						$data = '';
						$message ='';
						retourJS($statut,$message,$data);


					else:
						//Return
						$statut = 'error';
						$data = '404';
						$message ='Désolé! Votre code n\'est plus valide, veuillez <a href="'.base_url().'contacts">contacter notre équipe technique</a> ou <a href="#forget_pass" class="i-link js-open-poPup">reseillez</a>';
						retourJS($statut,$message,$data);
					endif;

				else:
					//Return
					$statut = 'error';
					$data = '404';
					$message ='Désolé! Votre code n\'est plus valide!';
					retourJS($statut,$message,$data);
				endif;

			//searchArticle
			elseif($ActiveAjax=='searchArticle'):
				$Link = '';
				if(isset($ideCart)&&!empty($ideCart)):
					$Link .= '?cat='.$ideCart;
				endif;

				if(isset($ideNiv)&&!empty($ideNiv)):
					$Link .= '&niv='.$ideNiv;
				endif;

				if(isset($ideMat)&&!empty($ideMat)):
					$Link .= '&mat='.$ideMat;
				endif;

				if(isset($ideAnn)&&!empty($ideAnn)):
					$Link .= '&ann='.$ideAnn;
				endif;

				//Return
				$statut = 'success';
				$data =  base_url().'documents'.$Link;
				$message ='';
				retourJS($statut,$message,$data);

			//Cart=> add
			elseif($ActiveAjax=='addNewArtInCart'):
				if(isset($idArt)&&isset($priceArt)&&isset($nameArt)):
					$data = array(
						'id'      => $idArt,
						'qty'     => 1,
						'price'   => $priceArt,
						'name'    => $nameArt
					);
					$this->cart->insert($data);

					//Return
					$statut = 'success';
					$data = $Returnlink;
					$message =$idArt.'/'.$priceArt.'/'.$nameArt;
					retourJS($statut,$message,$data);

				else:
					//Return
					$statut = 'error';
					$data = '';
					$message ='L\'article n\'a pu être ajouté au panier, veuillez réessayer.';
					retourJS($statut,$message,$data);
				endif;

			//Cart=> updateQteArtCart
			elseif($ActiveAjax=='updateQteArtCart'):
				if(isset($newValue)&&isset($rowid)):
					foreach ($this->cart->contents() as $items):
						if($rowid == $items['rowid']){
							$data = array(
								'rowid' => $items['rowid'],
								'qty'     => $newValue
							);
							$this->cart->update($data);
						}
					endforeach;
					//Return
					$statut = 'success';
					$data = '';
					$message ='';
					retourJS($statut,$message,$data);
				else:
					//Return
					$statut = 'error';
					$data = '';
					$message ='';
					retourJS($statut,$message,$data);
				endif;

			//Cart=> Pay Cart
			elseif($ActiveAjax=='payCart'):
				//Verifier si exist session client
				if(isset($this->session->user_connected)&&$this->session->user_connected['idGrpUti']==3):
					$user = user_connected();

					//Enregistrer le panier
					$this->db->trans_start();
					$dataAdd = array(
						"idUse" => $user->idUse,
						"total_panier" => $this->session->cart_contents['cart_total'],
						"statut" => 2,
						"dateCreate" => $maintenant
					);
					$this->spw_model->add_item('paniers',$dataAdd);
					$idPan = $this->spw_model->last_id_insert('paniers');

					//Enregistrer le contenu du panier
					foreach ($this->cart->contents() as $item):
						$idArt = $item['id'];
						$qtyArt = $item['qty'];


						//Infos article
						$articles = $this->spw_model->get_rows('articles', array('idArt'=>$idArt));
						if($articles):
							foreach($articles as $article):
								$priceArt = $article->prix;
								$nomDocArt = $article->nomDoc;
								$idVendeurArt = $article->idUse;
								$idArtCar = $article->idArtCar;
							endforeach;

							//item
							$this->db->trans_start();
							$dataAdd = array(
								"idPan" => $idPan,
								"idArt" => $idArt,
								"idArtCar" => $idArtCar,
								"nomArt" => $nomDocArt,
								"qte" => $qtyArt,
								"prix_u" => $priceArt,
								"idVendeur" => $idVendeurArt,
								"idAcheteur" => $user->idUse,
								"statut" => 2
							);
							$this->spw_model->add_item('paniers_content',$dataAdd);
						endif;
					endforeach;
					$this->db->trans_complete();

					//Detruir le panier
					$this->cart->destroy();

					//Return
					$statut = 'success';
					$data = base_url().'users/achats';
					$message ='';
					retourJS($statut,$message,$data);

				else:
					//Return
					$statut = 'error';
					$data = '';
					$message ='';
					retourJS($statut,$message,$data);
				endif;

			//Cart=> Delate Cart
			elseif($ActiveAjax=='DelateCart'):
				//Detruir le panier
				$this->cart->destroy();

				//Return
				$statut = 'success';
				$data = $Returnlink;
				$message ='';
				retourJS($statut,$message,$data);

			//Se connecter	
			elseif($ActiveAjax=='loginForm'):
				$existe = verifyExist('users', array('telephone'=>$telephone, 'password'=>sha1($password)));

				if($existe):
					foreach($existe as $user):
						$statut = $user->statut;
						$idUse = $user->idUse;
						$nom = $user->nom;
						$prenoms = $user->prenoms;
						$telephone = $user->telephone;
						$email = $user->email;
						$idUseCat = $user->idUseCat;
						$idGrpUti = $user->idGrpUti;
					endforeach;

					if($statut==2):
						//add history connection
						$this->db->trans_start();
						$dataAdd = array();
						$dataAdd['idUse'] = $idUse;
						$dataAdd['dateLogin'] = $maintenant;
						$dataAdd['dateLogout'] = $maintenant;
						$this->spw_model->add_item('users_connexion_history',$dataAdd);
						$idHistory = $this->spw_model->last_id_insert('users_connexion_history');

						if($this->db->trans_complete()):
							//Activer la session
							$user_connected = array(
								'idUse' => $idUse,
								'nom' => $nom,
								'prenoms' => $prenoms,
								'telephone' => $telephone,
								'email' => $email,
								'idUseCat' => $idUseCat,
								'idGrpUti' => $idGrpUti,
								'idHistory' => $idHistory
							);
							$this->session->set_userdata('user_connected', $user_connected);

							//Type de connection
							if($idGrpUti==1):
								$linkRedirect = base_url().'admin';
							elseif($idGrpUti==2):
								$linkRedirect = base_url().'clients';
							elseif($idGrpUti==3):
								$linkRedirect = base_url().'users';
							endif;


							//Return 
							$statut = 'success';
							$data = $linkRedirect;
							$message ='';
							retourJS($statut,$message,$data);
						endif;

					elseif($statut==0):
						//Return
						$statut = 'error';
						$data = '';
						$message ='Désolé! votre compte a été bloqué, veillez contacter notre service assistance.';
						retourJS($statut,$message,$data);

					elseif($statut==1):
						//Return
						$statut = 'error';
						$data = '';
						$message ='Désolé, votre compte n\'est pas encore activé.';
						retourJS($statut,$message,$data);

					elseif($statut==3):
						//Return
						$statut = 'error';
						$data = '';
						$message ='Désolé, votre compte a été désactivé, veillez contacter notre service assistance.';
						retourJS($statut,$message,$data);
					endif;


				else:
					//Return
					$statut = 'error';
					$data = '';
					$message ='Identifiant ou Mot de passe incorrect !!!';
					retourJS($statut,$message,$data);

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
			$this->template->loadTemplate('spw_template', 'default_view', False, 'site', 'site/home_view', $data);
		}
	}//End index()________




	function load_cart(){

		$totalQty = 0;
		$contentCart = '<div class="i-alert">Votre panier est vide!</div>';
		$cartList = '';

		if($this->cart->contents()):
			foreach($this->cart->contents() as $item):
				$totalQty++;
				$idArt = $item['id'];
				$rowid = $item['rowid'];
				$prixUnitaireArt = $item['price'];
				$prixToatalArt = $item['subtotal'];
				$nameToatalArt = $item['name'];
				$qtyToatalArt = $item['qty'];
				$totalPanier = $this->session->cart_contents['cart_total'];

				
				/*<script amount="500" 
        callback=""
        url="<?=base_url().'assets/images/default/logo.png';?>"
        position="center" 
        theme="#0095ff"
        sandbox="true"
        key="65e02ce0630811ea86dcdfac38167264"
        src="https://cdn.kkiapay.me/k.js"></script>
<button class="false-btn blue kkiapay-button">Payer '.number_format(0, 0, ',', ' ').'f</button>
        */

				

				$cartList .= '  
				<li class="i-panier-content-list-item">
				<div class="i-panier-content-list-item-left">
				<div class="top">
				<div class="img">
				<img src="'.base_url().'assets/images/default/img-document.png" alt="document tackanon">
				</div>
				<div class="name">'.$nameToatalArt.'</div>
				</div>
				</div>

				<div class="i-panier-content-list-item-right">
				<div class="price">'.number_format($prixUnitaireArt, 0, ',', ' ').'f</div>
				<div class="quantite">
				<span class="moin js-calc-moin">-</span>
				<input type="number" class="jsQtyArItem" value="'.number_format($qtyToatalArt, 0, ',', ' ').'" data-row="'.$rowid.'" data-idart="'.$idArt.'">
				<span class="plus js-calc-plus">+</span>
				</div>
				<div class="prixTU">'.number_format($prixToatalArt, 0, ',', ' ').'f</div>
				<a href="#" class="js-del-art">x</a>
				</div>
				</li>
				';
			endforeach;
			$blockDelate = ' <div class="del_cart">
			<a href="#" class="del_cart_linck js-delate-panier">
			<i class="fas fa-trash-alt"></i>
			<span>Vider le Panier</span>
			</a>
			</div>
			';
			$blockBottom = '
			<div class="i-panier-bottom">
			<div class="i-panier-bottom-total">
			<strong class="title">Total</strong>
			<span class="number">'.number_format($totalPanier, 0, ',', ' ').'f</span>
			</div>
			<div class="i-panier-bottom-btn ">
			<button class="false-btn blue js-payer-panier">Payer '.number_format(0, 0, ',', ' ').'f</button>
			</div>
			</div>';

			$contentCart = $blockDelate.'<ul class="i-panier-content-list">'.$cartList.'</ul>'.$blockBottom;
		endif;

		echo $contentCart;
	}

	function total_art_in_cart(){

		//Totale qty
		$totalQty = 0;
		if($this->cart->contents()):
			foreach($this->cart->contents() as $item):
				$totalQty++;
			endforeach;
		endif;
		echo $totalQty;
	}



	public function ajax(){

		$data['maintenant'] = $maintenant = now();

		//infos user
		/*if(user_connected()):
			$user = user_connected();
		endif;*/


		//Ajax
		if($this->input->is_ajax_request()):
			extract($_POST);

			//==>register
			if($ActiveAjax=='SelectedNiveau'):
				$as = '*';
				$lien = 'niveau_categories.idNiv = niveau.idNiv';
				$array = array('niveau_categories.idArtCat'=>$idCatArt);
				$selectedNiveaux = $this->spw_model->get_Double_Table('niveau_categories','niveau',$as,$lien,$array,'','');

				$list ='<option  value="">---- Choisir le niveau ----</option>';
				if($selectedNiveaux):
					foreach($selectedNiveaux as $selectedNiveau):
						$list .= '
						<option value="'.$selectedNiveau->idNiv.'">'.$selectedNiveau->libNiv.'</option>
						';
					endforeach;
					//Return 
					$statut = 'success';
					$data = $list;
					$message ='';
					retourJS($statut,$message,$data);

				else:
					//Return 
					$statut = 'error';
					$data = $list;
					$message ='';
					retourJS($statut,$message,$data);
				endif;

			//==>chager statut
			elseif($ActiveAjax=='changeStatut'):
				$dataItem = array();

				if(isset($objet)):
					if(!empty($objet)):
						$dataAdd['objet'] = $objet;
					else:
						//Return
						$statut = 'error';
						$data = '';
						$message ='Veillez notifier l\'objet de votre action.';
						retourJS($statut,$message,$data);
						exit();
					endif;
				else:
					$objet = '';
				endif;


				$this->db->trans_start();
				//Update infos
				$dataItem['statut'] = $newStatut;
				$this->spw_model->update_item($table,$dataItem,array($idNane=>$id));

				//HISTORIQUE___________________
				$idHisUpdNew = newUpdateStatut($id,$statut,$table,$newStatut,$maintenant,$objet);

				//FERMET UN TICKET_________________on ferme un ticket lors de l'activation de l'élémént
				if($newStatut==2&&$statut!=1):
					//Definir l'$dHisUpd
					$idHisUpd = idHisUpd($id);
					closeTicket($idHisUpd);
				endif;

				//Creation de ticket reget___________________
				//=>1 Verifier si existe un Objet pour l'action
				if(isset($objet)&&!empty($objet)):
					CreatTicketReget($id,$idHisUpdNew,$maintenant);
				endif;



				if($this->db->trans_complete()):
					//Return 
					$statut = 'success';
					$data = $Returnlink;
					$message ='Félicitation, opération réussie!!!';
					retourJS($statut,$message,$data,true);
				endif;

			//==> Modification infomation compte
			elseif($ActiveAjax=='modifier_mon_compte'):
				//infos user
				$user = user_connected();
				$idUser = $user->idUse;

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
						"idPay" => $idPay,
						"idVil" => $idVil,
						"adresse" => $adresse,
						"description" => $description
					);
					$this->spw_model->update_item('users',$dataItem,array('idUse'=>$idUser));
					if($this->db->trans_complete()):
						//Return 
						$statut = 'success';
						$data = $Returnlink;
						$message ='Vos information ont été bien mis à jour';
						retourJS($statut,$message,$data);
					endif;
				endif;

			//==> Modification avatar
			elseif($ActiveAjax=='modifier_avatar'):
				//infos user
				$user = user_connected();
				$idUser = $user->idUse;

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
							$data = $Returnlink;
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
				//infos user
				$user = user_connected();
				$idUser = $user->idUse;
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
				//infos user
				$user = user_connected();
				$idUser = $user->idUse;
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
						$data = $Returnlink;
						$message ='Votre mot de passe a été bien modifié !!!';
						retourJS($statut,$message,$data,true);
					endif;

					
				endif;

			//==> goToConcours
			elseif($ActiveAjax=='goToConcours'):
				$resultat = 0;
				if(isset($this->session->user_connected)&&$this->session->user_connected['idGrpUti']==3):
					$resultat = 1;
				endif;

				//Return
				$statut = 'success';
				$data = $resultat;
				$message ='';
				retourJS($statut,$message,$data,false);



			else:
				//Return
				$statut = 'error';
				$data = '';
				$message ='Une erreur est survenue, veuillez réessayer.';
				retourJS($statut,$message,$data);
			endif;

		endif;
	}


	public function ajax_load_last_comment_forum($idForum,$page){
		$idForum = cripterId($idForum,1);
		$limite = 8;
		$totalCommentaire = count($this->spw_model->get_rows('forums_content',array('idFor'=>$idForum)));

		//Le max de page
		$maxPage = ceil($totalCommentaire/8);

		

		if($page==0){			
			$offset = $totalCommentaire - $limite;
		}else{
			$offset = $totalCommentaire - ($page*$limite);
		}

		if($offset<0):
			$offset=0;
		endif;

		if($page<=$maxPage):
			$forumCommentaires = $this->spw_model->get_limit_offset_like_order('forums_content',array('idFor'=>$idForum),$limite,$offset,$like=array(),'idForCon','Asc');

			if($forumCommentaires):
				$list = '';
				foreach($forumCommentaires as $forumCommentaire):
					$idUser = $forumCommentaire->idUse;
					$message = $forumCommentaire->message;
					$dateCreate = $forumCommentaire->dateCreate;

				//infos user
					$participants = $this->spw_model->get_rows('users',array('idUse'=>$idUser));
					foreach($participants as $participant):
						$nomParticipant = $participant->nom;
						$prenomsParticipant = $participant->prenoms;
					endforeach;

					$list .= '

					<div class="v-discution-row">
					<div class="img">
					<img src="'.base_url().'assets/images/users/default.jpg" alt="user avatar">
					</div>
					<div class="content">
					<div class="head">
					<span class="name">'.$nomParticipant.' '.$prenomsParticipant.'</span>
					<span class="date">Le '.date('d-m-Y à H:i:s', strtotime($dateCreate)).'</span>
					<div class="text">'.$message.'</div>
					</div>
					</div>
					<div class="bottom">

					</div>
					</div>

					';
				endforeach;
				$data['listCommentaire'] = $list;
				echo $list;
			else:
				$data['listCommentaire'] = array();
			endif;
		else:
			$data['listCommentaire'] = array();
		endif;

		//$this->load->view('spw_template/laoud/clients/', $data);
	}//End ajax_load_last_comment_forum()________



	public function logout()
	{
		if(isset($this->session->user_connected['idHistory'])):
			$dataItem = array('dateLogout'=>now());
			$this->spw_model->update_item('users_connexion_history',$dataItem,array('idUseConHis'=>$this->session->user_connected['idHistory']));
		endif;

		session_destroy();
		redirect(base_url());
	}//End logout()________






}//End document


