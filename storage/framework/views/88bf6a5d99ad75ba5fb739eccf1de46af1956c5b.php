<!DOCTYPE html>
<html ng-app="admin">

    <head>
        <base href="/">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin</title>

        <script src="https://use.typekit.net/xhr7ioc.js"></script>
        <script>try {Typekit.load({ async: false });} catch (e) {}</script>

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/pikaday/1.2.0/css/pikaday.min.css">
        <!-- build:style admin -->
        <link rel="stylesheet" href="/build/admin.dev.css">
        <!-- /build -->
    </head>

    <body>

        <div ui-view></div>

        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/pikaday/1.2.0/pikaday.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular-animate.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.15/angular-ui-router.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular-resource.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular-cookies.min.js"></script>
        <!--[if lte IE 9]>
        <script src="//cdnjs.cloudflare.com/ajax/libs/Base64/0.3.0/base64.min.js"></script>
        <![endif]-->
        <script src="//cdn.jsdelivr.net/satellizer/0.12.5/satellizer.min.js"></script>

        <script>
            (function () {
                angular.module('siteConfig', []).constant('USER', <?php echo isset($user) && $user ? $user->toJson() : 'null'; ?>);
            })(angular);
        </script>

        <!-- build:script admin -->
        <script src="/build/admin.dev.js"></script>
        <!-- /build -->

    </body>

</html>