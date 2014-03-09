<?php

/**
 * This file is part of Moltin Cart, a PHP package to handle
 * your shopping basket.
 *
 * Copyright (c) 2013 Moltin Ltd.
 * http://github.com/moltin/cart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package moltin/cart
 * @author Chris Harvey <chris@molt.in>
 * @copyright 2013 Moltin Ltd.
 * @version dev
 * @link http://github.com/moltin/cart
 *
 */

namespace Moltin\Cart;

use InvalidArgumentException;
use Moltin\Currency\Currency;

class Cart
{
    protected $id;
    
    protected $identifier;
    protected $store;
    
    protected $currency;

    protected $requiredParams = array(
        'id',
        'name',
        'quantity',
        'price',
        'addons',
    );

    /**
     * Cart constructor
     * 
     * @param StorageInterface    $store      The interface for storing the cart data
     * @param IdentifierInterface $identifier The interface for storing the identifier
     */
    public function __construct(StorageInterface $store, IdentifierInterface $identifier)
    {
        $this->store = $store;
        $this->identifier = $identifier;

        // Generate/retrieve identifier
        $this->id = $this->identifier->get();

        // Restore the cart from a saved version
        if (method_exists($this->store, 'restore')) $this->store->restore($this->id);

        // Let our storage class know which cart we're talking about
        $this->store->setIdentifier($this->id);
    }

    /**
     * Retrieve the cart contents
     * 
     * @return array An array of Item objects
     */
    public function &contents($asArray = false)
    {
        return $this->store->data($asArray);
    }

    /**
     * Insert an item into the cart
     * 
     * @param  array  $item An array of item data
     * @return string       A unique item identifier
     */
    public function insert(array $item)
    {
        $this->checkArgs($item);

        $itemIdentifier = $this->createItemIdentifier($item);

        if ($this->has($itemIdentifier)) {
            $item['quantity'] = $this->item($itemIdentifier)->quantity + $item['quantity'];
            $item['addons'] = $this->item($itemIdentifier)->addons;
            $this->update($itemIdentifier, $item);

            return $itemIdentifier;
        }

        if ($item['quantity'] < 1) throw new InvalidArgumentException('Quantity can not be less than 1');

        $item = new Item($itemIdentifier, $item, $this->store);

        $this->store->insertUpdate($item);

        return $itemIdentifier;
    }

    /**
     * Update an item
     * 
     * @param  string $itemIdentifier The unique item identifier
     * @param  string|int|array $key  The key to update, or an array of key-value pairs
     * @param  mixed $value           The value to set $key to
     * @return void
     */
    public function update($itemIdentifier, $key, $value = null)
    {
        foreach ($this->contents() as $item) {

            if ($item->identifier == $itemIdentifier) {
                $item->update($key, $value);
                break;
            }

        }
    }

    /**
     * Remove an item from the cart
     * 
     * @param  string $identifier Unique item identifier
     * @return void
     */
    public function remove($identifier)
    {
        $this->store->remove($identifier);
    }

    /**
     * Destroy/empty the cart
     * 
     * @return void
     */
    public function destroy()
    {
        $this->store->destroy();
    }

    /**
     * Check if the cart has a specific item
     * 
     * @param  string  $itemIdentifier The unique item identifier
     * @return boolean                 Yes or no?
     */
    public function has($itemIdentifier)
    {
        return $this->store->has($itemIdentifier);
    }

    /**
     * Return a specific item object by identifier
     * 
     * @param  string $itemIdentifier The unique item identifier
     * @return Item                   Item object
     */
    public function item($itemIdentifier)
    {
        return $this->store->item($itemIdentifier);
    }

    /**
     * Returns the first occurance of an item with a given id
     * 
     * @param  string $id The item id
     * @return Item       Item object
     */
    public function find($id)
    {
        return $this->store->find($id);
    }

    /**
     * The total tax value for the cart
     * 
     * @return float The total tax value
     */
    public function tax()
    {
        $total = 0;

        foreach ($this->contents() as $item) $total += (float)$item->tax();

        return $total;
    }

    /**
     * The total value of the cart
     * 
     * @param  boolean $includeTax Include tax on the total?
     * @return float               The total cart value
     */
    public function total($includeTax = true)
    {
        $total = 0;

        foreach ($this->contents() as $item) $total += (float)$item->total($includeTax);

        return (float)$total;
    }

    /**
     * The total number of items in the cart
     * 
     * @param  boolean $unique Just return unique items?
     * @return int             Total number of items
     */
    public function totalItems($unique = false)
    {
        $total = 0;

        foreach ($this->contents() as $item) {
            $total += $unique ? 1 : $item->quantity;
        }

        return $total;
    }

