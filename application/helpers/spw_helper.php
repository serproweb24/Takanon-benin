<?php 
function userConnection($login,$password,$idGrpUti,$action){
	$CI = get_instance();
	$CI->load->model('spw_model');

	$phone = $login;
	$arraylogin = array('telUti'=>$phone, 'motPasUti'=>sha1($password));
	$connectedInfos = $CI->spw_model->get_rows('utilisateur',$arraylogin);
	if(count($connectedInfos)==1){
		foreach($connectedInfos as $connectedInfo):
			$_SESSION['userConnected']['id'] = $connectedInfo->ideUti;
			$_SESSION['userConnected']['matr'] = $connectedInfo->matUti;
			$_SESSION['userConnected']['nom'] = $connectedInfo->nomUti;
			$_SESSION['userConnected']['prenom'] = $connectedInfo->preUti;
			$_SESSION['userConnected']['idGrpUti'] = $connectedInfo->idGrpUti;
		endforeach;

		if(isset($memorizeCheck))
		{
			setcookie("phone", trim($phone), time() + (10 * 365 * 24 * 60 * 60));
			setcookie("password", $password, time() + (10 * 365 * 24 * 60 * 60));
		}
		return $action;
	}else{
		return 'Désolé!!!...Vous votre mot de passe ou numéro de téléphone a été mal renseillé.';
	}
}



//Verifi si une session de connection est ouverte
function userIsLogin($idGrpUti){
	$CI = get_instance();

	if(!isset($CI->session->user_connected) || $idGrpUti!=$CI->session->user_connected['idGrpUti']):
		redirect(base_url().'logout');
	endif;
}

//Verification de d'existance
function verifyExist($table,$elems){
	$CI = get_instance();
	$CI->load->model('spw_model');
	return	$findResultInfos = $CI->spw_model->get_rows($table,$elems);
}

function now(){
	/*===========Date==============*/
	setlocale(LC_TIME, 'fra_fra');
	//L'intemps
	return $maintenant = strftime('%Y-%m-%d %H:%M:%S', strtotime('-1 time'));
}

//Générator Code bar
function code_bar($pefix,$idRow)
{

	/*==GERERRE CODE BAR ==*/
  //=1=>code aleatoir de 12
	$characts = 'abcdefghijklmnopqrstuvwxyz';
	$characts .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$characts .= '1234567890';
	$code_aleatoire = '';

	for($i=0;$i < 12;$i++)
	{
		$code_aleatoire .= $characts[ rand() % strlen($characts) ];
	}


  //=2=>definit le nouveau identifian
	$NewID= $idRow;

  //=3=>Definir la taille de $NewID
	$tailleaNewID = mb_strlen($NewID);

  //=4=>Supprimer $tallaNewID dernier caracter de $code_aleatoire
	$chaineReduite = substr($code_aleatoire, 0, -$tailleaNewID);

  //=5=>Concatenation
	$codeBar = $chaineReduite."".$NewID;

	return $codeBar;
}



//Générator numéro matricule
function num_matriculeUti($pefix,$idRow)
{

	/*==GERERRE CODE BAR ==*/
  //=1=>code aleatoir de 8
	$characts = 'abcdefghijklmnopqrstuvwxyz';
	$characts .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$characts .= '1234567890';
	$code_aleatoire = '';

	for($i=0;$i < 8;$i++)
	{
		$code_aleatoire .= $characts[ rand() % strlen($characts) ];
	}


  //=2=>definit le nouveau identifian
	$NewID= $idRow;

  //=3=>Definir la taille de $NewID
	$tailleaNewID = mb_strlen($NewID);

  //=4=>Supprimer $tallaNewID dernier caracter de $code_aleatoire
	$chaineReduite = substr($code_aleatoire, 0, -$tailleaNewID);

  //=5=>Concatenation
	$codeBar = $chaineReduite."".$NewID;

	return $codeBar;
}
//Générator code validation register
function code_validation($cheneUniq,$taille)
{

	/*==GERERRE CODE BAR ==*/
  //=1=>code aleatoir de 8

	$characts = 'abcdefghijklmnopqrstuvwxyz';
	$characts .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$characts .= '1234567890';
	$characts .= $cheneUniq;
	$code_aleatoire = '';

	for($i=0;$i < $taille;$i++)
	{
		$code_aleatoire .= $characts[ rand() % strlen($characts) ];
	}

	return $code_aleatoire;
}

