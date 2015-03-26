var mainCtrl = angular.module('mainCtrl', []);

// ---------------------------------------------------------

mainCtrl.controller('IndexController', function($scope, $http, $modal, bbs) {
	$scope.postData = {};
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
						name: '',
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

		bbs.destroy(id)
			.success(function(data) {
				$scope.loadData();
			})
		return false;
	}
});

// ---------------------------------------------------------

mainCtrl.controller('MessageEditController', function($scope, $modalInstance, $http, post) {
	$scope.postData = $.extend({}, post);

	$scope.save = function() {
		var method = 'post';
		var endPoint = "/api/message";

		if (post.id && post.id.length > 0) {
			method = 'put';
			endPoint += "/" + post.id;
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

// ---------------------------------------------------------

mainCtrl.controller('DetailController', function($scope, $http, $routeParams, $modal, $upload) {
//mainControllers.controller('ApartmentDetailController', function($scope, $rootScope, $http, $location, $routeParams, $modal, $log) 
	$scope.topic = {};
	$scope.comments = [];
	$scope.loading = true;
	$scope.hidePost = true;
	$scope.imageUploading = false;

	$scope.maxSize = 5;
	$scope.itemPerPage = 10;
	$scope.totalItems = 1;
	$scope.filters = {
		page: 1
	};

	$scope.loadDetail = function() {
		$scope.loading = true;
		$http.get("/api/message/" + $routeParams.id)
			.success(function(json) {
				$scope.topic = json;

				$http.get("/api/message/" + $routeParams.id + "/comment", {
					params: $scope.filters
				})
				.success(function(comments) {
					$scope.comments = comments.data;
					$scope.filters.page = comments.current_page;
					$scope.itemPerPage = comments.per_page;
					$scope.totalItems = comments.total;
					$scope.loading = false;
				})
				.error(function(data) {
					console.log(data);
				});
			})
			.error(function(data) {
				console.log(data);
			});
	};
	$scope.loadDetail();

	$scope.reloadComment = function() {
		$scope.loadDetail();
	};


	$scope.upload = function(files) {
		if (files && files.length) {
			for(var i = 0; i < files.length; i++) {
				var file = files[i];
				// console.log(file);
				$upload.upload({
					url: '/api/media',
					method: 'POST',
					file: file,
				}).progress(function(evt) {
					$scope.imageUploading = true;
					// console.log('progress: ' + parseInt(100.0 * evt.loaded / evt.total) + '% file :' + evt.config.file.name);
				}).success(function(data, status, headers, config) {
					// console.log('file ' + config.file.name + ' is uploaded successfully. Response: ' + data);
					$scope.attachment = data;
					$scope.imageUploading = false;
				}).error(function(data) {
					console.log(data);
				});
			}
		}
	};

	$scope.attachment = null;

	$scope.save = function() {
		// console.log($scope.postData, $scope.attachment);
		if(!($scope.postData.name && $scope.postData.comment)) {
			return false;
		}
		$scope.postData.media_id = 0;
		if($scope.attachment) {
			$scope.postData.media_id = $scope.attachment.id;
		}
		// console.log($scope.postData);
		$scope.loading = true;
		$http({
			method: 'post',
			url: "/api/message/" + $routeParams.id + "/comment",
			data: $scope.postData
		}).success(function(json) {
			$scope.postData.comment = "";
			$scope.attachment = null;
			$scope.loadDetail();
		}).error(function(data) {
			console.log(data);
		});
	};

	$scope.deleteComment = function(id) {
		if(!confirm('削除しますか')) {
			return false;
		}

		$scope.loading = true;

		$http({
			method: 'delete',
			url: "/api/message/" + $routeParams.id + "/comment/" + id,
		}).success(function(json) {
			$scope.loadDetail();
		}).error(function(data) {
			console.log(data);
		});
		return false;
	}

});

// ---------------------------------------------------------

mainCtrl.controller('DetailMediaController', function($scope, $http, $routeParams, $modal, $upload) {
	$scope.media = {};
	$scope.loading = true;
	$scope.loadDetail = function() {
		$scope.loading = true;
		$http.get("/api/media/" + $routeParams.id)
			.success(function(json) {
				$scope.media = json;
				$scope.media.is_image = false;
				if(json.mime_type.match(/^image/)){
					$scope.media.is_image = true;
				}
			})
			.error(function(data) {
				console.log(data);
			});
	};
	$scope.loadDetail();
});
