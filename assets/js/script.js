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


/*
|--------------------------------------------------------------------------
| Générale
|--------------------------------------------------------------------------
|
*/
//Slick etablicement
$('.js-slick-1').slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	arrows: false,
	dots:true,
	fade: false,
	autoplay:true
});

//==js-ctr-CatNiv=>
$('body').find('.js-ctr-CatNiv').each(function(){
	let parent = $(this);
	let selectCat = parent.find('.js-ctr-Cat');
	parent.find('select').not('.js-ctr-Cat').prop('disabled', true);

	//Si categorie à une valeur par defaut
	if(selectCat.val()&&selectCat.val().length){
		ChangeCategorie(selectCat);
		//console.log(selectCat.val());
	}
	
	

});

function ChangeCategorie(categorie){
	var idCatArt = categorie.val();

	//var niveau = categorie.closest('.js-ctr-CatNiv').find('.js-ctr-Niv');
	var niveau = categorie.closest('.js-ctr-CatNiv').find('.js-ctr-Niv');
	var matiere = categorie.closest('.js-ctr-CatNiv').find('.js-ctr-Mat');
	var annee = categorie.closest('.js-ctr-CatNiv').find('.js-ctr-Ann');

	niveau.prop('disabled', true);
	matiere.prop('disabled', true);

	if(idCatArt.length){
		var formData = new FormData();
		formData.append("ActiveAjax", 'SelectedNiveau');
		formData.append("idCatArt", idCatArt);

		$.ajax({
			type: "POST",
			url:  base_url+"spw/ajax",
			data: formData,
			processData: false,
			contentType: false,
			dataType: "json",
			async: false,
			success: function(data){
				niveau.empty().append(data.data).prop('disabled', false);
			},
			error: function (data) {
				alert("Can not perform the upload action:" + JSON.stringify(data));
			}
		});
	}else{
		niveau.empty().append('<option  value="">---- Choisir le niveau ----</option>').prop('disabled', true);
	}
}

$('body').on('change', 'select.js-ctr-Cat', function(e){
	e.preventDefault();
	var categorie = $(this);
	ChangeCategorie(categorie);
});

//==js-ctr-CatNiv=> Change Niveau
$('body').on('change', 'select.js-ctr-Niv', function(e){
	e.preventDefault();
	var niveau = $(this);
	var idNiv = niveau.val();
	var matiere = niveau.closest('.js-ctr-CatNiv').find('.js-ctr-Mat');
	if(idNiv.length){
		matiere.prop('disabled', false);
	}else{
		matiere.prop('disabled', true);
	}
});

//==js-ctr-CatNiv=> Change Matiere
$('body').on('change', 'select.js-ctr-Mat', function(e){
	e.preventDefault();
	var matiere = $(this);
	var idMat = matiere.val();
	var annee = matiere.closest('.js-ctr-CatNiv').find('.js-ctr-Ann');
	if(idMat.length){
		annee.prop('disabled', false);
	}else{
		annee.prop('disabled', true);
	}
});


//==js-ctr-CatNiv=> Change Annee
$('body').on('change', 'select.js-ctr-Ann', function(e){
	e.preventDefault();
	var annee = $(this);
	var idAnn = annee.val();
	if(idAnn.length){
		annee.prop('disabled', false);
	}else{
		annee.prop('disabled', true);
	}
});


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
| Register
|--------------------------------------------------------------------------
|
*/
var essaie = 0;

function registerUserData(form,ActiveAjax){
	var nom = form.find('input[name="nom"]').val();
	var prenoms = form.find('input[name="prenoms"]').val();
	var idUseCat = form.find('select[name="idUseCat"]').val();
	var telephone = form.find('input[name="telephone"]').val();
	var email = form.find('input[name="email"]').val();
	var password = form.find('input[name="password"]').val();

	var formData = new FormData();

	formData.append("ActiveAjax", ActiveAjax);
	formData.append("nom", nom);
	formData.append("prenoms", prenoms);
	formData.append("idUseCat", idUseCat);
	formData.append("telephone", telephone);
	formData.append("email", email);
	formData.append("password", password);
	return formData;
}