function retourJS($statut='',$message='',$data='',$type=false){

	$json = array(
		'statut' => $statut,
		'message' => $message,
		'data' => $data
	);

	if($type):
		$_SESSION['message_'.$statut] = $message;
	endif;
	echo json_encode($json);
}


function request($url, $data, $method) {

	if ($method == "GET") {

		if (count($data) == 0) {
			$final_url = $url;
		} else {
			$built_query = http_build_query($data);
			$final_url = $url . "?" . $built_query;
		}

		$result = file_get_contents($final_url);
    // $json = json_decode($result);

		return ($result);
	}
}


function sendSMS($numero,$message){
	$data = array(
		'user' => 'kevinpak',
		'password' => 'deli2035',
		'api' => 6981,
		'from' => 'TAKANON',
		'to' => $numero,
		'text' => $message,
	);
	$resultat = request('http://oceanicsms.com/api/http/sendmsg.php', $data, 'GET');
	$explode = explode(":", $resultat);
	if (trim($explode[0]) == "ID") {
		return true;
	} else {
		return false;
	}
}


function recupererDebutTexte ($origine, $longueurAGarder)
{
	if (strlen ($origine) <= $longueurAGarder)
		return $origine;
	
	$debut = substr ($origine, 0, $longueurAGarder);
	$debut = substr ($debut, 0, strrpos ($debut, ' ')) . '...';
	
	return $debut;
}



//Replace
function replace($elem,$newElem,$array){
	return str_replace($elem,$newElem,$array);
}


//pagination
function pagination($pgt_url,$pgt_totalResult,$pgt_limit,$pgt_urlSegment){
	$CI = get_instance();

	if($CI->load->library('pagination')):

		$config['base_url'] = $pgt_url;
		$config['total_rows'] = $pgt_totalResult;
		$config['per_page'] = $pgt_limit;
		$config["uri_segment"] = $pgt_urlSegment;
		$config['num_links'] = 3;
		
		/*permet d'afficher le numero actif de la pagination das l'url
		$config['use_page_numbers'] = TRUE;*/

		//$config['reuse_query_string'] = TRUE;

		$config['full_tag_open'] = '<div class="i-pagination"><ul class="i-pagination-list">';
		$config['full_tag_close'] = '</ul></div>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$config['first_link'] = '1';
		$config['first_tag_open'] = '<li class="i-pagination-first">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = round($pgt_totalResult/$pgt_limit, 0, PHP_ROUND_HALF_UP);
		$config['last_tag_open'] = '<li class="i-pagination-last">';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = '>';
		$config['next_tag_open'] = '<li class="nextlink">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '<';
		$config['prev_tag_open'] = '<li class="prevlink">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';



		$CI->pagination->initialize($config);
		return $CI->pagination->create_links();
	else:
		return 404;
	endif;
}


//Critper id
function cripterId($id,$return){
	
	if(is_numeric($id)):
		if($return==0):
			return	($id*2)+4;
		elseif($return==1):
			return	($id-4)/2;
		endif;
	else:
		return null;
	endif;

}



//REturn all parametre in url
function allUlrParametre(){
	if(isset($_SERVER['REQUEST_URI'])):
		$secondSegment = explode("?", $_SERVER['REQUEST_URI']);
		if(isset($secondSegment[1])):
			$exlodeSecSeg = explode("/", $secondSegment[1]);
			return '?'.$exlodeSecSeg[0];
		else:
			return false;
		endif;
	else:
		return false;
	endif;
}



