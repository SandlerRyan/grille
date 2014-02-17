'use strict';

// the grilleController contains two objects:
// - grille: contains the product list
// - order: the shopping order object
function grilleController($scope, $routeParams, DataService) {

    // get grille and order from service
    $scope.grille = DataService.grille;
    $scope.order = DataService.order;

    // use routing to pick the selected product
    if ($routeParams.productId != null) {
        $scope.product = $scope.grille.getProduct($routeParams.productId);
    }
}
