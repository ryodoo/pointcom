<style type="text/css">
    #map-canvas {height:400px;width:100%;float:left;}
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
<div class="missions form">
    <?php echo $this->Form->create('Mission', array('type' => 'file')); ?>
    <legend><?php echo __('Ajouter une Mission'); ?></legend>
    <fieldset>
        <?php
        echo $this->Form->input('titre', array('required' => 'required'));
        echo $this->Form->input('description', array('required' => 'required'));
        ?>
        <div class="input text required">
            <label for="MissionImage">Image du Questionnaire</label>
            <?php echo $this->Form->file('image', array('label' => 'Image du magasin', 'id' => 'MissionImage')); ?>
        </div>
        <div class="input text required">
            <label for="">Type</label>
            <select name="data[Mission][type]" id="type">
                <option value="visite">Visite</option>
                <option value="achat">Achat</option>
            </select>
        </div>
        <div class="input text required" style="margin-bottom:30px;">
            <label for="amount">Nombre de clients</label>
            <b style="font-size: 18px; color: #777;float: right;">Client</b>
            <input type="text" id="amounte" readonly style="border:0; color:#777; font-weight:bold;background:none;box-shadow:none;width:55px;">
            <input type="hidden" id="val" name="data[Mission][client]" value="30"></input>
            <div id="slider-range-min"></div>
        </div>
        <div class="input text required" style="margin-bottom:30px;">
            <label for="amount">Nombre de point par clients</label>
            <b style="font-size: 18px; color: #777;float: right;">Point/Clients</b>
            <input type="text" id="amoun" readonly style="border:0; color:#777; font-weight:bold;background:none;box-shadow:none;width:55px;">
            <input type="hidden" id="vall" name="data[Mission][point/client]" value="1"></input>
            <div id="slider-range-m"></div>
        </div>
        <?php
        echo $this->Form->hidden('longitude', array('label' => 'Longtitude', 'id' => 'longitude'));
        echo $this->Form->hidden('latitude', array('label' => 'Latitude', 'id' => 'latitude'));
        ?>
        <div class="input number required" id="MissionTemps">
            <label for="MissionTemps">Temps minimum (en min)</label>
            <input name="data[Mission][temps]" type="number" >
        </div>
        <div class="input number required ">
            <label for="QuestionnaireNombreuser">Date debut</label>
            <input name="data[Mission][date]" required="required" type="text" id="datepicker">
        </div>
        <div class="input text required">
            <label for="">Sexe</label>
            <select name="data[Mission][sexe]" id="MagasinName">
                <option value="tous" checked="checked">Tous</option>
                <option value="F">Femme</option>
                <option value="M">Homme</option>
            </select>
        </div>
        <div class="input text required" style="margin-bottom:30px;">
            <label for="amount">Tranche d'age</label>
            <b style="float: right;width: auto;line-height: 32px;font-size: 18px; margin-right: 50px;">Ans</b>
            <input type="" id="amount" readonly="" style="border:0; color:#777; font-weight:bold;background:none;">
            <input type="hidden" id="val0" name="data[Mission][tranche]" value=",16-30">
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
        <div id="map-canvas"></div>
    </fieldset>
    <?php echo $this->Form->end(__('Ajouter')); ?>
    <div class="plus">
        <div class="plus1">
	    <?php echo $this->Html->image('vide.png', array('width' => "100%","height" => "100%")); ?>
            <b>Fini le vide</b>
            <p>
                Vous souffrez du vide et vous voulez donner de l’ambiance à votre magasin ou boutique ? MyBlan peut vous aider. Nos utilisateurs peuvent vous rendre visite et donnez à nouveau la dynamique à vos rayons.
            </p>
        </div>
        <div class="plus2">
	    <?php echo $this->Html->image('clients.png', array('width' => "100%","height" => "100%")); ?>
            <b>Dépensez moins pour séduire plusieurs clients</b>
            <p>
                Une visite déclenche automatiquement de la bouche à oreille, donc c’est à vous de rendre cette visite unique et agréable.
            </p>
        </div>
    </div>
</div>


<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

<script type="text/javascript">
    $('#type').change(function() {
        if ($('#type').val() == "achat") {
            document.getElementById('MissionTemps').style.display = 'none';
        } else {
            document.getElementById('MissionTemps').style.display = 'block';
        }
    });

    var map;
    var markers = [];

    function initialize() {
        var haightAshbury = new google.maps.LatLng(33.515064, -7.648201);
        var mapOptions = {
            zoom: 10,
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
        //addMarker(haightAshbury);
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