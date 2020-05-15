<?php 
/*
--------------------------------------
General
--------------------------------------
*/
//Liste des catégories d'utilisateur client
function categorieUsers(){
	$CI = get_instance();
	$CI->load->model('spw_model');
	return $categorieUsers = $CI->spw_model->get_rows_order('users_categories',array('statut'=>2), 'libUsCat', 'Asc');
}


//Liste de tous Les Pays
function tousLesPays(){
	$CI = get_instance();
	$CI->load->model('spw_model');
	return $categorieUsers = $CI->spw_model->get_rows_order('pays',array('statut'=>2), 'libPay', 'Asc');
}

//Liste de toutes les Vliles
function toutesLesVilles(){
	$CI = get_instance();
	$CI->load->model('spw_model');
	return $categorieUsers = $CI->spw_model->get_rows_order('villes',array('statut'=>2), 'libVil', 'Asc');
}



/*
--------------------------------------
Chagement de statut
--------------------------------------
*/
//Admin=> Nouveau ajout de changement de statut
function newUpdateStatut($id,$statut,$table,$newStatut,$maintenant,$objet=''){
	$CI = get_instance();
	$CI->load->model('spw_model');

	//Recuperation last LOT
	$infos = $CI->spw_model->get_last_row('historique_update',$array=array(),'idHisUpd');
	$lastLot = 0;
	if($infos):
		foreach($infos as $info):
			$lastLot = $info->lot;
		endforeach;
	endif;
	$newLot = $lastLot + 1;

	$dataAdd['idUse'] = $CI->session->user_connected['idUse'];
	$dataAdd['idRow'] = $id;
	$dataAdd['nameTable'] = $table;
	$dataAdd['nameColum'] = 'statut';
	$dataAdd['lot'] = $newLot;
	$dataAdd['lastValue'] = $statut;
	$dataAdd['newValue'] = $newStatut;
	$dataAdd['statut'] = 2;
	$dataAdd['objet'] = $objet;
	$dataAdd['dateCreate'] = $maintenant;
	$CI->spw_model->add_item('historique_update',$dataAdd);

	return $CI->spw_model->last_id_insert('historique_update');
}

//=>
function idHisUpd($id){
	$CI = get_instance();
	$CI->load->model('spw_model');
	
	$as = '*, tickets_regets.idHisUpd as idHisUpdActive, tickets_regets.idHisUpd as idHisUpdReg, tickets_regets.idUse as idUseReg, tickets_regets.statut as statutReg, tickets_regets.dateCreate as dateCreateReg ';
	$lien = 'historique_update.idHisUpd = tickets_regets.idHisUpd';
	$array = array('historique_update.idRow'=>$id, 'tickets_regets.statut'=>1);
	$verifications = $CI->spw_model->get_Double_Table('historique_update','tickets_regets',$as,$lien,$array,'','');
	if($verifications):
		foreach($verifications as $verification):
			$idHisUpd = $verification->idHisUpdActive;
		endforeach;
	else:
		$idHisUpd = 0;
	endif;

	return $idHisUpd;
}


//Admin=> Fermer un ticket
function closeTicket($idHisUpd){
	$CI = get_instance();
	$CI->load->model('spw_model');
	$dataItem['statut'] = 2;
	$CI->spw_model->update_item('tickets_regets',$dataItem,array('idHisUpd'=>$idHisUpd));
}


