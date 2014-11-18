<?php
echo $this->Html->css('jquery-ui-1.8.13.custom');
echo $this->Html->css('ui.dropdownchecklist.themeroller');
?>
<script type="text/javascript" src="http://dropdown-check-list.googlecode.com/svn/trunk/doc/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="http://dropdown-check-list.googlecode.com/svn/trunk/doc/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="http://dropdown-check-list.googlecode.com/svn/trunk/doc/ui.dropdownchecklist-1.4-min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
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
                $("#amount").val(ui.values[ 0 ] + " - " + ui.values[ 1 ]);
                $("#val0").attr("value", document.getElementById('amount').value);
            }
        });
        $("#amount").val($("#slider-range").slider("values", 0) +
                " - " + $("#slider-range").slider("values", 1));
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
<div class="questionnaires form">
    <?php echo $this->Form->create('Questionnaire', array('type' => 'file')); ?>
    <legend><?php echo __('Créer Questionnaire'); ?></legend>
    <fieldset>
        <?php
        echo $this->Form->input('image', array('label' => "Image du Questionnaire", 'type' => "file"));
        echo $this->Form->input('name', array('label' => "Nom du Questionnaire"));
        ?>
        <div class="input number required"> 
            <label for="QuestionnaireNombreuser">Date debut</label>
            <input name="data[Questionnaire][date]"  type="text" id="datepicker">
        </div>
        <div  class="input required">
            <label for="">Sexe</label>
            <select name="data[Questionnaire][sexe]" id="MagasinName">
                <option value="tous" checked="checked">Tous</option>
                <option value="F">Femme</option>
                <option value="M">Homme</option>
            </select>
        </div>
        <div class="input text required" style="margin-bottom:30px;">
            <label for="amount">Nombre de clients</label>
            <b style="font-size: 18px; color: #777;float: right;">Clients</b>
            <input type="text" id="amounte" readonly style="border:0; color:#777; font-weight:bold;background:none;box-shadow:none;width:55px;">
            <input type="hidden" id="val" name="data[Questionnaire][nombreuser]" value="30"></input>
            <div id="slider-range-min"></div>
        </div>
        <div class="input text required" style="margin-bottom:30px;">
            <label for="amount">Nombre de point par clients</label>
            <b style="font-size: 18px; color: #777;float: right;">Point/Client</b>
            <input type="text" id="amoun" readonly style="border:0; color:#777; font-weight:bold;background:none;box-shadow:none;width:55px;">
            <input type="hidden" id="vall" name="data[Questionnaire][pointparuser]" value="1"></input>
            <div id="slider-range-m"></div>
        </div>

        <div class="input text required" style="margin-bottom:30px;">
            <label for="amount">Tranche d'age</label>
            <b style="float: right;width: auto;line-height: 32px;font-size: 18px; margin-right: 50px;">Ans</b>
            <input type="" id="amount" readonly="" style="border:0; color:#777; font-weight:bold;background:none;">
            <input type="hidden" id="val0" name="data[Questionnaire][trancheage]" value=",16-30">
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
    </fieldset>
    <?php echo $this->Form->end(__('Valider')); ?>
    <div class="plus">
        <div class="plus1">
	 <?php echo $this->Html->image('quest.png', array('width' => "100%","height" => "100%")); ?>
            <b>Un questionnaire à multiples avantages</b>
            <p>
                Optez pour le questionnaire sur le smartphone minimise vos coûts, élargit votre échantillon et réduit significativement le temps d’obtention de données.
            </p>
        </div>
        <div class="plus2">
	<?php echo $this->Html->image('questionnaire.png', array('width' => "100%", "height" => "100%")); ?>
            <b>Vos études de  marché en un clin d’œil</b>
            <p>
                MyBlan vous aide à réaliser des études de marchés et vous assiste à collecter des informations fiables via son système de contrôle basé sur des questions pièges.
            </p>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
    $(function() {

        // Datepicker
        $('#datepicker').datepicker({
            inline: true
        });

        //hover states on the static widgets
        $('#dialog_link, ul#icons li').hover(
                function() {
                    $(this).addClass('ui-state-hover');
                },
                function() {
                    $(this).removeClass('ui-state-hover');
                }
        );

    });

    $(function() {
        var dates = $("#datepicker").datepicker({
            defaultDate: "+0d",
            changeMonth: true,
            numberOfMonths: 3,
            onSelect: function(selectedDate) {
                var option = this.id == "data" ? "minDate" : "maxDate",
                        instance = $(this).data("datepicker"),
                        date = $.datepicker.parseDate(
                                instance.settings.dateFormat ||
                                $.datepicker._defaults.dateFormat,
                                selectedDate, instance.settings);
                dates.not(this).datepicker("option", option, date);
            }
        });
    });
</script>
