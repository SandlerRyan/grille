<?php

/**
 * User model config
 */

return array(

	'title' => 'Inventory',

	'single' => 'inventory',

	'model' => 'Inventory',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'name' => array(
			'title' => 'Name',
			'select' => "(:table).name",
		),
		'description' => array(
			'title' => 'Description',
			'select' => "(:table).description",
		),
		'quantity' => array(
			'title' => 'Quantity in stock',
			'select' => "(:table).quantity",
		),
		'units' => array(
			'title' => 'Units',
			'select' => "(:table).units",
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
		'quantity' => array(
			'title' => 'Quantity',
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
		'description' => array(
			'title' => 'Description',
			'type' => 'text',
		),
		'email' => array(
			'title' => 'Quantity in stock',
			'type' => 'number',
			'decimals' => 2,
		),
		'units' => array(
			'title' => 'Units',
			'type' => 'text',
		),
	),

);