<div class="scans form">
<?php echo $this->Form->create('Scan');?>
	<fieldset>
		<legend><?php echo __('Edit Scan'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('mission_id');
		echo $this->Form->input('scan1');
		echo $this->Form->input('date_scan1');
		echo $this->Form->input('scan2');
		echo $this->Form->input('date_scan2');
		echo $this->Form->input('valider');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Scan.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Scan.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Scans'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Missions'), array('controller' => 'missions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mission'), array('controller' => 'missions', 'action' => 'add')); ?> </li>
	</ul>
</div>
