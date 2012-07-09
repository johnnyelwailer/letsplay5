<div class="users form">
	<h1>Einstellungen</h1>
	
	<?php echo $this->Form->create('User');
	
	echo $this->Form->input('username');
	echo $this->Form->input('password');
	
	if($currentUser['Group']['name'] == "Administrator" OR $currentUser['Group']['name'] == "Moderator") {
		echo $this->Form->select('User.group_id', $groups, array('empty' => false));	
	}
	?>
	<?php echo $this->Form->end(__('Submit')); ?>
</div>