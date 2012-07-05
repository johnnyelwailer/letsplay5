<?php
App::uses('Turn', 'Model');

/**
 * Turn Test Case
 *
 */
class TurnTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.turn'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Turn = ClassRegistry::init('Turn');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Turn);

		parent::tearDown();
	}

}
