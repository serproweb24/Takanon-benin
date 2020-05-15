$(document).ready(function(){
	var base_url = window.location.protocol + "//" +window.location.host+"/"; 

/*
|--------------------------------------------------------------------------
| Générale
|--------------------------------------------------------------------------
|
*/
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


/*-------*/
//==>Load comment forum
let urls = window.location.pathname;
let url = urls.split('/');
let urlHref = window.location.href;



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

	$.ajax({
		type: "POST",
		url:  base_url+"spw/ajax",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			if(data.statut=='success'&&data.data.indexOf("http") !== -1){
				document.location.href=data.data;
			}else{
				let btnText ='Oui';
				let message = data.message;
				actionAjaxError(form,btn,btnText,message);
			}

		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});
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
/*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
|
*/
//==>Changement de statut d'utilisateur
$('body').on('submit', 'form#ChangeStatutForm[data-type$="-users"]', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="ChangeStatutBtn"]');

	updateStatut(form,btn,'users','idUse',urlHref);
});







/*
|--------------------------------------------------------------------------
| Article
|--------------------------------------------------------------------------
|
*/
//==>Start Repetiteur

//==>Changement de statut actualite
$('body').on('submit', 'form#ChangeStatutForm[data-type$="-artilce"]', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="ChangeStatutBtn"]');

	let typeForm = form.attr('data-type');
	let newStatut = 0;
	if(typeForm=='valider-artilce'){
		newStatut = 2;
	}
	if(typeForm=='rejeter-artilce'){
		newStatut = 3;
	}
	if(typeForm=='bloquer-artilce'){
		newStatut = 0;
	}


	actionAjaxStart(form,btn);
	let formData = new FormData(form[0]);

	formData.append('ActiveAjax', 'changeStatut');
	formData.append('table', 'articles');
	formData.append('idNane', 'idArt');
	formData.append('newStatut', newStatut);
	formData.append('Returnlink', urlHref);
	

	$.ajax({
		type: "POST",
		url:  base_url+"spw/ajax",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			if(data.statut=='success'&&data.data.indexOf("http") !== -1){
				document.location.href=data.data;
			}else{
				let btnText ='Oui';
				let message = data.message;
				actionAjaxError(form,btn,btnText,message);
			}

		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});/**/
});




/*
|--------------------------------------------------------------------------
| Forum
|--------------------------------------------------------------------------
|
*/
//==>Changement de statut forum
$('body').on('submit', 'form#ChangeStatutForm[data-type$="-forum"]', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="ChangeStatutBtn"]');

	let typeForm = form.attr('data-type');
	let newStatut = 0;
	if(typeForm=='Activer-forum'){
		newStatut = 2;
	}
	if(typeForm=='Regeter-forum'){
		newStatut = 3;
	}
	if(typeForm=='Fermer-forum'){
		newStatut = 0;
	}


	actionAjaxStart(form,btn);
	let formData = new FormData(form[0]);

	formData.append('ActiveAjax', 'changeStatut');
	formData.append('table', 'forums');
	formData.append('idNane', 'idFor');
	formData.append('newStatut', newStatut);
	formData.append('Returnlink', urlHref);
	

	$.ajax({
		type: "POST",
		url:  base_url+"spw/ajax",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			if(data.statut=='success'&&data.data.indexOf("http") !== -1){
				document.location.href=data.data;
			}else{
				let btnText ='Oui';
				let message = data.message;
				actionAjaxError(form,btn,btnText,message);
			}

		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});/**/
});



/*
|--------------------------------------------------------------------------
| Actualités
|--------------------------------------------------------------------------
|
*/
//==>Changement de statut d'actualités
$('body').on('submit', 'form#ChangeStatutForm[data-type$="-actualites"]', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="ChangeStatutBtn"]');

	updateStatut(form,btn,'actualites','idAct',urlHref);
});


//==>Modifier la période de publication
$('body').on('submit', 'form#periodePubForm[data-type$="actualites"]', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="periodePubBtn"]');
	actionAjaxStart(form,btn);

	let formData = new FormData(form[0]);

	formData.append('ActiveAjax', 'periodePub');
	formData.append('Returnlink', urlHref);
	
	$.ajax({
		type: "POST",
		url:  base_url+"admin/actualites",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			if(data.statut=='success'&&data.data.indexOf("http") !== -1){
				document.location.href=data.data;
			}else{
				let btnText ='Modifier';
				let message = data.message;
				actionAjaxError(form,btn,btnText,message);
			}

		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});/**/
});



/*
|--------------------------------------------------------------------------
| Repétiteur
|--------------------------------------------------------------------------
|
*/
//==>Changement de statut répétiteur
$('body').on('submit', 'form#ChangeStatutForm[data-type$="-repetiteurs"]', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="ChangeStatutBtn"]');

	updateStatut(form,btn,'repetiteurs','idRep',urlHref);
});



/*
|--------------------------------------------------------------------------
| Messages
|--------------------------------------------------------------------------
|
*/
//==>Changement de statut des messages
$('body').on('submit', 'form#ChangeStatutForm[data-type$="-messages"]', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="ChangeStatutBtn"]');

	updateStatut(form,btn,'messages','idMes',urlHref);
});



