angular.module('mainCtrl', [])
	.controller('mainController', function($scope, $http, bbs) {
		$scope.postData = {};

		$scope.loading = true;

		$scope.loadData = function() {
			bbs.get()
				.success(function(data) {
					$scope.posts = data;
					$scope.loading = false;
				});
		};
		$scope.loadData();

		$scope.submitComment = function() {
			$scope.loading = true;

			bbs.save($scope.postData)
				.success(function(data) {
					$scope.postData = {};
					$scope.loadData();
				})
				.error(function(data) {
					console.log(data);
				});
		};

		$scope.deleteComment = function(id) {
			$scope.loading = true;

			bbs.destroy(id)
				.success(function(data) {
					$scope.loadData();
				})
		}
	})