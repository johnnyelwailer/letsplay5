<?php
App::uses('AppModel', 'Model');
/**
 * Game Model
 *
 * @property User $Challenger
 * @property User $Opponent
 * @property User $Winner
 * @property Turn $Turn
 */
class Game extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Challenger' => array(
			'className' => 'User',
			'foreignKey' => 'challenger_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Opponent' => array(
			'className' => 'User',
			'foreignKey' => 'opponent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Winner' => array(
			'className' => 'User',
			'foreignKey' => 'winner_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Turn' => array(
			'className' => 'Turn',
			'foreignKey' => 'game_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
