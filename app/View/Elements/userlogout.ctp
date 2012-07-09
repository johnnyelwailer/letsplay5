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
	
	echo $this->Form->end(__('Logout'));
	
	?>
</div>