/*
|--------------------------------------------------------------------------
| Aides
|--------------------------------------------------------------------------
|
*/
//==>Ajouter nouvelle aides
$('body').on('submit', 'form#newAideForm', function(e){
	e.preventDefault();

	let form = $(this);
	let btn = form.find('button[name="newAideBtn"]');

	actionAjaxStart(form,btn);

	let formData = new FormData(form[0]);
	formData.append('ActiveAjax', 'newAide');

	$.ajax({
		type: "POST",
		url:  base_url+"admin/aides",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			if(data.statut=='success'&&data.data.indexOf("http") !== -1){
				document.location.href=data.data;
			}else{
				var btnText ='Ajouter';
				var message = data.message;
				actionAjaxError(form,btn,btnText,message);
			}

		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});/**/
});


//==>Update aide
$('body').on('submit', 'form#updateAideForm', function(e){
	e.preventDefault();

	let form = $(this);
	let btn = form.find('button[name="updateAideBtn"]');

	actionAjaxStart(form,btn);

	var formData = new FormData(form[0]);


	formData.append('ActiveAjax', 'updateAide');

	$.ajax({
		type: "POST",
		url:  base_url+"admin/aides",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			if(data.statut=='success'&&data.data.indexOf("http") !== -1){
				document.location.href=data.data;
  			//console.log(data.data);
  		}else{
  			let btnText ='Modifier';
  			let message = data.message;
  			actionAjaxError(form,btn,btnText,message);
  		}

  	},
  	error: function(data){
  		alert("Can not perform the upload action:" + JSON.stringify(data));
  	}
  });
});


//==>Changement de statut de l'aide
$('body').on('submit', 'form#ChangeStatutForm[data-type$="-aides"]', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="ChangeStatutBtn"]');
	updateStatut(form,btn,'aides','idAid',urlHref);
});



/*
|--------------------------------------------------------------------------
| Questions
|--------------------------------------------------------------------------
|
*/
//==>Ajouter nouvelle question
$('body').on('submit', 'form#newQuestionForm', function(e){
	e.preventDefault();

	let form = $(this);
	let btn = form.find('button[name="newQuestionBtn"]');

	actionAjaxStart(form,btn);

	var formData = new FormData(form[0]);


	formData.append('ActiveAjax', 'newQuestion');
	formData.append('Returnlink', urlHref);

	url = base_url+"admin/questions";
	btnText = 'Ajouter';
	StandarAjaxScript(url,formData,btnText,form,btn);

});


//==>Modifier une question
$('body').on('submit', 'form#updateQuestionForm', function(e){
	e.preventDefault();

	let form = $(this);
	let btn = form.find('button[name="updateQuestionBtn"]');

	actionAjaxStart(form,btn);

	var formData = new FormData(form[0]);


	formData.append('ActiveAjax', 'updateQuestion');
	formData.append('Returnlink', urlHref);

	url = base_url+"admin/questions";
	btnText = 'Modifier';
	StandarAjaxScript(url,formData,btnText,form,btn);


});





//==>Ajouter nouvelle reponse
$('body').on('submit', 'form#newReponsesForm', function(e){
	e.preventDefault();

	let form = $(this);
	let btn = form.find('button[name="newReponsesBtn"]');

	actionAjaxStart(form,btn);

	var formData = new FormData(form[0]);


	formData.append('ActiveAjax', 'newReponses');
	formData.append('Returnlink', urlHref);

	url = base_url+"admin/questions";
	btnText = 'Ajouter';
	StandarAjaxScript(url,formData,btnText,form,btn);


});






/*
|--------------------------------------------------------------------------
| Concours
|--------------------------------------------------------------------------
|
*/
//==>Ajouter nouveau concours
$('body').on('submit', 'form#newConcoursForm', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="newConcoursBtn"]');
	actionAjaxStart(form,btn);
	var formData = new FormData(form[0]);
	formData.append('ActiveAjax', 'newConcours');
	formData.append('Returnlink', urlHref);
	url = base_url+"admin/concours";
	btnText = 'Créer';
	StandarAjaxScript(url,formData,btnText,form,btn);
});

//==>Update concours
$('body').on('submit', 'form#updateConcoursForm', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="updateConcoursBtn"]');
	actionAjaxStart(form,btn);
	var formData = new FormData(form[0]);
	formData.append('ActiveAjax', 'updateConcours');
	formData.append('Returnlink', urlHref);
	url = base_url+"admin/concours";
	btnText = 'Modifier';
	StandarAjaxScript(url,formData,btnText,form,btn);
});


//==>Ajouter nouvelle question
$('body').on('submit', 'form#newQuestionConcoursForm', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="newQuestionConcoursBtn"]');
	actionAjaxStart(form,btn);
	var formData = new FormData(form[0]);
	formData.append('ActiveAjax', 'newQuestionConcours');
	formData.append('Returnlink', urlHref);
	url = base_url+"admin/concours";
	btnText = 'Ajouter';
	StandarAjaxScript(url,formData,btnText,form,btn);
});


//==>Changement de statut de question du concours
$('body').on('submit', 'form#ChangeStatutForm[data-type$="-concours_content"]', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="ChangeStatutBtn"]');
	updateStatut(form,btn,'concours_content','idConCont',urlHref);
});


//==>Modifier periode du concours
$('body').on('submit', 'form#updatePeriodeConcoursForm', function(e){
	e.preventDefault();

	let form = $(this);
	let btn = form.find('button[name="updatePeriodeConcoursBtn"]');

	actionAjaxStart(form,btn);

	var formData = new FormData(form[0]);


	formData.append('ActiveAjax', 'updatePeriodeConcours');
	formData.append('Returnlink', urlHref);

	url = base_url+"admin/concours";
	btnText = 'Modifier';
	StandarAjaxScript(url,formData,btnText,form,btn);

});












});//END DOCUMENT