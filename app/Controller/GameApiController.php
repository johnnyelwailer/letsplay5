<?php
App::uses('AppController', 'Controller');
/**
 * Game Api Controller
 *
 * @property Game $Game
 * @property Turn $Turn
 */
class GameApiController extends AppController {

    public $components = array('RequestHandler');

    public function isAuthorized($user) {
        /*switch($user['Group']['name']) {
            case 'Moderator':
            case 'Registered':
            case 'Anonymous':
                if(in_array($this->request->params['action'], array("index", "play", "view")))
                    return true;
                break;
        }*/
        return true;

        return parent::isAuthorized($user);
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
        $this->loadModel('Game');
        $games = $this->Game->find('all');
        $this->set(array(
            'games' => $games,
            '_serialize' => array('games')
        ));
    }

    public function makeMatch() {
        $this->loadModel('Game');
        $this->loadModel('User');

        $creator = $this->User->find('first');
        $existing = $this->Game->find('first');

        if ($existing != null) {
            $this->set(array(
                'game' => $existing,
                '_serialize' => array('game')
            ));

            return;
        }

        $game = $this->Game->save(array('challenger_id' => $creator['User']['id'],'opponent_id' => null,'winner_id' => null));

        $this->set(array(
            'game' => $game,
            '_serialize' => array('game')
        ));
    }

    public function turns($id, $since = null) {
        $this->loadModel('Turn');



        $turns = $this->Turn->findAllByGameId($id);

        $this->set(array(
            'turns' => $turns,
            '_serialize' => array('turns')
        ));
    }

    public function place($id, $x, $y) {
        $this->loadModel('Turn');
        $this->loadModel('User');

        $existing = $this->Turn->find('first', array('conditions' =>
            array('game_id' => $id, 'x' => $x, 'y' => $y)));

        if ($existing != null) {
            throw new Exception('position already occupied.');
        }

        $creator = $this->User->find('first');
        $turn = $this->Turn->save(array('game_id' => $id, 'x' => $x, 'y' => $y, 'creator' => $creator['User']['id']));
        $this->set(array(
            'turn' => $turn,
            '_serialize' => array('turn')
        ));
    }

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id) {
        $this->loadModel('Turn');
        $turn = $this->Turn->findById($id);

        $this->set(array(
            'turn' => $turn,
            '_serialize' => array('turn')
        ));
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
	public function edit($id) {
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
	public function delete($id) {
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
