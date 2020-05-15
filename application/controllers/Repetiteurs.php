<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Repetiteurs extends CI_Controller {

	
	public function index()
	{
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Repetiteurs';
		$data['pageName']  = 'services';
		$data['pageKeywords'] = 'Maitre de maison, professeur, encadreus';
		$data['pageDescription'] = 'examen, concour, etude';

		$data['activePage'] = $activePage = $this->uri->segment(1);

		//Laste posts, limite 12
		$data['listPosts'] = lastPosts('forItemsSite',$limit=12,$offset='',$like=array(),$condition=array('articles.statut'=>2))->list;
		



		//==>Pagination=>1 (Variable)
		$pgt_limit =12; 
		$pgt_urlSegment = 2;
		$pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'repetiteurs'.allUlrParametre();
		$limit = $pgt_limit;
		$offset = $pgt_offset;

		//==>Pagination=>2 (Calcule)
		$array['repetiteurs.statut'] = 2;
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


		$data['pgt_totalResult'] = $pgt_totalResult = $this->spw_model->get_countAll_for_pagination('repetiteurs',$array,$like);
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
		

		//==>Pagination=>3 (Resultat)
		$as ='*, repetiteurs.statut as statutRep, repetiteurs.dateCreate as dateCreateRep, repetiteurs.description as descriptionRep';
		$lien = 'repetiteurs.idCatNiv = categories_niveau.idCatNiv';
		$lienSecond = 'repetiteurs.idUse = users.idUse';
		$data['repetiteursActualites'] =  $this->spw_model->get_treeTables_limit_for_pagination('repetiteurs','categories_niveau','users',$as,$lien,$lienSecond,$limit,$offset,$array,$like,'users.nom','Asc');



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
			$this->template->loadTemplate('spw_template', 'default_view', False, 'site', 'site/repetiteurs_view', $data);
		}
	}//End index()________




	


}//End document


