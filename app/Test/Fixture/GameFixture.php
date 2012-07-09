<?php
/**
 * GameFixture
 *
 */
class GameFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'challenger_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'key' => 'index'),
		'opponent_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'terminated' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4),
		'winner_id' => array('type' => 'integer', 'null' => true, 'default' => '0', 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_games_users2' => array('column' => 'challenger_id', 'unique' => 0),
			'fk_games_users3' => array('column' => 'opponent_id', 'unique' => 0),
			'fk_games_users1' => array('column' => 'winner_id', 'unique' => 0)
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
			'challenger_id' => 1,
			'opponent_id' => 1,
			'created' => '2012-07-05 11:06:43',
			'modified' => '2012-07-05 11:06:43',
			'terminated' => 1,
			'winner_id' => 1
		),
	);

}
