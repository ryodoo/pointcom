<div class="paiements form">
<?php echo $this->Form->create('Paiement');?>
	<fieldset>
		<legend><?php echo __('Edit Paiement'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('admin_id');
		echo $this->Form->input('valide');
		echo $this->Form->input('avatar');
		echo $this->Form->input('nom');
		echo $this->Form->input('prix');
		echo $this->Form->input('motif');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Paiement.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Paiement.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Paiements'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
