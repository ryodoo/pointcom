<?php
$this->set('title',"Nouveau magasin");
//echo $this->element('sql_dump');
//$this->layout = 'administration';
echo $this->Session->flash();
?>
<div class="users form">
<?php echo $this->Form->create('Cadeaux', array('type' => 'file'));?>
    <fieldset>
        <legend><?php echo __('Ajouter cadeau'); ?></legend>
        <?php echo $this->Form->input('label_cadeau',array('label'=>'Titre du cadeau'));
        echo $this->Form->input('desc',array('label'=>'Description du cadeau'));
        echo $this->Form->input('point_cadeau',array('label'=>'Nombre de points', 'default' => 0 ));
         echo $this->Form->input('infodusource');
        echo $this->Form->input('url_image',array('label'=>'Image du cadeau','type'=>'file'));
        ?>
    </fieldset>
<?php echo $this->Form->end(__('Ajouter'));?>
</div>