//----------------------------------------------------------------
// grille (contains the products)
//
function grille() {
    this.products = [
        new product(1, "Hamburger", "", 4.75),
        new product(2, "Cheeseburger", "", 5.25),
        new product(3, "Domus Domus", "", 5.25),
    ];
}

grille.prototype.getProduct = function (id) {
    for (var i = 0; i < this.products.length; i++) {
        if (this.products[i].id == id)
            return this.products[i];
    }
    return null;
}
