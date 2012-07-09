<div class="users index">
	<h2><?php echo ('Users'); ?></h2>

	<table border="0" class="size border radius">
	    <thead>
	        <tr>
	            <th><?php echo $this->Paginator->sort('id'); ?></th>
		        <th><?php echo $this->Paginator->sort('username'); ?></th>

                <?php

                    echo "<th>".$this->Paginator->sort('group_id')."</th>";
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
            ?>

                    <tr>

		                <td><?php echo h($user['User']['id']); ?>&nbsp;</td>
		                <td><?php echo h($user['User']['username']); ?>&nbsp;</td>

                            <?php
                                echo "<td>". h($user['Group']['name']). "&nbsp"."</td>";

                                //if the group is administrator
                                if($currentUser["Group"]["name"]=="Administrator"){
                                    echo "<td>". h($user['User']['created']). "&nbsp"."</td>";
                                    echo "<td>". h($user['User']['modified']). "&nbsp"."</td>";

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