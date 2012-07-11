<div class="user-form">
	<?php

    //session begings
	echo $this->Session->flash('auth');

	echo $this->Form->create('User',
		array(
			'url' => array(
				'controller' => 'users', 
				'action' => 'login'
			),
			'id' => 'UserLogin'
		)
	);


    echo $this->Form->input('username');
    echo $this->Form->input('password');

    //image as button
    echo $this->Form->submit('/img/login.png');


<<<<<<< HEAD
    //echo $this->html->image("Login");
=======
    /* outcommented for IE & Chrome
     *
     * echo $this->html->image("Login");
     * 
     * */
>>>>>>> 1fd659e403310bd7a074075e6859deeaac7af1fb



    echo $this->form->end();




	echo $this->Html->link('Registrieren', array(
		"controller" => "users",
		"action" => "add")
	);

	
	echo $this->Html->link('Passwort zurücksetzen', array(
		"controller" => "users",
		"action" => "resetPassword")
	);
	
	?>
</div>