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

use Moltin\Cart\Item as Item;

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

	public function insert_addon (array $addon, Item $item)
	{
        $this->checkArgs($addon);

        $addonIdentifier = $this->createItemIdentifier($addon);

        if (!$item) throw new InvalidArgumentException('Item for this addon does not exist');

        // if the addon is already in the item's array, update qty
        if (array_key_exists($addon['id'], $item->addons))
        {

        	// check if there are now more addons for the item than the quantity of the item itself
        	if ($item->addons[$addon['id']]['quantity'] + $addon['quantity'] > $item->quantity){
        		throw new InvalidArgumentException("Can't add more addons  than the quantity of the item");
        	}
        	else {
	        	$item->addons[$addon['id']]['quantity'] += $addon['quantity'];
	        	return $addonIdentifier;
	        }
        }
        else 
        {
	        // create the addon as an Item object and add it to the appropriate item
	        $addon = new Item($addonIdentifier, $addon, $this->store);
	        $item->addons[$addon->id] = $addon;

	        return $addonIdentifier;
	    }	
    }

    public function remove_addon ()
    {

    }

    public function total($includeTax=true)
    {

    }

    public function find_addon ()
    {

    }

    public function total_items_and_addons ()
    {

    }


}


