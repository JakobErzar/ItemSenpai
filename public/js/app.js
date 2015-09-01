// script.js

// create the module and name it itemSenpai
var itemSenpai = angular.module('itemSenpai', ['ui.router']); //, '
 // configure our routes
itemSenpai.config(function($stateProvider, $urlRouterProvider, $locationProvider) {
        
    $urlRouterProvider.otherwise('/');
    
    $stateProvider
        .state('home', {
            url: '/',
            templateUrl: 'pages/home.html',
            controller: 'mainController'
        })
        .state('fun', {
            url: '/fun',
            abstract: true,
            templateUrl: 'pages/fun.html',
            controller: 'funController'
        })
        .state('fun.randombuild', {
            url: '/randombuild',
            templateUrl: 'pages/fun/randombuild.html',
            controller: 'randomBuildController'
        })
        .state('fun.funbuild', {
            url: '/funbuild',
            templateUrl: 'pages/fun/funbuild.html',
            controller: 'funBuildController'
        })
        .state('fun.teamcomp', {
            url: '/teamcomp',
            templateUrl: 'pages/fun/teamcomp.html',
            controller: 'teamCompController'
        });
    
    
    // use the HTML5 History API
    $locationProvider.html5Mode({enabled: true, requireBase:false});
});


itemSenpai.factory('firstPageService', function($http) {
    return {
        getFun : function() {
            return $http.get('/api/memebuild/random');
        },
        getWork : function() {
            return $http.get('/api/winrate/random');
        }
    }
});

itemSenpai.factory('randomBuildService', function($http) {
    return {
        getBuild : function() {
            return $http.get('/api/random/build');
        }
    }
});

itemSenpai.factory('funBuildService', function($http) {
    return {
        getBuild : function() {
            return $http.get('/api/memebuild/random');
        }
    }
});

itemSenpai.factory('teamCompService', function($http) {
    return {
        getBuild : function() {
            return $http.get('/api/teamcomps/random');
        }
    }
});




// create the controller and inject Angular's $scope
itemSenpai.controller('mainController', function($scope, firstPageService) {
    // create a message to display in our view
    $scope.fun = {};
    $scope.fun.background_url = 'http://ddragon.leagueoflegends.com/cdn/img/champion/splash/Garen_0.jpg';
    firstPageService.getFun().success(function (res) {
        $scope.fun.background_url = res.itemset[0].champion.splash;
        $scope.fun.items = res.itemset[0].items;       
    });
    
    $scope.work = {}
    $scope.work.background_url = 'http://ddragon.leagueoflegends.com/cdn/img/champion/splash/Azir_0.jpg';
    firstPageService.getWork().success(function (res) {
        $scope.work.background_url = res.itemsets[0].champion.splash;
        $scope.work.items = res.itemsets[0].items;        
    });
});


itemSenpai.controller('funController', function($scope) {
    $scope.champions = [];
    $scope.itemsets = [];
    $scope.name = null;
    $scope.description = null;
    $scope.video = null;
});

itemSenpai.controller('randomBuildController', function($scope, randomBuildService) {
    $scope.$parent.activeRandom = 'active';
    $scope.$parent.activeFun = '';
    $scope.$parent.activeTeam = '';
    
    $scope.generateBuild = function() {
        randomBuildService.getBuild().success(function (res) {
            $scope.$parent.name = 'Random ' + res.champion.name;
            $scope.$parent.champions = [{image: res.champion.splash }];
            $scope.$parent.itemsets = [{items: res.items}];
        })
        
    }
    
    $scope.generateBuild();
});

itemSenpai.controller('funBuildController', function($scope, funBuildService, $sce) {
    $scope.$parent.activeRandom = '';
    $scope.$parent.activeFun = 'active';
    $scope.$parent.activeTeam = '';
    
    $scope.generateBuild = function() {
        funBuildService.getBuild().success(function (res) {
            $scope.$parent.name = res.name;
            $scope.$parent.description = res.description;
            var vid = '<iframe width="600" height="475" src="' + res.video + '" frameborder="0" allowfullscreen></iframe>'; 
            $scope.$parent.video = $sce.trustAsHtml(vid);
            $scope.$parent.champions = [{image: res.itemset[0].champion.splash} ];
            $scope.$parent.itemsets = [res.itemset[0]];
            $scope.$parent.download = '/api/memebuild/make/'+res.id;
        })
        
    }
    
    $scope.generateBuild();
});

itemSenpai.controller('teamCompController', function($scope, teamCompService, $sce) {
    $scope.$parent.activeRandom = '';
    $scope.$parent.activeFun = '';
    $scope.$parent.activeTeam = 'active';
    
    $scope.generateBuild = function() {
        teamCompService.getBuild().success(function (res) {
            $scope.$parent.name = res.name;
            $scope.$parent.description = res.description;
            var vid = '<iframe width="600" height="475" src="' + res.video + '" frameborder="0" allowfullscreen></iframe>'; 
            $scope.$parent.video = $sce.trustAsHtml(vid);
            $scope.$parent.$apply();
            $scope.$parent.champions = [];
            var counter = 0;
            res.itemsets.forEach(function(itemset) {
                if (counter < 5) $scope.$parent.champions.push({image: itemset.champion.splash, loading: itemset.champion.loading });
                counter++;
            }, this);
            $scope.$parent.itemsets = res.itemsets;
        })
        
    }
    
    $scope.generateBuild();
});