    /**
     * Set the currency object
     * 
     * @param \Moltin\Currency\Currency $currency The currency object
     */
    public function setCurrency(Currency $currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the currency object
     * 
     * @return Currency The currency object for this cart
     */
    public function currency()
    {
        return $this->currency;
    }
    
    /**
     * Set the cart identifier, useful if restoring a saved cart
     * 
     * @param  mixed The identifier
     * @return void
     */
    public function setIdentifier($identifier)
    {
        $this->store->setIdentifier($identifier);
    }

    /**
     * Create a unique item identifier
     * 
     * @param  array  $item An array of item data
     * @return string       An md5 hash of item
     */
    protected function createItemIdentifier(array $item)
    {
        if ( ! array_key_exists('options', $item)) $item['options'] = array();

        ksort($item['options']);

        return md5($item['id'].serialize($item['options']));
    }

    /**
     * Check if a cart item has the required parameters
     * 
     * @param  array  $item An array of item data
     * @return void
     */
    protected function checkArgs(array $item)
    {
        foreach ($this->requiredParams as $param) {

            if ( ! array_key_exists($param, $item)) {
                throw new InvalidArgumentException("The '{$param}' field is required");
            }

        }
    }

    /** 
    * Returns the given item's array of addons if the item and addons exists
    * @param Item $item             \Moltin\Cart\Item object of the corresponding item
    * @return array $item_addons    array of the item's addons as \Moltin\Cart\Item objects
    */
    public function get_addons(Item $item)
    {
        // check if item and addon are actually in cart
        if (!$this->has($item->identifier)){
            throw new InvalidArgumentException('Specified item is not in the cart');
        }
        return $item->toArray()['addons'];
    }

    /**
    * Finds an addon by the id of the addon and the item it's attached to
    * @param int $addon_id          database id of the addon we're searching for
    * @param Item $item             \Moltin\Cart\Item object of the corresponding item
    * @return Item $addon           \Moltin\Cart\Item object of the addon attached to this item
    */
    public function find_addon($addon_id, Item $item)
    {
        $item_addons = $this->get_addons($item);
        return (array_key_exists($addon_id, $item_addons) ? $item_addons[$addon_id] : false);
    }

    /**
    * Insert an addon into the keys of its appropriate item
    * @param array $addon   an array of addon data (same required params as an item)
    * @param Item $item     an Item object of the addon's corresponding item
    * @return string        md5 hash identifier of the addon; false if too many addons
    */
    public function insert_addon (array $addon, Item $item)
    {
        $this->checkArgs($addon);

        $addonIdentifier = $this->createItemIdentifier($addon);
        // get all the item's current addons as an array
        $item_addons = $this->get_addons($item);

        // if the addon is already in the item's array, update qty
        if (array_key_exists($addon['id'], $item_addons))
        {
            // check if there are now more addons for the item than the quantity of the item itself
            if ($item->addons[$addon['id']]->quantity + $addon['quantity'] > $item->quantity){
                return false;
            }
            else {
                // update addon quantity
                $newqty = $item_addons[$addon['id']]->quantity + $addon['quantity'];
                $item_addons[$addon['id']]->update('quantity', $newqty); 

                // update the addons list for the item
                $item->update('addons',$item_addons);
                return $addonIdentifier;
            }
        }
        else 
        {
            // create the addon as an Item object and add it to the appropriate item
            $addon = new Item($addonIdentifier, $addon, $this->store);
            $item->addons = array($addon->id => $addon);

            return $addonIdentifier;
        }   
    }

    /**
    * Removes an addon from the given item
    * @param int $addon_id      the id of the addon
    * @param Item $item         Moltin\Cart\Item object with the addon
    * @return void
    */
    public function remove_addon($addon_id, Item $item)
    {

        // get the item's addons; throw error if the addon is not attached to the item
        $item_addons = $this->get_addons($item);
        if (!array_key_exists($addon_id, $item_addons)){
            throw new InvalidArgumentException ('This addon cannot be removed 
                because it does not exist for the specified item');
        }

        // remove the addon from the item's addons array
        unset($item_addons[$addon_id]);
        $item->update('addons', $item_addons);
    }

    /**
    * Updates the property of an addon attached to the given item
    * @param int $addon_id      the id of the addon
    * @param Item $item         Moltin\Cart\Item object with the addon
    * @param $key               addon property to be modified
    * @param $value             new value to assign to the key
    * @return void
    */
    public function update_addon($addon_id, Item $item, $key, $value=NULL)
    {
        // get the item's addons; throw error if the addon is not attached to the item
        $item_addons = $this->get_addons($item);

        if (!array_key_exists($addon_id, $item_addons)){
            throw new InvalidArgumentException ('This addon cannot be updated 
                because it does not exist for the specified item');
        }

        // make sure quantity does not go below zero and does not exceed item quantity
        if ($key == 'quantity' and $value < 1) {
            throw new InvalidArgumentException('Quantity can not be less than 1');
        }
        if ($key == 'quantity' and $value > $item->quantity){
            throw new InvalidArgumentException('Addon quantity cannot exceed item quantity');
        }

        // update the property
        $item_addons[$addon_id]->update($key, $value);
        $item->update('addons', $item_addons);
    }

    /**
    * Calculates total of the cart with addons included
    * @return float $total      Total value of the cart
    */
    public function total_with_addons()
    {
        $total = 0.;
        foreach($this->contents() as $item){
            // add total for the items
            $total += (float)$item->total();

            // now factor in the addon prices
            foreach($this->get_addons($item) as $addon){
                $total += $addon->total();
            }
        }
        return $total;
    }
}
