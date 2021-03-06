<!DOCTYPE html>
<html data-ng-app="EHaaletamineApp">
<head lang="en">
    <meta charset="UTF-8">
    <title>E-h&auml;&auml;letamine</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap-papertheme.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- angular -->
    <script src="js/angular.min.js"></script>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/angular-route.js"></script>
    <script src="js/angular-messages.min.js"></script>
    <script src="js/ngFacebook.js"></script>
    <!-- bootstrap -->
    <script src="js/bootstrap.js"></script>

    <!-- App script-->
    <script src="app/js/main.js"></script>
</head>

<body data-ng-controller="FBCtrl">
<!-- Header -->
<div data-ng-include="'app/partials/blocks/header.html'"></div>


<!-- Sisu -->
<div class="container">
    <div data-ng-view></div>
</div>

</body>
</html>