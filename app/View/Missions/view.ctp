<div class="missions view">
    <div id="infoediteur" style="width:72%;">
        <h2 style="width:100%;"><?php echo __('Details de la Mission'); ?></h2>
        <table style="width:48% !important;min-height:257px; float:left;margin-right:8px;">
          <tr>
			<td><?php echo __('Image'); ?></td>
            <td><?php echo $this->Html->image('mission/mobile/' . $mission['Mission']['image']); ?></td>
		  </tr>
		  <tr>
            <td><?php echo __('Titre'); ?></td>
            <td>
                <?php echo h($mission['Mission']['titre']); ?>
                &nbsp;
            </td>
		  </tr>
		  <tr>
            <td><?php echo __('Description'); ?></td>
            <td>
                <?php echo h($mission['Mission']['description']); ?>
                &nbsp;
            </td>
		  </tr>
		  <tr>
            <td><?php echo __('type de mission'); ?></td>
            <td>
                <?php echo h($mission['Mission']['type']); ?>
                &nbsp;
            </td>
		</tr>
		<tr>
            <td><?php echo __('N° Client'); ?></td>
            <td>
                <?php echo h($mission['Mission']['client']); ?> Clients
                &nbsp;
            </td>
		</tr>
		<tr>
            <td><?php echo __('Point/client'); ?></td> 
            <td>
                <?php echo h($mission['Mission']['point/client']); ?> Points
                &nbsp;
            </td>
		</tr>
		</table>
		<table style="width:48% !important;min-height:257px; float:left;">
		<tr>
            <td><?php echo __('N° points total'); ?></td>
            <td>
                <?php echo $mission['Mission']['point/client'] * $mission['Mission']['client']; ?> Points
                &nbsp;
            </td>
		</tr>
		<tr>
            <td><?php echo __('Reste des clients a passer'); ?></td>
            <td>
                <?php echo h($mission['Mission']['reste']); ?> Clients
                &nbsp;
            </td>
		</tr>
		<tr>
            <td><?php echo __('Date de mission'); ?></td>
            <td>
                <?php echo h($mission['Mission']['date']); ?>
                &nbsp;
            </td>
		</tr>
		<tr>
            <td><?php echo __('Code Qr1'); ?></td>
            <td>
                <?php echo $this->Html->link("Cliquer ici", array('action' => 'code', $mission['Mission']['qr1'], 'Code QR1')); ?>
                &nbsp;
            </td>
		</tr>
            <?php if ($mission['Mission']['type'] == "visite"): ?>
             <tr> 
			  <td><?php echo __('Code Qr2'); ?></td>
                <td>
                    <?php echo $this->Html->link("Cliquer ici", array('action' => 'code', $mission['Mission']['qr2'], 'Code QR1')); ?>
                    &nbsp;
                </td>
			</tr>
			<tr>
                <td><?php echo __('Duré'); ?></td>
                <td>
                    <?php echo h($mission['Mission']['temps']); ?> min
                    &nbsp;
                </td>
			</tr>
            <?php endif; ?>
          <tr>
			<td><?php echo __('Date d\'ajout'); ?></td>
            <td>
                <?php echo h($mission['Mission']['created']); ?>
                &nbsp;
            </td>
		 </tr>		
        </table>
        <?php
        if ((strtotime($mission['Mission']['date']) + 600) >= time()) {
            echo $this->Html->link(__('Editer'), array('action' => 'edit', $mission['Mission']['id']),array('class' => 'btn','style' => 'display: table-cell;'));
            echo $this->Form->postLink(__('Supprimer'), array('action' => 'delete', $mission['Mission']['id']),array('class' => 'btn','style' => 'display: table-cell;'), null, 'etes vous sur de vouloir supprimer cette mission');
        } else
            echo $this->Html->link(__('Statistique'), array('action' => 'state', $mission['Mission']['id']),array('class' => 'btn','style' => 'display: table-cell;'));
        echo $this->Html->link(__('Ajouter des crédits'), array('action' => 'credit', $mission['Mission']['id']),array('class' => 'btn','style' => 'display: table-cell;'));
        ?>
    </div>

</div>
