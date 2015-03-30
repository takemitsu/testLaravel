var bbsApp = angular.module('bbsApp', ['ngRoute', 'mainCtrl', 'bbsService', 'ui.bootstrap', 'ngFileUpload', 'ngCookies']);

bbsApp.config([
	'$routeProvider', function($routeProvider) {
		return $routeProvider.when('/index', {
			templateUrl: '/partials/messages/index.html',
			controller: 'IndexController'
		}).when('/topic/:id', {
			templateUrl: '/partials/messages/detail.html',
			controller: 'DetailController'
		}).when('/media/:id', {
			templateUrl: '/partials/messages/media.html',
			controller: 'DetailMediaController'

		}).when('/user', {
			templateUrl: '/partials/user/index.html',
			controller: 'UserIndexController'

		}).otherwise({
			redirectTo: '/index'
		}) ;
	}
]);
