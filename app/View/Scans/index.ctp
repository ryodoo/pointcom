<div class="scans index">
	<h2><?php echo __('Scans');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('mission_id');?></th>
			<th><?php echo $this->Paginator->sort('scan1');?></th>
			<th><?php echo $this->Paginator->sort('date_scan1');?></th>
			<th><?php echo $this->Paginator->sort('scan2');?></th>
			<th><?php echo $this->Paginator->sort('date_scan2');?></th>
			<th><?php echo $this->Paginator->sort('valider');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($scans as $scan): ?>
	<tr>
		<td><?php echo h($scan['Scan']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($scan['User']['id'], array('controller' => 'users', 'action' => 'view', $scan['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($scan['Mission']['id'], array('controller' => 'missions', 'action' => 'view', $scan['Mission']['id'])); ?>
		</td>
		<td><?php echo h($scan['Scan']['scan1']); ?>&nbsp;</td>
		<td><?php echo h($scan['Scan']['date_scan1']); ?>&nbsp;</td>
		<td><?php echo h($scan['Scan']['scan2']); ?>&nbsp;</td>
		<td><?php echo h($scan['Scan']['date_scan2']); ?>&nbsp;</td>
		<td><?php echo h($scan['Scan']['valider']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $scan['Scan']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $scan['Scan']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $scan['Scan']['id']), null, __('Are you sure you want to delete # %s?', $scan['Scan']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Scan'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Missions'), array('controller' => 'missions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mission'), array('controller' => 'missions', 'action' => 'add')); ?> </li>
	</ul>
</div>
