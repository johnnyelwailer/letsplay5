<div class="users form" ng-controller="CreateUserViewModel">
    <?php echo $this->Form->create('UserAdd',
			array('id' => 'UserAdd')
	); ?>
	
	<h1><legend><?php echo __('Add User'); ?></h1>
        <?php
            echo $this->Form->input('username');
            echo $this->Form->input('email');
            echo $this->Form->input('password', array('type' => 'password'));
            echo $this->Form->input('passwordreplication', array('type' => 'password'));
        ?>
		
        <!-- drop down -->
		<?php if($currentUser['Group']['name'] == 'Administrator' OR $currentUser['Group']['name'] == 'Moderator') { ?>
			<?php echo $this->Form->select('User.group_id', $groups, array('empty' => false)); ?>
		<?php } ?>
		
        <!-- button -->
        <?php echo $this->Form->end(__('Submit')); ?>
</div>
