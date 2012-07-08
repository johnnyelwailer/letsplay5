<?php
App::uses('User', 'Model');

Class Gast extends User {
	/*
	public function __construct() {
		parent::__construct();
		//$this->data[$this->alias]['password']
		$this->set('name', 'Gast');
		$this->set('email', null);
		$this->set('group_id', 0);
		$this->set('isMale', 0);
	}*/
	
	
	public function create($data = null, $somethingElse = false) {
		$date = date('Y-m-d H:i:s');
		
		$def = array(
			'username' => 'Gast',
			'email' => NULL,
			'isGast' => 1,
			'isMale' => 1,
			'group_id' => 4,
			'Group' => $this->Group->read(null, 4),
			'password' => NULL,
			'storePassword' => NULL,
			'status' => 0,
			'created' => $date,
			'modified' => $date
		);
		
		if(is_array($data)) {
			array_merge($def, $data);
		}
		
		return parent::create($def, $somethingElse = false);
	}
}