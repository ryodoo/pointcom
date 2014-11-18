<?php
$this->set('title',"Cadeaux");

if($this->Session->read('Auth.User.role_user') == "admin") {
    ?>
<a href="<?php echo $this->Html->url(array('controller'=>'cadeauxs','action'=>'add')); ?>" class="btn1">
    Nouveau Cadeaux</a>
    <?php
}?>
<div id="cont">
    <?php echo $this->Session->flash(); ?>
    <ul class="cadeaux">
        <title>Liste des cadeaux</title>
        <li>
            <a href="<?php echo $this->Html->url(array('controller'=>'recharges','action'=>'cadeau')); ?>">
                    <?php  echo $this->Html->image("cadeaux/myblan-rech.jpg",array("width"=>"100%;","height"=>"100%;")); ?>
                <b>
                    Cartes recharges <br> <span>De 10 à 50 <strong>Points</strong></span></b>
            </a>
        </li>

        <?php  foreach($cadeaux as $data1):?>
        <li>
            <a href="<?php echo $this->Html->url(array('controller'=>'cadeauxs','action'=>'view', $data1['Cadeaux']['id_cadeaux'])); ?>">
                    <?php  echo $this->Html->image("cadeaux/".$data1['Cadeaux']['url_image'],array("width"=>"100%;","height"=>"100%;")); ?>
                <b style="min-height: 50px;width: 100%;height: auto;float: left;margin-top: 10px;">
                    <?php echo $data1['Cadeaux']['label_cadeau']; ?><br>
                </b>
                <span><?php echo $data1['Cadeaux']['point_cadeau']; ?><strong> Points</strong></span>
            </a>
        </li>
        <?php endforeach;?>

    </ul>
    <?php echo $this->requestAction("/users/countuser"); ?>
</div>