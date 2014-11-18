<div class="choipubs form">
<?php echo $this->Form->create('Choipub');?>
	<fieldset>
		<legend><?php echo __('Add Choipub'); ?></legend>
	<?php
		echo $this->Form->input('pub_id');
		echo $this->Form->input('repense');
		echo $this->Form->input('valide');
		echo $this->Form->input('image');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Choipubs'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Pubs'), array('controller' => 'pubs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pub'), array('controller' => 'pubs', 'action' => 'add')); ?> </li>
	</ul>
</div>
