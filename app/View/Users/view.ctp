<div id="cont" class="util">
    <?php
    $this->set('title',"Utilisateur");
    echo $this->Session->flash();
    ?>
    <h3>Details de l'utilisateur</h3>
    <div id="infoediteur">
        <dl>
            <dt>Nom & prenom</dt>
            <dd><?php echo $user['User']['nom_complet']; ?></dd>
            <dt>E-mail</dt>
            <dd><?php echo $user['User']['email']; ?></dd>
            <dt>Date d'inscription</dt>
            <dd><?php echo $user['User']['created']; ?></dd>
            <dt>Telephone</dt>
            <dd><?php echo $user['User']['tel']; ?></dd>
            <dt>Adresse</dt>
            <dd><?php echo $user['User']['adresse']; ?></dd>
            <dt>Point</dt>
            <dd><?php echo $user['User']['point']; ?> Points</dd>
            <dt>Sexe</dt>
            <dd><?php echo $user['User']['sexe']; ?></dd>
            <dt>Age</dt>
            <dd><?php echo $user['User']['age']; ?></dd>
        </dl>
    </div>

    <table border="1" cellspacing="2" cellpadding="2" bgcolor="#CCCCCC" width="95%">
        <tr>
            <th>Date Qr1</th>
            <th>Date Qr2</th>
            <th>Nombre de points</th>
            <th>Magasin</th>
        </tr>

        <?php
        $i=1;
        foreach($visits as $data1):
            $i=-$i;
            ?>
        <tr id="c<?php echo($i); ?>" onMouseOver="this.style.backgroundColor='#FFDDBB'" onMouseOut="this.style.backgroundColor='<?php if($i > 0)echo('#EBEBEB'); else echo('#D4D4D4');?>';">
            <td><?php echo $data1['scan']['date_scan1']; ?></td>
            <td><?php echo $data1['scan']['date_scan2']; ?></td>
            <td><?php echo $data1['mission']['point_offre']; ?></td>
            <td><?php echo $data1['magasin']['nom_mag']; ?></td>
        </tr>
        <?php
        endforeach;?>
    </table>

    <br/>
    <div id="chartdiv" ></div>
    <?php

    $val="Evolution des points par jour ";

    $str="<graph caption='".$val."'
       xAxisName='Temps' yAxisMinValue='0' yAxisName='Points'
       decimalPrecision='0' formatNumberScale='0' numberPrefix=''
       showNames='1' showValues='0' showAlternateHGridColor='1'
       AlternateHGridColor='blue' divLineColor='ff5904' divLineAlpha='20'
       alternateHGridAlpha='5'>";

    if(isset($liste)) {
        $t=$liste;
        //print_r($t);
        if(!empty($t)):
            foreach($t as $k => $v):
                $str .= "<set name='" . $k ."' value='" . $v ."' />";
            endforeach;
            echo $str;
        endif;

    }

    $str.="</graph>";
    include("FusionCharts.php");
    echo renderChartHTML($this->webroot."/Line.swf", "", $str, "ChartId", 830, 390);

    ?>
    <h3>Les cadeaux</h3>
    ?>
    <table border="1"  cellspacing="2" cellpadding="2" bgcolor="#CCCCCC" width="95%">
        <tr>
            <th>Cadeaux</th>
            <th>Description</th>
            <th>Image</th>
            <th>Nombre de points</th>
            <th>Date de la commande</th>
            <th>Etat</th>
        </tr>

        <?php
        $i=1;
        foreach($gifts as $data1):
            $i=-$i;
            ?>
        <tr id="c<?php echo($i); ?>" onMouseOver="this.style.backgroundColor='#FFDDBB'" onMouseOut="this.style.backgroundColor='<?php if($i > 0)echo('#EBEBEB'); else echo('#D4D4D4');?>';">
            <td>
                <?php echo $this->Html->image('cadeaux/'.$data1['cadeaux']['url_image'],array('width'=>'120px','height'=>'120px')); ?>
            </td>
            <td><?php echo $data1['cadeaux']['label_cadeau']; ?></td>
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
                    if($data1['uhc']['etat'] == 2) echo "Reçu";
                    if($data1['uhc']['etat'] == -1) echo "Annulé"; ?>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
</div>
