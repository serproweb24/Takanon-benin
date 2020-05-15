<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documents extends CI_Controller {

	
	public function index()
	{
		/*-----------------------------------*\
		|*-------==Varibles Générale==-------*|
		\*-----------------------------------*/
		$data['pageTitle'] = 'Recherche de  documents';
		$data['pageName']  = 'documents';
		$data['pageKeywords'] = 'touver document, epreuve, livre';
		$data['pageDescription'] = 'Pour toutes vos recherches en documents, epreuves ou livre, Takanou vous accompagne.';

		$data['activePage'] = $activePage = $this->uri->segment(1);

		//liste Categorie Article
		if(isset($_GET['cat'])): $getCat=$_GET['cat']; else: $getCat = False; endif;
		$data['optionCategorieArt'] = articles_categories('forSelect',$getCat);
		//liste Categorie Article
		$data['listCategorieArt'] = articles_categories('forList');

		//liste Categorie Article
		$data['optionMatieres'] = articles_matieres('forSelect');
		$data['listMatieres'] = articles_matieres('forList');

		//liste Categorie Article
		$data['optionAnnees'] = articles_annees('forSelect');
		$data['listAnnees'] = articles_annees('forList');

		

		//==>Pagination=>1 (Variable)
		$pgt_limit = 12; 
		$pgt_urlSegment = 2;
		$pgt_offset = ($this->uri->segment($pgt_urlSegment))? $this->uri->segment($pgt_urlSegment):'';
		$pgt_url = base_url().'documents'.allUlrParametre();
		$limit = $pgt_limit;
		$offset = $pgt_offset;
		$like = array();

		//==>Pagination=>2 (Calcule)
		//$array = array('articles.statut'=>2);
		$array = array();
		if(isset($_GET['cat'])):
			$data['idCatArt'] = $idCatArt = $_GET['cat'];
			$array['articles.idArtCar'] = $idCatArt;
		endif;
		if(isset($_GET['niv'])):
			$data['idNivArt'] = $idNivArt = $_GET['niv'];
			$array['articles.idNiv'] = $idNivArt;
		endif;
		if(isset($_GET['mat'])):
			$data['idMatArt'] = $idMatArt = $_GET['mat'];
			$array['articles.idMat'] = $idMatArt;
		endif;
		if(isset($_GET['ann'])):
			$data['idAnnArt'] = $idAnnArt = $_GET['ann'];
			$array['articles.idAnn'] = $idAnnArt;
		endif;



		$data['pgt_totalResult'] = $pgt_totalResult = $this->spw_model->get_countAll_for_pagination('articles',$array,$like);
		$data['pgt_nav'] = pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment);
		

		//==>Pagination=>3 (Resultat)
		$as ='*, articles.idUse as idUseArt';
		$lien = 'articles.idArtCar = articles_categories.idArtCar';
		$lienSecond = 'articles.idNiv = niveau.idNiv';
		$lienThird = 'articles.idMat = matieres.idMat';
		$lienFourth = 'articles.idAnn = annees.idAnn';
		$data['articles'] =  $this->spw_model->get_fiveTables_limit_for_pagination('articles','articles_categories','niveau','matieres','annees',$as,$lien,$lienSecond,$lienThird,$lienFourth,$limit,$offset,$array,$like,'articles.dateCreate','Desc');

		


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
			$this->template->loadTemplate('spw_template', 'default_view', False, 'site', 'site/documents_view', $data);
		}
	}//End index()________




	


}//End document


