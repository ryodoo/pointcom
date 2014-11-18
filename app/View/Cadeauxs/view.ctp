<div id="cont" class="util">
    <h2 style="font-size: xx-large;color: #cb0000;width: 100%;margin-top: 47px;margin-bottom: 20px;">les informations du cadeau</h2>
    <?php
    $this->set('title',"Cadeau");
    echo $this->Session->flash();

    if(!empty($cadeau)):

        if($this->Session->read('Auth.User.role_user') == "admin") {
            echo $this->Form->create('Cadeaux', array('type' => 'file','style'=>"-webkit-box-shadow:none !important"));
            echo $this->Form->hidden('id_cadeaux', array('value' => $cadeau[0]['cadeaux']['id_cadeaux']));
            echo $this->Form->input('label_cadeau',array('label'=>'Titre cadeau', 'value' => $cadeau[0]['cadeaux']['label_cadeau']));
            echo $this->Form->input('desc',array('label'=>'Description du cadeau', 'value' => $cadeau[0]['cadeaux']['desc'] ));
            echo $this->Form->input('point_cadeau',array('label'=>'Nombre de points', 'value' => $cadeau[0]['cadeaux']['point_cadeau'] ));
            echo $this->Form->input('infodusource', array("label" => "Mien +les info du cadeau le prix truc privé", "div"=>false , "id" => "datepicker2", 'value' => $cadeau[0]['cadeaux']['infodusource']));
            ?>
    <br/>
            <?php
            echo $this->Form->input('url_img',array('label'=>'Image du cadeau','type'=>'file'));?>
    <img src="<?php echo $this->Html->url( '/', true ); ?>img/cadeaux/<?php echo $cadeau[0]['cadeaux']['url_image']; ?>" width="120" height="120" />

            <?php echo $this->Form->end(__('Valider'));
        }

        else {

            ?>

    <div class="cdximg">
                <?php  echo $this->Html->image("cadeaux/".$cadeau[0]['cadeaux']['url_image'],array("width"=>"120px;","height"=>"120px;")); ?>
    </div>
    <div id="infocdx">
        <dl>
            <dt>Cadeaux</dt>
            <dd>
                        <?php echo $cadeau[0]['cadeaux']['label_cadeau']; ?>
                &nbsp;
            </dd>
            <dt>Description</dt>
            <dd>
                        <?php echo $cadeau[0]['cadeaux']['desc']; ?>
                &nbsp;
            </dd>
            <dt>Nombre de points : </dt>
            <dd>
                        <?php echo $cadeau[0]['cadeaux']['point_cadeau']; ?> Points &nbsp;
            </dd>
        </dl>
    </div>
    <div class="actionscdx">
        <ul>
            <li><?php if(AuthComponent::user('id')!=null)
                            echo $this->Html->link('Commender',array('controller'=>'usergifts','action'=>"add",$cadeau[0]['cadeaux']['id_cadeaux'])); ?>
            </li>
        </ul>
    </div>
            <?php }
    endif;?>
</div>