<?php

/**
 * User model config
 */

return array(

	'title' => 'Users',

	'single' => 'user',

	'model' => 'User',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'name' => array(
			'title' => 'Name',
			'select' => "(:table).name",
		),
		'preferred_name' => array(
			'title' => 'Preferred Name',
			'select' => "(:table).preferred_name",
		),
		'phone_number' => array(
			'title' => 'Phone Number',
			'select' => "(:table).phone_number",
		),
		'email' => array(
			'title' => 'Email',
			'select' => "(:table).email",
		),
		'privileges' => array(
			'title' => 'Privileges',
			'select' => "(:table).privileges",
		),
		'full_name' => array(
			'title' => 'Name',
			'select' => "(:table).name",
		),
		'hours_notification' => array(
			'title' => 'Hours Notification',
			'select' => "(:table).hours_notification",
		),
		'deals_notification' => array(
			'title' => 'Deals Notification',
			'select' => "(:table).deals_notification",
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
		'name' => array(
			'title' => 'Name',
		),
		'privileges' => array(
			'title' => 'Privileges',
		),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'name' => array(
			'title' => 'Name',
			'type' => 'text',
		),
		'phone_number' => array(
			'title' => 'Phone Number',
			'type' => 'number',
		),
		'email' => array(
			'title' => 'Email Address',
			'type' => 'text',
		),
		'phone_number' => array(
			'title' => 'Phone Number',
			'type' => 'text',
		),
		'privileges' => array(
			'title' => 'Privileges',
			'type' => 'enum',
			'options' => array('User', 'Staff', 'Manger'),
		),
	),

);