$('body').on('submit', 'form#registerForm', function(e){
	e.preventDefault();


	var form = $(this);
	var btn = form.find('button[name="registerBtn"]');
	var step = btn.attr('data-step');
	

	if(step==1){

		actionAjaxStart(form,btn);


		var formData = new FormData();

		var nom = form.find('input[name="nom"]').val();
		var prenoms = form.find('input[name="prenoms"]').val();
		var idUseCat = form.find('select[name="idUseCat"]').val();
		var telephone = form.find('input[name="telephone"]').val();
		var email = form.find('input[name="email"]').val();
		var password = form.find('input[name="password"]').val();
		//console.log(nom+'...'+prenoms+'...'+idUseCat+'...'+telephone+'...'+email+'...'+password)
		if(nom.length>0&&prenoms.length>0&&idUseCat.length>0&&telephone.length>0&&telephone!='+(22_) __-__-__-__'&&email.length>0&&password.length>0){

			formData.append("ActiveAjax", 'registerForm');
			formData.append("nom", nom);
			formData.append("nom", prenoms);
			formData.append("idUseCat", idUseCat);
			formData.append("telephone", telephone);
			formData.append("email", email);
			formData.append("password", password);
			formData.append("step", 1);

			$.ajax({
				type: "POST",
				url:  base_url+"spw",
				data: formData,
				processData: false,
				contentType: false,
				dataType: "json",
				async: false,
				success: function(data){


					if(data.statut=='success'){

						$('body').attr('data-v', data.data);

						actionAjaxInit(form,btn,'Confirmer');

						form.find('.js-step-1').slideUp('slow');
						form.closest('.poPup').find('.poPup-head-title .title').empty().text('Validation d\'inscription');


						$contentStep2 = `
						<div class="register-step-2-content">
						<div class="register-step-2-head">
						Votre code de validation a été envoyé au numéro <strong>${telephone}</strong> et au email <strong>${email}</strong>.
						</div>
						<div class="i-form-row">
						<div class="i-placeholder">Code de validation<span class="red-stars">*</span></div>
						<input type="text" name="codeValidation" required>
						</div>
						<div class="register-step-2-bottom">
						<a href="#" class="i-link js-resend-code">Me renvoyé le code de validation</a>
						</div>
						</div>
						`;

						form.find('.js-step-2').append($contentStep2);
						btn.attr('data-step', 2);
					}else{
						var btnText ='S\'inscrir';
						var message = data.message;
						actionAjaxError(form,btn,btnText,message);
					}
				},
				error: function (data) {
					alert("Can not perform the upload action:" + JSON.stringify(data));
				}
			});


		}else{
			var btnText = 'S\'inscrir';
			var message = 'Veuillez renseigner  tous les champs.';
			actionAjaxError(form,btn,btnText,message);
		}

	}else{

		if(step==2){
			var codeValidation = 	$('body').attr('data-v');
			var userCode = form.find('input[name="codeValidation"]').val();
			actionAjaxStart(form,btn);

			if(userCode.length==6){
				if(userCode==codeValidation){
					//Enregistrer le user
					var formData = registerUserData(form,'saveUser');

					$.ajax({
						type: "POST",
						url:  base_url+"spw",
						data: formData,
						processData: false,
						contentType: false,
						dataType: "json",
						async: false,
						success: function(data){
								//alerter
								form.closest('.poPup').find('.poPup-head-title .title').empty().text('Felicitation !!!');
								var successContent = `
								<div class="i-formAlertContent">
								<div class="i-formAlertContent-head text-center">
								<p>
								<h3>Votre compte a été enrégistré avec success!!!</h3>
								</p>
								<P>Vous pouvez vous <a href="#login" class='i-link js-open-poPup'>connecter</a></P>
								</div>
								</div>
								`;
								form.replaceWith(successContent);
							},
							error: function(data){
								alert("Can not perform the upload action:" + JSON.stringify(data));
							}

						});


				}else{
					essaie++;
					console.log(essaie);
					if(essaie<3){
						var btnText ='Confirmer';
						var message = 'Votre code est incorrect !!!';
						actionAjaxError(form,btn,btnText,message);
					}else{
						var formData = registerUserData(form,'saveUser');
						//Enregistrer les infos du pirate
						$.ajax({
							type: "POST",
							url:  base_url+"spw",
							data: formData,
							processData: false,
							contentType: false,
							dataType: "json",
							async: false,
							success: function(data){
								//alerter
								form.closest('.poPup').find('.poPup-head-title .title').empty().text('Compte bloqué pour tentative de piratage');
								var piratageContent = `
								<div class="piratageContent">
								<div class="piratageContent-head text-center">
								<p>
								Vous aviez épuisé les (03) trois essaies autorisés pour la validation de la création de votre compte!
								</p>
								<P>Pour des raisons de sécurité, votre numéro <strong class="text-red">${telephone}</strong> a été blocqué.</P>
								<p>Veuillez renseigner contacter notre service techique pour plus d'informations.</p>
								</div>
								</div>
								`;
								form.replaceWith(piratageContent);
							},
							error: function(data){
								alert("Can not perform the upload action:" + JSON.stringify(data));
							}

						});
					}

					
				}
			}else{
				var btnText ='Confirmer';
				var message = 'Votre code est erroné !!!';
				actionAjaxError(form,btn,btnText,message);
			}
			
		}
	}

});


