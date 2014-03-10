<?php

class UserTest extends TestCase {

	public function testphonecorrect()
	{
		$user = new User();
	    $user->cs50_id = "asdfasdfasdf";
	    $user->name = "Ryan Sandler";
	    $user->preferred_name = "Ryan";
	    $user->email = "SandlerRyan@gmail.com";
	    $user->phone_number = "9122578777";

	    $this->assertTrue($user->save());


	}

	public function testphoneshort()
	{
		$user = new User();
	    $user->cs50_id = "asdfasdfasdf";
	    $user->name = "Ryan Sandler";
	    $user->preferred_name = "Ryan";
	    $user->email = "SandlerRyan@gmail.com";
	    $user->phone_number = "122578777";

	    $this->assertFalse($user->save());

	    // Save the errors
		$errors = $user->errors()->all();
	
		// There should be 1 error
		$this->assertCount(1, $errors);
		$this->assertEquals($errors[0], "The phone number format is invalid.");

	}


	public function testphoneletters()
	{
		$user = new User();
	    $user->cs50_id = "asdfasdfasdf";
	    $user->name = "Ryan Sandler";
	    $user->preferred_name = "Ryan";
	    $user->email = "SandlerRyan@gmail.com";
	    $user->phone_number = "A122578777";

	    $this->assertFalse($user->save());

	    // Save the errors
		$errors = $user->errors()->all();
	
		// There should be 1 error
		$this->assertCount(1, $errors);
		$this->assertEquals($errors[0], "The phone number format is invalid.");

	}
}



