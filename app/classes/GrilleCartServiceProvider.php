<?php
use Moltin\Cart\CartServiceProvider as CartServiceProvider;

class GrilleCartServiceProvider extends CartServiceProvider {
    public function register()
    {
        $this->app->singleton('cart', function() {
            return new GrilleCart($this->getStorageService(), $this->getIdentifierService());
        });
    }
}