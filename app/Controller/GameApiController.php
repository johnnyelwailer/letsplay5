<?php
App::uses('AppController', 'Controller');
/**
 * Game Api Controller
 *
 * @property Game $Game
 * @property Turn $Turn
 * @property WaitingForGame $WaitingForGame
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
		$this->loadModel('WaitingForGame');

        $user = $this->currentUser();
        //var_dump('user', $user);

        $existingByUser = $this->WaitingForGame->findByUserId($user['id']);

        $existingByUser = isset($existingByUser) ? $existingByUser['WaitingForGame'] : null;
        //var_dump('user existing', $existingByUser);
        if (isset($existingByUser)) {

            //game created, ready to rumble!
            if ($existingByUser['game_id'] != null) {

                $game = $this->Game->findById($existingByUser['game_id']);
                $this->set(array(
                    'game' => $game,
                    '_serialize' => array('game')
                ));

                $this->WaitingForGame->delete($existingByUser);
                return;
            }

            //waiting on
            $this->set(array(
                'await' => $existingByUser,
                '_serialize' => array('await')
            ));
            return;
        }

        $matching =  $this->WaitingForGame->find('first',
            array('conditions' =>
                array(
                    'NOT' => array(
                        'user_id' => $user['id']),
                    'game_id' => null)));

        $matching = isset($matching) ? $matching['WaitingForGame'] : null;
        //var_dump('matching', $matching);
        if (isset($matching)) {
            $game = $this->Game->save(array(
                'challenger_id' => $matching['user_id'],
                'opponent_id' => $user['id'],
                'winner_id' => null));

            //var_dump('new game', $game);

            $this->WaitingForGame->save(array('id' => $matching['id'],'game_id' => $game['Game']['id']));

            $this->set(array(
                'game' => $game,
                '_serialize' => array('game')
            ));
            return;
        }

        $this->WaitingForGame->save(array('user_id' => $user['id']));
        $this->set(array(
            'await' => 'searching',
            '_serialize' => array('await')
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

        $user = $this->currentUser();
        $turn = $this->Turn->save(array('game_id' => $id, 'x' => $x, 'y' => $y, 'creator' => $user['id']));
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
