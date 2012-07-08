<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $name = 'User';
	public $displayField = 'id';
	
	//this encrypt the passwort
	public function beforeSave() {
	
        if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
    }
	
	
	/*
	What this does, is tie the Group and User models to the Acl, 
	and tell CakePHP that every-time you make a User or Group you 
	want an entry on the aros table as well. This makes Acl management
	a piece of cake as your AROs become transparently tied to your 
	users and groups tables. So anytime you create or delete a user/group
	the Aro table is updated.
	*/
	public $belongsTo = array('Group');
	//public $actsAs = array('Acl' => array('type' => 'requester'));
	
	public function parentNode() {
        if(!$this->id && empty($this->data))
            return null;

        if (isset($this->data['User']['group_id'])) {
            $groupId = $this->data['User']['group_id'];
        } else {
            $groupId = $this->field('group_id');
        }
        if (!$groupId) {
            return null;
        } else {
            return array('Group' => array('id' => $groupId));
        }
    }
	
	/*
	This method will tell ACL to skip checking User Aro’s and to check only Group Aro’s.

	Every user has to have assigned group_id for this to work.
	*/
	public function bindNode($user) {
		 return array('model' => 'Group', 'foreign_key' => $user['User']['group_id']);
	}
}
