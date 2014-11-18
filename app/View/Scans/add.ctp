<div class="scans form">
<?php echo $this->Form->create('Scan');?>
	<fieldset>
		<legend><?php echo __('Add Scan'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Scans'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Missions'), array('controller' => 'missions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mission'), array('controller' => 'missions', 'action' => 'add')); ?> </li>
	</ul>
</div>