/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
|
*/
$('body').on('submit', 'form#loginForm', function(e){
	e.preventDefault();

	var form = $(this);
	var btn = form.find('button[name="loginBtn"]');

	var telephone = form.find('input[name="telephone"]').val();
	var password = form.find('input[name="password"]').val();

	if(telephone.length&&password.length){

		actionAjaxStart(form,btn);

		var formData = new FormData();

		formData.append("ActiveAjax", 'loginForm');
		formData.append("telephone", telephone);
		formData.append("password", password);

		$.ajax({
			type: "POST",
			url:  base_url+"spw",
			data: formData,
			processData: false,
			contentType: false,
			dataType: "json",
			async: false,
			success: function(data){
				if(data.statut=='success'&&data.data.indexOf("http") !== -1){
					document.location.href=data.data;
				}else{
					var btnText ='Se connecter';
					var message = data.message;
					actionAjaxError(form,btn,btnText,message);
				}
			},
			error: function(data){
				alert("Can not perform the upload action:" + JSON.stringify(data));
			}

		});

	}else{
		var btnText ='Se connecter';
		var message = 'Veuillez  renseigner tous les champs.';
		actionAjaxError(form,btn,btnText,message);
	}
});


/*
|--------------------------------------------------------------------------
| Foget password
|--------------------------------------------------------------------------
|
*/
//==>Step 1
$('body').on('submit', 'form#forget_passForm[data-step="1"]', function(e){
	e.preventDefault();

	let form = $(this);
	let btn = form.find('button[name="forget_passBtn"]');
	actionAjaxStart(form,btn);

	let email = form.find('input[name="email"]').val();
	

	if(email&&email.length){
		let formData = new FormData(form[0]);

		formData.append("ActiveAjax", 'forgetPass');

		$.ajax({
			type: "POST",
			url:  base_url+"spw",
			data: formData,
			processData: false,
			contentType: false,
			dataType: "json",
			async: false,
			success: function(data){
				if(data.statut=='success'){
					form.find('.js-step-1').slideUp('slow').remove();
					form.closest('.poPup').find('.poPup-head-title .title').empty().text('Validation code');

					$contentStep2 = `
					<div class="js-step-2">
					<div class="text-center">Un code de validation vous à été envoyé à votre adresse email</div>
					<div class="i-form-row">
					<div class="i-placeholder">Code de validation <span class="red-stars">*</span></div>
					<input type="text" name="code"  required>
					</div>
					</div>
					`;

					form.prepend($contentStep2);
					form.attr('data-step', 2);

					let btnText ='Valider';
					actionAjaxInit(form,btn,btnText);

				}else{
					let btnText ='Suivant';
					let message = data.message;
					actionAjaxError(form,btn,btnText,message);
				}
			},
			error: function(data){
				alert("Can not perform the upload action:" + JSON.stringify(data));
			}

		});


	}else{
		var btnText ='Suivant';
		var message = 'Veuillez renseigner votre email.';
		actionAjaxError(form,btn,btnText,message);
	}
});

