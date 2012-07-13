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
 


define('gameExpires', 604800); //a week
define('waitingForGameExpires', 60*60); // a hour

class GameApiController extends AppController {

    public $components = array('RequestHandler');
	
	
    public function isAuthorized($user) {
        switch($user['Group']['name']) {
            case 'Moderator':
                if(in_array($this->request->params['action'], array("terminate")))
                    return true;
            case 'Registered':
                if(in_array($this->request->params['action'], array("makeMatch", "place")))
                    return true;
            case 'Anonymous':
                if(in_array($this->request->params['action'], array("index", "detail", "turns", "view")))
                    return true;
                break;
        }

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

    public function turns($id, $since) {
        $this->loadModel('Turn');
        $this->loadModel('Game');


        $turns = $this->Turn->find('all', array(
            'conditions' => array(
                'game_id' => $id,
                'UNIX_TIMESTAMP(Turn.created) >' => $since ))
        );


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
				'online' => $last_access < $timeout
			);
			
			$last_access = time() - strtotime($opponent['User']['last_access']);
			
			$opponent = array(
				'username' => $opponent['User']['username'],
				'id' => $opponent['User']['id'],
				'online' => $last_access < $timeout
			);
			
			$exp = strtotime($game['Game']['modified']) + gameExpires;
			$exp -= time();
			
			$game = array(
				'id' => $game['Game']['id'],
				'terminated' => (bool)$game['Game']['terminated'],
				'created' => $game['Game']['created'],
				//'modified' => $game['Game']['modified'],
				'expires' => $exp,
				'challenger_id' => $game['Game']['challenger_id'],
				'opponent_id' => $game['Game']['opponent_id']
			);
		}

        //$user = $this->currentUser();

		$this->set(array(
            'challenger' => $challenger,
            'opponent' => $opponent,
            //'player' => !isset($user['id']) ? $user['id'] : null,
			'game' => $game,
            '_serialize' => array('challenger', 'opponent', 'game'/*, 'player'*/)
        ));
	}
	
	
    public function place($id, $x, $y) {
        $this->loadModel('Turn');
        $this->loadModel('User');
        $this->loadModel('Game');
		
		//common tests
		$gamed = $this->Game->findById($id);
		$user = $this->currentUser();
		
		if(!$gamed) {
            throw new Exception('Game does not exist');
        }
		
		if($gamed['Game']['terminated']) {
			throw new Exception('Game is already terminated');
		}
		
		//field already in use
        $existing = $this->Turn->find('first', array('conditions' =>
            array('game_id' => $id, 'x' => $x, 'y' => $y)));
		
        if ($existing != null) {
            throw new Exception('position already occupied.');
        }
		
		//is it really my turn?
		$myturn = $this->Turn->find('first', array(
			'conditions' => array(
				'game_id' => $id
			),
			'order' => 
				array('Turn.created' => 'desc')
			)
		);
		
		if($myturn) {
			if($myturn['Turn']['creator'] == $user['id']) {
				throw new Exception('Not your turn!');
			}
        }else {
			if($user['id'] != $gamed['Game']['challenger_id']) {
				throw new Exception('Not your turna!');
			}
		}
		
        $turn = $this->Turn->save(array('game_id' => $id, 'x' => $x, 'y' => $y, 'creator' => $user['id']));
		
        $game = new GameMaths($this->Turn, $id);

        $rows = $game->findAdjacentRows($turn);
        $won = count($rows) > 0;

        if($won) {
			//terminate game
			$this->complete($id);
			
			//if both user exists perform additional tasks
			if($gamed['Game']['challenger_id'] && $gamed['Game']['opponent_id']) {
				/*$looserId = $gamed['Game']['challenger_id'] == $user['id'] ? $gamed['Game']['challenger_id'] : $gamed['Game']['opponent_id'];
				
				
				$winner = $this->User->findById($user['id']);
				$looser = $this->User->findById($looserId);
				
				if($winner && $looser) {
					$winner['User']['points'] += 1;
					$looser['User']['points'] -= 1;
					
					//calc ELO number
					$playerA = $winner['User']['score'] > $looser['User']['score'] ? $winner['User']['score'] : $looser['User']['score'];
					$playerB = $winner['User']['score'] < $looser['User']['score'] ? $winner['User']['score'] : $looser['User']['score'];
					
					$pointDiff = $playerB['User']['score'] - $playerA['User']['score'];
					
					if($pointDiff < -400)
						$pointDiff = -400;
					
					$pointDiff /= 400;
					
					$EA = 1 / (1 + pow(10, $pointDiff));
					
					if($playerA['User']['id'] == $winner['User']['id']) {
						$winner['User']['score'] = $winner['User']['score'] + 30*(1 - $EA);
						$looser['User']['score'] = $looser['User']['score'] + 30*(0 - (1- $EA) );
					}else {
						$winner['User']['score'] = $winner['User']['score'] + 30*(0 - $EA);
						$looser['User']['score'] = $looser['User']['score'] + 30*(1 - (1- $EA));
					}
					
					//store new "play points"
					$this->User->id = $user['id'];
					$this->User->save(
						array(
							'points' => $winner['User']['points'] < 0 ? 0 : $winner['User']['points'],
							'score' => $winner['User']['score'] < 0 ? 0 : $winner['User']['score']
						)
					);
					
					$this->User->id = $looserId;
					$this->User->save(
						array(
							'points' => $looser['User']['points'] < 0 ? 0 : $looser['User']['points'],
							'score' => $looser['User']['score'] < 0 ? 0 : $looser['User']['score']
						)
					);
					
					//set winner if the game was fairly won
					$this->complete($id, $user['id']);
				}*/
			}
			
        }

        $this->set(array(
            'turn' => $turn,
            'won' => $won,
            'rows' => $rows,
            '_serialize' => array('turn', 'won', 'rows')
        ));
    }
	
    private function complete($id, $winner_id = null) {
        $this->Game->id = $id;
        $this->Game->save(array('terminated' => true, 'winner_id' => $winner_id));
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
