/**
 * Created by vellovaherpuu on 08/02/15.
 */
var app = angular.module('EHaaletamineApp', ['ngRoute','ngMessages','ngFacebook']);
//FB
app.config(['$facebookProvider', function($facebookProvider) {
    $facebookProvider.setAppId('1576460085946716').setPermissions(['email','user_friends']);
    $facebookProvider.setVersion("v2.2");
}]);
app.run(['$rootScope', '$window', function($rootScope, $window) {
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    $rootScope.$on('fb.load', function() {
        $window.dispatchEvent(new Event('fb.load'));
    });
}]);
//FB Controller
app.controller('FBCtrl', ['$scope', '$facebook','$http','$rootScope','$location', function($scope, $facebook,$http,$rootScope,$location) {
    $scope.$on('fb.auth.authResponseChange', function() {
        $scope.status = $facebook.isConnected();
        if($scope.status) {
            $facebook.api('/me').then(function(user) {
                $rootScope.user = user;
                $http.post("app/scripts/addUser.php",
                    {
                        firstName:$scope.user.first_name,
                        lastName:$scope.user.last_name,
                        fbid:$scope.user.id,
                        email:$scope.user.email
                    }
                )
                    .success(function(data, status, headers, config){
                        //Set user role
                        $scope.user.role=data[0].role;
                        console.log(user);
                    });

            });
        }
    });
    $scope.loginToggle = function() {
        if($scope.status) {
            $facebook.logout();
            $rootScope.user={};
            $location.path('/');
        } else {
            $facebook.login();
        }
    };

    $scope.getFriends = function() {
        if(!$scope.status) return;
        $facebook.cachedApi('/me/friends').then(function(friends) {
            $scope.friends = friends.data;
        });
    }
}]);

//Controllers
app.controller('MainController', function($scope,$facebook) {
});
app.controller("NavController",function($scope,$http,$location){
    $http.get('menu.json').success(function(data) {
        $scope.menu = data;
    });
    $scope.isActive = function(route) {
        return route === $location.path();
    }
});
app.controller('HomeController', function($scope) {
    $scope.test = "Kodu"
});
app.controller('ElectionsController', function($scope,$http) {
    $http.get('app/scripts/getElections.php').success(function(data) {
        $scope.valimised=data;
        console.log(data);
    });
    $scope.checkIfCandidate=function(electionId){
        if($scope.user) {
            $http.get('app/scripts/checkIfCandidate.php', {
                params: {
                    electionId: electionId,
                    userId: $scope.user.id
                }
            }).success(function (data) {
               $scope.isCandidate=data.isCandidate;
            });
        }
    };
});
app.controller('ElectController', function($scope,$http,$routeParams) {
    $scope.getCandidates=function(){
        $http.get('app/scripts/getCandidates.php',{params:{electionId:$routeParams.electionId}}).success(function(data) {
            $scope.kandidaadid=data;
        });
    };
    $scope.getCandidates();
    
    $scope.checkIfVoted=function(candidateId){
        if($scope.user) {
            $http.get('app/scripts/checkIfVoted.php', {
                params: {
                    electionId: $routeParams.electionId,
                    userId: $scope.user.id,
                    candidateId: candidateId
                }
            }).success(function (data) {
               $scope.hasVoted=data.hasVoted;
            });
        }
    };

    $scope.deleteVote=function(id){
        $http.post('app/scripts/deleteVote.php',{candidateId:id,electionId:$routeParams.electionId, userId:$scope.user.id}).success(function(data){
            $scope.message="Hääl edukalt kustutatud!";
            $scope.kandid=null;
            $scope.getCandidates();
        });
    }
    
    $scope.addVote=function(id){
        $http.post('app/scripts/addVote.php',{candidateId:id,electionId:$routeParams.electionId, userId:$scope.user.id}).success(function(data){
            $scope.message="Hääl edukalt antud!";
            $scope.kandid=null;
            $scope.getCandidates();
        });
    }
});
app.controller('ResultsController', function($scope) {
    $scope.test = "Tulemused"
});
app.controller('NewController', function($scope,$http,$location) {
    $scope.valimine={
        nimetus:'',
        kirjeldus:''
    };
    $scope.submit=function(){
        $scope.submitted=true;
        if($scope.uusValimine.$valid){
            $http.post('app/scripts/newElection.php',{valimine:$scope.valimine}).success(function(data){
                $location.path('/valimised');
            });
        }
    };
});
app.controller('CandidateController', function($scope,$routeParams,$http,$location) {
    $scope.kandidaat={
        eesnimi:$scope.user.first_name,
        perenimi:$scope.user.last_name,
        kirjeldus:'',
        electionId:$routeParams.electionId,
        userId:$scope.user.id
    };
    $scope.submit=function(){
        $scope.submitted=true;
        if($scope.kandideeri.$valid){
            $http.post('app/scripts/kandideeri.php',{kandidaat:$scope.kandidaat}).success(function(data){
                $location.path('/valimised');
            });
        }
    }
});

//Routes
app.config(['$routeProvider', function($routeProvider)  {
    $routeProvider
        .when('/', {
            templateUrl: 'app/partials/avaleht.html',
            controller: 'HomeController'
        })
        .when('/valimised',{
            templateUrl:'app/partials/valimised.html',
            controller:'ElectionsController'
        })
        .when('/valima/:electionId',{
            templateUrl:'app/partials/valima.html',
            controller:'ElectController'

        })
        .when('/uus',{
            templateUrl:'app/partials/uus.html',
            controller:'NewController',
            AdminLogin :true
        })
        .when('/kandideeri/:electionId',{
            templateUrl:'app/partials/kandideeri.html',
            controller:'CandidateController',
            Login :true
        })

    $routeProvider.otherwise({redirectTo: '/'});
}]);

//Ei luba keelatud lehtedele.
app.run(['$rootScope',function($rootScope) {
    $rootScope.$on("$routeChangeStart", function(event, next, current) {
        if(next.AdminLogin && (!$rootScope.user || $rootScope.user.role!='admin')) {
            event.preventDefault();
        }
        if(next.Login && (!$rootScope.user || ($rootScope.user.role!='user' && $rootScope.user.role!='admin'))){
            event.preventDefault();
        }
    });
}]);

//Filters
app.filter('capitalize', function() {
    return function(input, scope) {
        if (input!=null ){
            input = input.toLowerCase();
            return input.substring(0,1).toUpperCase()+input.substring(1);
        }
        return input;
    }
});