//==>Step 2
$('body').on('submit', 'form#forget_passForm[data-step="2"]', function(e){
	e.preventDefault();

	let form = $(this);
	let btn = form.find('button[name="forget_passBtn"]');
	actionAjaxStart(form,btn);

	let code = form.find('input[name="code"]').val();

	if(code&&code.length){
		let formData = new FormData(form[0]);

		formData.append("ActiveAjax", 'forgetPassValidation');

		$.ajax({
			type: "POST",
			url:  base_url+"spw",
			data: formData,
			processData: false,
			contentType: false,
			dataType: "json",
			async: false,
			success: function(data){
				if(data.statut=='success'){
					form.find('.js-step-2').slideUp('slow').remove();
					form.closest('.poPup').find('.poPup-head-title .title').empty().text('Nouveau mot de passe');

					$contentStep3 = `
					<div class="js-step-3">
					<div class="x2">
					<div class="i-form-row x2-elem">
					<div class="i-placeholder">Nouveau mot de passe <span class="red-stars">*</span></div>
					<div class="block-password">
					<input type="password" name="password" class="password" minlength="8" required>
					<a href="#" class="block-password-show js-show-password"><i class="fas fa-eye"></i></a>
					</div>
					</div>
					<div class="i-form-row x2-elem">
					<div class="i-placeholder">Confirmer le mot de passe <span class="red-stars">*</span></div>
					<div class="block-password">
					<input type="password" name="password-repeat"  class="password-repeat" required>
					<a href="#" class="block-password-show js-show-password"><i class="fas fa-eye"></i></a>
					</div>
					</div>
					</div>
					</div>
					`;

					form.prepend($contentStep3);
					form.attr('data-step', 3);

					let btnText ='Valider';
					actionAjaxInit(form,btn,btnText);

				}else{
					let btnText ='Suivant';
					let message = data.message;
					actionAjaxError(form,btn,btnText,message);
				}
			},
			error: function(data){
				alert("Can not perform the upload action:" + JSON.stringify(data));
			}

		});


	}else{
		var btnText ='Suivant';
		var message = 'Veuillez renseigner le code de validation.';
		actionAjaxError(form,btn,btnText,message);
	}
});

//==>Step3
$('body').on('submit', 'form#forget_passForm[data-step="3"]', function(e){
	e.preventDefault();

	let form = $(this);
	let btn = form.find('button[name="forget_passBtn"]');
	actionAjaxStart(form,btn);

	let password = form.find('input[name="password"]').val();

	if(password&&password.length){
		let formData = new FormData(form[0]);

		formData.append("ActiveAjax", 'forgetPassUpdatePass');

		$.ajax({
			type: "POST",
			url:  base_url+"spw",
			data: formData,
			processData: false,
			contentType: false,
			dataType: "json",
			async: false,
			success: function(data){
				if(data.statut=='success'){
					form.find('.js-step-3, .i-form-bottom').slideUp('slow').remove();
					form.closest('.poPup').find('.poPup-head-title .title').empty().text('Nouveau mot de passe');

					$contentStep4 = `
					<div class="js-step-4">
					<div class="text-center"> <stron class="text-green">Félicitation! </stron> Votre mot de passe a été bien modier!</div>
					<div class="text-center">Vous pouvez à présent vous 
					<a href="#login" class="i-link js-open-poPup">Connecter</a></div>
					</div>
					`;

					form.prepend($contentStep4);
					form.attr('data-step', 4);

					let btnText ='Valider';
					actionAjaxInit(form,btn,btnText);

				}else{
					let btnText ='Valider';
					let message = data.message;
					actionAjaxError(form,btn,btnText,message);
				}
			},
			error: function(data){
				alert("Can not perform the upload action:" + JSON.stringify(data));
			}

		});


	}else{
		var btnText ='Suivant';
		var message = 'Veuillez renseigner le code de validation.';
		actionAjaxError(form,btn,btnText,message);
	}
});


/*
|--------------------------------------------------------------------------
| Mobile Menu
|--------------------------------------------------------------------------
|
*/
$('body').on('click', '.js-open-user-menu', function(e){
	e.preventDefault();
	$(this).toggleClass('open');
});






