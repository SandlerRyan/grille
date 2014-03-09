<?php

/**
 * User model config
 */

return array(

	'title' => 'Hours',

	'single' => 'hour',

	'model' => 'Hour',

	/**
	 * The display columns
	 */
	'columns' => array(
		'day' => array(
			'title' => 'Day',
			'select' => "(:table).day_of_week",
			'output' => function($value)
			{
				$days = array('0' => 'Sunday',
							'1' => 'Monday',
							'2' => 'Tuesday',
							'3' => 'Wednesday',
							'4' => 'Thursday',
							'5' => 'Friday',
							'6' => 'Saturday',);
				return $days[$value];
			}
		),
		'open' => array(
			'title' => 'Opening Time',
			'select' => '(:table).open_time',
		),
		'close' => array(
			'title'=> 'Closing Time',
			'select' => '(:table).close_time',
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'day' => array(
			'title' => 'Day',
			'select' => "(:table).day_of_week",
			'type' => 'enum',
			'options' => array(
				'0' => 'Sunday',
				'1' => 'Monday',
				'2' => 'Tuesday',
				'3' => 'Wednesday',
				'4' => 'Thursday',
				'5' => 'Friday',
				'6' => 'Saturday',),
		),
		'open' => array(
			'title' => 'Opening Time',
			'type' => 'time',
			'time_format' => 'HH:mm:ss',
			'select' => '(:table).open_time',
		),
		'close' => array(
			'title'=> 'Closing Time',
			'type' => 'time',
			'time_format' => 'HH:mm:ss',
			'select' => '(:table).close_time',
		),

	),

);