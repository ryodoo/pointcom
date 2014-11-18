<?php
echo $this->Html->css('jquery-ui-1.8.13.custom');
echo $this->Html->css('ui.dropdownchecklist.themeroller');
//debug($this->request->data);exit();
?>
<style>
    #prevquest {width: 745px;height: auto;clear: both;margin: auto;min-height: 300px;}
    .input{height:auto;min-height:100px;}
    #radio1 .repense, #check1 .repense {float: left;width: 477px;clear: none;height: 8px;}
    #radio1 #labeleradio1, #check1 #labelecheck1 {width: 360px;font-size: 16px !important;}
    .repense button{float: right;}
    #radio1 b,#check1 b{font-size: 14px !important;}
    #radio1 .repense input[type="radio"],#check1 .repense input[type="checkbox"]{margin: 0px;width: 18px;height: 18px;margin-top: -5px;margin-right: 10px;}
    #radio1 .repense input[type="text"],#check1 .repense input[type="text"]{float: none;width: 80%;}
    #prevquest .delet {margin-left: 0px;background: #aaa;border-radius: 84px;padding: 1px 5px;font-size: 16px;font-weight: bold;  color: #fff;}
</style>

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
$aa = substr($this->request->data['Pub']['tranche'], 1);
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
                value: <?php echo $this->request->data['Pub']['user']; ?>,
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
                value: <?php echo $this->request->data['Pub']['point/user']; ?>,
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
    <legend><?php echo __('Editer la mission'); ?></legend>
    <fieldset>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('question');
        echo $this->Form->file('image', array('label' => 'Image du magasin'));
        ?>
        <div class="input number required">
            <label for="QuestionnaireNombreuser">Date debut</label>
            <input name="data[Pub][date]"  type="text" id="datepicker"value="<?php echo $this->request->data['Pub']['date']; ?>">
        </div>
        <div class="required input">
            <label for="">Sexe</label>
            <select name="data[Pub][sexe]" id="MagasinName">
                <option value="tous" checked="checked">Tous</option>
                <option value="F">Femme</option>
                <option value="M">Homme</option>
            </select>
        </div>
        <div class="input text required" style="margin-bottom:30px;">
            <label for="amount">Nombre de clients</label>
            <b style="font-size: 18px; color: #777;float:right;">Clients</b>
            <input type="text" id="amounte" readonly style="border:0; color:#777; font-weight:bold;background:none;box-shadow:none;width:55px;">
            <input type="hidden" id="val" name="data[Pub][user]" value="<?php echo $this->request->data['Pub']['user']; ?>"></input>
            <div id="slider-range-min"></div>
        </div>
        <div class="input text required" style="margin-bottom:30px;">
            <label for="amount">Nombre de point par clients</label>
            <b style="font-size: 18px; color: #777;float:right;">Point/Client</b>
            <input type="text" id="amoun" readonly style="border:0; color:#777; font-weight:bold;background:none;box-shadow:none;width:55px;">
            <input type="hidden" id="vall" name="data[Pub][point/user]" value="<?php echo $this->request->data['Pub']['point/user']; ?>"></input>
            <div id="slider-range-m"></div>
        </div>
        <div class="input text required" style="margin-bottom:30px;">
            <label for="amount">Tranche d'age</label>
            <b style="float: right;width: auto;line-height: 32px;font-size: 18px; margin-right: 50px;">Ans</b>
            <input type="" id="amount" readonly="" style="border:0; color:#777; font-weight:bold;background:none;">
            <input type="hidden" id="val0" name="data[Pub][tranche]" value="<?php echo substr($this->request->data['Pub']['tranche'], 1); ?>">
            <div id="slider-range"></div>
        </div>
        <div class="input text" style="margin-bottom:30px;" class="required">
            <label for="PagTitre">Ville</label>
            <select id="s3" multiple="" style="display: none;" name="ville[]">
                <option  <?php if (strpos($this->request->data['Pub']['ville'], "tous") !== false) echo 'checked="checked" selected="selected"'; ?> value="tous">Tous</option>
                <option value="Casablanca" <?php if (strpos($this->request->data['Pub']['ville'], "Casablanca") !== false) echo 'checked="checked" selected="selected"'; ?>>Casablanca</option>
                <option value="Rabat" <?php if (strpos($this->request->data['Pub']['ville'], "Rabat") !== false) echo 'checked="checked" selected="selected"'; ?>>Rabat</option>
                <option value="Marrakech" <?php if (strpos($this->request->data['Pub']['ville'], "Marrakech") !== false) echo 'checked="checked" selected="selected"'; ?>>Marrakech</option>
                <option value="Agadir" <?php if (strpos($this->request->data['Pub']['ville'], "Agadir") !== false) echo 'checked="checked" selected="selected"'; ?>>Agadir</option>
            </select>
        </div>
