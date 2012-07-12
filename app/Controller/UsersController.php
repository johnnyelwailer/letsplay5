<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {
	
	public $uses = array('User', 'Group', 'Game');
	public $helpers = array('Validation');
	
	
	
	public function isAuthorized($user) {
		switch($user['Group']['name']) {
			case 'Moderator':
				if(in_array($this->request->params['action'], array("add")))
					return true;
				
				//only allowed if the other user is no admin or moderator
				if(in_array($this->request->params['action'], array("delete", "edit"))) {
					 $data = $this->User->findById($this->request->params['pass'][0]);
					 if($data['Group']['name'] == 'Registered')
						return true;
				}
			case 'Registered':
				if(in_array($this->request->params['action'], array("add", "resetPassword")))
					return false;
				
				if(in_array($this->request->params['action'], array("logout")))
					return true;
				
				//allowed to edit/delete own profile
				if($this->request->params['action'] ==  "edit")
					if(isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == $user['id'])
						return true;
				
				if($this->request->params['action'] ==  "delete")
					if(isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == $user['id'])
						return true;
				
			case 'Anonymous':
				if(in_array($this->request->params['action'], array("login", "index", "view", "add", "resetPassword")))
					return true;
				break;
		}
		
		return parent::isAuthorized($user);
	}
	
	public function beforeFilter() {
		parent::beforeFilter();
	}

    public $components = array('RequestHandler');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$users = null;
		
		if(isset($this->request->query['username'])) {
			$users = $this->paginate('User', array('User.username LIKE' => '%'.$this->request->query['username'].'%'));
		}else {
			$users = $this->paginate();
		}
		
        $this->set('users', $users);
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			$this->Session->setFlash(__('Invalid user'));
			return;
			throw new NotFoundException(__('Invalid user'));
		}
		
		
        $user = $this->User->findById($id);
		$this->set('user', $user);
		$this->paginate = array(
			'Game' => array('conditions' => array(
				'OR' => array(
					'Game.challenger_id' => $id,
					'Game.opponent_id' => $id
					)
				)
			)
		);
	
		
		$this->set('games', $this->paginate('Game'));
		
		/*
        if ($this->RequestHandler->requestedWith() == 'XMLHttpRequest') {
            $this->set(array(
                'user' => $user,
                '_serialize' => array('user')
            ));
        }*/
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->loadModel('UserAdd');
		
		$groups = $this->groups();
		$user = $this->currentUser();
		
		//moderator cannot access admin group
		if($user['Group']['name'] != 'Administrator')
			unset($groups[1]);
		
		$this->set('groups', $this->groups());
		
		
		
		if($this->request->is('post')) {
			$this->UserAdd->set($this->request->data);
			if($this->UserAdd->validates()) {
				
				if($user['Group']['name'] != 'Administrator') {
					if($user['Group']['name'] == 'Moderator') {
						if(!in_array($this->request->data['UserAdd']['group_id'], array_keys($groups))){
							$this->request->data['UserAdd']['group_id'] = 3;
						}
					}else
						$this->request->data['UserAdd']['group_id'] = 3;
				}
				
				//map back from abstract model to our real model
				$this->request->data['User'] = $this->request->data['UserAdd'];
				if($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('User has been saved.'), 'success');
					$this->redirect(array('controller' => 'pages', 'action' => 'index'));
				} else {
					$this->Session->setFlash(__('User not saved.'));
				}
			}else {
				//$this->flash(__('Invalid data'), array('action' => 'index'));
				$this->Session->setFlash('Invalid data');
			//	throw new NotFoundException(__('Invalid data'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$user = $this->currentUser();
		
		$groups = $this->groups();
		//moderator cannot access admin group
		if($user['Group']['name'] != 'Administrator')
			unset($groups[1]);
		$this->set('groups', $groups);
		
		
		$this->User->id = $id;
		if(!$this->User->exists()) {
			$this->Session->setFlash(__('Invalid user'));
			return;
			//throw new NotFoundException(__('Invalid user'));
		}
		
		if($this->request->is('post') || $this->request->is('put')) {
			//group and name can only be changed by admin && moderator
			if($user['Group']['name'] == 'Administrator' OR $user['Group']['name'] == 'Moderator') {
				//only accessable groups are allowed
				if(!in_array($this->request->data['User']['group_id'], array_keys($groups))){
					unset($this->request->data['User']['group_id']);
				}
				
				if(isset($this->request->data['User']['username'])) {
					$u = $this->User->findByUsername($this->request->data['User']['username']);
					if($u) {
						unset($this->request->data['User']['username']);
						 $this->Session->setFlash(__('Username is already in use'));
						 return;
					}
				}
				
			}else {
				if(isset($this->request->data['User']['group_id']))
					unset($this->request->data['User']['group_id']);
				
				if(isset($this->request->data['User']['username']))
					unset($this->request->data['User']['username']);
			}
			
			//reset the password only if it is not empty AND if the sent value isnt equal to the db password
			if(isset($this->request->data['User']['password'])) {
				if(empty($this->request->data['User']['password'])) {
					unset($this->request->data['User']['password']);
				}else {
					if($this->User->password == $this->request->data['User']['password'])
						unset($this->request->data['User']['password']);
				}
			}
			
			
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'), 'success');
			} else {
				$this->Session->setFlash(__('The user has not been saved.'));
			}
		} else {
			$this->request->data = $this->User->findById($id);
			//set password to an empty string
			unset($this->request->data['User']['password']);
		}
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			$this->Session->setFlash(__('Wrong HTTP method'));
			return;
			//throw new MethodNotAllowedException();
		}
		
		$this->User->id = $id;
		if(!$this->User->exists()) {
			$this->Session->setFlash(__('Invalid user'));
			return;
			//throw new NotFoundException(__('Invalid user'));
		}
		
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'), 'success');
			$this->redirect(array('action' => 'index'));
			return;
		}
		
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function login() {
		if($this->request->is('post')) {
			//if the user is a gast, he is already active as "user" -> we need to log him out
			if($this->isGast())
				$this->Auth->logout();
			else //if no gast then redirect him
				$this->redirect($this->Auth->redirect());
			
			//process login
			if ($this->Auth->login()) {
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Your username or password was incorrect.'));
			}
		}
	}

	public function logout() {
		$user = $this->currentUser();
		
		//reset the last_access
		$timeout = Configure::read('Session.timeout');
		$last_access = strtotime($user['User']['last_access']) - $timeout;
		
		$this->User->id = $user['id'];
		$this->User->saveField('last_access', date('Y-m-d H:i:s', $last_access));
		
		//redirect him to the logout page
		$this->redirect($this->Auth->logout());
	}
	
	public function resetPassword(){
		if($this->request->is('post')) {
			$this->User->recursive = 0;
			$user = $this->User->findByUsername($this->request->data['User']['screenname']);
			
			if(!$user) {
				$this->Session->setFlash(__('Invalid user'));
			}else {
				//generate a random password
				$password = $this->newpassword();
				try {
					//send email
					$email = new CakeEmail();
					$email->from(array('noreply@letsplay5.com' => 'Letsplay5'));
					$email->to($user['User']['email']);
					$email->subject('Password was reset');
					
					
					$text = "Dear User";
					$text .= "\n\n";
					$text .= "Your password have been reset and is now: ";
					$text .= $password;
					$text .= "Enjoy your day!";
					
					$email->send($text);
					
					//save it
					$this->User->id = $user['User']['id'];
					$this->User->saveField('password', AuthComponent::password($password));
				
					//display success message
					$this->Session->setFlash(__('Your password have been reset.'), 'success');
				}catch(Exception $e) {
					$this->Session->setFlash(__('Could not send the email'));
				}
			}
		}
	}
	
	/* generates a new password */
	private function newpassword($len = 10) {
		$letters = range("a", "z");
		$letters = array_merge($letters, range("A", "Z"));
		$letters = array_merge($letters, range(0, 9));
		$letters = array_merge($letters, array("!",".","_",":","=","+","-"));
		
		$ret = "";
		while($len--) {
			$ret .= $letters[mt_rand(0, count($letters)-1)];
		}
		
		return $ret;
	}
	
	/* returns all accessable groups */
	private function groups() {
		static $groups = null;
		
		if(!$groups) {
			$gs = $this->Group->find('all');
			
			$groups = array();
			
			//create array that can directly passed to $this->Html->select()
			//remove anonymous account from the list
			foreach($gs as $obj) {
				if($obj['Group']['name'] != 'Anonymous')
					$groups[(int)$obj['Group']['id']] = $obj['Group']['name'];
			}
		}
		
		return $groups;
	}
}
