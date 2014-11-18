<?php 
echo $this->Session->flash('auth'); 

echo "<b>".$this->Session->flash()."</b>";

echo $this->Form->create('User');

/*echo $this->Form->create('User', array(
    'url' => array('controller' => 'users', 'action' => 'passwordedit'),
	'inputDefaults' => array(
	'label' => false,
	'div' => false
	)
));*/
?>

<?php echo $this->Form->input('password'); ?>
<?php echo $this->Form->input('re_password', array('type'=>'password')); ?>

<?php echo $this->Form->end("Valider"); ?>