<?php if (empty($this->request->data['Choipub'])) { ?>
            <div  class="input text required">
                <label for="">Type de repense</label>
                <select name="data[Pub][type]" id="choix">
                    <option checked="checked">Choisir</option>
                    <option value="text">Text a remplire</option>
                    <option value="case">Multi-choix</option>
                    <option value="radio">Choix unique</option>
                </select>
            </div>
            <div class="input required" id="radio" style="display:none;">
                <label for="questradio" value="Question 2"  id="labeleradio1">Entrez vos choix et veuillez cocher la bonne réponse</label>
                <div class="repenseradio1-0 repense required"  id="radiou0">
                    <button  type='button' class='close radiou1-0'  id='closeradio0' onclick="closeradio(0)">x</button>
                    <input  type="radio" id="questradio1-0" name="radio1" value="0" >
                    <input type="text" placeholder="Votre Repence" name="repense[]" required='required' id="repradio0" value="">
                </div> 
                <div class="repenseradio1-1 repense required"  id="radiou1">
                    <button  type='button' class='close radiou1-1' id='closeradio1' onclick="closeradio(1)">x</button>
                    <input type="radio" id="questradio1-1" name="radio1" value="1" >
                    <input type="text" placeholder="Votre Repence" name="repense[]" required='required' id="repradio1" value="">
                </div> 
                <div class="repenseradio1-2 repense required" id="radiou2">
                    <button type="button" class="close radiou1-2" id='closeradio2' onclick="closeradio(2)">x</button>
                    <input type="radio" id="questradio1-2" name="radio1" value="2" >
                    <input type="text" placeholder="Votre Repence" name="repense[]" required='required' id="repradio2" value="">
                </div>
                <div class='repense repensen'>
                    <button  type="button" class="close ajouterrad" style="font-size: 16px; float: right;text-align: right;">+ Ajouter une répense</button><br>
                </div>
            </div>

            <div class="input required" id="check" style="display:none;">
                <label for="questchekbox" value="Question 4"  id="labelecheck1">Entrez vos choix et veuillez cocher la bonne réponse</label>
                <div class="repense repensecheck1-0" id="check0">
                    <button  type='button' class='close checke1-0' id="closecheck0" onclick="closecheck(0)">x</button>
                    <input name="check0" type="checkbox" id="questcheck1-0" name="case[]" value="0" >
                    <input type="text" placeholder="Votre Repence" required='required' name="repense[]" id="repcheck0" value="">
                </div>
                <div class="repense repensecheck1-1" id="check1">
                    <button  type='button' class='close checke1-1' id="closecheck1" onclick="closecheck(1)">x</button>
                    <input name="check1" type="checkbox" id="questcheck1-1" name="case[]" value="1">
                    <input type="text" placeholder="Votre Repence" required='required' id="repcheck1"  name="repense[]">
                </div>
                <div class="repense repensecheck1-2" id="check2"> 
                    <button  type='button' class='close checke1-2' id="closecheck2" onclick="closecheck(2)">x</button>
                    <input name="check2" type="checkbox" id="questcheck1-2" name="case[]" value="2">
                    <input type="text" placeholder="Votre Repence" required='required' id="repcheck2" name="repense[]">
                </div>
                <div class='repense repensem'>
                    <button  type="button" class="close ajoutercheck" style="font-size: 16px; float: right;text-align: right;">+ Ajouter une répense</button><br>
                </div>
            </div>
<?php } else { ?>
    <?php if ($this->request->data['Pub']['type'] == 'radio'): ?>
                <div class="input required" id="radio1" style="width: 80%;">
                    <label for="questradio" id="labeleradio1"><?php echo $this->request->data['Pub']['question']; ?></label>
                    <button  type="button" class="buttonradio1" onclick="radiou(1)">Modifier</button>
                    <?php echo $this->Form->postLink(__(''), array('controller' => 'choipubs', 'action' => 'delete',$this->request->data['Pub']['id']));?>
                    <?php echo $this->Form->postLink(__('X'), array('controller' => 'choipubs', 'action' => 'delete', $this->request->data['Pub']['id']), null, __('Vous les vous vraiment supprimer cette question?'));
        $i = 0;
        foreach ($this->request->data['Choipub'] as $value) : ?>
                        <div class="repenseradio1-<?php echo $i; ?> repense required" id="radiou<?php echo $i; ?>">
                            <input type="radio" name="radio1" id="questradio1-<?php echo $i; ?>" <?php if ($value['valide'] == 1) {
                echo 'checked="checked"';
            } ?> value="<?php echo $i; ?>" >
                            <b id="repradio1-<?php echo $i;
            $i++; ?>" name="<?php echo $value['choix']; ?>"><?php echo $value['choix']; ?></b>
                        </div> 
                <?php endforeach; ?>
                    <div class='repense repensen1'>
                        <button  type="button" class="close ajouterrad1" style="font-size: 16px; float: right;text-align: right;display:none;">+ Ajouter une répense</button><br>
                    </div>
                </div>
                <?php endif; ?>
    <?php if ($this->request->data['Pub']['type'] == 'case'): ?>
                <div class="input required" id="check1"  style="width: 80%;">
                    <label  id="labelecheck1"><?php echo $this->request->data['Pub']['question']; ?></label>
                    <button  type="button" class="buttoncheck1" onclick="check(1)">Modifier</button>
                    <?php echo $this->Html->link('X',array('controller' => 'choipubs', 'action' => 'del', $this->request->data['Pub']['id']));?>
                    <?php //echo $this->Form->postLink(__('X'), array('controller' => 'choipubs', 'action' => 'delete', $this->request->data['Pub']['id']), null, __('Vous les vous vraiment supprimer cette question?'));
         $i = 0;
        foreach ($this->request->data['Choipub'] as $value) : ?>                
                        <div class="repense repensecheck1-<?php echo $i; ?>" id="checke<?php echo $i; ?>">
                            <input name="" type="checkbox" id="questcheck1-<?php echo $i; ?>" value="<?php echo $i; ?>"<?php if ($value['valide'] == 1) {
                echo 'checked="checked"';
            } ?> >
                            <b id="repcheck1-<?php echo $i;
            $i++; ?>" name="<?php echo $value['choix']; ?>"><?php echo $value['choix']; ?></b> 
                        </div>
        <?php endforeach; ?>
                    <div class='repense repensem1'>
                        <button  type="button" class="close ajoutercheck1" style="font-size: 16px; float: right;text-align: right;display:none;">+ Ajouter une répense</button><br>
                    </div>
                </div>
    <?php endif;
}
?>
<?php echo $this->Form->end(__('Editer')); ?>
    </fieldset>

    <div class="plus">
        <div class="plus1">
            <?php echo $this->Html->image("impact-pub.png",array('width'=>"100%",'height'=>"100%"))?>
            <b>Testez l’impact et l’efficacité de votre publicité</b>
            <p>
                Vous avez besoin de savoir si votre publicité a bien touché le public ? Vous voulez savoir si votre dernière promotion est bien connue ? Vous n’avez qu’à envoyer vos questions à nos utilisateurs.
            </p>
        </div>
        <div class="plus2">
            <?php echo $this->Html->image("cible.png",array('width'=>"100%",'height'=>"100%"))?>
            <b>Visez votre cible</b>
            <p>
                Notre système de ciblage vous donne le privilège de choisir à qui envoyer vos questions selon certains critères (âge, ville...)
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

    function radiou(id) {
        //ensuite pour ajouter un attribut à ton element:
        var rad = $('#radio1 input[type="radio"]');
        for (var i = 0; i <= rad.length; i++) {
            var b = $('#repradio' + id + "-" + i).attr('name');
            var input = "<button  type='button' class='close radiou" + i + "' onclick='closeradio(" + i + ")'>x</button><input  type='radio' id='questradio" + id + "-" + i + "' name='radio1' value='" + i + "' ><input type='text' style='width:80%' name='repense[]' id='radio" + id + i + "' required='required' class='" + i + "' value='" + b + "'>";

            $(".repenseradio" + id + "-" + i).append(input);

            $("#questradio" + id + "-" + i).remove();
            $("#repradio" + id + "-" + i).remove();
        }
        $('.buttonradio' + id).hide();
        $('.deletradio' + id).hide();
        $('.ajouterrad' + id).show();
        for (var j = 0; j <= rad.length; j++) {
            var a = id + j;
        }
        $('.ajouterrad' + id).click(function() {
            a = a + 1;
            var input = "<div class='repenseradio" + id + " repense required' id='radiou" + (a - 1) + "'><button  type='button' class='close radiou" + a + 1 + "' onclick='closeradio(" + (a - 1) + ")'>x</button><input  type='radio' id='questradio" + a + "-" + j + "' name='radio1' value='" + j + "' ><input type='text' style='width:80%' id='radio" + (a - 1) + "' placeholder='Nouvelle réponse' required='required' class='radio" + id + "-" + j + "'></div>";
            $(".repensen" + id).append(input);
        });
    }

    function closeradio(id) {
        $('#radiou' + id).remove();
    }
    function check(id) {
        //ensuite pour ajouter un attribut à ton element:
        var chec = $('#check1 input[type="checkbox"]');
        for (var i = 0; i <= chec.length; i++) {

            var b = $('#repcheck' + id + "-" + i).attr('name');
            var e = ('#repcheck' + id + "-" + i);
            alert(e);
            var input = "<button  type='button' class='close checke" + i + "' onclick='closecheck(" + i + ")'>x</button><input  type='checkbox' id='questcheck" + id + "-" + f + "' name='case[]' value='" + i + "' ><input type='text' style='width:80%' id='check" + id + i + "' name='repense[]' required='required' class='" + id + i + "' value='" + b + "'>";

            $(".repensecheck" + id + "-" + i).append(input);

            $("#questcheck" + id + "-" + i).remove();
            $("#repcheck" + id + "-" + i).remove();
        }
        $('.buttoncheck' + id).hide();
        $('.deletcheck' + id).hide();
        $('.ajoutercheck' + id).show();
        for (var f = 0; f <= chec.length; f++) {
            var c = id + f;
        }
        $('.ajoutercheck' + id).click(function() {
            c = c + 1;
            var input = "<div class='repensecheck" + id + " repense required' id='checke" + (c - 1) + "'><button  type='button' class='close checke" + c + 1 + "' onclick='closecheck(" + (c - 1) + ")'>x</button><input  type='checkbox' id='questcheck" + c + "-" + f + "' name='case[]' value='' ><input type='text' style='width:80%' id='check" + c + 1 + "' placeholder='Nouvelle réponse' required='required' name='repense[]' class='check" + id + "-" + f + "'></div>";
            $(".repensem" + id).append(input);
        });
    }
    function closecheck(id) {
        $('#checke' + id).remove();
    }
    $(document).ready(function() {
        $('#choix').change(function() {
            var choix = $('#choix option:selected').val();
            var rad = $("input[type='radio']");
            var chec = $("input[type='checkbox']");
            if (choix == "Choisir") {
                $("#radio").hide();
                $("#check").hide();
                for (var i = 0; i <= rad.length; i++) {
                    $("#radiou" + i + " input[type='text']").removeAttr('required');
                    $("#radiou" + i + " input[type='text']").removeAttr('name');
                    $("#radiou" + i + " input[type='radio']").removeAttr('name');
                }
                for (var i = 0; i <= chec.length; i++) {
                    $("#check" + i + " input[type='text']").removeAttr('required');
                    $("#check" + i + " input[type='text']").removeAttr('name');
                    $("#check" + i + " input[type='checkbox']").removeAttr('name');
                }
            }
            else if (choix == "radio") {
                $("#radio").show();
                $("#check").hide();
                for (var i = 0; i <= rad.length; i++) {
                    $("#radiou" + i + " input[type='text']").attr('required', 'required');
                    $("#radiou" + i + " input[type='text']").attr('name', 'repense[]');
                    $("#radiou" + i + " input[type='radio']").attr('name', 'radio1');

                }
                for (var i = 0; i <= chec.length; i++) {
                    $("#check" + i + " input[type='text']").removeAttr('required');
                    $("#check" + i + " input[type='text']").removeAttr('name');
                    $("#check" + i + " input[type='checkbox']").removeAttr('name');
                }
            }
            else if (choix == "case") {
                $("#radio").hide();
                $("#check").show();
                for (var i = 0; i <= rad.length; i++) {
                    $("#radiou" + i + " input[type='text']").removeAttr('required');
                    $("#radiou" + i + " input[type='text']").removeAttr('name');
                    $("#radiou" + i + " input[type='radio']").removeAttr('name');
                }
                for (var i = 0; i <= chec.length; i++) {
                    $("#check" + i + " input[type='text']").attr('required', 'required');
                    $("#check" + i + " input[type='text']").attr('name', 'repense[]');
                    $("#check" + i + " input[type='checkbox']").attr('name', 'case[]');
                }
            }
        });
    });


    var rad = $('input[type="radio"]');
    for (var j = 0; j <= rad.length; j++) {
        var a = j;
    }
    $('.ajouterrad').click(function() {
        a = a + 1;
        var input = "<div class='repenseradio" + a + " repense required' id='radiou" + a + "'><button  type='button' class='close radiou" + a + "' onclick='closeradio(" + a + ")'>x</button><input  type='radio' id='questradio" + a + "-" + j + "' name='radio1' value='" + a + "' ></input><input type='text' style='width:80%' id='radio" + a + "' placeholder='Nouvelle réponse' required='required' class='radio" + a + "-" + j + "' name='repense[]'></div>";
        $(".repensen").append(input);
    });

    var chec = $('input[type="checkbox"]');
    for (var f = 0; f <= chec.length; f++) {
        var c = f;
    }

    $('.ajoutercheck').click(function() {
        c = c + 1;
        var input = "<div class='repenseradio" + c + " repense required' id='check" + c + "'><button  type='button' class='close checke" + c + "' onclick='closecheck(" + c + ")'>x</button><input  type='checkbox' id='questcheck" + c + "-" + f + "' name='case[]' value='" + (c - 1) + "' ></input><input type='text' style='width:80%' id='checke" + c + "' placeholder='Nouvelle réponse' required='required' class='check" + c + "-" + f + "' name='repense[]'></div>";
        $(".repensem").append(input);
    });
    function closeradio(id) {
        $('#radiou' + id).remove();
    }
    function closecheck(id) {
        $('#check' + id).remove();
    }

</script>