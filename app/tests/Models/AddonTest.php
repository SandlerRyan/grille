<?
class AddonTest extends TestCase {

	//don't provide grille id
	public function testaddon()
	{
		$addon = new Addon();
        $addon->name = "extra cheese";
        $addon->price = 1.50;
        $addon->available = 1;
        //$addon->grille_id = 1;
        $this->assertFalse($addon_order->save());

	}
}
