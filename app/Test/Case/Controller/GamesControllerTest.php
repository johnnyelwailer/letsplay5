<?php
App::uses('GamesController', 'Controller');

/**
 * GamesController Test Case
 *
 */
class GamesControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.game',
		'app.challenger',
		'app.opponent',
		'app.winner',
		'app.turn'
	);

}
