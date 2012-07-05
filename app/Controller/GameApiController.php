<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

    public $components = array('RequestHandler');
/**
 * index method
 *
 * @return void
 */
	public function index() {
            $games = $this->Game->find('all');
            $this->set(array(
                'games' => $games,
                '_serialize' => array('games')
            ));
    }

    public function makeMatch() {

    }

    public function turns($gameid, $since = null) {

    }

    public function place($gameid, $position) {

    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($gameid = null) {
		/*$this->User->id = $id;
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
        }*/
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


}
