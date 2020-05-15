$(document).ready(function(){

	validateForms();

}); //end of ready

function validateForms() {
  
	jQuery.validator.addClassRules('phone-email-group', {
		require_from_group: [1, ".phone-email-group"]
	});
	
	//$("input.phone").mask("+7 (999) 999-9999");
	
  $("form").each(function() {
    $(this).validate({
      focusInvalid: false,
      sendForm : false,
      errorPlacement: function(error, element) {
        if (element[0].tagName == "SELECT") {
          element.parents(".selectric-wrapper").addClass("selectric-wrapper-error");
					error.insertAfter(element.parents(".selectric-wrapper"));
        } else {
					if (element.attr("type") == "checkbox") {
						element.siblings("label").addClass("checkbox-label-error")
					} else {
						error.insertAfter(element);
					}
				}
				
				// element.parents(".form-group").addClass("form-group-error")
        
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass(errorClass);
				
        if ($(element)[0].tagName == "SELECT") {
          $(element).parents(".selectric-wrapper").removeClass("selectric-wrapper-error");
          $(element).parents(".selectric-wrapper").next("label.error").remove();
        } else {
					$(element).next(".error").remove();
					if ($(element).attr("type") == "checkbox") {
						$(element).siblings("label").removeClass("checkbox-label-error")
					}
				}
				
				// $(element).parents(".form-group").removeClass("form-group-error")
				
      },
      invalidHandler: function(form, validatorcalc) {
				var errors = validatorcalc.numberOfInvalids();
				if (errors && validatorcalc.errorList[0].element.tagName == "INPUT") {                    
						validatorcalc.errorList[0].element.focus();
				}
      }
    });
    
    if ($(this).find(".form-date").length) {
      $(this).find(".form-date").rules('add', {
        messages: {
          required:  "Выберите дату"
        }
      });
    }
		
		if ($(this).find("input.password").length && $(this).find("input.password-repeat").length) {
			$(this).find("input.password-repeat").rules('add', {
        equalTo: ".password"
      });
		}
    
    
  });  
  
}

jQuery.extend(jQuery.validator.messages, {
    required: "Veillez remplir ce champ",
    remote: "Please fix this field.",
    email: "Veillez saisir un e-mail valide",
    url: "Please enter a valid URL.",
    date: "Please enter a valid date.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Please enter a valid number.",
    digits: "Please enter only digits.",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Les deux mots de passes ne sont pas conformes.",

    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("Veillez saisir au maxi {0} caractères."),
    minlength: jQuery.validator.format("Veillez saisir au moins  {0} caractères."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});