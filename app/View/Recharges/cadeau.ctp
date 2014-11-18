<div id="cont">
    <?php echo $this->Session->flash(); ?>
    <ul class="cadeaux">
        <title>Listes des cadeaux</title>
        <?php foreach($cads as $data1):?>
        <li>
            <a href="<?php echo $this->Html->url(array('controller'=>'recharges','action'=>'view', $data1['Recharge']['id'])); ?>">
                <?php  echo $this->Html->image("cadeaux/".$data1['Recharge']['operateur'].'_'.$data1['Recharge']['prix'].'.jpg',array("width"=>"100%;","height"=>"100%;")); ?>
                <b><text></text>Carte recharge <?php echo $data1['Recharge']['operateur']; ?> de <?php echo $data1['Recharge']['prix']; ?> DH<br> <span><?php echo $data1['Recharge']['point']; ?><strong></strong></span></b>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>