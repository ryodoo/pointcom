<div class="changes index">
	<h2><?php echo __('Changes');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('point');?></th>
			<th><?php echo $this->Paginator->sort('prix');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($changes as $change): ?>
	<tr>
		<td><?php echo h($change['Change']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($change['User']['id'], array('controller' => 'users', 'action' => 'view', $change['User']['id'])); ?>
		</td>
		<td><?php echo h($change['Change']['point']); ?>&nbsp;</td>
		<td><?php echo h($change['Change']['prix']); ?>&nbsp;</td>
		<td><?php echo h($change['Change']['description']); ?>&nbsp;</td>
		<td><?php echo h($change['Change']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Valider & envoyer le code'), array('action' => 'edit', $change['Change']['id'])); ?>
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
