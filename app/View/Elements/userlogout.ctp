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
	// old version of button
	// echo $this->Form->end(__('Logout'));

    // picture logout
    echo $this->Form->submit('/img/logout.png');

	?>
</div>