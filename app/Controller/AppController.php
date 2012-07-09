<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * CakePHP Component & Model Code Completion
 * @author junichi11
 *
 * ==============================================
 * CakePHP Core Components
 * ==============================================
 * @property AuthComponent $Auth
 * @property AclComponent $Acl
 * @property CookieComponent $Cookie
 * @property EmailComponent $Email
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property SessionComponent $Session
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array(
        /*'Acl',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')
            )
			*/
		'Auth' => array(
			'loginRedirect' => array('controller' => 'pages', 'action' => 'display', 'home'),
			'logoutRedirect' => array('controller' => 'pages', 'action' => 'display', 'home'),
			'authorize' => array('controller'), // Added this line
        ),
        'Session'
    );
	
	private $_currentUser = null;
	
	public function beforeFilter() {
		
		$this->Auth->fields  = array( 
            'username'=>'username', //The field the user logs in with (eg. username) 
            'password' =>'password' //The password field 
        ); 
		
		if($this->Auth->user()){
			
		}
		
		if($this->isGast()) 
			$this->set('isGast', true);
		else
			$this->set('isGast', false);
		
		$this->set('currentUser', $this->currentUser());
    }
	
	public function isAuthorized($user) {
		// Admin can access every action
		if(isset($user['Group']) && $user['Group']['name'] === 'Administrator') {
			return true;
		}
		
		// Default deny
		return false;
	}
	
	
	
	public function createGast() {
		if(!$this->_currentUser) {
			$this->loadModel('Gast');
			$session = $this->Session;
		
			$def = array();
		
			if(!$session->check('gast')) {
				$date = date('Y-m-d H:i:s');
				$session->write('gast.created', $date);
				$session->write('gast.modified', $date);
			
				$def['created'] = $date;
				$def['modified'] = $date;
			}else {
				$def['created'] = $session->read('gast.created');
				$def['modified'] = $session->read('gast.modified');
			}
			$ret = $this->Gast->create($def);
			return $ret;
		}
		
		return false;
	}
	
	/* current user (gast will appear as NULL in the db)*/
	public function currentUser() {
		if($user = $this->Auth->user()) {
			return $user;
		}
		
		
		if(!$this->_currentUser) {
			$this->_currentUser = $this->createGast();
			
			$this->Auth->login($this->_currentUser);
		}
		
		return $this->_currentUser;
	}
	
	public function isGast() {
		$user = $this->currentUser();
		//var_dump($user);
		if($user['group_id'] == 4)
			return true;
		return false;
	}
	
}
