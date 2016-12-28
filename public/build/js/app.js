var app = angular.module('app', [
    'ngRoute',
    'angular-oauth2',
    'app.controllers',
    'app.filters',
    'app.directives',
    'app.services',
    'ui.bootstrap.typeahead',
    'ui.bootstrap.datepicker',
    'ui.bootstrap.tpls',
    'ui.bootstrap.modal',
    'ngFileUpload',
    'http-auth-interceptor',
    'angularUtils.directives.dirPagination',
    'ui.bootstrap.dropdown',
    'pusher-angular',
    'ui-notification'
]);

angular.module('app.controllers', ['ngMessages', 'angular-oauth2']);
angular.module('app.filters', []);
angular.module('app.directives', [])
angular.module('app.services', ['ngResource']);

app.provider('appConfig', ['$httpParamSerializerProvider', function($httpParamSerializerProvider){
    var config = {
        baseUrl: 'http://localhost:8000',
        pusherKey: 'feb23615ae097be86a8f',
        project: {
            status: [
                {value: 1, label: 'Não Iniciado'},
                {value: 2, label: 'Iniciado'},
                {value: 3, label: 'Concluído'}
            ]
        },
        projectTask: {
            status: [
                {value: 1, label: 'Incompleta'},
                {value: 2, label: 'Completa'}
            ]
        },
        urls: {
            projectFile: '/project/{{id}}/file/{{idFile}}'
        },
        utils: {
            transformRequest: function (data){
                if(angular.isObject(data)){
                    return $httpParamSerializerProvider.$get()(data);
                }
                return data;
            },
            transformResponse: function (data, headers) {
                var headersGetter = headers();
                if(headersGetter['content-type'] == 'application/json' || headersGetter['content-type'] == 'text/json'){
                    var dataJson = JSON.parse(data);
                    if(dataJson.hasOwnProperty('data') && Object.keys(dataJson).length == 1){
                        dataJson = dataJson.data;
                    }
                    return dataJson;
                }
                return data;
            }
        }
    };

    return {
        config: config,
        $get: function () {
            return config;
        }
    }
}]);

app.config([
    '$routeProvider',
    '$httpProvider',
    'OAuthProvider',
    'OAuthTokenProvider',
    'appConfigProvider',
    function($routeProvider, $httpProvider, OAuthProvider, OAuthTokenProvider, appConfigProvider){

    $httpProvider.defaults.headers.post['Content-Type'] = "application/x-www-form-urlencoded;charset=utf-8";
    $httpProvider.defaults.headers.put['Content-Type']  = "application/x-www-form-urlencoded;charset=utf-8";
    $httpProvider.defaults.transformRequest  = appConfigProvider.config.utils.transformRequest;
    $httpProvider.defaults.transformResponse = appConfigProvider.config.utils.transformResponse;
    $httpProvider.interceptors.splice(0,1);
    $httpProvider.interceptors.splice(0,1);
    $httpProvider.interceptors.push('oauthFixInterceptor');

    $routeProvider
        .when('/login',{
            templateUrl: 'build/views/login.html',
            controller: 'LoginController'
        })
        .when('/logout',{
            resolve: {
                logout: ['$location', 'OAuthToken', function($location, OAuthToken){
                    OAuthToken.removeToken();
                    return $location.path('/login');
                }]
            }
        })
        .when('/home',{
            templateUrl: 'build/views/home.html',
            controller: 'HomeController',
            title: 'Home'
        })
        .when('/clients/dashboard',{
            templateUrl: 'build/views/client/dashboard.html',
            controller: 'ClientDashboardController',
            title: 'Clients'
        })
        .when('/clients',{
            templateUrl: 'build/views/client/list.html',
            controller: 'ClientListController',
            title: 'Clients'
        })
        .when('/client/new',{
            templateUrl: 'build/views/client/new.html',
            controller: 'ClientNewController',
            title: 'Clients'
        })
        .when('/client/:id/edit',{
            templateUrl: 'build/views/client/edit.html',
            controller: 'ClientEditController',
            title: 'Clients'
        })
        .when('/client/:id/remove',{
            templateUrl: 'build/views/client/remove.html',
            controller: 'ClientRemoveController',
            title: 'Clients'
        })
        .when('/project/:id/notes',{
            templateUrl: 'build/views/project-note/list.html',
            controller: 'ProjectNoteListController',
            title: 'Projects Notes'
        })
        .when('/project/:id/note/:idNote/show',{
            templateUrl: 'build/views/project-note/show.html',
            controller: 'ProjectNoteShowController',
            title: 'Projects Notes'
        })
        .when('/project/:id/note/new',{
            templateUrl: 'build/views/project-note/new.html',
            controller: 'ProjectNoteNewController',
            title: 'Projects Notes'
        })
        .when('/project/:id/note/:idNote/edit',{
            templateUrl: 'build/views/project-note/edit.html',
            controller: 'ProjectNoteEditController',
            title: 'Projects Notes'
        })
        .when('/project/:id/note/:idNote/remove',{
            templateUrl: 'build/views/project-note/remove.html',
            controller: 'ProjectNoteRemoveController',
            title: 'Projects Notes'
        })
        .when('/projects/dashboard',{
            templateUrl: 'build/views/project/dashboard.html',
            controller: 'ProjectDashboardController',
            title: 'Projects'
        })
        .when('/projects',{
            templateUrl: 'build/views/project/list.html',
            controller: 'ProjectListController',
            title: 'Projects'
        })
        .when('/project/new',{
            templateUrl: 'build/views/project/new.html',
            controller: 'ProjectNewController',
            title: 'Projects'
        })
        .when('/project/:id/edit',{
            templateUrl: 'build/views/project/edit.html',
            controller: 'ProjectEditController',
            title: 'Projects'
        })
        .when('/project/:id/remove',{
            templateUrl: 'build/views/project/remove.html',
            controller: 'ProjectRemoveController',
            title: 'Projects'
        })
        .when('/project/:id/files',{
            templateUrl: 'build/views/project-file/list.html',
            controller: 'ProjectFileListController',
            title: 'Projects Files'
        })
        .when('/project/:id/file/new',{
            templateUrl: 'build/views/project-file/new.html',
            controller: 'ProjectFileNewController',
            title: 'Projects Files'
        })
        .when('/project/:id/file/:idFile/edit',{
            templateUrl: 'build/views/project-file/edit.html',
            controller: 'ProjectFileEditController',
            title: 'Projects Files'
        })
        .when('/project/:id/file/:idFile/remove',{
            templateUrl: 'build/views/project-file/remove.html',
            controller: 'ProjectFileRemoveController',
            title: 'Projects Files'
        })
        .when('/project/:id/tasks',{
            templateUrl: 'build/views/project-task/list.html',
            controller: 'ProjectTaskListController',
            title: 'Projects Tasks'
        })
        .when('/project/:id/task/new',{
            templateUrl: 'build/views/project-task/new.html',
            controller: 'ProjectTaskNewController',
            title: 'Projects Tasks'
        })
        .when('/project/:id/task/:idTask/edit',{
            templateUrl: 'build/views/project-task/edit.html',
            controller: 'ProjectTaskEditController',
            title: 'Projects Tasks'
        })
        .when('/project/:id/task/:idTask/remove',{
            templateUrl: 'build/views/project-task/remove.html',
            controller: 'ProjectTaskRemoveController',
            title: 'Projects Tasks'
        })
        .when('/project/:id/members',{
            templateUrl: 'build/views/project-member/list.html',
            controller: 'ProjectMemberListController',
            title: 'Projects Members'
        })
        .when('/project/:id/member/:idProjectMember/remove',{
            templateUrl: 'build/views/project-member/remove.html',
            controller: 'ProjectMemberRemoveController',
            title: 'Projects Members'
        })
        OAuthProvider.configure({
            baseUrl: appConfigProvider.config.baseUrl,
            clientId: 'appid1',
            clientSecret: 'secret',
            grantPath: 'oauth/access_token'
        });
        OAuthTokenProvider.configure({
            name: 'token',
            options: {
                secure: false
            }
        });
}]);