/*
|--------------------------------------------------------------------------
|	Client => Boutique
|--------------------------------------------------------------------------
|

//==>Modifier Post
$('body').on('click', '.js-upPost', function(e){
	e.preventDefault();
	let add = $(this).attr('href');
	let categorie = $(add).find('select[name="idArtCar"]');
	ChangeCategorie(categorie);
	
});*/










/*
|--------------------------------------------------------------------------
| Ticket
|--------------------------------------------------------------------------
|
*/


/*$('.js-list-content-post').animate({
	scrollTop: $(".js-list-content-post").offset().top
}, 1000);
*/

//==>commenter forum
$('body').on('keyup', '.js-edite-message', function(e){
	let input = $(this);
	let message = input.text();

	if(e.which==13){
		e.preventDefault();
		if(message.length){
			var formData = new FormData();

			formData.append("message", message);
			formData.append('ActiveAjax', 'NewCommentaire');
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

	}

});






/*===========================================*\
-------------------Contacts--------------------
\*===========================================*/
//==>Nouveau message
$('body').on('submit', 'form#newMessageForm', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="newMessageBtn"]');

	actionAjaxStart(form,btn);
	let formData = new FormData(form[0]);

	formData.append('ActiveAjax', 'newMessage');

	$.ajax({
		type: "POST",
		url:  base_url+"contacts",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			console.log(data);
			if(data.statut=='success'){
				//document.location.href=data.data;
				form.after(data.message).slideUp('slow');

			}else{
				let btnText ='Envoyer';
				let message = data.message;
				actionAjaxError(form,btn,btnText,message);
			}

		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});
});





/*=================================================*\
----------------------Articles-----------------------
\*=================================================*/

$('body').on('submit', 'form#searchArticlesForm', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="searchArticlesBtn"]');
	actionAjaxStart(form,btn);

	let formData = new FormData(form[0]);
	formData.append('ActiveAjax', 'searchArticle');
	$.ajax({
		type: "POST",
		url:  base_url+"spw",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			console.log(data);
			if(data.statut=='success'){
				document.location.href=data.data;
			}else{
				let btnText ='Trouver';
				let message = data.message;
				actionAjaxError(form,btn,btnText,message);
			}
		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});
});


//===Cart => Load
function loadCart(){
	$('body').find('.js-cart-view').empty().load(base_url+"spw/load_cart");
}
function countContentCart(){
	$('body').find('.js-countArt').empty().load(base_url+"spw/total_art_in_cart");
}
loadCart();
countContentCart();




//===Cart => Add Prodoct
$('body').on('submit', 'form#PreviewDocForm', function(e){
	e.preventDefault();
	let form = $(this);
	let btn = form.find('button[name="add-in-cartBtn"]');
	actionAjaxStart(form,btn);

	let formData = new FormData(form[0]);
	formData.append('ActiveAjax', 'addNewArtInCart');
	formData.append('Returnlink', urlHref);
	$.ajax({
		type: "POST",
		url:  base_url+"spw",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			console.log(data);
			if(data.statut=='success'){
				document.location.href=data.data;
			}else{
				let btnText ='Ajouter au panier';
				let message = data.message;
				actionAjaxError(form,btn,btnText,message);
			}
		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});
});


//===Cart => Update Qty Prodoct
function updateItemArtInCart(input){
	let newValue = input.val();
	let rowid = input.attr('data-row');
	let idArt = input.attr('data-idart');

	let formData = new FormData();
	formData.append('ActiveAjax', 'updateQteArtCart');
	formData.append('newValue', newValue);
	formData.append('rowid', rowid);
	formData.append('idArt', idArt);
	formData.append('Returnlink', urlHref);
	$.ajax({
		type: "POST",
		url:  base_url+"spw",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			loadCart();
			countContentCart();
			/*console.log(data);
			if(data.statut=='success'){
				document.location.href=data.data;
			}else{
				let btnText ='Ajouter au panier';
				let message = data.message;
				actionAjaxError(form,btn,btnText,message);
			}*/
		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});
}
$('body').on('keyup', 'input.jsQtyArItem', function(e){
	let input = $(this);
	updateItemArtInCart(input);
});

