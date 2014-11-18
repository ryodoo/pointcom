<div class="contacts form">
    <?php echo $this->Session->flash();?>
<?php echo $this->Form->create('Contact');?>
	<fieldset>
		<legend><?php echo __('Pour plus d\'informations Contatez-nous :'); ?></legend>
	<?php
		echo $this->Form->input('nom',array('required'=>"required"));
		echo $this->Form->input('email',array('required'=>"required"));
		echo $this->Form->input('telephone',array('required'=>"required"));
		echo $this->Form->input('message',array('required'=>"required"));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Envoyer'));?>
</div>

