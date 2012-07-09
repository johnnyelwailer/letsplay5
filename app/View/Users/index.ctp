<div class="users index">
	<h2><?php echo ('Users'); ?></h2>

	<table border="0" class="size border radius">
	    <thead>
	        <tr>
	            <th><?php echo $this->Paginator->sort('id'); ?></th>
		        <th><?php echo $this->Paginator->sort('username'); ?></th>
				<th><?php echo $this->Paginator->sort('status'); ?></th>
				
				
				<?php  if($currentUser["Group"]["name"]=="Administrator" OR $currentUser["Group"]["name"]=="Moderator") { ?>
				<th><?php echo $this->Paginator->sort('group_id'); ?></th>
				<?php } ?>
				
                <?php
                    if($currentUser["Group"]["name"]=="Administrator"){
                        echo "<th>".$this->Paginator->sort('created')."</th>";
                        echo "<th>".$this->Paginator->sort('modified')."</th>";
                        echo '<th class="actions">'.('Actions').'</th>';
                    }
                ?>

	        </tr>
	    </thead>
	    <tbody>
	        <?php
	            foreach ($users as $user) {
				var_dump($user);
				?>
					<?php
					if($currentUser["Group"]["name"]=="Administrator"){
                    ?>
					<tr>
					<?php
					}else {
					?>
					<tr onclick="window.location='<?php echo $this->Html->url(array(
							"controller" => "users",
							"action" => "view",
							$user['User']['id']
							)); ?>'">
					<?php
					}
					?>
		                <td><?php echo h($user['User']['id']); ?></td>
		                <td><?php echo h($user['User']['username']); ?></td>
						<td><?php $img = $user['User']['is_active'] ? 'inactive.png' : 'active.png';
						$desc = $game['Game']['terminated'] ? __('The was terminated') : __('The game is still running');
						
						echo $this->Html->image($img, array('alt' => $desc)); ?></td>
							
                            <?php
								if($currentUser["Group"]["name"]=="Administrator" OR $currentUser["Group"]["name"]=="Moderator") {
									echo "<td>", h($user['Group']['name']), "</td>";
								}
								
                                //if the group is administrator
                                if($currentUser["Group"]["name"]=="Administrator"){
                                    echo "<td>". $this->Time->nice($user['User']['created']), "</td>";
                                    echo "<td>". $this->Time->nice($user['User']['modified']), "</td>";

                                    //create delete view
                                    echo '<td class="actions">';
		                            echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id']));
			                        echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id']));
			                        echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id']));
	                            	echo '</td>';
                                }
                            ?>
	                </tr>
                    <?php
                }
                    ?>

	    </tbody>
	</table>
    <?php
    ?>

	<p>
	    <?php
	        echo $this->Paginator->counter(array(
	            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	        ));
	    ?>
    </p>

	<div class="paging">
	    <?php
		    echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		    echo $this->Paginator->numbers(array('separator' => ''));
		    echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	    ?>

	</div>
</div>