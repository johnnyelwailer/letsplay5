<?php

class UsersApiController extends AppController
{
    public $components = array('RequestHandler');

    public function index() {
        $recipes = $this->User->find('all');
        $this->set(array(
            'recipes' => $recipes,
            '_serialize' => array('recipe')
        ));
    }

    public function view($id) {
        $recipe = $this->User->findById($id);
        $this->set(array(
            'recipe' => $recipe,
            '_serialize' => array('recipe')
        ));
    }

    public function edit($id) {
        $this->User->id = $id;
        if ($this->User->save($this->request->data)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }

    public function delete($id) {
        if ($this->User->delete($id)) {
            $message = 'Deleted';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
}
