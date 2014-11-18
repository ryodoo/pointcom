<?php
$this->set('title',"Nouveau magasin");
//echo $this->element('sql_dump');
//$this->layout = 'administration';
echo $this->Session->flash();
?>
<div class="users form">
<?php echo $this->Form->create('Cadeaux', array('type' => 'file'));?>
    <fieldset>
        <legend><?php echo __('Modifier cadeau'); ?></legend>
        <img src="<?php echo $this->Html->url( '/', true ); ?>img/cadeauxProjet/<?php echo $cadeau['Cadeaux']['url_image']; ?>" width="120" height="120" />
        <?php
        echo $this->Form->hidden('id_uhc', array('value' => $uhc['UserHasCadeaux']['id']));
        echo $this->Form->hidden('id_cadeaux', array('value' => $cadeau['Cadeaux']['id_cadeaux']));
        echo $this->Form->input('label_cadeau',array('label'=>'Label du cadeau', 'value' => $cadeau['Cadeaux']['label_cadeau'], "readonly" => "readonly"));
        echo $this->Form->input('desc',array('label'=>'Description du cadeau', 'value' => $cadeau['Cadeaux']['desc'], "readonly" => "readonly" ));
        echo $this->Form->input('point_cadeau',array('label'=>'Nombre de points', 'value' => $cadeau['Cadeaux']['point_cadeau'], "readonly" => "readonly" ));
        echo $this->Form->input('quantity',array('label'=>'Quantité', 'value' => $cadeau['Cadeaux']['quantity'], "readonly" => "readonly" ));
        echo $this->Form->input('nb_commandes',array('label'=>'Nombre de commandes', 'value' => $cadeau['Cadeaux']['nb_commandes'], "readonly" => "readonly" ));
        echo $this->Form->input('Utilisateur',array('label'=>'Utilisateur', 'value' => $user[0]['User']['nom']." ".$user[0]['User']['prenom'], "readonly" => "readonly"));
        echo $this->Form->input('etat',array('label'=>'Etat', 'value' => $uhc["UserHasCadeaux"]["etat"], 'options' => array(0 => "En cours", 1 =>  "Non reçu", 2 => "Reçu", -1 => "Annulé") ));
        echo $this->Form->input('message',array('label'=>'Votre message', "type" => "textarea"));
        ?>
        
    </fieldset>
<?php echo $this->Form->end(__('Valider'));?>
    <?php //echo $this->element('sql_dump');?>
</div>