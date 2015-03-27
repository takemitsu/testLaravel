
mainCtrl.controller('BbsController', function($scope, $http, $modal, $cookies) {
	$scope.loading = true;

	$scope.maxSize = 5;
	$scope.itemPerPage = 10;
	$scope.totalItems = 1;
	$scope.filters = {
		page: 1
	};

	$scope.loadData = function() {
		$scope.loading = true;

		$http.get('/api/message', {
			params: $scope.filters
		})
		.success(function(data) {
			$scope.posts = data.data;
			$scope.filters.page = data.current_page;
			$scope.itemPerPage = data.per_page;
			$scope.totalItems = data.total;
			$scope.loading = false;
		});
	};
	$scope.loadData();

	$scope.reloadComment = function() {
		$scope.loadData();
	};

	$scope.addComment = function(post) {
		var instance = $modal.open({
			templateUrl: '/partials/messages/edit.html',
			controller: 'MessageEditController',
			resolve: {
				post: function() {
					return {
						id: null,
						name: $cookies['myName'] || "",
						subject: '',
						comment: ''
					};
				}
			}
		});
		return instance.result.then(function(selectedItem) {
			$scope.loadData();
		}, function() {
			return false;
		});
	};

	$scope.deleteComment = function(id) {
		if(!confirm('削除しますか')) {
			return false;
		}
		$scope.loading = true;
		return $http.delete('/api/message/' + id)
			.success(function(data) {
				$scope.loadData();
			})
		return false;
	}
});
