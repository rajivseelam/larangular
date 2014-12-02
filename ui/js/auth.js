'use strict';

(function(){

	var angularBasicAuth = angular.module(
		'angularBasicAuth',
		[
			'LocalStorageModule',
			'base64'
		]);

	/**
	 * Defaults
	 */
	angularBasicAuth.value('authDefaults', {
		authenticateUrl: apiBase + 'account',
	});

	(function(){

		angularBasicAuth.factory('TokenService',function(){

			function storeToken(){
				console.log('Store Token');
			}

			function removeToken(){
				console.log('Remove Token');
			}

			function getToken(){
				console.log('Get Token');
			}

			return {
				storeToken: storeToken,
				getToken: getToken,
				removeToken: removeToken
			};

		});

		angularBasicAuth.factory('authService',function($base64,$http,$rootScope,TokenService){


			function isAuthenticated(){
				console.log('is Authenticated?');
			}

			function login(email,password){

				console.log('In Login Function');

				$http.defaults.headers.common.Authorization = 'Basic ' + $base64.encode(email + ':' + password);

				$http.get(apiBase + 'account').
					success(function(data, status, headers, config) {

						storeToken(data);
						$rootScope.$broadcast('authentication-success');

					}).
					error(function(data, status, headers, config) {

						$rootScope.$broadcast('authentication-failed');

					});
			}

			return {

				login: login,
				isAuthenticated: isAuthenticated

			};

		});

	})();

	angularBasicAuth.factory('authInterceptor',
		function ($location, $q, FlashService) {


			var authInterceptor = {

				/**
				* Request Interceptor
				*
				* Adds an authorization header, if and only if there
				* is one found in the local storage
				*/
				request: function(config) {
					return config;
				},

				/**
				* Error Interceptor
				*
				* Used to trap an authentication error
				*/
				responseError: function(rejection) {

					$location.path('/login');
					FlashService.show('Not Authenticated');

					return $q.reject(rejection);
				}
			};

			return authInterceptor;
		}
	);


		// add the interceptor to the http service
	angularBasicAuth.config(['$httpProvider', function($httpProvider) {
		$httpProvider.interceptors.push('authInterceptor');
	}]);

})();