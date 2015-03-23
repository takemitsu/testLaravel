angular.module('bbsService', [])
	.factory('bbs', function($http) {
		return {
			get: function() {
				return $http.get('/api/message');
			},

			save: function(postData) {
				return $http({
					method: 'POST',
					url: '/api/message',
					headers: {'Content-Type': 'application/x-www-form-urlencoded'},
					data: $.param(postData)
				});
			},

			destroy: function(id) {
				return $http.delete('/api/message/' + id);
			}
		}
	});