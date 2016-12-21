/*global angular*/

var app = angular.module("lillyTemplate", ["ngRoute"])
                .config(["$routeProvider", function ($routeProvider) {
                  $routeProvider
                    .when("/landing",
                    {
                        templateUrl: "templates/landing.html"
                    })
                    .when("/wedding",
                    {
                        templateUrl: "templates/wedding.html"
                    })
                    .when("/destination",
                    {
                        templateUrl: "templates/destination.html"
                    })
                    .when("/contact",
                    {
                        templateUrl: "templates/contact.html"
                    })
                    .when("/faq",
                    {
                        templateUrl: "templates/faq.html"
                    })
                    .otherwise({redirectTo: "/landing"});
}]);