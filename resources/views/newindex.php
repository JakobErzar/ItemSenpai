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
    <!-- SPELLS -->
    <!-- load angular and angular route via CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.18/angular.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.18/angular-route.js"></script>
    <script src="js/app.js"></script>
    <title>Item Senpai</title>
</head>
<body>

    <!-- HEADER AND NAVBAR -->
    <!--header>
        <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">Angular Routing Example</a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li><a href=""><i class="fa fa-home"></i> Home</a></li>
                <li><a href="about"><i class="fa fa-shield"></i> About</a></li>
                <li><a href="contact"><i class="fa fa-comment"></i> Contact</a></li>
            </ul>
        </div>
        </nav>
    </header-->

    <!-- MAIN CONTENT AND INJECTED VIEWS -->
    <div id="main" class="container">
        <!-- angular templating -->
        <!-- this is where content will be injected -->

        <div ng-view></div>
        
    </div>

</body>
</html>