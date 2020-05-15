$(document).ready(function(){
	

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





/*
|--------------------------------------------------------------------------
| Boutique
|--------------------------------------------------------------------------
|
*/
//==>Ajouter nouvau Post
$('body').on('submit', 'form#newPostForm', function(e){
	e.preventDefault();

	var form = $(this);
	var btn = form.find('button[name="newPostBtn"]');

	actionAjaxStart(form,btn);

	var formData = new FormData(form[0]);
	var inputFile = form.find('input[name="file"]');
	var fileToUpload = inputFile[0].files[0];

  //console.log(fileToUpload);

  formData.append("file", fileToUpload);
  formData.append('ActiveAjax', 'newPost');

  $.ajax({
  	type: "POST",
  	url:  base_url+"clients/boutique",
  	data: formData,
  	processData: false,
  	contentType: false,
  	dataType: "json",
  	async: false,
  	success: function(data){
  		if(data.statut=='success'&&data.data.indexOf("http") !== -1){
  			document.location.href=data.data;
  		}else{
  			var btnText ='Poster';
  			var message = data.message;
  			actionAjaxError(form,btn,btnText,message);
  		}

  	},
  	error: function(data){
  		alert("Can not perform the upload action:" + JSON.stringify(data));
  	}
  });
});


//==>Update post
$('body').on('submit', 'form#updatePostForm', function(e){
	e.preventDefault();

	let form = $(this);
	let btn = form.find('button[name="updatePostBtn"]');

	actionAjaxStart(form,btn);

	var formData = new FormData(form[0]);


  formData.append('ActiveAjax', 'updatePost');

  $.ajax({
  	type: "POST",
  	url:  base_url+"clients/boutique",
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



/*
|--------------------------------------------------------------------------
| Forums
|--------------------------------------------------------------------------
|
*/
//==>Load comment forum
/*let urls = window.location.pathname;
let url = urls.split('/');
let urlHref = window.location.href;
console.log(url);
function ajax_load_last_comment_forum(idForum,offset)
{
	if(offset==0){
		$("#listCommentsForum").load(base_url+"clients/forums/ajax_load_last_comment_forum/"+idForum+"/"+offset);
		$('#listCommentsForum').animate({
			scrollTop: $("#listCommentsForum").offset().top
		}, 1000);
	}else{
		$("#listCommentsForum").find('.grp-row:first').load(base_url+"clients/forums/ajax_load_last_comment_forum/"+idForum+"/"+offset);
	}
	//setTimeout(ajax_load_last_comment_forum(idForum,offset),15000);
}



if(url[1]=='clients'&&url[2]=='forums'&&url[3]=='selection'){
	let idForum = url[4];
	ajax_load_last_comment_forum(idForum,0);
}


//si on scroll
$("#listCommentsForum").scroll(function(){
	let offset = parseInt($(this).attr('data-offset')) + 1;
	let Nivo_scroll = $(this).scrollTop();
	console.log(offset);
	if(Nivo_scroll==0){
		let idForum = url[4];
		$("#listCommentsForum").prepend('<div class="grp-row"></div>');
		ajax_load_last_comment_forum(idForum,offset);
		$(this).attr('data-offset', offset);
	}
});
*/

//==>Ajouter nouvau forum
$('body').on('submit', 'form#NewForumForm', function(e){
	e.preventDefault();

	let form = $(this);
	let btn = form.find('button[name="NewForumBtn"]');

	actionAjaxStart(form,btn);

	let formData = new FormData(form[0]);

	formData.append('ActiveAjax', 'newForum');

	$.ajax({
		type: "POST",
		url:  base_url+"clients/forums",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			if(data.statut=='success'&&data.data.indexOf("http") !== -1){
				document.location.href=data.data;
			}else{
				var btnText ='Poster';
				var message = data.message;
				actionAjaxError(form,btn,btnText,message);
			}

		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});
});

/*/==>commenter forum
$('body').on('keyup', '.js-edite', function(e){
	if(e.which==13){
		e.preventDefault();
		let input = $(this);
		let message = input.text();
		let idForum = input.attr('data-forum');
		if(message.length){
			var formData = new FormData();

			formData.append("message", message);
			formData.append('ActiveAjax', 'NewCommentaire');
			formData.append("message", message);

			$.ajax({
				type: "POST",
				url:  base_url+"clients/forums/selection/"+idForum,
				data: formData,
				processData: false,
				contentType: false,
				dataType: "json",
				async: false,
				success: function(data){
					if(data.statut=='success'&&data.data.indexOf("http") !== -1){
						document.location.href=data.data;
					}else{
						console(data.message);
					}

				},
				error: function(data){
					alert("Can not perform the upload action:" + JSON.stringify(data));
				}
			});


		}else{
			input.empty();
		}

		//console.log($(this).text());
	}

});*/








/*
|--------------------------------------------------------------------------
| Actualites
|--------------------------------------------------------------------------
|
*/
//==>Ajouter nouvau forum
$('body').on('submit', 'form#newActualiteForm', function(e){
	e.preventDefault();

	let form = $(this);
	let btn = form.find('button[name="newActualiteBtn"]');

	actionAjaxStart(form,btn);

	let formData = new FormData(form[0]);
	let inputFile = form.find('input[name="file"]');
	let fileToUpload = inputFile[0].files[0];

	formData.append("file", fileToUpload);
	formData.append('ActiveAjax', 'newActualite');

	$.ajax({
		type: "POST",
		url:  base_url+"clients/actualites",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			if(data.statut=='success'&&data.data.indexOf("http") !== -1){
				document.location.href=data.data;
			}else{
				let btnText ='Soumettre';
				let message = data.message;
				actionAjaxError(form,btn,btnText,message);
			}

		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});
});


//==>Desactiver actualite
$('body').on('submit', 'form#ChangeStatutForm[data-type="desactiver_actualite"]', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="ChangeStatutBtn"]');

	actionAjaxStart(form,btn);
	let formData = new FormData(form[0]);

	formData.append('ActiveAjax', 'changeStatut');
	formData.append('table', 'actualites');
	formData.append('idNane', 'idAct');
	formData.append('newStatut', 4);
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



//==>Modifier actualite
$('body').on('submit', 'form#modifierActualiteForm', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="odifierActualiteBtn"]');

	actionAjaxStart(form,btn);
	
	let formData = new FormData(form[0]);
	let inputFile = form.find('input[name="file"]');
	let fileToUpload = inputFile[0].files[0];

	formData.append("file", fileToUpload);
	formData.append('ActiveAjax', 'modifierActualite');

	$.ajax({
		type: "POST",
		url:  base_url+"clients/actualites/modifier_actualite/"+url[4],
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			if(data.statut=='success'&&data.data.indexOf("http") !== -1){
				document.location.href=data.data;
			}else{
				let btnText ='Soumettre';
				let message = data.message;
				actionAjaxError(form,btn,btnText,message);
			}

		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});
});




/*
|--------------------------------------------------------------------------
| Repetieurs
|--------------------------------------------------------------------------
|
*/
//==>Start Repetiteur
$('body').on('submit', 'form#startRepetiteurForm', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="startRepetiteurBtn"]');

	actionAjaxStart(form,btn);
	let formData = new FormData(form[0]);

	formData.append('ActiveAjax', 'startRepetiteur');
	formData.append('Returnlink', urlHref);
	

	$.ajax({
		type: "POST",
		url:  base_url+"clients/repetiteur",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			if(data.statut=='success'&&data.data.indexOf("http") !== -1){
				document.location.href=data.data;
			}else{
				let btnText ='Valider';
				let message = data.message;
				actionAjaxError(form,btn,btnText,message);
			}

		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});/**/
});


//==>Add new Matiere
$('body').on('submit', 'form#newMatierRepetiteurForm', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="newMatierRepetiteurBtn"]');

	actionAjaxStart(form,btn);
	let formData = new FormData(form[0]);

	formData.append('ActiveAjax', 'newMatierRepetiteur');
	formData.append('Returnlink', urlHref);
	

	$.ajax({
		type: "POST",
		url:  base_url+"clients/repetiteur",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			if(data.statut=='success'&&data.data.indexOf("http") !== -1){
				document.location.href=data.data;
			}else{
				let btnText ='Ajouter';
				let message = data.message;
				actionAjaxError(form,btn,btnText,message);
			}

		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});/**/
});











});//END DOCUMENT
