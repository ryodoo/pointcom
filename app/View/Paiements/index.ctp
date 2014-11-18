<div class="paiements index">

    <h2><?php echo __('Paiements');?></h2>
    <?php
    $this->set('title',"Paiement");
    echo $this->Session->flash();
    if(!empty($paiements)){
    ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('user_id');?></th>
            <th><?php echo $this->Paginator->sort('nom');?></th>
            <th><?php echo $this->Paginator->sort('mantant');?></th>
            <th><?php echo $this->Paginator->sort('point');?></th>
            <th><?php echo $this->Paginator->sort('Validation');?></th>
            <th><?php echo $this->Paginator->sort('date d\'envoie');?></th>
            <th class="actions">
                <?php echo __('Actions');?></th>
        </tr>
        <?php
        foreach ($paiements as $paiement): ?>
        <tr>
            <td>
                    <?php echo $this->Html->link($paiement['User']['nom_complet'], array('controller' => 'users', 'action' => 'view', $paiement['User']['id'])); ?>
            </td>
            <td><?php echo h($paiement['Paiement']['nom']); ?>&nbsp;</td>
            <td><?php echo h($paiement['Paiement']['prix']); ?>&nbsp;DH</td>
            <td><?php echo h($paiement['Paiement']['point']); ?>&nbsp;Points</td>
            <td><?php echo h($paiement['Paiement']['motif']); ?>&nbsp;</td>
            <td><?php echo h($paiement['Paiement']['created']); ?>&nbsp;</td>
            <td class="actions">
                    <?php echo $this->Html->link(__('Detail'), array('action' => 'view', $paiement['Paiement']['id'])); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
        'format' => __('')
        ));
        ?>	</p>

    <div class="paging">
        <?php
        echo $this->Paginator->prev('< ' . __('Précédent '), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => '||'));
        echo $this->Paginator->next(__('|| Suivanat') . ' >', array(), null, array('class' => 'next disabled'));
        ?>
    </div>
    <?php }
          else
              echo '<h2 style="width:100%;margin-left: 0px;margin-bottom: 20px;">
                       Pour le moment vous n\'avez aucun paiement envoye.
                </h2>';
    ?>
    <div class="actions cmpt">
        <?php echo $this->Html->link('Acheter des points',array('action'=>'add'),array("class"=>"btn")); ?>
    </div>
</div>