/*
--------------------------------------
GetCountNewEllem
--------------------------------------
*/
function GetCountNewEllem($table,$array,$count=false){
	$CI = get_instance();
	$CI->load->model('spw_model');
	$newMessages = $CI->spw_model->get_rows($table,$array);
	if($count){
		return count($newMessages);
	}else{
		return $newMessages;
	}
	
}


/*
--------------------------------------
Difference entre deux date
--------------------------------------
*/
function dateDiff($date1, $date2){
	//abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
	$diff = abs($date1 - $date2);
	$retour = array();

	$tmp = $diff;
	$retour['second'] = $tmp % 60;

	$tmp = floor( ($tmp - $retour['second']) /60 );
	$retour['minute'] = $tmp % 60;

	$tmp = floor( ($tmp - $retour['minute'])/60 );
	$retour['hour'] = $tmp % 24;

	$tmp = floor( ($tmp - $retour['hour'])  /24 );
	$retour['day'] = $tmp;

	return $retour;
}

function diffDate($LastDate, $NewDate){
	//Exemple format des date  '2020-01-01  00:00:00'
	$LastDate = new DateTime($LastDate);
	$NewDate = new DateTime($NewDate);

	$diff = $NewDate->diff($LastDate);

	$result = (object)array(
		'annees' => $diff->format('%y'),
		'mois' => $diff->format('%m'),
		'jours' => $diff->format('%d'),
		'heures' => $diff->format('%h'),
		'minutes' => $diff->format('%i'),
		'second' => $diff->format('%s'),
		'total_joures' => $diff->format('%a')
	);

	return $result;

}
//Conversion from second
function convertSecond($tatalSecond){
	//Arrondir par min (1,8=1)
	$min =  round($tatalSecond/60, 0, PHP_ROUND_HALF_DOWN);
	$h = 0; $m = 0 ; $s = 0;
	if($min>=60){
		$h = round($min/3600, 0, PHP_ROUND_HALF_DOWN);
		$m = round(($min - $h*3600)/60, 0, PHP_ROUND_HALF_DOWN);
		$s = round(($min - ($h*3600 + $m*60)), 0, PHP_ROUND_HALF_DOWN);
	}else{
		$h = 0;
		$m = $min;
		$s = round(($min - ($m*60)), 0, PHP_ROUND_HALF_DOWN);
	}
	($h<10)? $h='0'.$h:$h=$h;
	($m<10)? $m='0'.$m:$m=$m;
	($s<10)? $s='0'.$s:$s=$s;

	return $result = (object)array(
		"heures" => $h,
		"minutes" =>$m,
		"secondes" =>$s
	);
}


/*
--------------------------------------
Envoie de messages
--------------------------------------
*/
//Toujour configurer le fichier email dans application/config/email.php
function sendEmail($nameSender,$emailSender,$emailRecep,$sujet,$message)
{
	$CI = get_instance();
	$CI->load->library('email');


	$CI->email->set_mailtype("html");
	$CI->email->from($emailSender, $nameSender);
	$CI->email->cc($emailSender);
	$CI->email->bcc($emailSender);
	/*$CI->email->to('themagictouch229@gmail.com');*/
	$CI->email->to($emailRecep);
	$CI->email->subject($sujet);
	$CI->email->message($message);

	$CI->email->send();
	return $CI->email->print_debugger();
}









