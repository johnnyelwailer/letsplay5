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
		
		$groups = $this->Group->read(null, 4);
		
		$def = array(
			'username' => 'Anonymous',
			'email' => NULL,
			'isGast' => 1,
			'isMale' => 1,
			'group_id' => 4,
			'Group' => $groups['Group'],
			'password' => NULL,
			'storePassword' => NULL,
			'status' => 0,
			'created' => $date,
			'modified' => $date
		);
		
		//var_dump($def);
		if(is_array($data)) {
			$def = array_merge($def, $data);
		}
		
		$ret = parent::create($def, $somethingElse);
		return array_merge($def, $ret['Gast']);
	}
}