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
app.controller('CandidatesController', function($scope,$http) {
    $scope.test = "Kandidaat"
    $http.get('app/scripts/getCandidates.php').success(function(data) {//replace url
        $scope.kandidaadid=data;
    });
});
app.controller('ElectController', function($scope) {
    $scope.test = "Valimine"
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
        .when('/kandidaadid',{
            templateUrl:'app/partials/kandidaadid.html',
            controller:'CandidatesController'
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
