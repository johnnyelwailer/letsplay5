<?php
/**
 * TurnFixture
 *
 */
class TurnFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'game_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'creator' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'x' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'y' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_turns_games1' => array('column' => 'game_id', 'unique' => 0),
			'fk_turns_users1' => array('column' => 'creator', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_bin', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'created' => '2012-07-05 11:10:17',
			'game_id' => 1,
			'creator' => 1,
			'x' => 1,
			'y' => 1
		),
	);

}
