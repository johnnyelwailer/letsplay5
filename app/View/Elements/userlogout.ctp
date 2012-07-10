<div id="user-form">
	<?php 
	echo $this->Session->flash('auth');



	echo $this->Form->create(null, array(
		'url' => array(
			'controller' => 'users', 
			'action' => 'logout'
			)
		)
	); 
	
	// picture logout
    echo $this->Form->submit('/img/logout.png');
	
	echo $this->Form->end();
	?>
</div>