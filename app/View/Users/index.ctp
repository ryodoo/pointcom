<div id="cont" class="util">
    <?php if ($this->Session->read('Auth.User.role_user') != "admin") { ?>
        <div id="infoediteur">
            <h2>Mon compte</h2>
            <dl>
                <dt>Nom & prenom</dt>
                <dd><?php echo $this->Session->read('Auth.User.nom_complet'); ?></dd>
                <dt>E-mail</dt>
                <dd><?php echo $this->Session->read('Auth.User.email'); ?></dd>
                <dt>Date d'inscription</dt>
                <dd><?php echo $this->Session->read('Auth.User.created'); ?></dd>
                <dt>Telephone</dt>
                <dd><?php echo $this->Session->read('Auth.User.tel'); ?></dd>
                <dt>Adresse</dt>
                <dd><?php echo $this->Session->read('Auth.User.adresse'); ?></dd>
                <dt>Point</dt>
                <dd><?php echo $this->Session->read('Auth.User.point'); ?> Points</dd>
            </dl>
        </div>

    <?php } ?>


    <?php if ($this->Session->read('Auth.User.role_user') == "vendeur") : 
              $hamza=0;
        ?>
        <h2><?php echo __('La liste des missions actif'); ?></h2>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th>Image</th>
                <th>Titre</th>
                <th>Date debut</th>
                <th>N° Clients</th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php
            $date = date('Y-m-d');
            foreach ($info['Questionnaire'] as $value):
                ?>
                <tr>
                    <td><div class="ribons" id="<?php
                        if ($value['reste'] > 0 && $value['date'] < $date)
                            echo 'vert';
                        ?>" ></div>
                             <?php echo $this->Html->image('questionnaire/qmobile/' . $value['image']); ?>
                        <div class="gnr" id="gnrquest"><b>Questionnaire</b></div>
                    </td>
                    <td><?php echo h($value['name']); ?>&nbsp;</td>
                    <td><?php echo h($value['date']); ?>&nbsp;</td>
                    <td class="nbrclient<?php echo $hamza;?>">
                       <span class="spanprogress">
                           <b class="prog<?php echo $hamza; $hamza++;?>"></b>
                       </span> 
                       <e name="<?php echo $value['nombreuser']-$value['reste'];?>"> </e> <br> <f> </f> / <d name="<?php echo $value['nombreuser'];?>"> </d>    
                    </td>
                    <td class="actions">
                        <?php
                        echo $this->Html->link(__('Voir'), array('controller' => 'questionnaires', 'action' => 'view', $value['id']));
                        echo $this->Html->link(__('Statistique'), array('controller' => 'questions', 'action' => 'state', $value['id']));
                        echo $this->Html->link(__('Ajouter des crédits'), array('controller' => 'questionnaires', 'action' => 'credit', $value['id']));
                        ?>
                    </td>
                </tr>
                <?php
            endforeach;
            foreach ($info['Pag'] as $value):
                ?>
                <tr>
                    <td><div class="ribons" id="<?php
                        if ($value['reste'] > 0 && $value['date'] < $date)
                            echo 'vert';
                        ?>" ></div>
                             <?php echo $this->Html->image($value['image']); ?>
                        <div class="gnr" id="gnrquest"><b>Facebook</b></div>
                    </td>
                    <td><?php echo h($value['titre']); ?>&nbsp;</td>
                    <td><?php echo h($value['date']); ?>&nbsp;</td>
                    <td class="nbrclient<?php echo $hamza;?>">
                       <span class="spanprogress">
                           <b class="prog<?php echo $hamza; $hamza++;?>"></b>
                       </span> 
                       <e name="<?php echo $value['user']-$value['reste'];?>"> </e> <br> <f> </f> / <d name="<?php echo $value['user'];?>"> </d>    
                    </td>
                    <td class="actions">
                        <?php
                        echo $this->Html->link(__('Voir'), array('controller' => 'pags', 'action' => 'view', $value['id']));
                        echo $this->Html->link(__('Statistique'), array('controller' => 'pags', 'action' => 'state', $value['id']));
                        echo $this->Html->link(__('Ajouter des crédits'), array('controller' => 'pags', 'action' => 'credit', $value['id']));
                        ?>
                    </td>
                </tr>
                <?php
            endforeach;
            foreach ($info['Mission'] as $value):
                ?>
                <tr>
                    <td><div class="ribons" id="<?php
                        if ($value['reste'] > 0 && $value['date'] < $date)
                            echo 'vert';
                        ?>" ></div>
                             <?php echo $this->Html->image('mission/mobile/' . $value['image']); ?>
                        <div class="gnr" id="gnrquest"><b>Mission</b></div>
                    </td>
                    <td><?php echo h($value['titre']); ?>&nbsp;</td>
                    <td><?php echo h($value['date']); ?>&nbsp;</td>
                    <td class="nbrclient<?php echo $hamza;?>">
                       <span class="spanprogress">
                           <b class="prog<?php echo $hamza; $hamza++;?>"></b>
                       </span> 
                       <e name="<?php echo $value['client']-$value['reste'];?>"> </e> <br> <f> </f> / <d name="<?php echo $value['client'];?>"> </d>    
                    </td>
                <td class="actions">
                    <?php
                    echo $this->Html->link(__('Voir'), array('controller' => 'missions', 'action' => 'view', $value['id']));
                    echo $this->Html->link(__('Statistique'), array('controller' => 'missions', 'action' => 'state', $value['id']));
                    echo $this->Html->link(__('Ajouter des crédits'), array('controller' => 'missions', 'action' => 'credit', $value['id']));
                    ?>
                <?php endforeach; ?>
        </table>

        <?php
    endif;
    if ($this->Session->read('Auth.User.role_user') == "admin") :
        ?>
        <table border="1"  cellspacing="2" cellpadding="2" bgcolor="#CCCCCC" width="95%">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Total</th>
                    <th>Prochainement</th>
                    <th>En cour</th>
                    <th>Terminer</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tr>
                <td>Missions</td>
                <td><?php echo $this->Html->link(count($missions), array('controller' => 'missions', 'action' => 'index')); ?></td>
                <?php
                $encour = $pro = $fin = $point = 0;
                foreach ($missions as $value) {
                    $point = $point + $value['Mission']['client'] * $value['Mission']['point/client'];
                    if ((strtotime($value['Mission']['date']) + 600) >= time())
                        $pro++;
                    else {
                        if ($value['Mission']['reste'] > 0)
                            $encour++;
                        else
                            $fin++;
                    }
                }
                ?>
                <td><?php echo $this->Html->link($pro, array('controller' => 'missions', 'action' => 'index', 'pro')); ?></td>
                <td><?php echo $this->Html->link($encour, array('controller' => 'missions', 'action' => 'index', 'cour')); ?></td>
                <td><?php echo $this->Html->link($fin, array('controller' => 'missions', 'action' => 'index', 'fin')); ?></td>
                <td><?php echo $point; ?></td>
            </tr>
            <tr>
                <td>Questionnaire</td>
                <td><?php echo $this->Html->link(count($questionnaires), array('controller' => 'questionnaires', 'action' => 'index')); ?></td>
                <?php
                $encour = $pro = $fin = $point = 0;
                foreach ($questionnaires as $value) {
                    $point = $point + $value['Questionnaire']['nombreuser'] * $value['Questionnaire']['pointparuser'];
                    if ((strtotime($value['Questionnaire']['date']) + 600) >= time())
                        $pro++;
                    else {
                        if ($value['Questionnaire']['reste'] > 0)
                            $encour++;
                        else
                            $fin++;
                    }
                }
                ?>
                <td><?php echo $this->Html->link($pro, array('controller' => 'questionnaires', 'action' => 'index', 'pro')); ?></td>
                <td><?php echo $this->Html->link($encour, array('controller' => 'questionnaires', 'action' => 'index', 'cour')); ?></td>
                <td><?php echo $this->Html->link($fin, array('controller' => 'questionnaires', 'action' => 'index', 'fin')); ?></td>
                <td><?php echo $point; ?></td>
            </tr>
            <tr>
                <td>Pages facebook </td>
                <td><?php echo $this->Html->link(count($pages), array('controller' => 'pags', 'action' => 'index')); ?></td>
                <?php
                $encour = $pro = $fin = $point = 0;
                foreach ($pages as $value) {
                    $point = $point + $value['Pag']['user'] * $value['Pag']['point/user'];
                    if ((strtotime($value['Pag']['date']) + 600) >= time())
                        $pro++;
                    else {
                        if ($value['Pag']['reste'] > 0)
                            $encour++;
                        else
                            $fin++;
                    }
                }
                ?>
                <td><?php echo $this->Html->link($pro, array('controller' => 'pags', 'action' => 'index', 'pro')); ?></td>
                <td><?php echo $this->Html->link($encour, array('controller' => 'pags', 'action' => 'index', 'cour')); ?></td>
                <td><?php echo $this->Html->link($fin, array('controller' => 'pags', 'action' => 'index', 'fin')); ?></td>
                <td><?php echo $point; ?></td>
            </tr>
            <tr>
                <td>Paiements </td>
                <td><?php echo count($paiement); ?></td>
                <?php
                $encour = $pro = $fin = $point = 0;
                foreach ($paiement as $value) {
                    $point = $point + $value['Paiement']['point'];
                    if ($value['Paiement']['valide'] == 1)
                        $pro++;
                    if ($value['Paiement']['valide'] == 0)
                        $encour++;
                    if ($value['Paiement']['valide'] == -1)
                        $fin++;
                }
                ?>
                <td>Valider :<?php echo $this->Html->link($pro, array('controller' => 'paiements', 'action' => 'index', '1')); ?></td>
                <td><?php echo $this->Html->link($encour, array('controller' => 'paiements', 'action' => 'index', '0')); ?></td>
                <td>Annulé : <?php echo $this->Html->link($fin, array('controller' => 'paiements', 'action' => 'index', '-1')); ?></td>
                <td><?php echo $point; ?></td>
            </tr>
            <tr>
                <td>Recharges </td>
                <td><?php echo count($recharges); ?></td>
                <?php
                $encour = $pro = $fin = $point = 0;
                foreach ($recharges as $value) {
                    $point = $point + $value['Recharge']['point'];
                    if ($value['Recharge']['user_id'] == null)
                        $pro++;
                    else
                        $fin++;
                }
                ?>
                <td>Disponible :<?php echo $this->Html->link($pro, array('controller' => 'recharges', 'action' => 'index', '1')); ?></td>
                <td></td>
                <td>Envoyer : <?php echo $this->Html->link($fin, array('controller' => 'recharges', 'action' => 'index', '0')); ?></td>
                <td><?php echo $point; ?></td>
            </tr>
            <tr>
                <td>Cadeaux </td>
                <td><?php echo count($cadeaux); ?></td>
                <?php
                $encour = $pro = $fin = $pont = 0;
                foreach ($cadeaux as $value) {
                    $point = $point + $value['Usergift']['point'];
                    if ($value['Usergift']['etat'] == 0)
                        $encour++;
                    if ($value['Usergift']['etat'] == 2)
                        $fin++;
                    if ($value['Usergift']['recharge_id'] != null)
                        $pro++;
                }
                ?>
                <td>Recharge :<?php echo $pro; ?></td>
                <td><?php echo $this->Html->link($encour, array('controller' => 'usergifts', 'action' => 'index', '0')); ?></td>
                <td><?php echo $this->Html->link($fin, array('controller' => 'usergifts', 'action' => 'index', '2')); ?></td>
                <td><?php echo $point; ?></td>
            </tr>
            <tr>
                <td>Users </td>
                <td><?php echo count($users); ?></td>
                <?php
                $encour = $pro = $fin = $pont = 0;
                foreach ($users as $value) {
                    $point = $point + $value['User']['point'];
                }
                ?>
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo $this->Html->link($point, array('controller' => 'users', 'action' => 'liste')); ?></td>
            </tr>
        </table>
        <?php
    endif;
    if ($this->Session->read('Auth.User.role_user') == "mobile") {
        if (!empty($state)):
            echo "<h3>Mes dérnieres visites</h3>";
            ?>
            <table border="1" cellspacing="2" cellpadding="2" bgcolor="#CCCCCC" width="95%">
                <tr>
                    <th>Type</th>
                    <th>Nombre de points</th>
                    <th>Date</th>
                </tr>

                <?php
                $i = 1;
                $k = 0;
                foreach ($state as $data1):
                    $i = -$i;
                    ?>
                    <tr id="c<?php echo($i); ?>" onMouseOver="this.style.backgroundColor = '#FFDDBB'" onMouseOut="this.style.backgroundColor = '<?php
                    if ($i > 0)
                        echo('#EBEBEB');
                    else
                        echo('#D4D4D4');
                    ?>';">
                        <td><?php echo $data1['type']; ?></td>
                        <td><?php echo $data1['point']; ?></td>
                        <td><?php
                            echo $data1['date'];
                            if ($k == 7)
                                break;
                            $k++;
                            ?></td>
                    </tr>
                    <?php
                endforeach;
                echo "</table>";
            endif;
            ?>

            <br/>
            <h3>Mes statistiques</h3>
            <div id="chartdiv" ></div>
            <?php
            $info = "";
            $date = new DateTime('tomorrow');
            $date->modify('-30 day');
            $point = $cadeau = 0;
            for ($i = -29; $i < 0; $i++) {
                foreach ($graph as $value) {
                    if ($date->format('Y-m-d') == $value['date']) {
                        $point = $point + $value['point'];
                        $cadeau = $cadeau + $value['cadeau'];
                    }
                }
                $info = $info . ",['" . $date->format('m-d') . "'," . $point . "," . $cadeau . "]";
                $point = $cadeau = 0;
                $date->modify("+1 day");
            }
            ?>
            <script type="text/javascript" src="https://www.google.com/jsapi"></script>
            <script type="text/javascript">
                        google.load("visualization", "1", {packages: ["corechart"]});
                        google.setOnLoadCallback(drawChart);
                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['Jours', 'Points gagner', 'Points cadeaux']
    <?php echo $info; ?>
                            ]);

                            var options = {
                                title: 'Suivi des Points Dernies 30 Jours'
                            };

                            var chart = new google.visualization.LineChart(document.getElementById('chartdiv'));

                            chart.draw(data, options);
                        }                    

            </script>

