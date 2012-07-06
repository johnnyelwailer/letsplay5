<div class="games index">
	<h2><?php echo __('Games'); ?></h2>
	
	<table border="0" class="size border radius">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('username'); ?></th>
				<th><?php echo $this->Paginator->sort('password'); ?></th>
				<th><?php echo $this->Paginator->sort('group_id'); ?></th>
				<th><?php echo $this->Paginator->sort('created'); ?></th>
				<th><?php echo $this->Paginator->sort('modified'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($games as $game) { ?>
			
			
		<?php } ?>
</div>