//Verification de ticket ouvert
function existTicket($id,$table,$type=false){
	$CI = get_instance();
	$CI->load->model('spw_model');

	$as = '*, tickets_regets.idHisUpd as idHisUpdActive, tickets_regets.idHisUpd as idHisUpdReg, tickets_regets.idUse as idUseReg, tickets_regets.statut as statutReg, tickets_regets.dateCreate as dateCreateReg ';
	$lien = 'historique_update.idHisUpd = tickets_regets.idHisUpd';
	$array = array('historique_update.idRow'=>$id, 'tickets_regets.statut'=>1, 'historique_update.nameTable'=>$table);
	$verifications = $CI->spw_model->get_Double_Table('historique_update','tickets_regets',$as,$lien,$array,'','');
	if($verifications):
		if($type):
			foreach($verifications as $verification):
				$result = (object)array(
					'idTicReg' => $verification->idTicReg,
					'idUse' => $verification->idUseReg,
					'idHisUpd' => $verification->idHisUpdReg,
					'statutTicReg' => $verification->statutReg,
					'dateCreate' => $verification->dateCreateReg
				);
			endforeach;
			return $result;
		else:
			return $verifications;
		endif;
	else:
		return $verifications;
	endif;
}

//Admin=> rejet et bloquage
function CreatTicketReget($id,$idHisUpdNew,$maintenant){
	$CI = get_instance();
	$CI->load->model('spw_model');

	//=>1 Verifier et fermer tous eventuel ticket encore  ouvert ayant le meme Id
	$as = '*, tickets_regets.idHisUpd as idHisUpdActive';
	$lien = 'tickets_regets.idHisUpd = historique_update.idHisUpd';
	$array = array('historique_update.idRow'=>$id, 'tickets_regets.statut'=>1);
	$verifications = $CI->spw_model->get_Double_Table('tickets_regets','historique_update',$as,$lien,$array,'','');
	if($verifications):
		//Definir $dHisUpd
		foreach($verifications as $value):
			$idHisUpd = $value->idHisUpdActive;
		endforeach;
		closeTicket($idHisUpd);
	endif;


	//=>2 Creation du nouveau ticket
	$dataAdd['idUse'] = $CI->session->user_connected['idUse'];
	$dataAdd['idHisUpd'] = $idHisUpdNew;
	$dataAdd['statut'] = 1;
	$dataAdd['dateCreate'] = $maintenant;
	$CI->spw_model->add_item('tickets_regets',$dataAdd);

}


//Return La valeur du  lot a utiliser
function  valueLot($table,$array,$column){
	$CI = get_instance();
	$CI->load->model('spw_model');

	$lot = 0;
	$lasRows = $CI->spw_model->get_last_row($table,$array,$column);
	if($lasRows):
		foreach($lasRows as $lasRow):
			$lot = $lasRow->lot;
		endforeach;
	endif;

	return $lot++;
}

//Fonction generale d'enregistrement des modification
function historyAllUpdate($dataAdd){
	$CI = get_instance();
	$CI->load->model('spw_model');
	// Enregister l'ecriture
	$CI->spw_model->add_item('historique_update',$dataAdd);
}

/*
--------------------------------------
User
--------------------------------------
*/

function user_connected()
{
	$CI = get_instance();
	$CI->load->model('spw_model');
	
	//infos user
	$users = $CI->spw_model->get_rows('users', array('idUse'=>$CI->session->user_connected['idUse']));
	foreach($users as $user_infos):
		$user = (object)array(
			'idUse' => $user_infos->idUse,
			'nom' => $user_infos->nom,
			'prenoms' => $user_infos->prenoms,
			'idUseCat' => $user_infos->idUseCat,
			'email' => $user_infos->email,
			'telephone' => $user_infos->telephone,
			'idPay' => $user_infos->idPay,
			'idVil' => $user_infos->idVil,
			'adresse' => $user_infos->adresse,
			'profession' => $user_infos->profession,
			'description' => $user_infos->description,
			'avatar' => (isset($user_infos->avatar)&&!empty($user_infos->avatar)&&$user_infos->avatar!="error")? $user_infos->avatar:'default.jpg'
		);
	endforeach;
	return $user;
}
//Liste des utilisateur
function all_users($userArray=array()){
	$CI = get_instance();
	$CI->load->model('spw_model');
	$as = '*, users.statut as statutUser';
	$lien = 'users.idUseCat = users_categories.idUseCat';
	$lienSecond = 'users_categories.idGrpUti = groupe_utilisateurs.idGrpUti';
	$array = $userArray;
	$all_users = $CI->spw_model->get_tree_Table('users','users_categories','groupe_utilisateurs',$as,$lien,$lienSecond,$array,'users.nom','Asc');
	
	return $all_users;
}


