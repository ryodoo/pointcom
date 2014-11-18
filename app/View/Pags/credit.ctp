<div class="pags form">
    <?php echo $this->Form->create('Pag'); ?>
    <legend><?php echo __('Ajouter des crédits'); ?></legend>
    <fieldset>
        <?php
        echo $this->Form->input('user', array("label" => "N° Clients à ajouter"));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Ajouter')); ?>
</div>