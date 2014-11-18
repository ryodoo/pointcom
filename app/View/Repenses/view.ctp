<div class="repenses view">
<h2><?php  echo __('Repense');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($repense['Repense']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($repense['User']['id'], array('controller' => 'users', 'action' => 'view', $repense['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Question'); ?></dt>
		<dd>
			<?php echo $this->Html->link($repense['Question']['id'], array('controller' => 'questions', 'action' => 'view', $repense['Question']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Choix'); ?></dt>
		<dd>
			<?php echo h($repense['Repense']['choix']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($repense['Repense']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Repense'), array('action' => 'edit', $repense['Repense']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Repense'), array('action' => 'delete', $repense['Repense']['id']), null, __('Are you sure you want to delete # %s?', $repense['Repense']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Repenses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Repense'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
