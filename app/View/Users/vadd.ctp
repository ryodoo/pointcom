<?php
echo $this->Session->flash();
?>
<div class="users form">
<?php
echo $this->Form->create('User');?>
    <legend><?php echo __('Ajouter Client'); ?></legend>
    <fieldset>
        
        <?php 
        echo $this->Form->input('email');
        echo $this->Form->input('password');
        echo $this->Form->input('re_password', array('type'=>'password', 'label'=>'Comfirmer votre mot de passe*'));
        echo $this->Form->input('nom_complet');
        echo $this->Form->input('adresse');
        echo $this->Form->input('tel');

    ?>
    </fieldset>
    <?php echo $this->Form->end(__('Ajouter'));?>

</div>