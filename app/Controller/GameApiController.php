<?php
App::uses('AppController', 'Controller');
/**
 * Game Api Controller
 *
 * @property Game $Game
 * @property Turn $Turn
 * @property User $User
 * @property Waitingforgame $Waitingforgame
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
		$this->loadModel('Waitingforgame');

        $user = $this->currentUser();
        //var_dump('user', $user);

        $existingByUser = $this->Waitingforgame->findByUserId($user['id']);

        $existingByUser = isset($existingByUser) ? $existingByUser['Waitingforgame'] : null;

        //var_dump('user existing', $existingByUser);
        if (isset($existingByUser)) {

            //game created, ready to rumble!
            if ($existingByUser['game_id'] != null) {

                $this->set(array(
                    'game_id' => $existingByUser['game_id'],
                    '_serialize' => array('game_id')
                ));

                $this->Waitingforgame->delete($existingByUser);
                return;
            }

            //waiting on
            $this->set(array(
                'await' => $existingByUser,
                '_serialize' => array('await')
            ));
            return;
        }

        $matching =  $this->Waitingforgame->find('first',
            array('conditions' =>
                array(
                    'NOT' => array(
                        'user_id' => $user['id']),
                    'game_id' => null)));

        $matching = isset($matching) ? $matching['Waitingforgame'] : null;
        //var_dump('matching', $matching);
        if (isset($matching)) {
            $game = $this->Game->save(array(
                'challenger_id' => $matching['user_id'],
                'opponent_id' => $user['id'],
                'winner_id' => null));

            //var_dump('new game', $game);

            $this->Waitingforgame->save(array('id' => $matching['id'],'game_id' => $game['Game']['id']));

            $this->set(array(
                'game_id' => $game['Game']['id'],
                '_serialize' => array('game_id')
            ));
            return;
        }

        $this->Waitingforgame->save(array('user_id' => $user['id']));
        $this->set(array(
            'await' => 'searching',
            '_serialize' => array('await')
        ));
    }

    public function turns($id, $since = null) {
        $this->loadModel('Turn');
        $this->loadModel('Game');

        $turns = $this->Turn->findAllByGameId($id);

        $game = $this->Game->findById($id);

        $this->set(array(
            'turns' => $turns,
            'winner' => $game['Game']['winner_id'],
            '_serialize' => array('turns', 'winner')
        ));
    }
	
	public function detail($id) {
		$this->loadModel('Game');
        $this->loadModel('User');
		
		$data = null;
		$challenger = null;
		$opponent = null;
		$game = null;
		
		$this->Game->recursive = 0;
		if($game = $this->Game->findById($id)) {
			$this->User->recursive = 0;
			$challenger = $this->User->findById($game['Game']['challenger_id']);
			$opponent = $this->User->findById($game['Game']['opponent_id']);
			
			$timeout = Configure::read('Session.timeout');
			$last_access = time() - strtotime($challenger['User']['last_access']);
			
			$challenger = array(
				'username' => $challenger['User']['username'],
				'id' => $challenger['User']['id'],
				'online' => $last_access > $timeout
			);
			
			$last_access = time() - strtotime($opponent['User']['last_access']);
			
			$opponent = array(
				'username' => $opponent['User']['username'],
				'id' => $opponent['User']['id'],
				'online' => $last_access > $timeout
			);
			
			
			$game = array(
				'id' => $game['Game']['id'],
				'terminated' => (bool)$game['Game']['terminated'],
				'created' => $game['Game']['created'],
				'modified' => $game['Game']['modified'],
				'challenger_id' => $game['Game']['challenger_id'],
				'opponent_id' => $game['Game']['opponent_id']
			);
		}

        $user = $this->currentUser();
		
		$this->set(array(
            'challenger' => $challenger,
            'opponent' => $opponent,
            'player' => $user['id'],
			'game' => $game,
            '_serialize' => array('challenger', 'opponent', 'game', 'player')
        ));
	}
	
	
    public function place($id, $x, $y) {
        $this->loadModel('Turn');
        $this->loadModel('User');
        $this->loadModel('Game');

        $existing = $this->Turn->find('first', array('conditions' =>
            array('game_id' => $id, 'x' => $x, 'y' => $y)));

        if ($existing != null) {
            throw new Exception('position already occupied.');
        }

        $user = $this->currentUser();
        $turn = $this->Turn->save(array('game_id' => $id, 'x' => $x, 'y' => $y, 'creator' => $user['id']));

        $game = new GameMaths($this->Turn, $id);

        $rows = $game->findAdjacentRows($turn);
        $won = count($rows) > 0;

        if($won) {
            $this->Game->id = $id;
            $this->Game->save(array('terminated' => true, 'winner_id' => $user['id']));
        }

        $this->set(array(
            'turn' => $turn,
            'won' => $won,
            'rows' => $rows,
            '_serialize' => array('turn', 'won', 'rows')
        ));
    }
}

class GameMaths {
    public $turns;

    public function __construct($turns, $game){
        $this->turns = $turns;
        $this->game = $game;
    }

    public function getTurnAt($pos) {
        return $this->turns->find('first', array(
            'conditions' => array(
                'x' => $pos['x'],
                'y' => $pos['y'],
                'game_id' => $this->game
            )
        ));
    }

    public function isOccupied($pos, $by) {
        $turn = $this->getTurnAt($pos);

        if ($turn == false)
            return false;

        return $turn['Turn']['creator'] == $by;
    }

    public function getTurnsInLine($turn, $vector) {
        $result = array($turn);
        $creator = $turn['Turn']['creator'];

        $current = $this->getTurnAt(array('x' => $turn['Turn']['x'] + $vector['x'],'y' => $turn['Turn']['y'] + $vector['y']));
        while ($this->isOccupied($current['Turn'], $creator)) {
            array_push($result, $current);
            $current = $this->getTurnAt(array('x' => $current['Turn']['x'] + $vector['x'],'y' => $current['Turn']['y'] + $vector['y']));
        }

        $current = $this->getTurnAt(array('x' => $turn['Turn']['x'] - $vector['x'],'y' => $turn['Turn']['y'] - $vector['y']));
        while ($this->isOccupied($current['Turn'], $creator)) {
            array_push($result, $current);
            $current = $this->getTurnAt(array('x' => $current['Turn']['x'] - $vector['x'],'y' => $current['Turn']['y'] - $vector['y']));
        }

        return $result;
    }

    public function findAdjacentRows($turn) {
        $result = array();
        $allRows = array(
            $this->getTurnsInLine($turn, array('x'=> 1, 'y' => 0)),
            $this->getTurnsInLine($turn, array('x'=> 1, 'y' => 1)),
            $this->getTurnsInLine($turn, array('x'=> 0, 'y' => 1)),
            $this->getTurnsInLine($turn, array('x'=> -1, 'y' => 1))
        );

        foreach($allRows as $row) {
            if (count($row) >= 5) {
                array_push($result, $row);
            }
        }

        return $result;
    }
}
