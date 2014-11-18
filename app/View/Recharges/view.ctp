<div id="cont" class="util">
    <?php
    $this->set('title',"Cadeau");
    echo $this->Session->flash();
    if(!empty($recharge)):?>
    <div class="cdximg">
	<?php  echo $this->Html->image("cadeaux/".$recharge['Recharge']['operateur'].'_'.$recharge['Recharge']['prix'].'.jpg',array("width"=>"100%;","height"=>"100%;")); ?>
    </div>
    <div id="infocdx">
        <dl>
            <dt>Cadeaux</dt>
            <dd>
                Recharge
               &nbsp;
            </dd>
            <dt>Model</dt>
            <dd>
                 <?php echo $recharge['Recharge']['operateur']; ?> de <?php echo $recharge['Recharge']['prix']; ?> DH
                &nbsp;
            </dd>
            <dt>Nombre de points : </dt>
            <dd>
                <?php echo $recharge['Recharge']['point']; ?> Points &nbsp;
            </dd>
        </dl>
    </div>
    <div class="actionscdx">
        <ul>
            <li><?php if(AuthComponent::user('id')!=null)
                        echo $this->Html->link('Commender',array('controller'=>'usergifts','action'=>"addrecharge",$recharge['Recharge']['id'])); ?></li>
        </ul>
    </div>
    <?php endif; ?>
</div>