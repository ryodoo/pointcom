<div class="choipubs view">
<h2><?php  echo __('Choipub');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($choipub['Choipub']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pub'); ?></dt>
		<dd>
			<?php echo $this->Html->link($choipub['Pub']['id'], array('controller' => 'pubs', 'action' => 'view', $choipub['Pub']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Repense'); ?></dt>
		<dd>
			<?php echo h($choipub['Choipub']['repense']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Valide'); ?></dt>
		<dd>
			<?php echo h($choipub['Choipub']['valide']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image'); ?></dt>
		<dd>
			<?php echo h($choipub['Choipub']['image']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($choipub['Choipub']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Choipub'), array('action' => 'edit', $choipub['Choipub']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Choipub'), array('action' => 'delete', $choipub['Choipub']['id']), null, __('Are you sure you want to delete # %s?', $choipub['Choipub']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Choipubs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Choipub'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pubs'), array('controller' => 'pubs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pub'), array('controller' => 'pubs', 'action' => 'add')); ?> </li>
	</ul>
</div>
