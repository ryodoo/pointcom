
<div class="users form">
    <?php
    echo $this->Session->flash();
    echo $this->Form->create('User');?>
    <fieldset>
        <legend><?php echo __('Modifier Mot de passe'); ?></legend>
        <?php
        echo $this->Form->input('password',array('label'=>'Encien mot de passe'));?>
        <div class="input password required">
            <label for="UserPpassword">Mot de passe</label>
            <input name="data[User][ppassword]" type="password" id="UserPpassword">
        </div>
        <div class="input password required">
            <label for="UserRePassword">Confirmez votre mot de passe</label>
            <input name="data[User][re_password]" type="password" id="UserRePassword">
        </div>
    </fieldset>
    <?php echo $this->Form->end(__('Modifier'));?>
</div>
