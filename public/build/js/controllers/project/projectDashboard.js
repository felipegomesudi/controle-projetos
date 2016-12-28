angular.module('app.controllers')
    .controller('ProjectDashboardController',
        ['$scope', '$location', '$routeParams', 'appConfig', 'Project',
        function ($scope, $location, $routeParams, appConfig, Project) {

            $scope.project = {

            };

            $scope.status = appConfig.project.status;

            $scope.getStatus = function($id) {
                for (var i = 0; i < $scope.status.length; i++) {
                    if($scope.status[i].value === $id){
                        return $scope.status[i].label;
                    }
                }
                return "";
            };

            Project.query({
                orderBy: 'created_at',
                sortedBy: 'desc',
                limit: 5
            }, function (response) {
                $scope.projects = response.data;
            });

            $scope.showProject = function (project) {
                $scope.project = project;
            };

    }]);