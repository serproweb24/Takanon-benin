$(document).ready(function(){

/*
|--------------------------------------------------------------------------
| Activation plugins
|--------------------------------------------------------------------------
|
*/
//==Select2=>
$('.i-select2').select2();



//==Masque input phone=>
$(".js-phone").mask("+(220) 00-00-00-00");
//$(".js-phone").mask("+(7) 999-999-99-99");
$(".js-date").mask("99-99-9999");

//==Alert=>
$('.item-alertSession').alertAjaxSession();

//validation
validateForms();




//==Dropify=>
function myDropify(){
	$('body').find('.js-dropify').each(function(){
		$(this).dropify({
			messages: {
				default: 'Glissez-déposez un fichier ici ou cliquez',
				replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
				remove:  'Supprimer',
				error:   'Désolé, le fichier trop volumineux'
			}
		});
	});
}

//==>Load comment forum
let urls = window.location.pathname;
let url = urls.split('/');
let urlHref = window.location.href;

let  listPage = ['modifier_actualite']

///Segment 2
if($.inArray(url[2], url) !=-1){
	myDropify();
}
///Segment 3
if($.inArray(url[3], url) !=-1){
	myDropify();
}






//==WebCam=>
/*Webcam.set({
	width: 490,
	height: 390,
	image_format: 'jpeg',
	jpeg_quality: 90
});
	Webcam.attach('#ma_camera3');

$('body').on('click', '.js-camera-btn', function(){
	Webcam.attach('#ma_camera2');
});


$('body').on('click', '.js-prendre-photo', function(){
	var input = $(this).closest('form').find('input.js-input-photo');
	Webcam.snap(function(data_uri) {
		input.val(data_uri);
		$('#mon_image').empty().html('<img src="'+data_uri+'"/>');
	} );
});*/


//= Générale => Update elem start
$('body').on('click', '[class*="js-transfer_data"]', function(){
	let elem = $(this);

	//Au clic, recupérer les infos mis à disposition
	if(elem.is('[data-infos]')){
		var infos = elem.attr('data-infos');
	}
	if(elem.is('[data-checkbox]')){
		var chekeds = elem.attr('data-checkbox');
	}
	if(elem.is('[data-title-modal]')){
		var title = elem.attr('data-title-modal');
	}
	if(elem.is('[data-modal-text]')){
		var text = elem.attr('data-modal-text');
	}
	if(elem.is('[href]')){
		var idModal = elem.attr('href');
	}


	let form = $(idModal).find('form');
	form.find('input[type="password"]').closest('.i-form-row').addClass('hide');
	form.removeAttr('data-type');

	if(elem.is('[data-type]')){
		var dataType = elem.attr('data-type');
		form.attr('data-type', dataType);
	}

	
	if(infos&&infos.length){
		info = infos.split('@@');

		if(title&&title.length){
			$(idModal).find('.poPup-title').empty().html(title);
		}else{
			$(idModal).find('.poPup-title').empty().text('Changement de statut');
		}

		if(text&&text.length){
			$(idModal).find('.i-form-textAlert').empty().html(text);
		}
		
		
		//pour chaque element trouver,affecter la valleur correspondante
		$(idModal).find('[data-id]').each(function(){
			let row = $(this);
			let valRow = row.attr('data-id');


			//input
			if(row.is('input')){
				row.attr('value', info[valRow]);
				//row.val(info[valRow]);
			}

			//textarea
			if(row.is('textarea')){
				row.text(info[valRow]);
				//row.val(info[valRow]);
			}

			//Select
			if(row.is('select')){
				row.val(info[valRow]).trigger('change');
			}

			//Mark/strong
			if(row.is('mark,strong,div,span')){
				row.empty().html(info[valRow]);
				//row.val(info[valRow]);
			}

		});
	}else{
		alert('Veillez vérifier svp la configuration de modification.')
	}

	//===>Pour les checkbox et radio
	$(idModal).find('input[type="checkbox"],input[type="radio"]').prop("checked", false);
	if(chekeds&&chekeds.length){
		cheked = chekeds.split('@@');
		$(idModal).find('input[type="checkbox"],input[type="radio"]').each(function(){
			if(jQuery.inArray($(this).attr('data-id'), cheked) !== -1){
				$(this).prop("checked", true);
			}else{
				$(this).prop("checked", false);
			}
		});
	}


	//===>Pour les PoPup Sataut, ajouter un champ objet 
	if(elem.is('[data-objet]')){
		form.find('.i-form-textAlert').siblings('.i-form-row').remove();
		if(elem.attr('data-objet')=='true'){
			form.find('.i-form-textAlert').before('<div class="i-form-row"><span class="i-placeholder">Objet *</span> <textarea name="objet" requred></textarea></div>');
		}
	}



});




/*
|--------------------------------------------------------------------------
| Tabs
|--------------------------------------------------------------------------
|
*/
$('body').on('click', '.js-tabs-nav>li>a', function(e){
	e.preventDefault();
	let link = $(this);
	let tabs = link.closest('.js-tabs');
	let IdActiveBlock = link.attr('href');
	link.addClass('active').closest('li').addClass('active').siblings().removeClass('active').find('a').removeClass('active');
	$(IdActiveBlock).addClass('active').siblings().removeClass('active');
});



/*
|--------------------------------------------------------------------------
| Menu
|--------------------------------------------------------------------------
|
*/
$('body').on('click', '.js-btn-menu', function(e){
	e.preventDefault();
	$(this).toggleClass('active');
	$('.header-nav').toggleClass('active');
});



/*
|--------------------------------------------------------------------------
| ContextMenu - click droit
|--------------------------------------------------------------------------
|
*/
//click droit
$('.js-open-context-menu').on("contextmenu",function(event){
	event.preventDefault();
	console.log(event.which);

	var contentContextMenu = $(this).find('.js-contextMenuList').html();

	$("body").find('.i-context-menu').remove();

	$("<div class='i-context-menu' id='ContextMenu'><div class='i-custom-menu-content'><section class='i-custom-menu-section'><ul>"+contentContextMenu+"</ul></section></div></div>").appendTo("body").css({top: event.pageY + "px", left: event.pageX + "px"}); 

}); 

//Close ContextMenu
$('body').on('click', function(e){
	if(!$(e.target).hasClass('js-open-contextmenuClick')){
		$('#ContextMenu').remove();
	}
});


/*
|--------------------------------------------------------------------------
| ContextMenu - click gauche
|--------------------------------------------------------------------------
|
*/
//click droit
$('body').on('click', '.js-open-contextmenuClick', function(event){
	event.preventDefault();
//console.log(event.which);

var contentContextMenu = $(this).find('.js-contextMenuList').html();
$("body").find('.i-context-menu').remove();

$("<div class='i-context-menu'  id='ContextMenu2'><div class='i-custom-menu-content'><section class='i-custom-menu-section'><ul>"+contentContextMenu+"</ul></section></div></div>").appendTo("body").css({top: event.pageY + "px", left: (event.pageX - 238) + "px"});
}); 

//Close ContextMenu
$('body').on('click', function(e){
	if(!$(e.target).hasClass('js-open-contextmenuClick')){
		$('#ContextMenu2').remove();
	}/**/
	
});


/*
|--------------------------------------------------------------------------
| block-password
|--------------------------------------------------------------------------
|
*/
$('body').on('click', '.js-show-password', function(e){
	e.preventDefault();
	$(this).toggleClass('active');
	var etat = $(this).siblings('input').attr('type');
	if(etat=='password'){
		$(this).siblings('input').attr('type', 'text');
	}else{
		$(this).siblings('input').attr('type', 'password');
	}
});








/*
|--------------------------------------------------------------------------
| poPup
|--------------------------------------------------------------------------
|
*/

//Open poPup
$('body').on('click', '.js-open-poPup', function(e){
	e.preventDefault();

	
	//$('#poPup-bg').remove();
	$('body').find('.poPup').unwrap();
	$('body').find('.poPup').removeClass('open');

	let fenetre = $(this).attr('href');
	$('body').find(fenetre).wrap('<div id="poPup-bg"> </div>');
	$(fenetre).addClass('open');
	$(fenetre).prepend('<a href="#" class="poPup-close"></a>');
	
});



//Close poPup
$('body').on('click', '.poPup-close,.js-poPup-close', function(e){
	e.preventDefault();
	$(this).closest('.poPup').unwrap();
	$(this).closest('.poPup').removeClass('open');


});
$('body').on('click', function(e){
	let el= e.target;
	let idElem = el.id;
	if(idElem == "poPup-bg")
	{
		$('.poPup.open').closest('.poPup').unwrap();
		$('.poPup').removeClass('open');
	}
});




/*
|--------------------------------------------------------------------------
| Accordion
|--------------------------------------------------------------------------
|
*/
var accordion = $('.i-accordion');
accordion.find('dd').hide();
accordion.find('dt').on('click', function(){
	//$(this).closest('.i-accordion').find('.i-accordion-item').removeClass('i-open');
	$(this).toggleClass('open').next('dd').stop().slideToggle().siblings('dd:visible').slideUp().prev('dt').removeClass('open');
});


/*
|--------------------------------------------------------------------------
| js-calc
|--------------------------------------------------------------------------
|
*/

$('body').on('click', '[class*="js-calc-"]', function(){
	var btn = $(this);
	var value = btn.siblings('input').val();
	if(btn.hasClass('js-calc-plus')){
		var newValue = parseInt(value) + 1;
	}else{
		var newValue = parseInt(value) - 1;
	}
	btn.siblings('input').val(newValue);
});















});//END DOCUMENT