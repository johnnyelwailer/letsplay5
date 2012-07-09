<div class="users form" ng-controller="CreateUserViewModel">
    <?php echo $this->Form->create('User'); ?>
	<h1><legend><?php echo __('Add User'); ?></h1>
        <?php
            echo $this->Form->input('username');
            echo $this->Form->input('E-mail');
            echo $this->Form->input('password');
            echo $this->Form->input('password replication');
        ?>
		
        <!-- drop down -->
		<?php if($currentUser['Group']['name'] == 'Administrator') { ?>
			<?php echo $this->Form->select('User.group_id', $groups, array('empty' => false)); ?>
		<?php } ?>
		
        <!-- button -->
        <?php echo $this->Form->end(__('Submit')); ?>
</div>
