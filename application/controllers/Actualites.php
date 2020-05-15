<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actualites extends CI_Controller {

	
	public function index()
	{
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Actualites';
		$data['pageName']  = 'Actualites';
		$data['pageKeywords'] = 'examen, concour, etude';
		$data['pageDescription'] = 'examen, concour, etude';

		$data['activePage'] = $activePage = $this->uri->segment(1);

		//Laste posts, limite 12
		$data['listPosts'] = lastPosts('forItemsSite',$limit=12,$offset='',$like=array(),$condition=array('articles.statut'=>2))->list;


		//==>Pagination=>1 (Variable)
		$pgt_limit = 9; 
		$pgt_urlSegment = 2;
		$pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'actualites'.allUlrParametre();
		$limit = $pgt_limit;
		$offset = $pgt_offset;

		//==>Pagination=>2 (Calcule)
		$array = array('statut'=>2);
		$like = array();
		if(isset($_GET['cat'])):
			$data['idArtCat'] = $idArtCat = $_GET['cat'];
			$data['titleSection'] = '';
			$array['articles.idArtCar'] = $idArtCat;
		endif;
		if(isset($_GET['sta'])):
			$data['statutArt'] = $statutArt = $_GET['sta'];
			$array['articles.statut'] = $statutArt;
		endif;


		$data['pgt_totalResult'] = $pgt_totalResult = $this->spw_model->get_countAll_for_pagination('actualites',$array,$like);
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
		
		//==>Pagination=>3 (Resultat)
		$data['listeActualites'] =  $this->spw_model->get_limit_for_pagination('actualites',$array,$limit,$offset,$like,'idAct','Desc');
		




		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);
			//logoin
			if($ActiveAjax=='login'){
				echo userConnection($phone,$password,base_url().'home');
			}else{
				echo "Une erreur est survenue, veuillez renseigner";
			}
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', False, 'site', 'site/actualites_view', $data);
		}
	}//End index()________




	public function selection($idArt)
	{
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Actualité';
		$data['pageName'] = 'selection';
		$data['pageKeywords'] = '';
		$data['pageDescription'] = '';

		//date et heure actuel
		$data['maintenant'] = $maintenant = now();

		$data['activePage'] = $activePage = $this->uri->segment(1);


		$data['idAct'] = $idActualite = cripterId($idArt,1);
		//infos actualite
		$array = array('idAct'=>$idActualite);
		$data['actualites'] = $actualites = $this->spw_model->get_rows('actualites', $array);
		if($actualites):
			foreach($actualites as $actualite):
				$data['idArt'] = cripterId($idArt,0);
				$data['statut'] = $statut = $actualite->statut;
				$data['titleArt']  = $actualite->libAct;
				$data['descriptionArt']  = $actualite->description;
				$data['artDate'] = $artDebut = $actualite->dateCreate;
				$data['artDebut'] = $artDebut = $actualite->dateDebut;
				$data['artFin'] = $artFin= $actualite->dateFin;
				$artAffiche = $actualite->affiche;
			endforeach;
			if(isset($artAffiche)&&!empty($artAffiche)):
				$data['artAffiche'] = $artAffiche;
			else:
				$data['artAffiche'] = 'default.jpg';
			endif;
		else:
			//Return
			$statut = 'error';
			$data = '';
			$message ='Une erreur est survenue, veuillez réseller';
			retourJS($statut,$message,$data,true);
		endif;


		//Les trois derniers actualité sans celui choisir
		$array = array('statut'=>2, 'idAct !='=>$idActualite);
		$data['lastActualites'] = $lastActualites = $this->spw_model->get_rows_limit('actualites',$array,3);

		//Ajax
		if($this->input->is_ajax_request()){ 
			extract($_POST);
		}else{
			/*--==Chargement du template==--*/
			$this->template->loadTemplate('spw_template', 'default_view', False, 'site', 'site/detail_actualite_view', $data);
		}
	}


}//End document


