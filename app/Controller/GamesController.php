<?php
App::uses('AppController', 'Controller');
/**
 * Games Controller
 *
 * @property Game $Game
 */
class GamesController extends AppController {
    
	public $helpers = array('Time');

	
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
            $this->set('games', $this->paginate());
			var_dump($this->Time);
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
