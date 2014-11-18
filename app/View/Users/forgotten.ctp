<div id="cont" class="util">
    <?php
    echo $this->Session->flash();
    echo $this->Form->create('User');
    ?>
    <fieldset>
        <h3>Entrez votre Email:</h3>
        <?php echo $this->Form->input('email', array('label' => "Votre adresse Email")); ?>
        <?php echo $this->Form->end('Valider'); ?>
    </fieldset>
</div>