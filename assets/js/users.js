$(document).ready(function(){
	/*
	| $('#email').val().replace(/ /g,""); //permet de remplacer tous les espaces (et uniquement les espaces)
	| $('#email').val().replace(/\s/g,""); //permet de rempalcer tous les caractères 'blanc' (ceux que j'ai cités précédemment)
	|	var nText = text.trim(); //vaut "exemple de texte"
	|
	|
	*/

/*
|--------------------------------------------------------------------------
| Générale
|--------------------------------------------------------------------------
|
*/
//==>
let base_url = window.location.protocol + "//" +window.location.host+"/";

//==>
let urls = window.location.pathname;
let url = urls.split('/');
let urlHref = window.location.href;
let urlSearch = window.location.search;
//console.log(window.location); 


//==>
function actionAjaxStart(form,btn){
	btn.prop("disabled", true);
	btn.html('Chargement... <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>');
}
function actionAjaxError(form,btn,btnText,message){
	form.find(".js-alert").remove();
	form.append('<div class="form-alert js-alert">'+message+'</div>');
	btn.html(btnText);
	btn.prop("disabled", false);
}
function actionAjaxInit(form,btn,btnText){
	form.find(".js-alert").remove();
	btn.html(btnText);
	btn.prop("disabled", false);
}



//==>StandarAjaxScript
function StandarAjaxScript(url,formData,btnText,form,btn)
{
	$.ajax({
		type: "POST",
		url:  url,
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			if(data.statut=='success'&&data.data.indexOf("http") !== -1){
				document.location.href=data.data;
			}else{
				let message = data.message;
				actionAjaxError(form,btn,btnText,message);
			}
		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});
}


//==>updateStatut
function updateStatut(form,btn,table,idNane,urlHref){
	let typeForm = form.attr('data-type');
	let newStatut = 0;
	if(typeForm=='Activer-'+table){
		newStatut = 2;
	}
	if(typeForm=='Regeter-'+table){
		newStatut = 3;
	}
	if(typeForm=='Bloquer-'+table){
		newStatut = 0;
	}
	if(typeForm=='Desactiver-'+table){
		newStatut = 4;
	}

	actionAjaxStart(form,btn);
	let formData = new FormData(form[0]);

	formData.append('ActiveAjax', 'changeStatut');
	formData.append('table', table);
	formData.append('idNane', idNane);
	formData.append('newStatut', newStatut);
	formData.append('Returnlink', urlHref);
	StandarAjaxScript(base_url+"spw/ajax",formData,'Oui',form,btn);
}




/*
|--------------------------------------------------------------------------
| Concours
|--------------------------------------------------------------------------
|
*/
//=>0: Load view concours
function loadZoneConcours(){
	$('body').find('#zoneConcours').empty().load(base_url+'users/concours/load_concours_encours'+urlSearch);
}
loadZoneConcours();

//=>1: Start concours
$('body').on('submit', 'form#startConcoursForm', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="startConcoursBtn"]');
	actionAjaxStart(form,btn);
	let formData = new FormData(form[0]);
	formData.append('ActiveAjax', 'startConcours');
	formData.append('Returnlink', urlHref);
	StandarAjaxScript(urlHref,formData,'Oui',form,btn);
});



//=>2: Destory concours
$('body').on('submit', 'form#destoryConcoursForm', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="destoryConcoursBtn"]');
	actionAjaxStart(form,btn);
	let formData = new FormData(form[0]);
	formData.append('ActiveAjax', 'destoryConcours');
	formData.append('Returnlink', urlHref);
	StandarAjaxScript(urlHref,formData,'Oui',form,btn);
});

//=>3: Load zoneTimeEcouler
function loadZoneTimeEcouler(){
	$('body').on('click', '#zoneTimeEcouler', function(e){
		$('body').find('#zoneTimeEcouler').empty().load(base_url+'users/concours/time_elapsed');
	});
	$('body').find('#zoneTimeEcouler').trigger('click');
	setTimeout(loadZoneTimeEcouler,1000);
}
loadZoneTimeEcouler();



//=>4: ConcourPlay
$('body').on('submit', 'form#playConcoursForm', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="playConcoursBtn"]');
	let block = $('body').find('.js-active-question-reponse');
	let ideQuestionActive = Number(block.attr('data-q'));
	let ideReponsChoisir = block.find('input[type="radio"]:checked').val();
	

	if(ideQuestionActive&ideReponsChoisir){
		actionAjaxStart(form,btn);
		let formData = new FormData(form[0]);
		formData.append('ideQuestionActive', ideQuestionActive);
		formData.append('ideReponsChoisir', ideReponsChoisir);
		formData.append('ActiveAjax', 'playConcours');
		formData.append('Returnlink', urlHref);
		
		$.ajax({
		type: "POST",
		url:  urlHref,
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
loadZoneConcours();
			/*f(data.statut=='success'){
				if(data.data.indexOf("http") !== -1){
					document.location.href=data.data;
				}else{
					
				}
				
			}else{
				let message = data.message;
				actionAjaxError(form,btn,btnText,message);
			}*/
			
		},
		error: function(data){
			console.log("Can not perform the upload action:" + JSON.stringify(data));
		}
	});

	}else{
		let btnText ='Suivant';
		let message = 'Vous n\'aviez pas choisir de reponse!!!';
		actionAjaxError(form,btn,btnText,message);
	}
	
});













});//END DOCUMENT