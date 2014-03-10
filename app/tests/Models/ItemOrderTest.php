// <?php

// class ItemOrderTest extends TestCase {
// 	public function testitemorder()
// 	{
// 	$item_order = new ItemOrder();
//         $item_order->order_id = 1;
//         $item_order->item_id = 5;
//         $item_order->quantity = 2;
//         $item_order->notes = "Hello this is an example note";
//         $this->assertTrue($item_order->save());

//         //assert that order and item exists that is associate
//         $order = Order::where('id', $item_order->order_id)->get();
//         $this->assertTrue(count($order)==1);

//         $item = Item::where('id', $item_order->item_id)->get();
//         $this->assertTrue(count($order)==1);


// 	}

// /*	public function ItemOrderNoOrder()
// 	{
// 		 // create the new order
//         $item_order = new ItemOrder();
//         $item_order->order_id = 100;
//         $item_order->item_id = 10;
//         $item_order->quantity = 1;
//         $item_order->notes = "Hello this is an example note";

// 	    //assert false order and item exists that is associate
//         $order = Order::where('id', $item_order->order_id)->get();
//         $this->assertFalse(count($order)==1);

// 	}*/
// }