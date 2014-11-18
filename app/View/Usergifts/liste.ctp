<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<div id="cont" class="util">
<?php
$this->set('title',"Utilisateurs");
$this->set('title',"commandes");
?>


<div id="dialog-form" title="Etat de la commande">
    <?php 
    echo $this->Form->create('Cadeaux'); ?>
    <input type="checkbox" id="sansMessage" name="sansMessage" onclick="sendEmail(this.checked)" />
    Sans envoie de message
    <?php
    echo $this->Form->hidden('idUhc', array("id" => "idUHC"));
    echo $this->Form->hidden('etat', array("id" => "idEtat"));
    echo $this->Form->hidden('pointsCadeau', array("id" => "pointsCadeau"));
    echo $this->Form->hidden('idUser', array("id" => "idUser"));
    echo "<br/><br/>";
    echo $this->Form->input('message',array('label'=>false, "placeholder" => "Votre message", "id" => "message", "type" => "textarea", 'rows' => '5', 'cols' => '5', "style" => "width : 280px;"));
    echo $this->Form->end(__('Valider'));
    ?>
</div>



<?php

echo $this->Session->flash();


if(!empty($gifts)):
    echo "<h3>Liste des cadeaux</h3>";
    ?>
<table border="1"  cellspacing="2" cellpadding="2" bgcolor="#CCCCCC" width="95%">
    <tr>
        <th>Cadeaux</th>
        <th>Points</th>
        <th>Date Commande</th>
        <th>Utilisateur</th>
        <th>Etat</th>
        <th>Message</th>
    </tr>

        <?php
        $i=1;
        foreach($gifts as $data1):
            $i=-$i;
            ?>
    <tr id="c<?php echo($i); ?>" onMouseOver="this.style.backgroundColor='#FFDDBB'" onMouseOut="this.style.backgroundColor='<?php if($i > 0)echo('#EBEBEB'); else echo('#D4D4D4');?>';">
        <td>
                    <?php echo $data1['Cadeaux']['label_cadeau']; ?>
        </td>
        <td>
                    <?php echo $data1['Cadeaux']['point_cadeau']; ?>
        </td>
        <td>
                    <?php echo $data1['Usergift']['created']; ?>
        </td>
        <td>
            <a href="<?php
                       echo $this->Html->url(array('controller'=>'users','action'=>'view', $data1['User']['id'])); ?>" >
                        <?php echo $data1['User']['nom_complet']; ?></a>
        </td>
        <td>
                    <?php echo $this->Form->input('etat',array('label'=>false, 'onchange'=>'dialog('.$data1['User']['id'].','.$data1['Cadeaux']['point_cadeau'].','.$data1['Usergift']['id'].', this.value)', 'value' =>$data1['Usergift']['etat'], 'options' => array(0 => "En cours", 1 =>  "Non reçu", 2 => "Reçu", -1 => "Annulé") ));?>
        </td>
        <td>
                    <?php echo $data1['Usergift']['message']; ?>
        </td>
    </tr>
        <?php
        endforeach;
        echo "</table>";
    endif;
    ?>
    <script type="text/javascript">
        $('.confirmation').on('click', function () {
            return confirm('Etes vous sur de bien vouloir supprimer cet enregistrement ?');
        });

        function dialog(idUser, points, idUhc, val){
            //alert(val+" "+idUhc+" "+points+" "+idUser);
            document.getElementById('idUser').value = idUser;
            document.getElementById('pointsCadeau').value = points;
            document.getElementById('idUHC').value = idUhc;
            document.getElementById('idEtat').value = val;
            $( "#dialog-form" ).dialog( "open" );
        }

        $(function() {
            var tips = $( ".validateTips" );

            function updateTips( t ) {
                tips
                .text( t )
                .addClass( "ui-state-highlight" );
                setTimeout(function() {
                    tips.removeClass( "ui-state-highlight", 1500 );
                }, 500 );
            }


            $( "#dialog-form" ).dialog({
                autoOpen: false,
                height: 300,
                width: 350,
                modal: true,

                close: function() {

                }
            });
            $( ".editEtat" )
            .button()
            .change(function() {
                $( "#dialog-form" ).dialog( "open" );
            });
        });

        function sendEmail(val){
            if(val == true){
                document.getElementById('message').readOnly = true;
            }else{
                document.getElementById('message').readOnly = false;
            }
        }
    </script>
</div>