<?php

/**
 * Addons model config
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
		'price' => array(
			'title' => 'Price',
			'select' => "(:table).price",
		),
		'description' => array(
			'title' => 'Description',
			'select' => "(:table).description",
		),
		'avilable' => array(
			'title' => 'Available',
			'select' => "(:table).available",
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
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'name' => array(
			'title' => 'Name',
			'type' => 'text',
		),
	),

);