app.run(['$rootScope', '$location', '$http', '$modal', '$cookies', '$pusher', '$filter', 'httpBuffer', 'OAuth', 'appConfig', 'Notification',
    function($rootScope, $location, $http, $modal, $cookies, $pusher, $filter, httpBuffer, OAuth, appConfig, Notification) {

    $rootScope.$on('pusher-build', function (event, data) {
        if(data.next.$$route.originalPath != '/login'){
            if(OAuth.isAuthenticated()){
                if(!window.client) {
                    window.client = new Pusher(appConfig.pusherKey);
                    var pusher = $pusher(window.client);
                    var channel = pusher.subscribe('user.' + $cookies.getObject('user').id);
                    channel.bind('ControleProjetos\\Events\\TaskWasIncluded',
                        function (data) {
                            var name = data.task.name;
                            var start_date = data.task.start_date;
                            var msgm = "Tarefa '"+name+"' foi incluída!";

                            if(start_date != null){
                                msgm += "<br> Data de início: "+$filter('dateBr')(start_date);
                            }

                            Notification.success(msgm);
                        }
                    );
                    channel.bind('ControleProjetos\\Events\\TaskChanged',
                        function (data) {
                            var name = data.task.name;
                            var start_date = data.task.start_date;
                            var msgm = "Tarefa '"+name+"' foi alterada!";

                            if(data.task.status == 2){
                                msgm = "Tarefa '"+name+"' foi concluída!";
                            }
                            Notification.success(msgm);
                        }
                    );
                }
            }
        }
    });

    $rootScope.$on('pusher-destroy', function (event, data) {
        if(data.next.$$route.originalPath == '/login'){
            if(window.client){
                window.client.disconnect();
                window.client = null;
            }
        }
    });

    $rootScope.$on('$routeChangeStart', function(event, next, current){
        if(next.$$route.originalPath != '/login'){
            if(!OAuth.isAuthenticated()){
                $location.path('login');
            }
        }
        $rootScope.$emit('pusher-build', {next: next});
        $rootScope.$emit('pusher-destroy', {next: next});
    });

    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.pageTitle = current.$$route.title;
    });

    $rootScope.$on('oauth:error', function(event, data) {
        // Ignore `invalid_grant` error - should be catched on `LoginController`.
        if ('invalid_grant' === data.rejection.data.error) {
            return;
        }

        // Refresh token when a `invalid_token` error occurs.
        if ('access_denied' === data.rejection.data.error) {
            httpBuffer.append(data.rejection.config, data.deferred);
            if(!$rootScope.loginModalOpened){
                var modalInstance = $modal.open({
                    templateUrl: 'build/views/templates/loginModal.html',
                    controller: 'LoginModalController'
                });
                $rootScope.loginModalOpened = true;
            }
            return;
        }

        return $location.path('login');
    });
}]);