/**
 * Created by vellovaherpuu on 08/02/15.
 */
var app = angular.module('EHaaletamineApp', ['ngRoute']);

//Controllers
app.controller('MainController', function($scope) {
    $scope.person = {greeted: false};
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
});
app.controller('ElectController', function($scope,$http) {
    $scope.getCandidates=function(){
        $http.get('app/scripts/getCandidates.php').success(function(data) {
            $scope.kandidaadid=data;
            console.log(data);
        });
    };
    $scope.getCandidates();
    $scope.addVote=function(id){
        $http.post('app/scripts/addVote.php',{id:id}).success(function(data){
            $scope.message="Hääl edukalt antud!";
            $scope.kandid=null;
            $scope.getCandidates();
        });
    }
});
app.controller('ResultsController', function($scope) {
    $scope.test = "Tulemused"
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
        .when('/valima',{
            templateUrl:'app/partials/valima.html',
            controller:'ElectController'
        })
        .when('/tulemused',{
            templateUrl:'app/partials/tulemused.html',
            controller:'ResultsController'
        });
    $routeProvider.otherwise({redirectTo: '/'});
}]);
