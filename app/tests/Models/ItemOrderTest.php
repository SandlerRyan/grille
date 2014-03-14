<?php

class ItemOrderTest extends TestCase {
	public function testitemorder()
	{
		$item_order = new ItemOrder();
        $item_order->order_id = 1;
        $item_order->item_id = 5;
        $item_order->quantity = 2;
        $item_order->notes = "Hello this is an example note";
        $this->assertTrue($item_order->save());


	}
}
