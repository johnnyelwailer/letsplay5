<?php
/**
 * WaitingforgameFixture
 *
 */
class WaitingforgameFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'game_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'session_id' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_waitingForGames_users1' => array('column' => 'user_id', 'unique' => 0),
			'fk_waitingForGames_games1' => array('column' => 'game_id', 'unique' => 0),
			'fk_waitingForGames_cake_sessions1' => array('column' => 'session_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_bin', 'engine' => 'MEMORY')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'created' => '2012-07-09 13:49:21',
			'modified' => '2012-07-09 13:49:21',
			'game_id' => 1,
			'session_id' => 'Lorem ipsum dolor sit amet'
		),
	);

}
