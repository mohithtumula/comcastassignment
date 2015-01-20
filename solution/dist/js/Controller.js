var app = angular.module('Movies',['ngTable','ngSanitize']);

var globalData = '', pData = ''; //global variable


app.controller('headerController',function($scope, $timeout, $filter, ngTableParams, $http){
	
	$scope.rootURL = 'http://localhost/rest-api/RestApi/';
	
	 $scope.tableParams = new ngTableParams({
        page: 1,            // show first page
        count: 6,
		// count per page
        sorting: {
            title: 'asc'     // initial sorting
        },
		filter: {
            title: ''       // initial filter
        }
    }, {
        total: 0,           // length of data
        getData: function($defer, params) {
			
            // ajax request to api
            $http.get($scope.rootURL+'readAll/').success(function(data) {
				 $timeout(function() {
                    
					
					
						
						//filtering the data
						var orderedData = params.filter() ? $filter('filter')(data, params.filter()) : data;

						// ordering the data
						orderedData = params.sorting() ?
											$filter('orderBy')(orderedData, params.orderBy()) :
											orderedData;
						// update table params
						params.total(orderedData.length);
						//set the data
						$defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
						
					
					
                }, 500);
            });
			
			
		
		}
    });
	
	$scope.text = '';
	$scope.$watch('needle', function(newValue, oldValue) {
	  $scope.text = newValue;
	  $scope.search();
	});
	/* Form Submitting Searching Videos */
	$scope.submitSearch = function(){
		
	}
	/* Searching Videos */
	$scope.search = function(needle){
		// ajax request to api
            $http.get($scope.rootURL+'searchVideo/'+needle).success(function(data) {
			
            });
			
	}
	
});	

