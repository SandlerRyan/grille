<?php

/**
* This class extends the Cart class written by Moltin to include 
* addon implementation, treating each addon as a separate but
* distinct instance of the Item class
*
* Each addon belonging to a particular item is inserted into the 'addons'
* property of that item, such that each item can have an array of addons
*
* This implementation assumes that the 'addons' property of each item is 
* initialized as an empty array
*/

use \Moltin\Cart\Item as Item;

class GrilleCart extends Cart
{
	// add an addons field to the required cart parameters
	protected $requiredParams = array(
        'id',
        'name',
        'quantity',
        'price',
        'addons',
    );

    /**
     * Insert an item into the cart
     * Modified to preserve addons during insertion
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


