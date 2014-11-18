<div class="recharges form">
<?php echo $this->Form->create('Recharge');?>
	<fieldset>
		<legend><?php echo __('Edit Recharge'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('recharge');
		echo $this->Form->input('hachage');
                $this->request->data['Recharge']['hachage+']=($this->request->data['Recharge']['hachage+']+$this->request->data['Recharge']['hachage'])/$this->request->data['Recharge']['hachage'];
		echo $this->Form->input('hachage+');
		echo $this->Form->input('prix');
		echo $this->Form->input('point');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Modifier'));?>
</div>
