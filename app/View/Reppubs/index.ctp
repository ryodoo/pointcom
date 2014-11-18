<div class="reppubs index">
	<h2><?php echo __('Reppubs');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('pub_id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('choix');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($reppubs as $reppub): ?>
	<tr>
		<td><?php echo h($reppub['Reppub']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($reppub['Pub']['id'], array('controller' => 'pubs', 'action' => 'view', $reppub['Pub']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($reppub['User']['id'], array('controller' => 'users', 'action' => 'view', $reppub['User']['id'])); ?>
		</td>
		<td><?php echo h($reppub['Reppub']['choix']); ?>&nbsp;</td>
		<td><?php echo h($reppub['Reppub']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $reppub['Reppub']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $reppub['Reppub']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $reppub['Reppub']['id']), null, __('Are you sure you want to delete # %s?', $reppub['Reppub']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Reppub'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Pubs'), array('controller' => 'pubs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pub'), array('controller' => 'pubs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
