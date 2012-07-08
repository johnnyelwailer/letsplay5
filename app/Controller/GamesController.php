<?php
App::uses('AppController', 'Controller');
/**
 * Games Controller
 *
 * @property Game $Game
 */
class GamesController extends AppController {
    
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
            $this->Game->recursive = 1;
            $this->set('games', $this->paginate());
			
        //}
    }

    /**
     * play method
     *
     * @return void
     */
    public function play() {
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
    }
}