/*
--------------------------------------
Actualités
--------------------------------------
*/

//Liste des categorie articles
function articles_categories($type,$getCat=false){
	$CI = get_instance();
	$CI->load->model('spw_model');
	$categorieArticles = $CI->spw_model->get_rows_order('articles_categories',array('statut'=>2), 'libArtCar', 'Asc');

	if(!isset($type) || $type=='forList'):
		return $categorieArticles;
	elseif($type=='forSelect'):
		$liste = '';
		foreach($categorieArticles as $categorieArticle):
			$cat = (isset($getCat)&&$getCat==$categorieArticle->idArtCar)? "selected='selected'":"";
			$liste .= '
			<option value="'.$categorieArticle->idArtCar.'" '.$cat.'>'.$categorieArticle->libArtCar.'</option>
			';
		endforeach;
		return $liste;
	endif;
}


//Liste des categorie Matieres
function articles_matieres($type){
	$CI = get_instance();
	$CI->load->model('spw_model');
	$categorieMatieres = $CI->spw_model->get_rows_order('matieres',array('statut'=>2), 'libMat', 'Asc');

	if(!isset($type) || $type=='forList'):
		return $categorieMatieres;
	elseif($type=='forSelect'):
		$liste = '';
		foreach($categorieMatieres as $categorieMatiere):
			$liste .= '
			<option value="'.$categorieMatiere->idMat.'">'.$categorieMatiere->libMat.'</option>
			';
		endforeach;
		return $liste;
	endif;
}


//Liste des categorie niveau d'enseignement
function categorie_niveau_enseignement($type,$getNiv=false){
	$CI = get_instance();
	$CI->load->model('spw_model');
	$categorieNiveaus = $CI->spw_model->get_rows_order('categories_niveau',array('statut'=>2), 'libCatNiv', 'Asc');

	if(!isset($type) || $type=='forList'):
		return $categorieNiveaus;
	elseif($type=='forSelect'):
		$liste = '';
		foreach($categorieNiveaus as $categorieNiveau):
			$niv = (isset($$getNiv)&&$$getNiv==$categorieArticle->idArtCar)? "selected='selected'":"";
			$liste .= '
			<option value="'.$categorieNiveau->idCatNiv.' '.$niv.'">'.$categorieNiveau->libCatNiv.'</option>
			';
		endforeach;
		return $liste;
	endif;
}


//Liste des categorie Annees
function articles_annees($type){
	$CI = get_instance();
	$CI->load->model('spw_model');
	$categorieAnnees = $CI->spw_model->get_rows_order('annees',array('statut'=>2), 'libAnn', 'Desc');

	if(!isset($type) || $type=='forList'):
		return $categorieAnnees;
	elseif($type=='forSelect'):
		$liste = '';
		foreach($categorieAnnees as $categorieAnnee):
			$liste .= '
			<option value="'.$categorieAnnee->idAnn.'">'.$categorieAnnee->libAnn.'</option>
			';
		endforeach;
		return $liste;
	endif;
}

//Liste des categorie Actualites
function actualites_categories($type){
	$CI = get_instance();
	$CI->load->model('spw_model');
	$categorieActualites = $CI->spw_model->get_rows_order('actualites_categories',array('statut'=>2), 'libActCat', 'Asc');

	if(!isset($type) || $type=='forList'):
		return $categorieActualites;
	elseif($type=='forSelect'):
		$liste = '';
		foreach($categorieActualites as $categorieActualite):
			$liste .= '
			<option value="'.$categorieActualite->idActCat.'">'.$categorieActualite->libActCat.'</option>
			';
		endforeach;
		return $liste;
	endif;
}


