<?php

use Moltin\Cart\Item;
class GrilleStore extends \Moltin\Cart\Storage\Session implements \Moltin\Cart\StorageInterface
{
    public function insertUpdateAddon(Item $item, Item $addon)
    {
        static::$cart[$this->id][$item->identifier] = $item;
    }