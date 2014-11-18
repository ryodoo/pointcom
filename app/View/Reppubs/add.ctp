<div class="reppubs form">
<?php echo $this->Form->create('Reppub');?>
	<fieldset>
		<legend><?php echo __('Add Reppub'); ?></legend>
	<?php
		echo $this->Form->input('pub_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('choix');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Reppubs'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Pubs'), array('controller' => 'pubs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pub'), array('controller' => 'pubs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