<?php } ?>

<script type="text/javascript">
   $(window).load(function(){	
					
        var prog = $(".spanprogress");
        for(var i=0 ; i<prog.length ; i++){
                var nbr = $('.nbrclient'+i+' e').attr('name');
                var pers = $('.nbrclient'+i+' d').attr("name");
                $('.nbrclient'+i+' f').append(nbr);
                $('.nbrclient'+i+' d').append(pers);
                nbr=nbr*100/pers;
                nbr=nbr.toFixed(0);
                var wid = nbr+'%';
                if(nbr<=20){
                        $('.spanprogress .prog'+i).css({"width":wid,"background":"#47C70f","transition":"2s"});
                }
                else if(nbr>20 && nbr<=40 ){
                        $('.spanprogress .prog'+i).css({"width":wid,"background":"#7BFF09","transition":"2s"});
                }
                else if( nbr>40 && nbr<=60 ){
                        $('.spanprogress .prog'+i).css({"width":wid,"background":"#EADB0C","transition":"2s"});
                }
                else if( nbr>60 && nbr<=80 ){
                        $('.spanprogress .prog'+i).css({"width":wid,"background":"#EF6612","transition":"2s"});
                }
                else if( nbr>80 ){
                        $('.spanprogress .prog'+i).css({"width":wid,"background":"#EF0000","transition":"2s"});
                }
                $('.nbrclient'+i+' e').append(wid);
                
                };
        });
            </script>