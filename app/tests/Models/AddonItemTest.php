<?
class AddonItemTest extends TestCase {

	//don't provide addon id
	public function testaddonitem()
	{
		$addon = new AddonItem();
        $addon->item_id = 1;
       // $addon->addon_id = 1;

        $this->assertFalse($addon->save());

	}
}
