<div class="users form">
    <?php echo $this->Form->create('User');?>
    <fieldset>
        <legend><?php echo __('Modifier mes informations personnelles'); ?></legend>
        <p style="font-size: 18px;  color: #FFFFFF;  font-weight: bold;padding:6px;background: #555;">
            Pour des raisons de securité la modification de vos informations personnelles
            est autorisé pour une seul fois. Si vous avez des problémes
             <?php echo $this->Html->link('conctactez nous',array('controller'=>'contacts','action'=>'index'),array("style"=>'margin-left: 3px;color: #46C5EC;')); ?>
        </p>
        <?php
        echo $this->Form->input('nom_complet',array('label'=>'Nom & Prenom'));
        echo $this->Form->input('adresse',array('label'=>'Adresse'));
        echo $this->Form->input('tel',array('label'=>'Téléphone'));
        echo $this->Form->input('age');
        echo $this->Form->input('ville');
        echo $this->Form->input('password',array('label'=>'Mot de passe actuel','value'=>''));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Modifier'));?>
</div>