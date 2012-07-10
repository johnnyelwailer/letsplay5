<?php
App::uses('AppModel', 'Model');
/**
 * Waitingforgame Model
 *
 * @property User $User
 * @property Game $Game
 * @property CakeSession $CakeSession
 */
class Waitingforgame extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User',
		'Game'/*,
		'CakeSession'*/
	);
}
