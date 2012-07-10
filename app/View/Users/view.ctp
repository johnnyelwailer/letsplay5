<div class="users view">
<h2><?php  echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		
		<?php if($currentUser['Group']['name'] == "Administrator" OR $currentUser['Group']['name'] == "Moderator") { ?>
		<dt><?php echo __('Groupname'); ?></dt>
		<dd>
			<?php echo h($user['Group']['name']); ?>
			&nbsp;
		</dd>
		<?php } ?>
		
		
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo $this->Time->nice($user['User']['created']); ?>
			&nbsp;
		</dd>
		
		<dt><?php echo __('Last access'); ?></dt>
		<dd>
			<?php echo $this->Time->nice($user['User']['last_access']); ?>
			&nbsp;
		</dd>
		
		<?php if($currentUser['Group']['name'] == "Administrator" OR $currentUser['Group']['name'] == "Moderator") { ?>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo $this->Time->nice($user['User']['modified']); ?>
			&nbsp;
		</dd>
		<?php } ?>
		
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php
			$timeout = Configure::read('Session.timeout');
						$last_access = time() - strtotime($user['User']['last_access']);
						
						$img = $last_access < $timeout ? 'inactive.png' : 'active.png';
						$desc = $last_access < $timeout ? __('Offline') : __('Online');
						
						echo $this->Html->image($img, array('alt' => $desc));
						
			?>
			&nbsp;
		</dd>
	</dl>
</div>

<?php if($currentUser['Group']['name'] == "Administrator" OR $currentUser['Group']['name'] == "Moderator") { ?>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
	</ul>
</div>
<?php } ?>
