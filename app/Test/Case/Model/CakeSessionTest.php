<?php
App::uses('CakeSession', 'Model');

/**
 * CakeSession Test Case
 *
 */
class CakeSessionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cake_session'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CakeSession = ClassRegistry::init('CakeSession');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CakeSession);

		parent::tearDown();
	}

}
