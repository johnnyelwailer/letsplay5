<div class="users resetPassword">
	<h1><?php  echo __('Reset Password'); ?></h1>
	
	<?php echo $this->Form->create('User'); ?>
	<?php echo $this->Form->input('screenname'); ?>
	<?php echo $this->Form->end('Submit'); ?>
</div>

