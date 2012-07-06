<div class="games index">
	<h2><?php echo __('Games'); ?></h2>
	
	<table border="0" class="size border radius">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('terminated'); ?></th>
				<th><?php echo $this->Paginator->sort('countturns'); ?></th>
				<th><?php echo $this->Paginator->sort('created'); ?></th>
				<th><?php echo $this->Paginator->sort('modified'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		
		foreach ($games as $game) { ?>
			<tr>
				<td><a href="<?php
				echo $this->Html->url(array(
					"controller" => "games",
					"action" => "view",
					$game['Game']['id'])
				);
				
				?>"><?php echo $game['Game']['id']; ?></a></td>
				<td>
				<?php
				
				$img = $game['Game']['terminated'] ? 'inactive.png' : 'active.png';
				$desc = $game['Game']['terminated'] ? __('The was terminated') : __('The game is still running');
				
				echo $this->Html->image($img, array('alt' => $desc));
				?>
				</td>
				<td><?php echo count($game['Turn']); ?></td>
				<td><?php echo $this->Time->nice($game['Game']['created']); ?></td>
				<td><?php echo $this->Time->nice($game['Game']['modified']); ?></td>
			</tr>
		<?php } ?>
		
		</tbody>
	</table>
	
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>