<?php

App::uses('User', 'Model');

//define a fake model for user. That way cakephp does not have any conflicts with multiple forms on the same page
class UserAdd extends User {

	//this defines the rules for validating the userfields
	
	/*
	http://book.cakephp.org/2.0/en/models/data-validation.html
	The difference between required and allowEmpty can be confusing. 
	'required' => true means that you cannot save the model without the key for 
	this field being present in $this->data (the check is performed with isset);
	whereas, 'allowEmpty' => false makes sure that the current field value is
	nonempty, as described above.
	
	*/
	
	public $validate = array(
        'username' => array(
            'alphaNumeric' => array(
                'rule'     => 'alphaNumeric',
                'required' => true,
                'message'  => 'Alphabets and numbers only'
            ),
			
            'between' => array(
                'rule'    => array('between', 5, 15),
                'message' => 'Between 5 to 15 characters'
            ),
			
			'unique' => array(
				'rule'    => 'isUnique',
				'required' => true,
				'message' => 'Username is already in use'
			)
        ),
		
        'password' => array(
            'between' => array(
                'rule'    => array('between', 8, 16),
                'message' => 'Between 8 to 16 characters',
				'required'   => true
            ),
			
			//our own rule
			'identicalFieldValues' => array(
				'rule' => array('identicalFieldValues', 'passwordreplication'),// calls the method identicalFieldValues
				'message' => 'Both passwordfields must match each other'
			)
        ),
		
        'email' => array(
			'allowEmpty' => false,
			'rule' => 'email',
			'message'    => 'Enter a valid email address',
			'required'   => true
		),
		
		'group_id' => array(
			'allowedChoice' => array(
				'rule'    => array('inList', array('1', '2', '3')),
				'message' => 'Group does not exist'
			 )
		)
    );
	
	/* should be in appmodel.php */
	function identicalFieldValues($field=array(), $compare_field=null ) {
        return $this->data[get_class($this)][$compare_field] === current($field);
    } 
	
}