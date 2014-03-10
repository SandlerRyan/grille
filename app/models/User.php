<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use LaravelBook\Ardent\Ardent;

class User extends Ardent implements UserInterface, RemindableInterface {

	/**
	 * Ardent validation rules
	 */
	public static $rules = array(
	  'cs50_id' => 'required',
	  'name' => 'required|min:1',
	  'preferred_name' => 'required|min:1',
	  'phone_number' => 'required|regex:"^\d{10}$"',
	  'email' => 'required|email',
	  'hours_notification' => 'required',
	  'deals_notification' => 'required'
	);

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function orders ()
	{
		return $this->hasMany('Order');
	}

	public function manager_of ()
	{
		return $this->hasMany('Grille');
	}

}