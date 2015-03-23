var mainCtrl = angular.module('mainCtrl', []);



mainCtrl.controller('IndexController', function($scope, $http, $modal, bbs) {
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

	$scope.addComment = function(post) {
		var instance = $modal.open({
			templateUrl: '/partials/messages/edit.html',
			controller: 'MessageEditController',
			resolve: {
				post: function() {
					return {
						id: null,
						name: '',
						subject: '',
						comment: ''
					};
				}
			}
		});
		return instance.result.then(function(selectedItem) {
			//showSuccessMessage('保存しました');
			//return $scope.loadRoom();
			$scope.loadData();
		}, function() {
			return true;
			//return $log.info('dismiss editRoom');
		});
	};
/*
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
*/
	$scope.deleteComment = function(id) {
		if(!confirm('削除しますか')) {
			return false;
		}

		$scope.loading = true;

		bbs.destroy(id)
			.success(function(data) {
				$scope.loadData();
			})
		return false;
	}
});

mainCtrl.controller('MessageEditController', function($scope, $modalInstance, $http, post) {
	$scope.postData = $.extend({}, post);

	$scope.save = function() {
		var method = 'post';
		var endPoint = "/api/message/";

		if (post.id && post.id.length > 0) {
			method = 'put';
			endPoint += post.id;
		}

		$http({
			method: method,
			url: endPoint,
			data: $scope.postData
		}).success(function(json) {
			return $modalInstance.close(json);
		}).error(function(data) {
			console.log(data);
		});
	};
	return $scope.cancel = function() {
		return $modalInstance.dismiss('cancel');
	};
});
