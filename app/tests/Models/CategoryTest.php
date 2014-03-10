<?

class CategoryTest extends TestCase {

	//give no name
	public function testcatcorrect()
	{
		$cat = new category();
		$cat->name = ""

		 $this->assertFalse($cat->save());
	}

}