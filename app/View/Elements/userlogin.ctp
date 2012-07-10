<div class="user-form">
	<?php

    //session begings
	echo $this->Session->flash('auth');

	echo $this->Form->create('User',
		array(
			'url' => array(
				'controller' => 'users', 
				'action' => 'login'
			)
		)
	);


    echo $this->Form->input('username');
    echo $this->Form->input('password');

    //image as button
    echo $this->Form->submit('/img/login.png');


    echo $this->html->image("Login");



    //echo $this->form->end('Login');




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