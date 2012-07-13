<div class="users view">
	<h1><?php  echo __('User Profile'); ?></h1>
	
	<dl class="profile">
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
						
						$img = $last_access > $timeout ? 'inactive.png' : 'active.png';
						$desc = $last_access > $timeout ? __('Offline') : __('Online');
						
						echo $this->Html->image($img, array('alt' => $desc));
						
			?>
			&nbsp;
		</dd>
		
		<dt><?php echo __('Score'); ?></dt>
		<dd>
			<?php echo $user['User']['score']; ?>
			&nbsp;
		</dd>
	</dl>
	
	<div class="games">
	<?php if(count($games) == 0) { ?>
	<span class="error"><?php echo __('No games found'); ?></span>
	<?php }else{ ?>
	<table border="0" class="border radius">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('terminated'); ?></th>
				<th><?php echo $this->Paginator->sort('turn_count'); ?></th>
				<th><?php echo $this->Paginator->sort('modified'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($games as $game) { ?>
			<tr onclick="window.location='<?php echo $this->Html->url(array(
					"controller" => "games",
					"action" => "view",
					$game['Game']['id'])
				);?>';">
				<td>
				<?php
				
				$img = $game['Game']['terminated'] ? 'active.png' : 'inactive.png';
				$desc = $game['Game']['terminated'] ? __('The game is still running') : __('The was terminated');
				
				echo $this->Html->image($img, array('alt' => $desc));
				?>
				</td>
				<td><?php echo $game['Game']['turn_count']; ?></td>
				<td><?php echo $this->Time->nice($game['Game']['modified']); ?></td>
			</tr>
		<?php } ?>
		
		</tbody>
	</table>
	<?php } ?>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
	
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
