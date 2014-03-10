<?php

class GrilleTest extends TestCase {


	public function testgrillephoneshort()
	{
		$grille = new Grille();
	    $grille->name = "Test Grille";
	    $grille->phone_number = "122578777";
	    $grille->open_now = 1;

	    $this->assertFalse($grille->save());

	    // Save the errors
		$errors = $grille->errors()->all();
	
		// There should be 1 error
		$this->assertCount(1, $errors);
		$this->assertEquals($errors[0], "The phone number format is invalid.");

	}
}