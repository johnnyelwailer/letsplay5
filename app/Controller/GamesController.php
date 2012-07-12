<?php
App::uses('AppController', 'Controller');
/**
 * Games Controller
 *
 * @property Game $Game
 */
class GamesController extends AppController {
    
	public $uses = array('Game', 'User');
	public $helpers = array('Time');
	
	
	public function isAuthorized($user) {
		switch($user['Group']['name']) {
			case 'Moderator':
			case 'Registered':
			case 'Anonymous':
				if(in_array($this->request->params['action'], array("index", "play", "view")))
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
		//if ($this->RequestHandler->requestedWith()) {
            //$games = $this->Game->find('all');
           /* $this->set(array(
                'games' => $games
            ));*/
        //}else {
            $this->Game->recursive = 0;
			//var_dump($this->paginate);
	/*		$this->paginate = array(
				'fields' => array('COUNT(t.id) AS countturns', '*'),
				'joins' => array('LEFT JOIN turns as t ON Game.id = t.game_id'),
				'group' => array('Game.id'),
				'order' => array('countturns' => 'asc')
			);
		*/
			
			
            $this->set('games', $this->paginate());
        //}
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = 'null') {
        $this -> set('id', $id);
        $this -> set('intentionToPlay', false);
    }

    public function play() {
        $this -> set('id', 'null');
        $this -> set('intentionToPlay', true);
        $this->view = 'view';
    }

    public function playTemplate() {
        $this->layout = false;

    }
    public function viewTemplate() {
        $this->layout = false;
    }
}
