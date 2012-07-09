<div id="user-form">
	<?php 
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
		
	echo $this->Form->end(__('Login'));
	
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