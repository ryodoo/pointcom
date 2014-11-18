function valideTitle() {
    for (i = 0; i <= 100; i++) {
        var inputall = '#input0,#forminput' + i;
        if ($(inputall).val() == "") {
            $("#menuGenerator").show(400);
            $("#div-error-0").html("");
            $("#blank-div-error-0").hide();
            $("#div-error-0").hide(400);
            $("#vtitle").hide(400);
            $("#tuto2").addClass("aide-active");
            $("#tuto1").removeClass("aide-active")
        } else {
            $("#div-error-0").html("Saisissez le titre de votre questionnaire dans ce champ.");
            $("#blank-div-error-0").show();
            $("#div-error-0").show(400)
        }
    }
}
function validForm(e) {
    $(".error").hide();
    var t = 0;
    var n = 0;
    for (i = 0; i <= 100; i++) {
        var inputall = '#forminput' + i;
        if ($(inputall).val() == "") {
            $("#div-error-0").html("Ce champ est obligatoire.").fadeIn(800);
            $("#blank-div-error-0").fadeIn(800);
            t = 1
        }
    }
    if (t == 0) {
        return true
    } else
        return false
}
/*cnt li kai7at qd clic btn*/
function add_mail(e, t, n) {
    if (!n)
        n = "";
    error = "<div class='error-blank30p' id='formblank-div-error-" + e + "'></div><div class='error' id='formdiv-error-" + e + "'></div>";
    if (t.length >= 23) {
        tmp = '<div class="element-multiligne" id="element' + e + '"><div class="label-multiligne"><label for="input' + e + '"> ' + t + '</label></div><div class="blank30p"></div><div class="input"><input  id="forminput' + e + '" value="' + n + '" name="forminput' + e + '" type="email" required="required" placeholder="Champ obligatoire" maxlength="100" onkeypress="refuserToucheEntree(event);"/></div>' + error + "</div>"
    } else {
        tmp = '<div class="element" id="element' + e + '"><div class="label"><label for="input' + e + '"> ' + t + '</label></div><div class="input"><input  id="forminput' + e + '" name="forminput' + e + '" type="email" required="required" placeholder="Champ obligatoire" value="' + n + '" maxlength="100" onkeypress="refuserToucheEntree(event);"/></div>' + error + "</div>"
    }
    return tmp
}
function add_input(e, t, n) {
    if (!n)
        n = "";
    error = "<div class='error-blank30p' id='formblank-div-error-" + e + "'></div><div class='error' id='formdiv-error-" + e + "'></div>";
    if (t.length >= 23) {
        tmp = '<div class="element-multiligne" id="element' + e + '"><div class="label-multiligne"><label for="input' + e + '"> ' + t + '</label></div><div class="blank30p"></div><div class="input"><input  id="forminput' + e + '" value="' + n + '" name="forminput' + e + '" type="text" required="required" placeholder="Champ obligatoire" maxlength="250" onkeypress="refuserToucheEntree(event);"/></div>' + error + "</div>"
    } else {
        tmp = '<div class="element" id="element' + e + '"><div class="label"><label for="input' + e + '"> ' + t + '</label></div><div class="input"><input  id="forminput' + e + '" name="forminput' + e + '" type="text" required="required" placeholder="Champ obligatoire" value="' + n + '" maxlength="250" onkeypress="refuserToucheEntree(event);"/></div>' + error + "</div>"
    }
    return tmp
}
function add_images(e, t, n) {
    if (!n)
        n = "";
    error = "<div class='error-blank30p' id='formblank-div-error-" + e + "'></div><div class='error' id='formdiv-error-" + e + "'></div>";
    if (t.length >= 23) {
        tmp = '<div class="element-multiligne" id="element' + e + '"><div class="label-multiligne"><label for="input' + e + '"> ' + t + '</label></div><div class="blank30p"></div><div class="input"><input  id="forminput' + e + '" value="' + n + '" name="forminput' + e + '" type="text" required="required" placeholder="Champ obligatoire" maxlength="250" onkeypress="refuserToucheEntree(event);"/></div>' + error + "</div>"
    } else {
        tmp = '<div class="element" id="element' + e + '"><div class="label"><label for="input' + e + '"> ' + t + '</label></div><div class="input"><input  id="forminput' + e + '" name="forminput' + e + '" type="text" required="required" placeholder="Champ obligatoire" value="' + n + '" maxlength="250" onkeypress="refuserToucheEntree(event);"/></div>' + error + "</div>"
    }
    return tmp
}
function add_mdp(e, t, n) {
    if (!n)
        n = "";
    error = "<div class='error-blank30p' id='formblank-div-error-" + e + "'></div><div class='error' id='formdiv-error-" + e + "'></div>";
    if (t.length >= 33) {
        tmp = '<div class="element-multiligne" id="element' + e + '"><div class="label-multiligne"><label for="input' + e + '"> ' + t + '</label></div><div class="blank30p"></div><div class="input"><input  id="forminput' + e + '" value="' + n + '" name="forminput' + e + '" type="password" placeholder="Champ obligatoire" required="required" maxlength="30" onkeypress="refuserToucheEntree(event);"/></div>' + error + "</div>"
    } else {
        tmp = '<div class="element" id="element' + e + '"><div class="label"><label for="input' + e + '"> ' + t + '</label></div><div class="input"><input  id="forminput' + e + '" name="forminput' + e + '" type="password" required="required" placeholder="Champ obligatoire" value="' + n + '" maxlength="30" onkeypress="refuserToucheEntree(event);"/></div>' + error + "</div>"
    }
    return tmp
}
function add_separation(e) {
    tmp = '<div class="element-multiligne" id="element' + e + '"></div>';
    return tmp
}
function add_presentation(e, t) {
    if (!t)
        t = "";
    tmp = '<div class="element-multiligne" id="element' + e + '"><div class="input"><textarea  id="forminput' + e + '" name="forminput' + e + '" cols="70" rows="2" required="required" onkeypress="refuserToucheEntree(event);">' + t + "</textarea></div></div>";
    return tmp
}
function remove_condition(e) {
    $("#condition_" + e).html(add_condition(e));
    $("#condition_" + e).removeClass("div_condition")
}
function add_condition_modif(e) {
    tmp = '<div id="condition_' + e + '"><button class="lien left" type="button" onclick="add_condition2(' + e + ");\">+ Ajouter une condition d'affichage</button></div>";
    return tmp
}
function add_condition_modif2(e, t, n, r) {
    analyse();
    tmp1 = "<div class='condition'><select  id='condition-champ-" + e + "' name='condition-champ-" + e + "' onchange='on_condition_change(" + e + ")'><option value=''> --- </option>";
    for (var i = 1; i <= tab_index.length; i++) {
        if (t == tab_index[i - 1])
            var s = "selected";
        else
            var s = " ";
        if (e != tab_index[i - 1] && types[tab_index[i - 1]] < 10) {
            if (tab_libelle[i - 1])
                tmp1 += "<option value='" + tab_index[i - 1] + "' " + s + ">" + tab_index[i - 1] + " - " + tab_libelle[i - 1] + "</option>";
            else
                tmp1 += "<option value='" + tab_index[i - 1] + "' " + s + ">" + tab_index[i - 1] + " - libellé vide</option>"
        }
    }
    tmp1 += "</select></div>";
    var o = new Array("", "", "", "");
    o[n] = "selected";
    tmp2 = "<div class='condition'><select name='condition-valeur-" + e + "' id='condition-valeur-" + e + "' onchange='on_condition_change2(" + e + ")'><option value='0' " + o[0] + ">est complété</option><option value='1' " + o[1] + ">n'est pas complété</option><option value='2' " + o[2] + ">est égale à : </option><option value='3' " + o[3] + ">est différent de : </option></select></div>";
    tmp3 = '<div class="condition" id="condition-valeur-' + e + '-detail"></div>';
    $("#condition_" + e).html("Afficher cet élément seulement si la question " + tmp1 + " " + tmp2 + " " + tmp3 + ' <div class="closecondition" id="closecondition' + e + '"> <button class="close left" type="button" onclick="remove_condition(' + e + ');"> ×</button></div>');
    $("#condition_" + e).addClass("div_condition");
    on_condition_change(e, r)
}
function add_condition(e) {
    tmp = '<div id="condition_' + e + '"><button class="lien left" type="button" onclick="add_condition2(' + e + ");\">+ Ajouter une condition d'affichage</button></div>";
    return tmp
}
function add_condition2(e) {
    analyse();
    tmp1 = "<div class='condition'><select  id='condition-champ-" + e + "' name='condition-champ-" + e + "' onchange='on_condition_change(" + e + ")'><option value=''> --- </option>";
    for (var t = 1; t <= tab_index.length; t++) {
        if (e != tab_index[t - 1] && types[tab_index[t - 1]] < 10) {
            if (tab_libelle[t - 1])
                tmp1 += "<option value='" + tab_index[t - 1] + "'>" + tab_index[t - 1] + " - " + tab_libelle[t - 1] + "</option>";
            else
                tmp1 += "<option value='" + tab_index[t - 1] + "'>" + tab_index[t - 1] + " - libellé vide</option>"
        }
    }
    tmp1 += "</select></div>";
    tmp2 = "<div class='condition'><select name='condition-valeur-" + e + "' id='condition-valeur-" + e + "' onchange='on_condition_change2(" + e + ")'><option value='0'>est complété</option><option value='1'>n'est pas complété</option><option value='2'>est égale à : </option><option value='3'>est différent de : </option></select></div>";
    tmp3 = '<div class="condition" id="condition-valeur-' + e + '-detail"></div>';
    $("#condition_" + e).html("Afficher cet élément seulement si la question " + tmp1 + " " + tmp2 + " " + tmp3 + ' <div style="display:none !important;" class="closecondition" id="closecondition' + e + '"> <button class="close left" type="button" onclick="remove_condition(' + e + ');"> ×</button></div>');
    $("#condition_" + e).addClass("div_condition")
}
function on_condition_change(e, t) {
    if (!t)
        t = "";
    if (types[$("#condition-champ-" + e).val()] == 5 || types[$("#condition-champ-" + e).val()] == 6 || types[$("#condition-champ-" + e).val()] == 7) {
        tmp5 = '<select name="condition-valeur-' + e + '-detail">';
        $("#inputOptions" + $("#condition-champ-" + e).val()).find("input").each(function() {
            if ($(this).val()) {
                if (t == HTMLentities($(this).val()))
                    var e = "selected";
                else
                    var e = "";
                tmp5 += "<option " + e + ">" + $(this).val() + "</option>"
            }
        });
        tmp5 += "</select>";
        $("#condition-valeur-" + e + "-detail").html(tmp5)
    } else {
        $("#condition-valeur-" + e + "-detail").html('<input name="condition-valeur-' + e + '-detail" type="text" maxlength="30" value="' + t + '" onkeypress="refuserToucheEntree(event);"/>')
    }
    on_condition_change2(e)
}
function on_condition_change2(e) {
    if ($("#condition-valeur-" + e).val() <= 1) {
        $("#condition-valeur-" + e + "-detail").hide()
    } else {
        $("#condition-valeur-" + e + "-detail").show()
    }
}
function add_obligatoire(e, t, n) {
    if (!n || n == 0) {
        var r = "";
        var i = "checked"
    } else {
        var r = "checked";
        var i = ""
    }
    //tmp = '<div style="display:none !important;"  class="element" id="element_radio_obligatoire' + e + '"><div class="label"><label for="input' + e + '"> ' + t + '</label></div><div s class="input"><input id="radio' + index + 'oui" onchange="obligatoire(' + e + ')" name="forminputradio' + e + '" ' + r + ' type="radio" value="Oui" >Oui &nbsp;&nbsp;&nbsp;&nbsp;<input  id="radio' + e + 'non" onchange="non_obligatoire(' + e + ')" name="forminputradio' + e + '" type="radio" style="display:none !important;" value="Non" ' + i + ">Non</div></div>";
    //return tmp
    return '';
}
function remove_option(e, t) {
    $("#casesoptions" + e + "-" + t).remove();
    $("#closereponse" + e + "-" + t).remove();
    optionsDesCheckbox[e][optionsDesCheckbox_index[t]] = 0
}
function add_option(e, t, n, r) {
    if (!n)
        n = "";
    if (!r)
        r = "";
    return'<div class="casesoptions" id="casesoptions' + e + "-" + t + '"><input type="hidden" name="type' + e + '" value="texte"/><input id="forminput' + e + "-" + t + '" name="forminput' + e + "-" + t + '" type="text" required="required" placeholder="Champ obligatoire' + n + '" value="' + r + '" maxlength="40" size="60" onkeypress="refuserToucheEntree(event);"/></div><div class="closereponse" id="closereponse' + e + "-" + t + '"><button class="close left" type="button" onclick="remove_option(' + e + "," + t + ');">×</button></div>'
}
function add_reponse(e) {
    if (optionsDesCheckbox_index[e] <= 50) {
        optionsDesCheckbox_index[e]++;
        optionsDesCheckbox[e][optionsDesCheckbox_index[e]] = [optionsDesCheckbox_index[e]];
        tmp0 = add_option(e, optionsDesCheckbox_index[e], "Réponse " + optionsDesCheckbox_index[e]);
        $("#inputOptions" + e).append(tmp0)
    }
}
function add_reponses(e, t, n, r) {
    if (!n)
        n = "";
    optionsDesCheckbox[e] = [];
    optionsDesCheckbox_index[e] = 0;
    if (!r) {
        optionsDesCheckbox_index[e]++;
        optionsDesCheckbox[e][optionsDesCheckbox_index[e]] = [optionsDesCheckbox_index[e]];
        tmp0 = add_option(e, optionsDesCheckbox_index[e], "Réponse " + optionsDesCheckbox_index[e], r);
        optionsDesCheckbox_index[e]++;
        optionsDesCheckbox[e][optionsDesCheckbox_index[e]] = [optionsDesCheckbox_index[e]];
        tmp0 += add_option(e, optionsDesCheckbox_index[e], "Réponse " + optionsDesCheckbox_index[e]);
        optionsDesCheckbox_index[e]++;
        optionsDesCheckbox[e][optionsDesCheckbox_index[e]] = [optionsDesCheckbox_index[e]];
        tmp0 += add_option(e, optionsDesCheckbox_index[e], "Réponse " + optionsDesCheckbox_index[e])
    } else {
        var s = r.split("##");
        tmp0 = "";
        for (i = 0; i < s.length; i++) {
            optionsDesCheckbox_index[e]++;
            optionsDesCheckbox[e][optionsDesCheckbox_index[e]] = [optionsDesCheckbox_index[e]];
            tmp0 += add_option(e, optionsDesCheckbox_index[e], "Réponse " + optionsDesCheckbox_index[e], s[i])
        }
    }
    error = "<div class='error-blank30p' id='formblank-div-error-" + e + "'></div><div class='error' id='formdiv-error-" + e + "'></div>";
    if (t.length >= 23) {
        tmp = '<div class="element-multiligne" id="element' + e + '"><div class="label-multiligne"><label for="input' + e + '"> ' + t + '</label></div><div class="blank30p"></div><div class="input" id="inputOptions' + e + '">' + tmp0 + '</div><div class="blank30p"></div><div class="input"><button class="close left" type="button" onclick="add_reponse(' + e + ');">+ Ajouter une réponse</button></div>' + error + "</div>"
    } else {
        tmp = '<div class="element" id="element' + e + '"><div class="label"><label for="input' + e + '"> ' + t + '</label></div><div class="input" id="inputOptions' + e + '">' + tmp0 + '</div><div class="blank30p"></div><div class="input"><button class="lien left" type="button" onclick="add_reponse(' + e + ');">+ Ajouter une réponse</button></div>' + error + "</div>"
    }
    return tmp
}
/* pr mdf des btn */
function ajoute(e) {
    types[index] = e;
    tmp = '<fieldset id="fieldset' + index + '"><id class="hidden">' + index + '</id><div class="contenu"><legend> ' + index + " - ";
    if (e == 0) {
        tmp += "Question de type : Texte simple</legend><br><input type='hidden' name='type"+index+"'  value='texte'/>" + add_input(index, "Votre question :")
    } else if (e == 1) {
        tmp += "Question de type : Image</legend><br><input type='hidden' name='type"+index+"'  value='image'/>" + add_input(index, "Votre question :")
    } else if (e == 2) {
        tmp += "Question de type : Chiffres</legend><br>" + add_input(index, "Votre question :");
        tmp += add_input("labelerror" + index, "Texte à afficher si le format n'est pas respecté :", "Ce champ doit contenir seulement des chiffres")
    } else if (e == 3) {
        tmp += "Question de type : Adresse de site web</legend><br>" + add_input(index, "Votre question :");
        tmp += add_input("labelerror" + index, "Texte à afficher si le format n'est pas respecté :", "Ce champ doit contenir une adresse de site internet (exemple http://google.fr)")
    } else if (e == 5) {
        tmp += "Question de type : Liste déroulante</legend><br>" + add_input(index, "Votre question :");
        tmp += add_reponses(index, "Réponses possibles :")
    } else if (e == 6) {
        tmp += "Question de type : Cases à cocher - choix multiples possibles</legend><br><input type='hidden' name='type"+index+"'  value='case'/>" + add_input(index, "Votre question :");
        tmp += add_reponses(index, "Réponses possibles :")
    } else if (e == 7) {
        tmp += "Question de type : Cases à cocher</legend><br><input type='hidden' name='type"+index+"'  value='radio'/>" + add_input(index, "Votre question :");
        tmp += add_reponses(index, "Réponses possibles :")
    } else if (e == 8) {
        tmp += "Question de type : Texte long</legend><br>" + add_input(index, "Votre question :")
    } else if (e == 10) {
        tmp += "Texte de présentation</legend><br>" + add_presentation(index)
    } else if (e == 11) {
        tmp += "Ligne de séparation</legend><br>" + add_separation(index)
    } else if (e == 12) {
        tmp += "Titre de présentation</legend><br>" + add_input(index, "")
    }
    if (e < 10) {
        tmp += add_obligatoire(index, "Réponse obligatoire :")
    }
    if (affichagedesconditions == 1)
        tmp += add_condition(index);
    else if (e < 10)
        affichagedesconditions = 1;
    tmp += "</div>";
    tmp += '<div class="options"><div ><button class="close" onclick="remove_element(' + index + ');" type="button">×</button></div></div>';
    tmp += '<div class="fleches" id="fleches' + index + '"><div class="up" id="up' + index + '" onclick="up(' + index + ');"><img src="images/flecheh.png" width="50%"> </div><div class="down" id="down' + index + '" onclick="down(' + index + ');"> <img src="images/flecheb.png" width="50%"></div></div>';
    tmp += "</fieldset>";
    $(tmp).appendTo("#generatorContent");
    $(".error-blank30p").hide();
    $(".error").hide();
    index++;
    analyse();
    $(".right1").show();
    $(".left1").show()
}
function valider1() {
    $("#etape1").slideUp(400);
    $("#menuGenerator").slideUp(400);
    $("#etape2").delay(800).fadeIn(400);
    $(".error-blank30p").hide();
    $(".error").hide()
}
function analyse() {
    $(".up").show();
    $(".down").show();
    nb_element = 0;
    tab_index = [];
    tab_libelle = [];
    $("#generatorContent").find("fieldset").each(function() {
        foo = $(this).find("id").text();
        tab_index[nb_element] = foo;
        tmp = parseInt(foo);
        tab_libelle[nb_element] = $("#forminput" + tmp).val();
        nb_element++
    });
    $("#up" + tab_index[0]).hide();
    $("#down" + tab_index[nb_element - 1]).hide()
}
function valider() {
    analyse();
    var e = "";
    for (elt in tab_index) {
        e = e + "----" + tab_index[elt] + "****" + types[tab_index[elt]];
        $("#tabindex").val(e)
    }
}
function remove_element(e) {
    types[e] = -1;
    $("#fieldset" + e).remove();
    analyse()
}
function obligatoire(e) {
    $("#condition_" + e).hide();
    remove_condition(e)
}
function non_obligatoire(e) {
    $("#condition_" + e).show()
}
function up(e) {
    analyse();
    var t = getBefore(e);
    $("#fieldset" + e).insertBefore($("#fieldset" + t));
    analyse()
}
function down(e) {
    analyse();
    var t = getAfter(e);
    $("#fieldset" + e).insertAfter($("#fieldset" + t));
    analyse()
}
function getBefore(e) {
    return tab_index[array_search(e, tab_index) - 1]
}
function getAfter(e) {
    return tab_index[array_search(e, tab_index) + 1]
}
function array_search(e, t) {
    var n = -1;
    for (elt in t) {
        n++;
        if (t[elt] == e) {
            return n
        }
    }
    n = -1;
    return n
}
function previsualisation() {
    analyse();
    var e = '<div class="etape" id="etapex">';
    var t = "";
    var n = "";
    for (elt in tab_index) {
        if ($("#radio" + tab_index[elt] + "oui").is(":checked"))
            tmp1 = " *";
        else
            tmp1 = " ";
        if (types[tab_index[elt]] == 0) {
            e += add_previsualisation_input(tab_index[elt], $("#forminput" + tab_index[elt]).val() + tmp1)
        } else if (types[tab_index[elt]] == 1) {
            e += add_previsualisation_input(tab_index[elt], $("#forminput" + tab_index[elt]).val() + tmp1)
        } else if (types[tab_index[elt]] == 2) {
            e += add_previsualisation_input(tab_index[elt], $("#forminput" + tab_index[elt]).val() + tmp1)
        } else if (types[tab_index[elt]] == 3) {
            e += add_previsualisation_input(tab_index[elt], $("#forminput" + tab_index[elt]).val() + tmp1)
        } else if (types[tab_index[elt]] == 5) {
            tmp5 = "";
            $("#inputOptions" + tab_index[elt]).find("input").each(function() {
                if ($(this).val())
                    tmp5 += $(this).val() + "##"
            });
            e += add_previsualisation_select(tab_index[elt], $("#forminput" + tab_index[elt]).val() + tmp1, tmp5.substr(0, tmp5.length - 2))
        } else if (types[tab_index[elt]] == 6) {
            tmp5 = "";
            $("#inputOptions" + tab_index[elt]).find("input").each(function() {
                if ($(this).val())
                    tmp5 += $(this).val() + "##"
            });
            e += add_previsualisation_checkbox(tab_index[elt], $("#forminput" + tab_index[elt]).val() + tmp1, tmp5.substr(0, tmp5.length - 2))
        } else if (types[tab_index[elt]] == 7) {
            tmp5 = "";
            $("#inputOptions" + tab_index[elt]).find("input").each(function() {
                if ($(this).val())
                    tmp5 += $(this).val() + "##"
            });
            e += add_previsualisation_radio(tab_index[elt], $("#forminput" + tab_index[elt]).val() + tmp1, tmp5.substr(0, tmp5.length - 2))
        } else if (types[tab_index[elt]] == 8) {
            e += add_previsualisation_textarea(tab_index[elt], $("#forminput" + tab_index[elt]).val())
        } else if (types[tab_index[elt]] == 10) {
            e += add_previsualisation_presentation(tab_index[elt], $("#forminput" + tab_index[elt]).val())
        } else if (types[tab_index[elt]] == 11) {
            e += add_previsualisation_separation(tab_index[elt])
        } else if (types[tab_index[elt]] == 12) {
            e += add_previsualisation_titre(tab_index[elt], $("#forminput" + tab_index[elt]).val())
        }
        if (tmp1 == " " && $("#condition-valeur-" + tab_index[elt]).is(":visible"))
            n = '<div id="prev-conditions"><i>Attention: Les conditions d\'affichage ne sont pas prises en compte en mode prévisualisation.</i></div>'
    }
    e += n;
    e += "</div>";
    $("#previsualisation-content").html(e);
    $("#previsualisation-titre").html($("#input0").val());
    $(".error").hide();
    $(".error-blank30p").hide();
    openInfo("previsualisation")
}
function refuserToucheEntree(e) {
    if (!e && window.event) {
        e = window.event
    }
    if (e.keyCode == 13) {
        e.returnValue = false;
        e.cancelBubble = true
    }
    if (e.which == 13) {
        e.preventDefault();
        e.stopPropagation()
    }
}
function validerletitre(e) {
    if (!e && window.event) {
        e = window.event
    }
    if (e.keyCode == 13) {
        e.returnValue = false;
        e.cancelBubble = true;
        valideTitle()
    }
    if (e.which == 13) {
        e.preventDefault();
        e.stopPropagation()
    }
}
function HTMLentities(e) {
    if (e) {
        e = e.replace(/"/g, "&quot;");
        e = e.replace(/\'/g, "&#039;");
        e = e.replace(/</g, "&lt;");
        e = e.replace(/>/g, "&gt;");
        e = e.replace(/\^/g, "&circ;");
        e = e.replace(/‘/g, "&lsquo;");
        e = e.replace(/’/g, "&rsquo;");
        e = e.replace(/“/g, "&ldquo;");
        e = e.replace(/”/g, "&rdquo;");
        e = e.replace(/•/g, "&bull;");
        e = e.replace(/–/g, "&ndash;");
        e = e.replace(/—/g, "&mdash;");
        e = e.replace(/˜/g, "&tilde;");
        e = e.replace(/™/g, "&trade;");
        e = e.replace(/š/g, "&scaron;");
        e = e.replace(/›/g, "&rsaquo;");
        e = e.replace(/œ/g, "&oelig;");
        e = e.replace(/ /g, "&#357;");
        e = e.replace(/ž/g, "&#382;");
        e = e.replace(/Ÿ/g, "&Yuml;");
        e = e.replace(/¡/g, "&iexcl;");
        e = e.replace(/¢/g, "&cent;");
        e = e.replace(/£/g, "&pound;");
        e = e.replace(/¥/g, "&yen;");
        e = e.replace(/¦/g, "&brvbar;");
        e = e.replace(/§/g, "&sect;");
        e = e.replace(/¨/g, "&uml;");
        e = e.replace(/©/g, "&copy;");
        e = e.replace(/ª/g, "&ordf;");
        e = e.replace(/«/g, "&laquo;");
        e = e.replace(/¬/g, "&not;");
        e = e.replace(/­/g, "&shy;");
        e = e.replace(/®/g, "&reg;");
        e = e.replace(/¯/g, "&macr;");
        e = e.replace(/°/g, "&deg;");
        e = e.replace(/±/g, "&plusmn;");
        e = e.replace(/²/g, "&sup2;");
        e = e.replace(/³/g, "&sup3;");
        e = e.replace(/´/g, "&acute;");
        e = e.replace(/µ/g, "&micro;");
        e = e.replace(/¶/g, "&para");
        e = e.replace(/·/g, "&middot;");
        e = e.replace(/¸/g, "&cedil;");
        e = e.replace(/¹/g, "&sup1;");
        e = e.replace(/º/g, "&ordm;");
        e = e.replace(/»/g, "&raquo;");
        e = e.replace(/¼/g, "&frac14;");
        e = e.replace(/½/g, "&frac12;");
        e = e.replace(/¾/g, "&frac34;");
        e = e.replace(/¿/g, "&iquest;");
        e = e.replace(/À/g, "&Agrave;");
        e = e.replace(/Á/g, "&Aacute;");
        e = e.replace(/Â/g, "&Acirc;");
        e = e.replace(/Ã/g, "&Atilde;");
        e = e.replace(/Ä/g, "&Auml;");
        e = e.replace(/Å/g, "&Aring;");
        e = e.replace(/Æ/g, "&AElig;");
        e = e.replace(/Ç/g, "&Ccedil;");
        e = e.replace(/È/g, "&Egrave;");
        e = e.replace(/É/g, "&Eacute;");
        e = e.replace(/Ê/g, "&Ecirc;");
        e = e.replace(/Ë/g, "&Euml;");
        e = e.replace(/Ì/g, "&Igrave;");
        e = e.replace(/Í/g, "&Iacute;");
        e = e.replace(/Î/g, "&Icirc;");
        e = e.replace(/Ï/g, "&Iuml;");
        e = e.replace(/Ð/g, "&ETH;");
        e = e.replace(/Ñ/g, "&Ntilde;");
        e = e.replace(/Ò/g, "&Ograve;");
        e = e.replace(/Ó/g, "&Oacute;");
        e = e.replace(/Ô/g, "&Ocirc;");
        e = e.replace(/Õ/g, "&Otilde;");
        e = e.replace(/Ö/g, "&Ouml;");
        e = e.replace(/×/g, "&times;");
        e = e.replace(/Ø/g, "&Oslash;");
        e = e.replace(/Ù/g, "&Ugrave;");
        e = e.replace(/Ú/g, "&Uacute;");
        e = e.replace(/Û/g, "&Ucirc;");
        e = e.replace(/Ü/g, "&Uuml;");
        e = e.replace(/Ý/g, "&Yacute;");
        e = e.replace(/Þ/g, "&THORN;");
        e = e.replace(/ß/g, "&szlig;");
        e = e.replace(/à/g, "&aacute;");
        e = e.replace(/á/g, "&aacute;");
        e = e.replace(/â/g, "&acirc;");
        e = e.replace(/ã/g, "&atilde;");
        e = e.replace(/ä/g, "&auml;");
        e = e.replace(/å/g, "&aring;");
        e = e.replace(/æ/g, "&aelig;");
        e = e.replace(/ç/g, "&ccedil;");
        e = e.replace(/è/g, "&egrave;");
        e = e.replace(/é/g, "&eacute;");
        e = e.replace(/ê/g, "&ecirc;");
        e = e.replace(/ë/g, "&euml;");
        e = e.replace(/ì/g, "&igrave;");
        e = e.replace(/í/g, "&iacute;");
        e = e.replace(/î/g, "&icirc;");
        e = e.replace(/ï/g, "&iuml;");
        e = e.replace(/ð/g, "&eth;");
        e = e.replace(/ñ/g, "&ntilde;");
        e = e.replace(/ò/g, "&ograve;");
        e = e.replace(/ó/g, "&oacute;");
        e = e.replace(/ô/g, "&ocirc;");
        e = e.replace(/õ/g, "&otilde;");
        e = e.replace(/ö/g, "&ouml;");
        e = e.replace(/÷/g, "&divide;");
        e = e.replace(/ø/g, "&oslash;");
        e = e.replace(/ù/g, "&ugrave;");
        e = e.replace(/ú/g, "&uacute;");
        e = e.replace(/û/g, "&ucirc;");
        e = e.replace(/ü/g, "&uuml;");
        e = e.replace(/ý/g, "&yacute;");
        e = e.replace(/þ/g, "&thorn;");
        e = e.replace(/ÿ/g, "&yuml;");
        return e
    }
}
var index = 1;
var nb_element = 0;
var tab_index = [];
var tab_libelle = [];
var types = [];
var affichagedesconditions = 0;
var optionsDesCheckbox = [];
var optionsDesCheckbox_index = []