<div class="reppubs view">
<h2><?php  echo __('Reppub');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($reppub['Reppub']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pub'); ?></dt>
		<dd>
			<?php echo $this->Html->link($reppub['Pub']['id'], array('controller' => 'pubs', 'action' => 'view', $reppub['Pub']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($reppub['User']['id'], array('controller' => 'users', 'action' => 'view', $reppub['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Choix'); ?></dt>
		<dd>
			<?php echo h($reppub['Reppub']['choix']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($reppub['Reppub']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Reppub'), array('action' => 'edit', $reppub['Reppub']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Reppub'), array('action' => 'delete', $reppub['Reppub']['id']), null, __('Are you sure you want to delete # %s?', $reppub['Reppub']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Reppubs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Reppub'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pubs'), array('controller' => 'pubs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pub'), array('controller' => 'pubs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
