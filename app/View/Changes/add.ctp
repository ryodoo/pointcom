<div class="changes form">
    <?php echo $this->Session->flash();
    echo $this->Form->create('Change');?>
    <fieldset>
        <p style="font-size: 18px;  color: #FFFFFF;  font-weight: bold;padding:6px;background: #555;">
            LE montant total de transaction doit dépassé 300 Points pour que la transaction passe<br>
            Les frais de transaction serant facturé sur vous.
        </p>
        <legend><?php echo __('Transaction'); ?></legend>
        <?php
        echo $this->Form->input('point');
        ?>
    </fieldset>
    <div>
        
    </div>
    <?php echo $this->Form->end(__('Envoyer'));?>

</div>