function infos_actualites($array,$type){
	$CI = get_instance();
	$CI->load->model('spw_model');
	$actualites = $CI->spw_model->get_rows_order('actualites',$array, 'libAct', 'Desc');
	//Count
	if(isset($type)):
		return count($actualites);
	else:
		return $actualites;
	endif;
}










/*
--------------------------------------
Articles
--------------------------------------
*/
function infos_articles($array,$type){
	$CI = get_instance();
	$CI->load->model('spw_model');
	$articles = $CI->spw_model->get_rows_order('articles',$array, 'libArt', 'Desc');
	//Count
	if(isset($type)):
		return count($articles);
	else:
		return $articles;
	endif;
}


function lastPosts($type,$limit=12,$offset=1,$like=array(),$condition=array()){
	$CI = get_instance();
	$CI->load->model('spw_model');

	$as = '*,articles.statut as statutArt, articles_categories.idArtCar as idArtCat, articles.description as descriptionArt, articles.idUse as idUseArt';
	$lien = 'articles.idArtCar = articles_categories.idArtCar';
	$lienSecond = 'articles.idNiv = niveau.idNiv';
	$lienThird = 'articles.idMat = matieres.idMat';
	$lienFourth = 'articles.idAnn = annees.idAnn';


	if(isset($condition)):
		$array = $condition;
	else: 
		$array = array();
	endif;
	$lastPosts = $CI->spw_model->get_fiveTables_limit_for_pagination('articles','articles_categories','niveau','matieres','annees',$as,$lien,$lienSecond,$lienThird,$lienFourth,$limit,$offset,$array,$like,'articles.idArt','Desc');

	$count =  $CI->spw_model->get_countAll_for_pagination('articles',$array,$like);


	if(!isset($type) || $type=='forList'):
		return (object)array('list'=>$lastPosts, 'count'=>$count);
	elseif($type=='forItemsSite'):
		$liste = '';
		foreach($lastPosts as $article):
			$idArt = $article->idArt;
			$libArt = $article->libArt;
			$prixArt = $article->prix;
			$idUseArt = $article->idUseArt;
			$descArt = (!empty($article->description))? $article->description:'<small>Sans description.</small>';
			//Auteur
			$autors = $CI->spw_model->get_rows('users', array('idUse'=>$idUseArt));
			foreach($autors as $autor):
				$identiteAutor = $autor->nom.' '.$autor->prenoms;
			endforeach;


			$liste .= '
			<li class="last_offers-list-item">
			<a href="#PreviewDoc" class="js-open-poPup js-transfer_data" data-infos="'.$idArt.'@@'.$libArt.'@@'.$prixArt.'F@@'.$descArt.'@@'.$identiteAutor.'">
			<div class="last_offers-list-item-img">
			<img src="'.base_url().'assets/images/default/img-document.png" alt="document takanon-benin">
			</div>
			<span class="last_offers-list-item-name">
			'.$libArt.'
			</span>
			<span class="last_offers-list-item-price">
			'.number_format($prixArt, 0, ',', ' ').' f
			</span>
			</a>
			</li>
			';
		endforeach;
		return (object)array('list'=>$liste, 'count'=>$count);
	endif;

}


function CountnewTicketReget($idTicReg,$idGrpUti){
	$CI = get_instance();
	$CI->load->model('spw_model');
	//Type Acteur (1 = les comments des admins, 2 = les comments des clients)

	$array =array('tickets_regets_content.statut'=>1, 'idTicReg'=>$idTicReg, 'idGrpUti'=>$idGrpUti);

	$as = '*';
	$lien = 'tickets_regets_content.idUse = users.idUse';
	$comments = $CI->spw_model->get_Double_Table('tickets_regets_content','users',$as,$lien,$array,'','');
	return count($comments);
}


/*
--------------------------------------
Forum
--------------------------------------
*/
function infos_forums($array,$type){
	$CI = get_instance();
	$CI->load->model('spw_model');
	$forums = $CI->spw_model->get_rows_order('forums',$array, 'libFor', 'Desc');
	//Count
	if(isset($type)):
		return count($forums);
	else:
		return $forums;
	endif;
}





