var bbsApp = angular.module('bbsApp', ['ngRoute', 'mainCtrl', 'bbsService', 'ui.bootstrap']);

bbsApp.config([
	'$routeProvider', function($routeProvider) {
		return $routeProvider.when('/index', {
			templateUrl: '/partials/messages/index.html',
			controller: 'IndexController'
		}).when('message/:id', {
			templateUrl: '/partials/messages/detail.html',
			controller: 'DetailController'
		}).otherwise({
			redirectTo: '/index'
		}) ;
	}
]);
