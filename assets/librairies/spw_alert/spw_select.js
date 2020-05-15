(function($){
	jQuery.fn.alertAjaxSession = function(){
		var alertIndex = 0;
		var base_url = window.location.origin;

		this.each(function(){
			alertIndex++;

			var thisAlert = $(this);
			var alertContent = thisAlert.html();
			var alertTitle = thisAlert.attr("data-title");
			var alertType = thisAlert.attr("data-type");
			var alertSession = thisAlert.attr("data-session");

			//body
			var parentLinght = $('body').find('.alertSession').length;
			if(parentLinght==0)
			{
				$('body').append('<div class="alertSession"></div>');
			}
			var identifiant = "alertS"+alertIndex;
			$('body').find('.alertSession').append('<div class="j-alert" id="'+identifiant+'"><span class="close-alert"></span>'+alertContent+'</div>');

			//session
			if(alertSession.length>0){
				$('#'+identifiant).attr('data-session', alertSession);
			}
			//type
			if(alertType.length>0)
			{
				$('#'+identifiant).addClass(alertType);
			}

			//Tile
			if(alertTitle){
				$('#'+identifiant).prepend('<div class="j-alert-title">'+alertTitle+'</div>');
			}
			

			thisAlert.remove();
		});


		//ALERT CLOSE SESSION BY AJAX
		function closeAction(){
			if($sible.attr('data-session')){
				$TypeAjax = "alertSession";
				$ContentSession = $sible.attr('data-session');
				$.ajax({
					type: "POST",
					url:  base_url+"/ajax",
					data: {
						'TypeAjax' : $TypeAjax,
						'ContentSession' : $ContentSession
					},
					success: function(data){
						console.log(data);
					//$('#facture').empty().html(data);
				}
			});
			}
		}


		function closeAlerts()
		{
			$('body').find('.j-alert').each(function(){
				$sible = $(this);
				closeAction();
				$(this).remove();
			});
			
		}

		//AU click
		$('.close-alert').on('click', function(){
			$sible = $(this).closest('.j-alert');
			closeAction();  
			$sible.remove();
		});
		

		//Auto
		setTimeout(closeAlerts, 12000);

		return this;
	}
})(jQuery);

