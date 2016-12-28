angular.module('app.controllers')
    .controller('ClientDashboardController',
        ['$scope', '$location', '$routeParams', 'appConfig', 'Client',
        function ($scope, $location, $routeParams, appConfig, Client) {

            $scope.clients = Client.query({
                orderBy: 'created_at',
                sortedBy: 'desc',
                limit: 8
            }, function (response) {
                $scope.clients = response.data;
            });

            $scope.status = appConfig.project.status;

            $scope.getStatus = function($id) {
                for (var i = 0; i < $scope.status.length; i++) {
                    if($scope.status[i].value === $id){
                        return $scope.status[i].label;
                    }
                }
                return "";
            };

            $scope.showClient = function (client) {
                $scope.client = client;
            };

    }]);