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
});