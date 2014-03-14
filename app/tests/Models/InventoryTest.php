// <?php

class InventoryTest extends TestCase {

public function testinvent()
	{
		$invent = new Inventory();
        $invent->name = "example";
        $invent->grille_id = 1;
        $invent->quantity = 3;
        $invent->description = "example desc";
        $invent->units = "tubs";
        $this->assertTrue($invent->save());

	}
	
}

