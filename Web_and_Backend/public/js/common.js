$(document).ready(function() {
	$(document).ready(function(){
		$('.sub_menu_header').click(function() {
			$('.sub_menu_header').toggleClass('open');
		});
	});

	$('.pay_close').click(function(){
		$('body').removeClass('new_fix');
	});

	$('.field__input').on('input', function() {
		var $field = $(this).closest('.field');
		if (this.value) {
			$field.addClass('field--not-empty');
		}
		else {
			$field.removeClass('field--not-empty');
		}
	});
});

$http = angular.injector(["ng"]).get("$http");

$('#js-currency-select').on('change', function(){
	currency_code = $(this).val();
	$http.post(APP_URL+'/set_session', {currency: currency_code}).then(function(response){
		location.reload();
	});
});

$('#js-language-select').on('change', function(){
	language_code = $(this).val();
	$http.post(APP_URL+'/set_session', {language: language_code
	}).then(function(response){
		location.reload();
	});
});
	
$("a[name=mobile_number_tab]").on("click", function () { 
	var mobile_number = $(this).attr("data-index");
	console.log(mobile_number);
	$("#pop_up_mobile_number").text(mobile_number);
});
	
//Payout Preferences
app.controller('payout_preferences', ['$scope', '$http', function($scope, $http) {
	
    var stripe = Stripe(STRIPE_PUBLISH_KEY);

	// Check input is valid or not
    $scope.checkInValidInput = function(value) {
        return (value == undefined || value == 0 || value == '');
    };

	$scope.countryChanged = function() {
		if($scope.country == '') {
			$scope.payout_country = '';
	      	$scope.payout_currency = '';
		}
		else {
	      	$scope.payout_country = $scope.country;
	      	$scope.changeCurrency();
		}
	};

	// change currency based on country selected
    $scope.changeCurrency = function(reset = true) {
    	if(reset) {
			$scope.payout_currency = '';
    	}
		if($scope.payout_country == 'GB' && $scope.payout_currency == 'EUR') {
			$('.routing_number_cls').addClass('hide');
			$('.account_number_cls').html('IBAN');
		}
		else {
			$('.routing_number_cls').removeClass('hide');
			$('.account_number_cls').html('Account Number');
		}
	};

	// response handler function from for create stripe token
    $scope.stripeResponseHandler = function(result) {
		$("#stripe_errors").html("");
		if (result.error) {
			$("#stripe_errors").html(result.error.message); 
			/*if(result.error.code == "parameter_invalid_empty") { 
				$("#stripe_errors").html('Please fill all required fields');
			}*/
			return false;
		}

		document.getElementById("stripe_token").value = result.token.id;
		document.getElementById('payout_stripe').submit();
		setTimeout( () => $('button[type="button"]').attr('disabled',''),0);
    };

	$scope.resetErrors = function() {
		$scope.show_address_error = false;
		$scope.show_method_error = false;
		$scope.address_error = false;
		$scope.city_error = false;
		$scope.postal_error = false;
		$scope.country_error = false;
		$scope.required_error = false;
	};

	$(document).on('change',".payout_method",function() {
		$scope.payout_method = this.value;
	});

	$('[id$="_flash-container"]').on('click', '.alert-close', function() {
    	$(this).parent().parent().addClass('ng-hide');
    });
}]);

app.controller('help', ['$scope', '$http', function($scope, $http) {
	$('.help-nav .navtree-list .navtree-next').click(function() {
		var id = $(this).data('id');
		var name = $(this).data('name');
		$('.help-nav #navtree').addClass('active');    
		$('.help-nav #navtree').removeClass('not-active');
		$('.help-nav .subnav-list li:first-child a').attr('aria-selected', 'false');
		$('.help-nav .subnav-list').append('<li> <a class="subnav-item" href="#" data-node-id="0" aria-selected="true"> ' + name + ' </a> </li>');
		$('.help-nav #navtree-'+id).css({
			'display': 'block'
		});
	});

	$('.help-nav .navtree-list .navtree-back').click(function() {
		var id = $(this).data('id');
		var name = $(this).data('name');
		$('.help-nav #navtree').removeClass('active');
		$('.help-nav #navtree').addClass('not-active');
		$('.help-nav .subnav-list li:first-child a').attr('aria-selected', 'true');
		$('.help-nav .subnav-list li').last().remove();
		$('.help-nav #navtree-' + id).css({
			'display': 'none'
		});
	});

	$('#help_search').autocomplete({
		source: function(request, response) {
			$.ajax({
				url: APP_URL + "/ajax_help_search",
				type: "GET",
				dataType: "json",
				data: {
					term: request.term
				},
				success: function(data) {
					response(data);
					$(this).removeClass('ui-autocomplete-loading');
				}
			});
		},
		search: function() {
			$(this).addClass('loading');
		},
		open: function() {
			$(this).removeClass('loading');
		}
	})
	.autocomplete("instance")._renderItem = function(ul, item) {
		if (item.id != 0) {
			$('#help_search').removeClass('ui-autocomplete-loading');
			return $("<li>")
			.append("<a href='" + APP_URL + "/help/article/" + item.id + "/" + item.question + "' class='article-link article-link-panel link-reset'><div class='hover-item__content'><div class='col-middle-alt article-link-left'><i class='icon icon-light-gray icon-size-2 article-link-icon icon-description'></i></div><div class='col-middle-alt article-link-right'>" + item.value + "</div></div></a>")
			.appendTo(ul);
		}
		else {
			$('#help_search').removeClass('ui-autocomplete-loading');
			return $("<li style='pointer-events: none;'>")
			.append("<span class='article-link article-link-panel link-reset'><div class='hover-item__content'><div class='col-middle-alt article-link-left'><i class='icon icon-light-gray icon-size-2 article-link-icon icon-description'></i></div><div class='col-middle-alt article-link-right'>" + item.value + "</div></div></span>")
			.appendTo(ul);
		}
	};

}]);

app.controller('vehicle_details',['$scope','$http',function($scope,$http){
	$('#vehicle_make').on('change', function(){
		var make_id =  $(this).val();
		if(make_id ==''){
			return false;
		}
		$('.vehicle_model').addClass('loading');
		$http.post(APP_URL+'/makelist', {make_id: make_id}).then(function(response) {
			$('#vehicle_model').html('');
	        $('#vehicle_model').append('<option value="' + 0 + '">Select</option>');
	        $.each(response.data, function(k, v) {   
	            $('#vehicle_model').append('<option value="' + k + '">' + v + '</option>');
	         });
	        $('.vehicle_model').removeClass('loading');
		});
	});
}]);

$( window ).on("load", function() {
        var header = $("#header").innerHeight()
        var dashhead = $("#dashhead").innerHeight()
        
        // console.log($('#main').css("margin-top",header || dashhead))
        $('#main').css("margin-top",header || dashhead)
});