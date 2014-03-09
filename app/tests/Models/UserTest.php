<?php

class UserTest extends TestCase {

	public function testwithoutemail()
	{
		//no email
		$user = new User();
	    $user->cs50_id = "asdfasdfasdf";
	    $user->name = "Ryan Sandler";
	    $user->preferred_name = "Ryan";

	    $this->assertFalse($user->save());

	    // Save the errors
		//$errors = $user->errors()->all();
		 
		// There should be 1 error
		//$this->assertCount(1, $errors);
		 
	}

	public function testwithoutphone()
	{
		//no email
		$user = new User();
	    $user->cs50_id = "asdfasdfasdf";
	    $user->name = "Ryan Sandler";
	    $user->preferred_name = "Ryan";
	    $user->email = "SandlerRyan@gmail.com";

	    $this->assertFalse($user->save());

	    // Save the errors
		//$errors = $user->errors()->all();
		 
		// There should be 1 error
		//$this->assertCount(1, $errors);
		 
	}


}