<div class="changes form">
<?php echo $this->Form->create('Change');?>
	<fieldset>
		<legend><?php echo __('Edit Change'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('point');
		echo $this->Form->input('prix');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

