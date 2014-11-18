<div id="cont">
    <?php
    $this->set('title',"Administration");
    echo $this->Session->flash();
    ?>

    <h3>Details du paiement</h3>
    <?php if($this->Session->read('Auth.User.role_user') == "admin") {
        echo $this->Form->create('Paiement');?>
    <input type="hidden" name="paiement_id" value="<?php echo $paiement['Paiement']['id']; ?>" />
   <?php }?>
    <table>
        <tr>
            <td>Nom</td>
            <td><?php echo $paiement['User']['nom_complet']; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $paiement['User']['email']; ?></td>
        </tr>
        <tr>
            <td>Date de paiement</td>
            <td><?php echo $paiement['Paiement']['created']; ?></td>
        </tr>
        <tr>
            <td>Envoyé par</td>
            <td><?php echo $paiement['Paiement']['nom']; ?></td>
        </tr>
        <tr>
            <td>Prix</td>
            <td><?php echo $paiement['Paiement']['prix']; ?></td>
        </tr>
        <tr>
            <td>Reçu</td>
            <td><a href="<?php echo $this->Html->url( '/', true ); ?>img/paiement/<?php echo $paiement['Paiement']['avatar']; ?>" target="_blank">Voir reçu</a></td>
        </tr>
    <?php if($this->Session->read('Auth.User.role_user') == "admin"): ?>
        <tr>
            <td>Nombre de Points</td>
            <td>
        <?php
                        echo $this->Form->input('point', array("label" => false, "div"=>false, 'value' =>  $paiement['User']['point']));
                        ?>
            </td>
        </tr>

        <tr>
            <td>Motif</td>
            <td>
        <?php
                        echo $this->Form->input('motif', array("label" => false, "div"=>false));
                        ?>
            </td>
        </tr>

 </table>
        <?php echo $this->Form->end('VALIDER'); ?>
        <?php endif; ?>
            </table>
</div>