//btn qty art
$('body').on('click', '[class*="js-calc-"]', function(e){
	e.preventDefault();
	let btn = $(this);
	let input = btn.siblings('input[type="number"]');
	updateItemArtInCart(input);
});


//Delaye Art
$('body').on('click', '.js-del-art', function(e){
	e.preventDefault();
	let link = $(this);
	let input = link.siblings('.quantite').find('input[type="number"]');
	input.val(0);
	updateItemArtInCart(input);
});


//===Cart => Pay cart
$('body').on('click', '.js-payer-panier', function(e){
	e.preventDefault();
	let link = $(this);

	let formData = new FormData();
	formData.append('ActiveAjax', 'payCart');
	formData.append('Returnlink', urlHref);

	$.ajax({
		type: "POST",
		url:  base_url+"spw",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			if(data.statut=='success'){
				document.location.href=data.data;
			}else{
				if(data.statut=='error'){
					$('body').find('.header-right .js-open-poPup').trigger('click');
				}
				
			}
		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});
	
});
//===Cart => Delate cart
$('body').on('click', '.js-delate-panier', function(e){
	e.preventDefault();
	let link = $(this);

	let formData = new FormData();
	formData.append('ActiveAjax', 'DelateCart');
	formData.append('Returnlink', urlHref);

	$.ajax({
		type: "POST",
		url:  base_url+"spw",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		async: false,
		success: function(data){
			if(data.statut=='success'){
				document.location.href=data.data;
			}else{
				if(data.statut=='error'){
					$('body').find('.header-right .js-open-poPup').trigger('click');
				}
				
			}
		},
		error: function(data){
			alert("Can not perform the upload action:" + JSON.stringify(data));
		}
	});
	
});







/*
|--------------------------------------------------------------------------
| Mon compte
|--------------------------------------------------------------------------
|
*/
//==>Modifier Mon compte
$('body').on('submit', 'form#modifierCompteFrom', function(e){
	e.preventDefault();

	var form = $(this);
	var btn = form.find('button[name="modifierCompteBtn"]');

	actionAjaxStart(form,btn);

	var telephone = form[0]['telephone']['value'];

	if(telephone&&telephone!='+(22_) __-__-__-__'){
		var formData = new FormData(form[0]);
		formData.append('ActiveAjax', 'modifier_mon_compte');
		formData.append('Returnlink', urlHref);
		//console.log(telephone);
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
					var btnText ='Modifier';
					var message = data.message;
					actionAjaxError(form,btn,btnText,message);
				}

			},
			error: function(data){
				alert("Can not perform the upload action:" + JSON.stringify(data));
			}
		});
	}else{
		var btnText = 'Modifier';
		var message = 'Veuillez renseigner remplir tous les champs.';
		actionAjaxError(form,btn,btnText,message);
	}
});


//==>Modifier photo de profile
$('body').on('submit', 'form#updateAvatarForm', function(e){
	e.preventDefault();

	var form = $(this);
	var btn = form.find('button[name="updateAvatarBtn"]');

	actionAjaxStart(form,btn);

	var formData = new FormData(form[0]);
	var inputFile = form.find('input[name="file"]');
	var fileToUpload = inputFile[0].files[0];


  //console.log(fileToUpload);

  formData.append("file", fileToUpload);
  formData.append('ActiveAjax', 'modifier_avatar');
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
  			var btnText ='Modifier';
  			var message = data.message;
  			actionAjaxError(form,btn,btnText,message);
  		}

  	},
  	error: function(data){
  		alert("Can not perform the upload action:" + JSON.stringify(data));
  	}
  });
});


