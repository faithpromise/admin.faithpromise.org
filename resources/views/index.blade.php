<!DOCTYPE html>
<html ng-app="admin">

    <head>
        <base href="/">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin</title>

        <script src="https://use.typekit.net/xhr7ioc.js"></script>
        <script>try {Typekit.load({async: false});} catch (e) {}</script>

        <!-- build:style admin -->
        <link rel="stylesheet" href="/build/admin.dev.css">
        <!-- /build -->
    </head>

    <body>

        <div class="Nav">
            <div class="Nav-container">
                <a class="Nav-logoWrap" href="">
                    <svg class="Nav-logo" role="img" title="Faith Promise Church Logo">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/build/general.svg#logo-faith-promise"></use>
                    </svg>
                </a>
                <ul class="Nav-menu">
                    <li class="Nav-item">
                        <a nav-button class="Nav-link" href="/admin/events">Events</a>
                    </li>
                    <li class="Nav-item">
                        <a nav-button class="Nav-link" href="/admin/series">Series</a>
                    </li>
                    <li class="Nav-item">
                        <a nav-button class="Nav-link" href="/admin/staff">Staff</a>
                    </li>
                    <li class="Nav-item" uib-dropdown>
                        <span nav-button class="Nav-link Nav-link--dropdown" uib-dropdown-toggle>More</span>
                        <ul class="NavDropdown">
                            <li class="NavDropdown-item">
                                <a nav-button class="NavDropdown-link" href="/admin/ministries">Ministries</a>
                            </li>
                            <li class="NavDropdown-item">
                                <a nav-button class="NavDropdown-link" href="/admin/missions">Missions</a>
                            </li>
                            <li class="NavDropdown-item">
                                <a nav-button class="NavDropdown-link" href="/admin/topics">Topics</a>
                            </li>
                            <li class="NavDropdown-item">
                                <a nav-button class="NavDropdown-link" href="/admin/campuses">Campuses</a>
                            </li>
                            <li class="NavDropdown-item">
                                <a nav-button class="NavDropdown-link" href="/admin/studies">Studies</a>
                            </li>
                            <li class="NavDropdown-item">
                                <a nav-button class="NavDropdown-link" href="/admin/volunteer-positions">Vol Positions</a>
                            </li>
                        </ul>
                    </li>

                </ul>
                <div class="Nav-account">
                    <div class="Nav-item">
                        <a class="Nav-link" href="/requests/new">
                            <i class="icon-paper-plane"></i> Request
                        </a>
                    </div>
                    <div class="Nav-item">
                        <a class="Nav-link" href="http://faithpromise.zendesk.com">
                            <i class="Nav-linkIcon icon-lifebuoy"></i> Help Desk
                        </a>
                    </div>
                </div>
                <div class="Nav-profile">
                    <div class="Nav-item">
                        <span class="Nav-link">
                            <img class="Nav-profileImage" src="http://d3m6gouty6q7nm.cloudfront.net/sm/quarter/images/staff/brandon-dunford-square.jpg?v=1438638001&">
                            <i class="Nav-linkIcon icon-down-open"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="Layout">

            <div class="Layout-content">
                <ng-view autoscroll="true"></ng-view>
            </div>
        </div>

        <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular-animate.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular-route.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular-resource.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>

        <!-- build:script admin -->
        <script src="/build/admin.dev.js"></script>
        <!-- /build -->

    </body>

</html>