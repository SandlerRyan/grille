<?php

class ItemTest extends TestCase {

	public function testitembasic()
	{
		$item = new Item();
        $item->name = "example";
        $item->price = 2.50;
        
        $this->assertFalse($item->save());

	}
	
}