/*
--------------------------------------
Répétiteur
--------------------------------------
*/
function infos_repetiteurs($array,$type){
	$CI = get_instance();
	$CI->load->model('spw_model');
	$repetiteurs = $CI->spw_model->get_rows_order('repetiteurs',$array, 'idRep', 'Desc');
	//Count
	if(isset($type)):
		return count($repetiteurs);
	else:
		return $repetiteurs;
	endif;
}


/*
--------------------------------------
Messages
--------------------------------------
*/
function allNewMessages($array,$count=false){
	$CI = get_instance();
	$CI->load->model('spw_model');
	$newMessages = $CI->spw_model->get_rows('messages',$array);
	if($count){
		return count($newMessages);
	}else{
		return $newMessages;
	}
	
}



/*
--------------------------------------
Statistique
--------------------------------------
*/
function forStatistiqueCount($table,$arrayFSC,$column=false){
	$CI = get_instance();
	$CI->load->model('spw_model');
	if($column):
		$result = $CI->spw_model->get_rows_distinct($table,$arrayFSC,$column);
	else: 
		$result = $CI->spw_model->get_rows($table,$arrayFSC);
	endif;
	return number_format(count($result), 0, ',', ' ');
	
}





/*
--------------------------------------
Concours
--------------------------------------
*/
//==>Infos Concours
function infos_concours_encours($ideConcour)
{
	$CI = get_instance();
	$CI->load->model('spw_model');


	$concourSelects = $CI->spw_model->get_rows('concours', array('idCon'=>$ideConcour));
	if($concourSelects):
		$concourInfos = array();
		foreach($concourSelects as $concourSelect):
			array_push($concourInfos, (object)array(
				'libConcour' => $concourSelect->libCon,
				'dateStartConcour' => $concourSelect->dateStart
			));
		endforeach;
		return $concourInfos;
	else:
		redirect(base_url().'users/concours');
		exit();
	endif;
}


//==>Questions Concours
function question_concours_encours($ideConcour,$ideConPar)
{
	$CI = get_instance();
	$CI->load->model('spw_model');

	
	$listeReponses = $CI->spw_model->get_rows('concours_participants_reponses', array('idConPar'=>$ideConPar));
	if($listeReponses):
		$responsListe = array();
		foreach($listeReponses as $listeReponse):
			array_push($responsListe, $listeReponse->idAllQue);
		endforeach;
	else:
		$responsListe = array('0');
	endif;




	$as = '*,concours_content.idCon as idConCC, concours_all_questions.idAllQue as idAllQueCAQ';
	$lien = 'concours_content.idAllQue = concours_all_questions.idAllQue';
	if($responsListe)
		$array = array('concours_content.idCon'=>$ideConcour, 'concours_content.statut'=>2);
	$indice = 'concours_content.idAllQue';
	$arrayNotIn = $responsListe;
	$concourQuestions = $CI->spw_model->get_two_Tables_whereNotIn_limit('concours_content','concours_all_questions',$as,$lien,$array,$indice,$arrayNotIn,'','',1);

	if($concourQuestions):
		return $concourQuestions;
	else:
		return NULL;
	endif;

}



//==>Participant
function participant($ideParticipant)
{
	$CI = get_instance();
	$CI->load->model('spw_model');

	$participants = $CI->spw_model->get_rows('users', array('idUse'=>$ideParticipant));
	if($participants):

		foreach($participants as $participant):
		$result = (object)array(
				"nom" => $participant->nom,
				"prenoms" => $participant->prenoms
			);
		endforeach;
		$result = (object)$result;
	else:
		$result = NULL;
	endif;

	return $result;

}


//Count concours by periode=======> for admin
function countConcourByPeriode($periode){
	$CI = get_instance();
	$CI->load->model('spw_model');

	return count($CI->spw_model->get_rows('concours',$periode));
}








?>