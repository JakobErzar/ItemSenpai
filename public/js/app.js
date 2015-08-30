// script.js

// create the module and name it itemSenpai
var itemSenpai = angular.module('itemSenpai', ['ngRoute']);
 // configure our routes
itemSenpai.config(function($routeProvider, $locationProvider) {
    $routeProvider

        // route for the home page
        .when('/', {
            templateUrl : 'pages/home.html',
            controller  : 'mainController'
        })

        // route for the about page
        .when('/about', {
            templateUrl : 'pages/about.html',
            controller  : 'aboutController'
        })

        // route for the contact page
        .when('/contact', {
            templateUrl : 'pages/contact.html',
            controller  : 'contactController'
        });
        // use the HTML5 History API
        $locationProvider.html5Mode({enabled: true, requireBase:false});
});


itemSenpai.factory('firstPageService', function($http) {
    return {
        getFun : function() {
            return $http.get('/api/random/build');
        }
    }
})



// create the controller and inject Angular's $scope
itemSenpai.controller('mainController', function($scope, firstPageService) {
    // create a message to display in our view
    $scope.fun = {};
    $scope.fun.background_url = 'http://ddragon.leagueoflegends.com/cdn/img/champion/splash/Garen_0.jpg';
    firstPageService.getFun().success(function (res) {
        $scope.fun.background_url = res.champion.splash;
        $scope.fun.items = res.items;       
    });
    
    $scope.work = {}
    $scope.work.background_url = 'http://ddragon.leagueoflegends.com/cdn/img/champion/splash/Azir_0.jpg';
    firstPageService.getFun().success(function (res) {
        $scope.work.background_url = res.champion.splash;        
    });
});

itemSenpai.controller('aboutController', function($scope) {
    $scope.message = 'Look! I am an about page.';
});

itemSenpai.controller('contactController', function($scope) {
    $scope.message = 'Contact us! JK. This is just a demo.';
});
