app.directive('postsPagination', function(){  
	return{
			restrict: 'E',
			template: '<ul class="pagination">'+
				// '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getTrips(1)">&laquo;</a></li>'+
				'<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getTrips(currentPage-1)"><span class="icon icon_left-arrow"></span></li>'+
				'<li ng-repeat="i in trip_range" ng-class="{active : currentPage == i}">'+
						'<a href="javascript:void(0)" ng-click="getTrips(i)">{{i}}</a>'+
				'</li>'+
				'<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getTrips(currentPage+1)"><span class="icon icon_right-arrow"></span></a></li>'+
				// '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getTrips(totalPages)">&raquo;</a></li>'+
			'</ul>'
	 };
})
.controller('trip', ['$scope', '$http', '$compile', function($scope, $http, $compile) {
$scope.date = new Date();
$( document ).ready(function() 
{
    $scope.getTrips();
});


$scope.getTrips = function(pageNumber)
{
	$('.all-trips-table').hide();
	$('.all-trips-table:first').show();
	$('.all-trips-table').addClass("loading");
	if($scope.currentPage == undefined)
		$scope.currentPage = '1';

	if(pageNumber===undefined)
	{
		pageNumber = '1';
	}
	var id = $('#user_id').val();
	if($scope.selected_filter)
   	{
		$http.post('ajax_trips/'+id+'?page='+pageNumber+'&month='+$scope.selected_filter, { }).then(function(response) 
	    {
			$('.all-trips-table').removeClass("loading");
			$('.all-trips-table').show();
	    	$("#selected_month").text($scope.selected_month);
	    	$scope.trips = response.data.data;
	    	$scope.totalPages   = response.data.last_page;
	    	$scope.currentPage  = response.data.current_page;
	    	let range = [];
			for(var i=1; i <= $scope.totalPages; i++) {
				range.push(i);
			}
			$scope.trip_range = range;
	    });
	}
	else
	{
		$http.post('ajax_trips/'+id+'?page='+pageNumber, { }).then(function(response) 
	    {
			$('.all-trips-table').removeClass("loading");
			$('.all-trips-table').show();	   			    		    	
	    	$scope.trips = response.data.data;
	    	$scope.totalPages   = response.data.last_page;
	    	$scope.currentPage  = response.data.current_page;
	    	let range = [];
			for(var i=1; i <= $scope.totalPages; i++) {
			  	range.push(i);
			}
			$scope.trip_range = range;
	    });
	}
}
$(document).on('click', '.month-filter', function() 
{
	$scope.selected_month = $(this).attr('month');
	$scope.selected_filter = $(this).attr('value');
	$('.month-filter').removeClass('filter-checked');
	$(this).addClass('filter-checked')

});

$scope.Rating = function(rate,trip_id)
{
	$http.post('rider_rating/'+rate+'/'+trip_id, { }).then(function(response) 
    {
    	if(response.data.success)
    	{
    		window.location.reload();
    	}
    });
}


}]);


	