//==>Modifier Mot de passe
$('body').on('submit', 'form#updatePasswordForm', function(e){
	e.preventDefault();

	var form = $(this);
	var btn = form.find('button[name="updatePasswordBtn"]');
	var step = btn.attr('data-step');

	actionAjaxStart(form,btn);

	if(step==1){
		var formData = new FormData(form[0]);

  	//console.log(fileToUpload);
  	formData.append('ActiveAjax', 'verifier_password');
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
  			if(data.statut=='success'){
  				actionAjaxInit(form,btn,'Modifier');

  				form.find('.js-step-1').slideUp('slow').remove();
  				form.closest('.poPup').find('.poPup-head-title .title').empty().text('Modifier Mot de passe');


  				$contentStep2 = `
  				<div class="x2">
  				<div class="i-form-row x2-elem">
  				<div class="i-placeholder">Nouveau mot de passe <span class="red-stars">*</span></div>
  				<div class="block-password">
  				<input type="password" name="password" class="password" minlength="8" required>
  				<a href="#" class="block-password-show js-show-password"><i class="fas fa-eye"></i></a>
  				</div>
  				</div>
  				<div class="i-form-row x2-elem">
  				<div class="i-placeholder">Confirmer le mot de passe <span class="red-stars">*</span></div>
  				<div class="block-password">
  				<input type="password" name="password-repeat"  class="password-repeat" required>
  				<a href="#" class="block-password-show js-show-password"><i class="fas fa-eye"></i></a>
  				</div>
  				</div>
  				</div>
  				`;

  				form.find('.js-step-2').append($contentStep2);
  				btn.attr('data-step', 2);
  			}else{
  				var btnText ='Modifier';
  				var message = data.message;
  				actionAjaxError(form,btn,btnText,message);
  			}

  		},
  		error: function(data){
  			alert("Can not perform the upload action:" + JSON.stringify(data));
  		}
  	});

  }else{
  	if(step==2){
  		var formData = new FormData(form[0]);
  		formData.append('ActiveAjax', 'modifier_password');
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
  					var btnText ='Modifier';
  					var message = data.message;
  					actionAjaxError(form,btn,btnText,message);
  				}

  			},
  			error: function(data){
  				alert("Can not perform the upload action:" + JSON.stringify(data));
  			}
  		});
  	}
  }
});






/*
|--------------------------------------------------------------------------
| Forums
|--------------------------------------------------------------------------
|
*/
//==>Load comment forum

function ajax_load_last_comment_forum(idForum,page)
{
	if(page==0){
		$("#listCommentsForum").load(base_url+"spw/ajax_load_last_comment_forum/"+idForum+"/"+page);
		$('#listCommentsForum').animate({
			scrollTop: $("#listCommentsForum").offset().top
		}, 1000);
	}else{
		$("#listCommentsForum").find('.grp-row:first').load(base_url+"spw/ajax_load_last_comment_forum/"+idForum+"/"+page);
	}
	//setTimeout(ajax_load_last_comment_forum(idForum,offset),15000);
}
if(url[2]=='forums'&&url[3]=='selection'){
	let idForum = url[4];
	ajax_load_last_comment_forum(idForum,0);
}



//si on scroll
$("#listCommentsForum").scroll(function(){
	let Nivo_scroll = $(this).scrollTop();
	console.log(Nivo_scroll);
	if(Nivo_scroll==0){
		let page = parseInt($(this).attr('data-page')) + 1;
		let idForum = url[4];
		$("#listCommentsForum").prepend('<div class="grp-row"></div>');
		ajax_load_last_comment_forum(idForum,page);
		$(this).attr('data-page', page);
		$(this).scrollTop(10);
		/*$('#listCommentsForum').animate({
			scrollTop: $("#listCommentsForum").offset().top
		}, 1000);*/
	}


});


//==>commenter forum
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
			formData.append("returnUrl", urlHref);

			$.ajax({
				type: "POST",
				url:  base_url+""+url[1]+"/forums/selection/"+idForum,
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

});



/*
|--------------------------------------------------------------------------
| concours
|--------------------------------------------------------------------------
|
*/

$('body').on('click', '.js-go_to_concours', function(e){
	e.preventDefault();
	let btn = $(this);
	let formData = new FormData();
	formData.append('ActiveAjax', 'goToConcours');
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
					console.log(data);
					if(data.statut=='success'&&data.data==1){
						document.location.href=base_url+"users/concours";
					}else{
						$('body').find('a.link-login.js-open-poPup').trigger('click');
					}

				},
				error: function(data){
					alert("Can not perform the upload action:" + JSON.stringify(data));
				}
			});

});










});//END DOCUMENT
