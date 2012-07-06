<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	public function beforeFilter() {
		//overwrite permission from the db
		//static pages are ALL accessable
		
		parent::beforeFilter();
		$this->Auth->allow('*');
	}

function initDB() {
	
    $this->Acl->allow(array( 'model' => 'Group', 'foreign_key' => 4), 'controllers');

    //we add an exit to avoid an ugly "missing views" error message
    echo "all done";
    exit;
    //allow managers to posts and widgets
    $group->id = 3;
    $this->Acl->deny('Registered', 'controllers');
    $this->Acl->allow('Registered', 'controllers/Games/play');
	$this->Acl->allow('Registered', 'controllers/Games/view');
	$this->Acl->allow('Registered', 'controllers/Games/index');
    $this->Acl->allow('Registered', 'controllers/Users/view');
	$this->Acl->allow('Registered', 'controllers/Users/index');
 
    //allow users to only add and edit on posts and widgets
    $group->id = 2;
    $this->Acl->deny('Moderator', 'controllers');
    $this->Acl->allow('Moderator', 'controllers/Games/');
    $this->Acl->allow('Moderator', 'controllers/Users');
	
	$group->id = 1;
    $this->Acl->deny('Gast', 'controllers');
    $this->Acl->allow('Gast', 'controllers/Games/play');
	$this->Acl->allow('Gast', 'controllers/Games/view');
	$this->Acl->allow('Gast', 'controllers/Games/index');
    $this->Acl->allow('Gast', 'controllers/Users/view');
	$this->Acl->allow('Gast', 'controllers/Users/index');
	
	
	
	}
    public $components = array('RequestHandler');
/**
 * index method
 *
 * @return void
 */
	public function index() {
        /*//if ($this->RequestHandler->requestedWith()) {
            $users = $this->User->find('all');
            $this->set(array(
                'users' => $users,
                '_serialize' => array('users')
            ));
        //}else {
		*/
            $this->User->recursive = 0;
            $this->set('users', $this->paginate());
        //}
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
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Your username or password was incorrect.'));
			}
		}
	}

	public function logout() {
		//Leave empty for now.
	}
}
