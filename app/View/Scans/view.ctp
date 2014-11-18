<div class="scans view">
<h2><?php  echo __('Scan');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($scan['Scan']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($scan['User']['id'], array('controller' => 'users', 'action' => 'view', $scan['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mission'); ?></dt>
		<dd>
			<?php echo $this->Html->link($scan['Mission']['id'], array('controller' => 'missions', 'action' => 'view', $scan['Mission']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Scan1'); ?></dt>
		<dd>
			<?php echo h($scan['Scan']['scan1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Scan1'); ?></dt>
		<dd>
			<?php echo h($scan['Scan']['date_scan1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Scan2'); ?></dt>
		<dd>
			<?php echo h($scan['Scan']['scan2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Scan2'); ?></dt>
		<dd>
			<?php echo h($scan['Scan']['date_scan2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Valider'); ?></dt>
		<dd>
			<?php echo h($scan['Scan']['valider']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Scan'), array('action' => 'edit', $scan['Scan']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Scan'), array('action' => 'delete', $scan['Scan']['id']), null, __('Are you sure you want to delete # %s?', $scan['Scan']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Scans'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Scan'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Missions'), array('controller' => 'missions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mission'), array('controller' => 'missions', 'action' => 'add')); ?> </li>
	</ul>
</div>
