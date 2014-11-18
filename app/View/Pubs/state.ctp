<?php
if (!empty($pubs)) {
    $choise = $this->requestAction("/choipubs/getchoises/" . $pubs[0]['Pub']['id']);
    if ($pubs[0]['Pub']['type'] != 'texte') {
        $choi = "['info'";
        $rep = "['Repense'";
        $i = 0;
        foreach ($choise as $choix) {
            $choi = $choi . ",'" . $choix['Choipub']['choix'] . "'";
            $inc = 0;
            $h=0;
            $f=0;
            foreach ($pubs as $repense) 
            {
                if ($repense['Reppub']['choix'] == $choix['Choipub']['id'])
                    $inc++;
                if($repense['User']['sexe']=='M')
                    $h++;
                else
                    $f++;
            }
            $rep = $rep . ',' . $inc;
        }
        $choi = $choi . "]," . $rep . "]";
    }

    echo $this->Html->css('jquery-ui-1.8.13.custom');
    echo $this->Html->css('ui.dropdownchecklist.themeroller');
    ?>
    <script type="text/javascript" src="http://dropdown-check-list.googlecode.com/svn/trunk/doc/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="http://dropdown-check-list.googlecode.com/svn/trunk/doc/jquery-ui-1.8.13.custom.min.js"></script>
    <script type="text/javascript" src="http://dropdown-check-list.googlecode.com/svn/trunk/doc/ui.dropdownchecklist-1.4-min.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $("#s3").dropdownchecklist({icon: {}, width: 150});
        });
        $(function() {
            $("#slider-range").slider({
                range: true,
                min: 10,
                max: 100,
                values: [16, 30],
                slide: function(event, ui) {
                    $("#amount").val(ui.values[ 0 ] + "ans  - " + ui.values[ 1 ] + " ans");
                    $("#val0").attr("value", ',' + $("#slider-range").slider("values", 0) + '-' + $("#slider-range").slider("values", 1));
                }
            });
            $("#amount").val($("#slider-range").slider("values", 0) +
                    "ans  - " + $("#slider-range").slider("values", 1) + " ans");
            $("#val0").attr("value", ',' + $("#slider-range").slider("values", 0) + '-' + $("#slider-range").slider("values", 1));

            $(function() {
                $("#slider-range-min").slider({
                    range: "min",
                    value: 30,
                    min: 10,
                    max: 1000,
                    slide: function(event, ui) {
                        $("#amounte").val(ui.value);
                        $("#val").attr("value", document.getElementById('amounte').value);
                    }
                });
                $("#amounte").val($("#slider-range-min").slider("value"));
                $("#val").attr("value", document.getElementById('amounte').value);
            });

            $(function() {
                $("#slider-range-m").slider({
                    range: "min",
                    value: 1,
                    min: 1,
                    max: 10,
                    slide: function(event, ui) {
                        $("#amoun").val(ui.value);
                        $("#vall").attr("value", document.getElementById('amoun').value);
                    }
                });
                $("#amoun").val($("#slider-range-m").slider("value"));
                $("#vall").attr("value", document.getElementById('amoun').value);
            });
        });
    </script>

    <div class="pubs form">
    <?php echo $this->Form->create('Pub', array('type' => 'file')); ?>
        <legend><?php echo __('Statistique'); ?></legend>
        <style>
                fieldset {width: 100%;height: 360px;float: left;border: 1px solid;}
                .input {width: 80% !important;}
                .graph {width: 400px;float: right;border: 1px solid;min-height: 325px;height: auto;margin-top: 20px;}
                form {width: 58%;}
                .submit { width: 100% !important;}
                #infograph {width: 400px; float: right;height: auto;margin-top: 20px;}
                #infograph b {width: 100%;float: left; margin-top: 6px;}
                #infograph img {width: 33px;}
                #infograph f {width: 14%;float: left;}
                #infograph h {width: 14%;float: right;}
                #infograph .sexe {margin-top: 0px;width: 48%;float: left;margin-left: 104px;}
        </style>
        <fieldset>
            <div class="input required">
                <label for="">Sexe</label>
                <select name="data[Pub][sexe]" id="MagasinName">
                    <option value="tous" checked="checked">Tous</option>
                    <option value="F">Femme</option>
                    <option value="M">Homme</option>
                </select>
            </div>

            <div class="input text required" style="margin-bottom:30px;">
                <label for="amount">Tranche d'age</label>
                <input type="" id="amount" readonly="" style="border:0; color:#777; font-weight:bold;background:none;">
                <input type="hidden" id="val0" name="data[Pub][tranche]" value=",16-30">
                <div id="slider-range"></div>
            </div>
            <div class="input text" style="margin-bottom:30px;" class="required">
                <label for="MissionTitre">Ville</label>
                <select id="s3" multiple="" style="display: none;" name="ville[]">
                    <option selected="selected" checked="checked" value="tous">Tous</option>
                    <option value="Casablanca">Casablanca</option>
                    <option value="Rabat">Rabat</option>
                    <option value="Marrakech">Marrakech</option>
                    <option value="Agadir">Agadir</option>
                </select>
            </div>
    <?php echo $this->Form->end(__('Envoyer')); ?>
        </fieldset>

        <script type="text/javascript">
            google.load("visualization", "1", {packages: ["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {

                var data = google.visualization.arrayToDataTable([
    <?php echo $choi; ?>

                ]);

                var options = {
                    title: '<?php echo $pubs[0]['Pub']['question']; ?>',
                    hAxis: {title: '', titleTextStyle: {color: 'red'}}
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('graph'));

                chart.draw(data, options);

            }
        </script>
        <?php if(!empty($info)):?>
            <div id="infograph">

                <b>Tranche d'age : 
                    <t><?php $age=explode(',', $info['Pub']['tranche']);
                             $age=explode('-',$age[1]); 
                             echo "$age[0] ans - $age[1] ans";
                        ?>
                    </t>
                </b>
                <b>Ville : 
                    <v>
                        <?php foreach ($info['ville'] as $key => $value) 
                            {
                                if($value=='tous')
                                {
                                    echo $value;
                                    break;
                                }
                                echo "$value,";
                            }?>
                    </v>
                </b>
                <b>Sexe :</b>
                <b class="sexe">
                    <f><?php echo $this->Html->image("f.png",array('width'=>'20px'));?>
                        <e><?php echo $f; ?> Femme</e>
                    </f>
                    <h><?php echo $this->Html->image("h.png",array('width'=>'20px'));?>
                        <e><?php echo $h; ?> Homme</e>
                    </h>
                </b>
            </div>
            <div id="graph" class="graph" ></div>

        </div>
     <?php endif;?>
<?php } else { ?>
    <div class="pubs form">
        <legend>Les statistiques seront bientôt disponibles</legend>
    </div>
<?php } ?>

