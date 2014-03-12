<?php

/**
 * User model config
 */

return array(

	'title' => 'Ordered Items',

	'single' => 'ordered item',

	'model' => 'ItemOrder',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'order' => array(
			'title' => 'Order Number',
			'relationship' => 'order',
			'select' => "(:table).id",
		),
		'item' => array(
			'title' => 'Item',
			'relationship' => 'item',
			'select' => "(:table).name",
		),
		'quantity' => array(
			'title' => 'Quantity',
			'select' => "(:table).quantity",
		),
		'item' => array(
			'title' => 'Price per item',
			'relationship' => 'item',
			'select' => "(:table).price",
		),
		'addons' => array(
			'title' => 'Addons',
			'relationship' => 'addons',
			'select' => "GROUP_CONCAT((:table).name SEPARATOR ', ')",
		),
		'notes' => array(
			'title' => 'Notes',
			'select' => "(:table).notes",
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
		'order' => array(
			'title' => 'Order Number',
			'type' => 'relationship',
			'name_field' => 'id',
		),
		'item' => array(
			'title' => 'Item',
			'type' => 'relationship',
			'name_field' => 'name',
		),
		'quantity' => array(
			'title' => 'Quantity',
		),
		'item' => array(
			'title' => 'Price per item',
			'type' => 'relationship',
			'name_field' => 'price',
		),
		'addons' => array(
			'title' => 'Addons',
			'type' => 'relationship',
			'name_field' => 'name',
		),
		'notes' => array(
			'title' => 'Notes',
		),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'order' => array(
			'title' => 'Order Number',
			'type' => 'relationship',
			'name_field' => 'id',
		),
		'item' => array(
			'title' => 'Item',
			'type' => 'relationship',
			'name_field' => 'name',
		),
		'quantity' => array(
			'title' => 'Quantity',
			'type' => 'number',
			'decimals' => 0,
		),
		'notes' => array(
			'title' => 'Notes',
			'type' => 'text',
		),
	),

);