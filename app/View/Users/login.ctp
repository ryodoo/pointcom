<div id="cont" class="util">
    <?php
    echo $this->Session->flash(); ?>
    <div class="users form">
        <?php echo $this->Session->flash('auth'); ?>
        <?php echo $this->Form->create('User');?> 
        <legend>N.B : Veuillez Vous inscrire d’abord au niveau de l'application mobile pour accéder a votre compte </legend>
        <fieldset>
            <?php echo $this->Form->input('email');
            echo $this->Form->input('password');
            ?>
           
            <a style="color: #616060;font-size: 15px;font-weight: bold;float: right;" href="<?php
               echo $this->Html->url(array('controller'=>'users','action'=>'forgotten')); ?>" >
                Mot de passe oublié</a>
        </fieldset> 
        <?php echo $this->Form->end(__('Connexion'));?>
    </div>
</div>