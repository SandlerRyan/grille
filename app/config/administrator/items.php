<?php

/**
 * Item model config
 */

return array(

	'title' => 'Items',

	'single' => 'item',

	'model' => 'Item',

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
		'available' => array(
			'title' => 'Available',
			'select' => "(:table).available",
		),
		'category' => array(
			'title' => 'Category',
			'relationship' => 'category',
			'select' => "(:table).name",
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
			'title' => 'Status',
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
		'price' => array(
			'title' => 'Price',
			'type' => 'number',
			'symbol' => '$',
			'decimals' => 2,
		),
		'description' => array(
			'title' => 'Description',
			'type' => 'text',
		),
		'available' => array(
			'title' => 'Available',
			'type' => 'bool',
		),
		'category' => array(
			'title' => 'Category',
			'type' => 'relationship',
			'name_field' => 'name',
		),

	),

);