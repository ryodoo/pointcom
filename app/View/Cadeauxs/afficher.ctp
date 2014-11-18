<?php
$this->set('title',"Cadeau");
//echo $this->element('sql_dump');

echo $this->Session->flash();

if(!empty($cadeau)):
    ?>
<table class="colorText">
    <tr>
        <td>
            <?php  echo $this->Html->image("cadeaux/".$cadeau[0]['cadeaux']['url_image'],array("width"=>"120px;","height"=>"120px;"));?>
        </td>
        <td>
                <?php echo $cadeau[0]['cadeaux']['label_cadeau']; ?> <br/>   <?php echo $cadeau[0]['cadeaux']['desc']; ?>
        </td>
    </tr>

    <tr>
        <td>Points</td>
        <td>
                <?php echo $cadeau[0]['cadeaux']['point_cadeau']; ?>
        </td>
    </tr>

    <tr>
        <td>Quantité</td>
        <td>
                <?php echo $cadeau[0]['cadeaux']['quantity']; ?>
        </td>
    </tr>

    <tr>
        <td>nombre de demandes</td>
        <td>
                <?php echo $cadeau[0]['cadeaux']['nb_commandes']; ?>
        </td>
    </tr>

    <tr>
        <td>Date d'expiration</td>
        <td>
                <?php echo $cadeau[0]['cadeaux']['date_expiration']; ?>
        </td>
    </tr>
</table>
<br/>
<a href="<?php echo $this->Html->url(array('action'=>'view', $cadeau[0]['cadeaux']['id_cadeaux'])); ?>" class="btn1">Modifier</a>
<?php

endif;
