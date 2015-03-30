
mainCtrl.controller('UserIndexController', function($location, $scope, $http, $modal, $cookies) {

	$scope.loading = true;

	$scope.maxSize = 5;
	$scope.itemPerPage = 10;
	$scope.totalItems = 1;
	$scope.filters = {
		page: 1
	};

	$scope.userStatus = ['未承認','承認済み','その他'];
	$scope.userAuthType = ['ユーザ', '管理者', 'その他'];

	console.log($location.path());

	$scope.loadData = function() {
		$scope.loading = true;

		$http.get('/api/user', {
			params: $scope.filters
		})
		.success(function(data) {
			$scope.users = data.data;
			$scope.filters.page = data.current_page;
			$scope.itemPerPage = data.per_page;
			$scope.totalItems = data.total;
			$scope.loading = false;
		});
	};
	$scope.loadData();

	$scope.editUser = function(user) {
		var instance = $modal.open({
			templateUrl: '/partials/user/edit.html',
			controller: 'UserEditController',
			resolve: {
				user: function() {
					return user;
				}
			}
		});
		return instance.result.then(function(selectedItem) {
			$scope.loadData();
		}, function() {
			return false;
		});
	};

	$scope.approve = function(user) {
		$http.put('/api/user/' + user.idkey, {
			status: 1
		})
		.success(function(data) {
			$scope.loadData();
		})
		.error(function(data) {
			console.log(data);
		});
	};
	$scope.suspend = function(user) {
		$http.put('/api/user/' + user.idkey, {
			status: 2
		})
		.success(function(data) {
			$scope.loadData();
		})
		.error(function(data) {
			console.log(data);
		});
	};
	$scope.to_admin = function(user) {
		$http.put('/api/user/' + user.idkey, {
			auth_type: 1
		})
		.success(function(data) {
			$scope.loadData();
		})
		.error(function(data) {
			console.log(data);
		});
	};
	$scope.to_user = function(user) {
		$http.put('/api/user/' + user.idkey, {
			auth_type: 0
		})
		.success(function(data) {
			$scope.loadData();
		})
		.error(function(data) {
			console.log(data);
		});
	};

	$scope.deleteUser = function(user) {
		if(!confirm(user.name + ' を削除しますか')) {
			return false;
		}

		$scope.loading = true;

		$http({
			method: 'delete',
			url: "/api/user/" + user.idkey,
		}).success(function(json) {
			$scope.loadData();
		}).error(function(data) {
			console.log(data);
		});
	}

});

// ---------------------------------------------------------

mainCtrl.controller('UserEditController', function($scope, $modalInstance, $http, user) {
	$scope.user = $.extend({}, user);

	$scope.save = function() {
		var method = 'post';
		var endPoint = "/api/user";

		if (user.idkey && user.idkey.length > 0) {
			method = 'put';
			endPoint += "/" + user.idkey;
		}

		$http({
			method: method,
			url: endPoint,
			data: $scope.user
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
