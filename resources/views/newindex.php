<!DOCTYPE html>
<html ng-app="itemSenpai">
<head>
    <base href="/">
    <meta charset="utf-8">
    <!-- SCROLLS -->
    <!-- load bootstrap and fontawesome via CDN -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <!-- SPELLS -->
    <!-- load angular and angular route via CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.18/angular.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.18/angular-route.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.15/angular-ui-router.js"></script>
    <script src="js/app.js"></script>
    <title>Item Senpai</title>
</head>
<body>
    <div class="text-center">
        <img src="/logo.png">
        <div class="lead">
            Let the senpai show you the ways of the item sets.
        </div>
    </div>

    <!-- MAIN CONTENT AND INJECTED VIEWS -->
    <div id="main" class="container">
        <!-- angular templating -->
        <!-- this is where content will be injected -->

        <div ui-view></div>
        
    </div>

</body>
</html>