/*
--------------------------------------
Compteur de visite
--------------------------------------
*/
function count_visitor(){
	$CI = get_instance();
	$CI->load->model('spw_model');

	$maintenant = now();

	/*---=== Récupérer les variables ===---*/

	//1=>Recuperer l'adresse IP
	if(!empty($_SERVER['REMOTE_ADDR'])):
		$ipAdresse = $_SERVER['REMOTE_ADDR'];
	else:
		$ipAdresse = 0;
	endif;

	//2=>Le lien de reference si existe (d'où vient l'utilisateur)
	if(isset($_SERVER['HTTP_REFERER'])):
		$reference_link = $_SERVER['HTTP_REFERER'];
	else:
		$reference_link ='Inconnu';
	endif;

	//3=>Le systeme et navigateur de l'utilisateur
	if(isset($_SERVER['HTTP_USER_AGENT'])):
		$user_browser_oc = $_SERVER['HTTP_USER_AGENT'];
	else:
		$user_browser_oc ='Inconnu';
	endif;

	//4=>Le lien consulté (REQUEST_URI)
	if(isset($_SERVER['REQUEST_URI'])):
		$user_link_view = $_SERVER['REQUEST_URI'];
	else:
		$user_link_view ='Inconnu';
	endif;


	/*---=== Verifier si visiteur existe deja dans la base de donnnées ===---*/
	$existe = $CI->spw_model->get_rows('visiteurs',array(
		'ipVis'=>$ipAdresse,
		'browser_oc'=>$user_browser_oc
	));


	$CI->db->trans_start();
	//Si existe déjà
	if($existe):
		//Infos visiteur
		foreach($existe as $visitor):
			$idVisitor = $visitor->idVis;
			$visiteVisitor = $visitor->visites;
			$lasteVisiteTime = $visitor->last_visite;
		endforeach;
		$newVisiteVisitor = $visiteVisitor++;

		//verivfier la difference de temps entre la derniere rechage de page et la nouvelle
		$diffTime = diffDate($maintenant, $lasteVisiteTime);
		$joursTotal = $diffTime->total_joures;
		//si supérieur ou egale à un jour
		if($joursTotal>=1):
			//Créer une nouvelle visite
			$dataAdd = array();
			$dataAdd['idVis'] = $idVisitor;
			$dataAdd['first_visite_time'] = $maintenant;
			$dataAdd['last_visite_time'] = $maintenant;
			$dataAdd['reference_link'] = $reference_link;
			$dataAdd['view_link'] = $user_link_view;
			$CI->spw_model->add_item('visites',$dataAdd);

			//Ajouter de 1 le nbre de visite
			$dataItem = array();
			$dataItem['visites'] = $newVisiteVisitor;
			$dataItem['last_visite'] = $maintenant;
			$CI->spw_model->update_item('visiteurs',$dataItem,array('idVis'=>$idVisitor));
		else:

			//Derniervisite
			$lasVisites = $CI->spw_model->get_last_row('visites',array('idVis'=>$idVisitor),'idViste');
			foreach($lasVisites as $lasVisites):
				$idLasVisites = $lasVisites->idViste;
			endforeach;

			//Modifier les last visite time
			$dataItemVisiteur['last_visite'] = $maintenant;
			$CI->spw_model->update_item('visiteurs',$dataItemVisiteur,array('idVis'=>$idVisitor));

			
			$dataItemVisite['last_visite_time'] = $maintenant;
			$CI->spw_model->update_item('visites',$dataItemVisite,array('idVis'=>$idVisitor, '	idViste'=>$idLasVisites));
			

		endif;

	else:

		//Creer un nouveau visiteur
		$dataAdd = array();
		$dataAdd['ipVis'] = $ipAdresse;
		$dataAdd['browser_oc'] = $user_browser_oc;
		$dataAdd['visites'] = 1;
		$dataAdd['dateCreate'] = $maintenant;
		$dataAdd['last_visite'] = $maintenant;
		$CI->spw_model->add_item('visiteurs',$dataAdd);
		$idVisitor = $CI->spw_model->last_id_insert('visiteurs');

		//Créer une nouvelle visite
		$dataAdd = array();
		$dataAdd['idVis'] = $idVisitor;
		$dataAdd['first_visite_time'] = $maintenant;
		$dataAdd['last_visite_time'] = $maintenant;
		$dataAdd['reference_link'] = $reference_link;
		$dataAdd['view_link'] = $user_link_view;
		$CI->spw_model->add_item('visites',$dataAdd);
	endif;
	$CI->db->trans_complete();


	return $CI->spw_model->sum_columns('visiteurs',array(),'visites');
}



?>