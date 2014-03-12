<?php

/**
 * User model config
 */

return array(

	'title' => 'Orders',

	'single' => 'order',

	'model' => 'Order',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'user' => array(
			'title' => 'User',
			'relationship' => 'user',
			'select' => "(:table).name",
		),
		'cost' => array(
			'title' => 'Cost',
			'select' => "(:table).cost",
		),
		'items' => array(
			'title' => 'Items',
			'relationship' => 'item_orders',
			'select' => "GROUP_CONCAT((:table).name SEPARATOR ', ')",
		),
		'venmo' => array(
			'title' => 'Venmo ID',
			'select' => "(:table).venmo_id",
		),
		'cooked' => array(
			'title' => 'Cooked',
			'select' => "(:table).cooked",
		),
		'fulfilled' => array(
			'title' => 'Fulfilled',
			'select' => "(:table).fulfilled",
		),
		'refunded' => array(
			'title' => 'Refunded',
			'select' => "(:table).refunded",
		),
		'cancelled' => array(
			'title' => 'Cancelled',
			'select' => "(:table).cancelled",
		),
		'date' => array(
			'title' => 'Date placed',
			'select' => "(:table).created_at",
		),

	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
		'user' => array(
			'title' => 'User',
			'type' => 'relationship',
			'name_field' => 'name',
		),
		'cost' => array(
			'title' => 'Cost',
			'select' => "(:table).cost",
		),
		'item_orders' => array(
			'title' => 'Items',
			'type' => 'relationship',
			'name_field' => 'name',
		),
		'venmo' => array(
			'title' => 'Venmo ID',
		),
		'cooked' => array(
			'title' => 'Cooked',
		),
		'fulfilled' => array(
			'title' => 'Fulfilled',
		),
		'refunded' => array(
			'title' => 'Refunded',
		),
		'cancelled' => array(
			'title' => 'Cancelled',
		),
		'date' => array(
			'title' => 'Date placed',
		),

	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'cost' => array(
			'title' => 'Cost',
			'type' => 'number',
			'symbol' => '$',
			'decimals' => 2,
		),
		'cooked' => array(
			'title' => 'Cooked',
			'type' => 'bool',
		),
		'fulfilled' => array(
			'title' => 'Fulfilled',
			'type' => 'bool',
		),
		'refunded' => array(
			'title' => 'Refunded',
			'type' => 'bool',
		),
		'cancelled' => array(
			'title' => 'Cancelled',
			'type' => 'bool',
		),
	),

);