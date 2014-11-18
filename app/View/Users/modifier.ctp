<?php
$this->set('title',"Update utilisateur");
echo $this->Session->flash();
?>

<div class="users form">
<?php echo $this->Form->create('User');?>
    <fieldset>
        <legend><?php echo __('Modifier User'); ?></legend>
        <?php
        echo $this->Form->hidden('id_user', array('value' => $user['User']['id']));
        echo $this->Form->input('point', array('value' => $user['User']['point']));
        echo $this->Form->input('active', array('value' => $user['User']['active'], 'options' => array(0 => "Non Active", 1 =>  "Active")));
       
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Valider'));?>
</div>