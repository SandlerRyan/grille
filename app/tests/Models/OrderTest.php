<?php

class OrderTest extends TestCase {
	public function testbasicorder()
	{
		 // create the new order
        $order = new Order();
        $order->user_id = 1;
        $order->grille_id = 1;
        $order->cost = 1.50;
        $order->fulfilled = 0;

	    $this->assertTrue($order->save());


	}
}