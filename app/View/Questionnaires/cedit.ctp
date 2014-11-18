<style type="text/css">
    #map-canvas {height:400px;width:700px;}
    #map-canvas div {padding: 0px;}
</style>
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
            values: [<?php
$aa = substr($this->request->data['Questionnaire']['trancheage'], 1);
$aa = explode("-", $aa);
echo "$aa[0],$aa[1]";
?>],
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
                value: <?php echo $this->request->data['Questionnaire']['nombreuser']; ?>,
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
                value: <?php echo $this->request->data['Questionnaire']['pointparuser']; ?>,
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
<?php echo $this->Form->create('Questionnaire', array('type' => 'file', 'url' => array('action' => 'edit'))); ?>
    <legend><?php echo __('Editer la mission'); ?></legend>
    <fieldset>
        <?php
        echo $this->Form->input('id');
        if ($this->request->data['Questionnaire']['image'] != null)
            echo $this->Html->image('questionnaire/qmobile/' . $this->request->data['Questionnaire']['image']);
        echo $this->Form->input('image', array('label' => "Image du Questionnaire", 'type' => "file"));
        echo $this->Form->input('name', array('label' => "Nom du Questionnaire"));
        echo $this->Form->input('description');
        ?>
        <div class="input number">
            <label for="QuestionnaireNombreuser">Date debut</label>
            <input name="data[Questionnaire][date]"  type="text" id="datepicker" value="<?php echo $this->request->data['Questionnaire']['date']; ?>">
        </div>
        <div class="input text required">
            <label for="">Sexe</label>
            <select name="data[Questionnaire][sexe]" id="MagasinName">
                <option value="tous" checked="checked">Tous</option>
                <option value="F">Femme</option>
                <option value="M">Homme</option>
            </select>
        </div>
        <div class="input text required" style="margin-bottom:30px;">
            <label for="amount">Nombre de clients</label>
            <b style="font-size: 18px; color: #777; float: right;">Clients</b>
            <input type="text" id="amounte" readonly style="border:0; color:#777; font-weight:bold;background:none;box-shadow:none;width:55px;">
            <input type="hidden" id="val" name="data[Questionnaire][nombreuser]" value="<?php echo $this->request->data['Questionnaire']['nombreuser']; ?>"></input>
            <div id="slider-range-min"></div>
        </div>
        <div class="input text required" style="margin-bottom:30px;">
            <label for="amount">Nombre de point par clients</label>
            <b style="font-size: 18px; color: #777;float: right;">Points/Client</b>
            <input type="text" id="amoun" readonly style="border:0; color:#777; font-weight:bold;background:none;box-shadow:none;width:55px;">
            <input type="hidden" id="vall" name="data[Questionnaire][pointparuser]" value="<?php echo $this->request->data['Questionnaire']['pointparuser']; ?>"></input>
            <div id="slider-range-m"></div>
        </div>

        <div class="input text required" style="margin-bottom:30px;">
            <label for="amount">Tranche d'age</label>
            <b style="float: right;width: auto;line-height: 32px;font-size: 18px; margin-right: 50px;">Ans</b>
            <input type="" id="amount" readonly="" style="border:0; color:#777; font-weight:bold;background:none;">
            alert(<?php echo substr($this->request->data['Questionnaire']['trancheage'], 1); ?>);
            <input type="hidden" id="val0" name="data[Questionnaire][trancheage]" value="<?php echo substr($this->request->data['Questionnaire']['trancheage'], 1); ?>">
            <div id="slider-range"></div>
        </div>
        <div class="input text" style="margin-bottom:30px;" class="required">
            <label for="MissionTitre">Ville</label>
            <select id="s3" multiple="" style="display: none;" name="ville[]">
                <option  <?php if (strpos($this->request->data['Questionnaire']['ville'], "tous") !== false) echo 'checked="checked" selected="selected"'; ?> value="tous">Tous</option>
                <option value="Casablanca" <?php if (strpos($this->request->data['Questionnaire']['ville'], "Casablanca") !== false) echo 'checked="checked" selected="selected"'; ?>>Casablanca</option>
                <option value="Rabat" <?php if (strpos($this->request->data['Questionnaire']['ville'], "Rabat") !== false) echo 'checked="checked" selected="selected"'; ?>>Rabat</option>
                <option value="Marrakech" <?php if (strpos($this->request->data['Questionnaire']['ville'], "Marrakech") !== false) echo 'checked="checked" selected="selected"'; ?>>Marrakech</option>
                <option value="Agadir" <?php if (strpos($this->request->data['Questionnaire']['ville'], "Agadir") !== false) echo 'checked="checked" selected="selected"'; ?>>Agadir</option>
            </select>
        </div>
        <?php
        echo $this->Form->hidden('longitude', array('label' => 'Longtitude', 'id' => 'longitude'));
        echo $this->Form->hidden('latitude', array('label' => 'Latitude', 'id' => 'latitude'));
        ?>
        <div id="map-canvas"></div>
    </fieldset>
<?php echo $this->Form->end(__('Editer')); ?>
    <div class="plus">
        <div class="plus1">
            <?php echo $this->Html->image("donnée-m.png",array('width'=>"100%",'height'=>"100%"))?>
            <b>Et si c’est le marché qui vient à vous ?</b>
            <p>
                Plus besoin de descendre au terrain pour savoir si tout va bien ou pas. MyBlan vous permet de trouver qui vérifie à votre place.
            </p>
        </div>
        <div class="plus2">
            <?php echo $this->Html->image("donnée-images.png",array('width'=>"100%",'height'=>"100%"))?>
            <b>Vos données en photos</b>
            <p>
                Nos utilisateurs, armés par leurs smartphones, peuvent prendre des photos et faire des commentaires pour répondre à vos besoins de contrôles.
            </p>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

<script type="text/javascript">
                $('#type').change(function() {
        if($('#type').val() == "achat"){
        document.getElementById('MissionTemps').style.display = 'none';
            }else{
            document.getElementById('MissionTemps').style.display = 'block';
            }
        });
        
            var map;
    var markers = [];

    function initialize() {
        var haightAshbury = new google.maps.LatLng(33.515064, -7.648201);
        var mapOptions = {             zoom: 10,
            center: haightAshbury,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
    map = new google.maps.Map(document.getElementById('map-canvas'),
                mapOptions);

        // This event listener will call addMarker() when the map is clicked.
            google.maps.event.addListener(map, 'click', function(event) {
            addMarker(event.latLng);
        document.getElementById("latitude").value = event.latLng.lat();
    document.getElementById("longitude").value = event.latLng.lng();
    });

            // Adds a marker at the center of the map.
                var existe = new google.maps.LatLng(<?php echo $this->request->data['Questionnaire']['latitude'] . ',' . $this->request->data['Questionnaire']['longitude']; ?>);
        addMarker(existe);
    }

                        // Add a marker to the map and push to the array.
    function addMarker(location) {
                            deleteOverlays();
                        var marker = new google.maps.Marker({
                        position: location,
            map: map,
                                    animation: google.maps.Animation.DROP
        });
                                markers.push(marker);

    }
                                    // Deletes all markers in the array by removing references to them
                                function deleteOverlays() {
                        if (markers) {
                        for (i in markers) {
                markers[i].setMap(null);
                            }
                            markers.length = 0;
        }
    } 
                            google.maps.event.addDomListener(window, 'load', initialize);
    
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