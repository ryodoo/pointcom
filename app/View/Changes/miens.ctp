<div id="cont" class="util">
    <?php echo $this->Session->flash();?>
    <div class="recharges index">
        
        <?php if(!empty($changes)){ ?>
        <h2><?php echo __('liste des changes effectuées');?></h2>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?php echo 'point';?></th>
                <th><?php echo 'prix';?></th>
                <th><?php echo 'info';?></th>
                <th><?php echo 'Date';?></th>
            </tr>
            <?php
            foreach ($changes as $change): ?>
            <tr>
                <td><?php echo h($change['Change']['point']); ?> Points</td>
                <td><?php echo h($change['Change']['prix']); ?> DH</td>
                <td><?php if($change['Change']['description']!=null)
                            echo h($change['Change']['description']);
                        else
                            echo 'En cour';
                        ?>
                </td>
                <td><?php echo h($change['Change']['created']); ?>&nbsp;</td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php }
        else
            echo '<h2 style="width:100%;margin-left: 0px;margin-bottom: 20px;">Aucune transaction n’a été faite dans ce compte.</h2>';
        ?>

    </div>
    <div class="actions">
        <?php echo $this->Html->link('Échangez vos points',array('action'=>'add'));?>
    </div>
</div>