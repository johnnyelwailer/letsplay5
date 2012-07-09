<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {
	
	public function isAuthorized($user) {
		switch($user['Group']['name']) {
			case 'Moderator':
				if(in_array($this->request->params['action'], array("delete", "edit", "add")))
					return true;
			case 'Registered':
				if(in_array($this->request->params['action'], array("add")))
					return false;
				
				if(in_array($this->request->params['action'], array("logout")))
					return true;
				
				if($this->request->params['action'] ==  "edit")
					if(isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == $user['id'])
						return true;
				
			case 'Anonymous':
				if(in_array($this->request->params['action'], array("login", "index", "view", "add")))
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
        $this->set('users', $this->paginate());
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
			throw new NotFoundException(__('Invalid user'));
		}

        $user = $this->User->read(null, $id);
		$this->set('user', $user);

        if ($this->RequestHandler->requestedWith() == 'XMLHttpRequest') {
            $this->set(array(
                'user' => $user,
                '_serialize' => array('user')
            ));
        }
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->flash(__('User saved.'), array('action' => 'index'));
			} else {
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->flash(__('The user has been saved.'), array('action' => 'index'));
			} else {
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
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
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->flash(__('User deleted'), array('action' => 'index'));
		}
		$this->flash(__('User was not deleted'), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}

	public function login() {
		if($this->request->is('post')) {
			if($this->isGast())
				$this->Auth->logout();
			else 
				$this->redirect($this->Auth->redirect());
			
			if ($this->Auth->login()) {
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Your username or password was incorrect.'));
			}
		}
	}

	public function logout() {
		 $this->redirect($this->Auth->logout());
	}
}
