var iflvgApp = angular.module('iflvgApp', []);

iflvgApp.controller('IflvgIndexController', function IflvgIndexController($scope,$interval, $http) {
	
	var getData = function($scope, $http) {
		$http.get('/iflvg/Api/').then(function(response) {
			$scope.content = response.data;
		});
	};
	
	getData($scope, $http);
	
	$interval(function() {
		getData($scope, $http);
	}, 3000);
	
});
