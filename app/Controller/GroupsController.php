<?php
App::uses('AppController', 'Controller');
/**
 * Groups Controller
 *
 */
class GroupsController extends AppController {

    public $components = array('RequestHandler');
    public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('*');
	}
	
	
	public function isAuthorized($user) {
		return parent::isAuthorized($user);
	}
	
	
	public function getAll() {
        $groups = $this->Group->find('all');
        $this->set(array(
            'groups' => $groups,
            '_serialize' => array('groups')
        ));
    }
	
 /**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;


}
