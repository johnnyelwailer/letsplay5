<div class="users form" ng-controller="CreateUserViewModel">
    <?php echo $this->Form->create('UserAdd',
			array('id' => 'UserAdd')
	); ?>
	
	<h1><legend><?php echo __('Add User'); ?></h1>
        <?php
            echo $this->Form->input(__('username'));
            echo $this->Form->input(__('Email'));
            echo $this->Form->input(__('password'), array('type' => 'password'));
            echo $this->Form->input(__('passwordreplication'), array('type' => 'password'));
        ?>
		
        <!-- drop down -->
		<?php if($currentUser['Group']['name'] == 'Administrator' OR $currentUser['Group']['name'] == 'Moderator') { ?>
			<?php echo $this->Form->select('User.group_id', $groups, array('empty' => false)); ?>
		<?php } ?>
		
        <!-- button -->
        <?php echo $this->Form->end(__('Submit')); ?>
</div>
