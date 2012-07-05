<?php
App::uses('Waitingforgame', 'Model');

/**
 * Waitingforgame Test Case
 *
 */
class WaitingforgameTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.waitingforgame',
		'app.user',
		'app.session'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Waitingforgame = ClassRegistry::init('Waitingforgame');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Waitingforgame);

		parent::tearDown();
	}

}
