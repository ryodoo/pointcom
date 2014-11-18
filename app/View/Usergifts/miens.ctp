<div id="cont" class="util">
    <?php
    $this->set('title',"Utilisateurs");

    echo $this->Session->flash();


    if(!empty($gifts)){
        echo "<h3>Mes cadeaux</h3>";
        ?>
    <table border="1"  cellspacing="2" cellpadding="2" bgcolor="#CCCCCC" width="95%">
        <tr>
            <th>
                Image
            </th>
            <th>
                Cadeaux
            </th>
            <th>
                Description
            </th>
            <th>
                Nombre de points
            </th>
            <th>
                Date de la commande
            </th>
            <th>
                Etat
            </th>
        </tr>

            <?php
            $i=1;
            foreach($gifts as $data1):
                $i=-$i;
                ?>
        <tr id="c<?php echo($i); ?>" onMouseOver="this.style.backgroundColor='#FFDDBB'" onMouseOut="this.style.backgroundColor='<?php if($i > 0)echo('#EBEBEB'); else echo('#D4D4D4');?>';">
            <td>
                        <?php echo $this->Html->image('cadeaux/'.$data1['cadeaux']['url_image'],array('width'=>'20px','height'=>'20px')); ?>
            </td>
            <td>
                        <?php echo $data1['cadeaux']['label_cadeau']; ?>
            </td>
            <td>
                        <?php echo $data1['cadeaux']['desc']; ?>
            </td>
            <td>
                        <?php echo $data1['cadeaux']['point_cadeau']; ?>
            </td>
            <td>
                        <?php echo $data1['uhc']['created']; ?>
            </td>
            <td>
                        <?php if($data1['uhc']['etat'] == 0) echo "En cours";
                        if($data1['uhc']['etat'] == 1) echo "Non reçu";
                        if($data1['uhc']['etat'] == 2) echo "Reçu";
                        if($data1['uhc']['etat'] == -1) echo "Annulé"; ?>
            </td>
        </tr>
            <?php
            endforeach;
            echo "</table>";
    }
   else
            echo '<h2 style="width:100%;margin-left: 0px;margin-bottom: 20px;">
                    Aucun cadeau n’est demandé par ce compte.
                </h2>';
        ?>
</div>
