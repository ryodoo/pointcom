<div id="cont" class="util">
    <div class="recharges index">
        <h2><?php echo __('Recharges'); ?></h2>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <?php if (AuthComponent::user('role_user') == 'admin')
                    echo "<th>User</th>"
                    ?>
                <th>Recharge</th>
                <th>Prix</th>
                <th>Point</th>
                <th>Operateur</th>
                <th>Date</th>
                <?php if (AuthComponent::user('role_user') == 'admin'):
                    echo "<th>created</th>"
                    ?>
                    <th class="actions"><?php echo __('Actions');
                endif; ?></th>
            </tr>
                <?php foreach ($recharges as $recharge): ?>
                <tr>
                    <?php if (AuthComponent::user('role_user') == 'admin') : ?>
                        <td><?php echo $this->Html->link($recharge['User']['nom_complet'], array('controller' => 'users', 'action' => 'view', $recharge['User']['id'])); ?></td>
                        <?php endif; ?>
                    <td><?php $re = ($recharge['Recharge']['hachage+'] + $recharge['Recharge']['hachage']) / $recharge['Recharge']['hachage'];
                    echo h($re);
                    ?>&nbsp;</td>
                    <td><?php echo h($recharge['Recharge']['prix']); ?>&nbsp;</td>
                    <td><?php echo h($recharge['Recharge']['point']); ?>&nbsp;</td>
                    <td><?php echo h($recharge['Recharge']['operateur']); ?>&nbsp;</td>
                    <td><?php echo h($recharge['Recharge']['modified']); ?>&nbsp;</td>
                    <?php if (AuthComponent::user('role_user') == 'admin') : ?>
                        <td><?php echo h($recharge['Recharge']['created']); ?>&nbsp;</td>

                        <td class="actions">
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $recharge['Recharge']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $recharge['Recharge']['id']), null, __('Are you sure you want to delete # %s?', $recharge['Recharge']['id'])); ?>
                        </td>
                <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="paging">
            <?php
            echo $this->Paginator->prev('< ' . __('Précédent'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('Suivant') . ' >', array(), null, array('class' => 'next disabled'));
            ?>
        </div>
    </div>
</div>

<?php if (AuthComponent::user('role_user') == 'admin') 
        echo $this->Html->link('Ajouter une recharge', array('action' => 'add')); 
?>