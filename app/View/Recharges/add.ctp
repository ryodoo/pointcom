<div class="recharges form">
    <?php echo $this->Form->create('Recharge');?>
    <fieldset>
        <legend><?php echo __('Ajouter Recharge'); ?></legend>
        <?php
        echo $this->Form->input('hachage+',array('label'=>'Recharge'));
        echo $this->Form->input('point');
        ?>
        <div class="input">
            <label for="RechargePrix">Prix</label>
            <select name="data[Recharge][prix]" id="PagTypeId">
                <option value="10">10 DH</option>
                <option value="20">20 DH</option>
                <option value="50">50 DH</option>
                <option value="100">100 DH</option>
            </select>
        </div>
        <div class="input">
            <label>Operateur</label>
            <select name="data[Recharge][operateur]" id="PagTypeId">
                <option value="iam">IAM</option>
                <option value="meditel">Meditel</option>
                <option value="inwi">Inwi</option>
                <option value="bayn">Bayn</option>
            </select>
        </div>
    </fieldset>
    <?php echo $this->Form->end(__('Ajouter'));?>
</div>