<?
class AddonItemOrderTest extends TestCase {
	public function testitemorder()
	{
		$addon_order = new AddonItemOrder();
        $addon_order->item_order_id = 1;
        $addon_order->addon_id = 1;
        $addon_order->quantity = 3;

        $this->assertTrue($addon_order->save());

	}
}
