'use strict';

// App Module: the name AngularGrille matches the ng-app attribute in the main <html> tag
// the route provides parses the URL and injects the appropriate partial page
var grilleApp = angular.module('AngularGrille', []).
  config(['$routeProvider', function($routeProvider) {
  $routeProvider.
      when('/grille', {
        templateUrl: 'partials/grille.htm',
        controller: grilleController 
      }).
      when('/order', {
        templateUrl: 'partials/grilleOrder.htm',
        controller: grilleController
      }).
      otherwise({
        redirectTo: '/grille'
      });
}]);

// create a data service that provides a grille and a grille order that
// will be shared by all views (instead of creating fresh ones for each view).
grilleApp.factory("DataService", function () {

    // create grille
    var myGrille = new grille();

    // create grille order
    var myOrder = new grilleOrder("AngularGrille");

    // enable Stripe checkout
    // note: the second parameter identifies your publishable key; in order to use the 
    // grille order with Stripe, you have to create a merchant account with 
    // Stripe. You can do that here:
    // https://manage.stripe.com/register
    myOrder.addCheckoutParameters("Stripe", "pk_test_xxxx",
        {
            chargeurl: "https://localhost:1234/processStripe.aspx"
        }
    );

    // return data object with grille and order
    return {
        grille: myGrille,
        order: myOrder
    };
});