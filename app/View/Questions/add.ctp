<?php
echo $this->Html->css('stylesqest');
echo $this->Html->css('perso');
echo $this->Html->css('previsualisation');
echo $this->Html->css('style-boutons');
echo $this->Html->css('popup');
echo $this->Html->script('jquery-1.10.2.min');
echo $this->Html->script('metaFormGenartor');
echo $this->Html->script('previsualisation');
echo $this->Html->script('popup');
?>
<div style="margin-top:80px;float:left;margin-bottom:20px;width: 100%;">
    <form id="formulaire" name="formulaire" action="/pointcom/questions/add" autocomplete="on" method="post" onsubmit="return validForm(-1);">

        <div id="nav">
            <div class="inner" id="menuGenerator" style="display: block; overflow: hidden;"><h3>Ajouter une question</h3>
                <ul>
                    <li><a href="#" onclick="ajoute(0)" title="Ajoute un champ de formulaire contenant du texte sur une ligne." class="btn1">Texte simple</a></li>
                    <li><a href="#" onclick="ajoute(7)" title="Ajoute des cases à cocher, l&#39;utilisateur pourra en sélectionner une seule." class="btn2">Cases à cocher</a></li>
                    <li><a href="#" onclick="ajoute(6)" title="Ajoute des cases à cocher, l&#39;utilisateur pourra en sélectionner plusieurs." class="btn3">Cases à cocher multiples</a></li>
                    <li><a href="#" onclick="ajoute(1)" title="Ajoute un champ de formulaire contenant du texte sur une ligne." class="btn1">Image à prendre</a></li>
                </ul><br>
            </div>
        </div>
        <div id="info1" class="info">
            <div class="inner">
                <h3>Aide - Comment débuter :</h3>
                <div id="tuto2" class="aide-active">1) Sélectionnez les questions qui vont composer votre questionnaire dans le menu de gauche.</div>
                <div id="tuto3">2) Validez votre formulaire lorsque vous avez terminé la sélection de vos questions.</div>
            </div>
        </div>

        <div id="content">
            <div class="inner etape" id="etape1" style="display: block;">
                <div id="generatorContent">
                    <div class="element" id="element0"> 
                        <div class="error-blank30p" id="blank-div-error-0" style="display: none;"></div><div class="error" id="div-error-0" style="display: none; overflow: hidden;"></div>
                    </div>			<input type="hidden" id="tabindex" name="tabindex"><br>
                    <a class="large color blue button" onclick="valideTitle()" name="vtitle" id="vtitle" href="#" style="display: none; overflow: hidden;">Valider</a>
                </div>	
                <div class="boutons" id="bouton1"> <div class="left1" style="display: none;"><a href="#" class="large color blue button" name="s2" onclick="previsualisation()">Prévisualiser</a></div><div class="right1" style="display: none;"> Validez votre formulaire lorsque vous avez terminé la sélection de vos questions <img src="img/flecheg.png"> 
                        <input type="submit" value="Valider" name="Valider" class="large color blue button" id="button-valid"  style="display:block !important;">
                    </div>	
                </div>
                <input type="hidden" name="data[Question][questionnaire_id]" value="<?php echo $questionnaire_id; ?>">
            </div>
            <div class="inner etape" id="etape2" style="display: none;">

            </div><script> $(document).ready(function() {
                    $('.right1').hide();
                    $('.left1').hide();
                    $(".error").hide();
                    $(".error-blank30p").hide();
                    $("#button-valid").hide();
                    $(".etape").hide();
                    $("#etape1").show();
                });
                var required = new Array();
                required.push(0);
                required.push(1);
                required.push(3);
                required.push(4);
                var onglets = new Array();
                var type = new Array();
                onglets[0] = 0;
                type[0] = 0;
                onglets[1] = 1;
                type[1] = 1;
                onglets[2] = 1;
                type[2] = 7;
                onglets[3] = 1;
                type[3] = 0;
                onglets[4] = 1;
                type[4] = 0;
                function valide_onglets(onglet, nextOnglet, validation) {
                    var tmp = 0;
                    //verification des champs obligatoires
                    var formValid = validForm(onglet - 1);

                    if ((validation == 0) || (formValid)) {
                        if (nextOnglet != 99) {
                            $('#etape' + onglet).fadeOut(400);
                            $('#etape' + nextOnglet).delay(400).fadeIn();
                            if (nextOnglet == 1) {
                                $('#menuGenerator').fadeIn();
                            } else {
                                $('#menuGenerator').fadeOut();
                                $('#info1').fadeOut();
                                //lancement de l'analyse des champs pour mise à jour de l'index
                                valider();
                            }
                        } else {
                            formulaire.submit();
                        }
                    }
                }
                function validForm(onglet) {
                    $('.error').hide();
                    var error = 0;
                    var tmp = 0;


                    //verification des champs obligatoires
                    for (var i = 0; i < required.length; i++) {
                        if ((onglet == -1) || (onglets[required[i]] == (onglet))) {
                            if ((type[required[i]] == 6) || (type[required[i]] == 7)) {
                                //cases à cocher ou radio
                                tmp = 0;
                                for (var j = 0; j < 10; j++) {
                                    if ($('#input' + required[i] + '-' + j).is(':checked'))
                                        tmp = 1;
                                }
                                if (tmp == 0) {
                                    $('#div-error-' + required[i]).html('Ce champ est obligatoire.').fadeIn(800);
                                    $('#blank-div-error-' + required[i]).fadeIn(800);
                                    error = 1;
                                }
                            } else if ($('#input' + required[i]).is(':visible')) {
                                if ($('#input' + required[i]).val() == '') {
                                    $('#div-error-' + required[i]).html('Ce champ est obligatoire.').fadeIn(800);
                                    $('#blank-div-error-' + required[i]).fadeIn(800);
                                    error = 1;
                                }
                            }
                        }
                    }
                    if (error == 0) {
                        return true;
                    } else
                        return false;
                }

                //cette fonction valide un champ, elle est appelé au changement de la valeur du champ
                function validUnChamp(i) {
                    $('#div-error-' + i).hide();
                    $('#blank-div-error-' + i).hide();
                    var error = 0;
                    var tmp = 0;

                    if (error == 0) {
                        return true;
                    } else
                        return false;
                }


                function verifNumber(myString) { // idTag 3	
                    if (isNaN(myString)) {
                        return false;
                    } else {
                        return true;
                    }
                }


                function verifEmail(myString) { // idTag 4

                    var reg = /^\w+([\.-]?\w+)*@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;

                    if (reg.test(myString) == true) {
                        return true; // adresse valide
                    }
                    else {
                        return false; // adresse non valide
                    }
                }


                function verfifUrl(myString) { // idTag 5

                    var reg = /(http):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

                    if (reg.test(myString) == true) {
                        return true; // adresse valide
                    }
                    else {
                        return false; // adresse non valide
                    }

                }
                //empeche la validation par la touche entrée 
                function refuserToucheEntree(event)
                {
                    // Compatibilité IE / Firefox
                    if (!event && window.event) {
                        event = window.event;
                    }
                    // IE
                    if (event.keyCode == 13) {
                        event.returnValue = false;
                        event.cancelBubble = true;
                    }
                    // DOM
                    if (event.which == 13) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                }
                $(document).ready(function() {
                    $('.btn2,.btn3').click(function() {
                        $(".casesoptions input[type='hidden']").remove();
                    });
                });

                $(document).ready(function() {
                    $('input[type="submit"]').click(function() {
                        $(".casesoptions input[type='hidden']").remove();
                    });
                });
                $(document).load(function() {
                    $("input[value!='texte']").remove();
                    $("input[value!='radio']").remove();
                    $("input[value!='case']").remove();
                    $("input[value!='valider']").remove();
                });

                $(document).load(function() {
                    for (i = 0; i <= 100; i++) {
                        cond = '#condition_' + i;
                        $(cond).hide();
                    }
                });
            </script>
        </div>
    </form>						


    <div style="display: none; width: 800px;position:absolute;top: 200px !important;" id="previsualisation" class="popup_block">
        <div class="dialogTitre" style="background: none #00ace6;" id="previsualisation-titre"> </div>
        <div id="previsualisation-content"><br>
        </div>
    </div>
</div>
