<?php
echo $this->Html->css('prevquest');
echo $this->Html->css('style');
?>
<style>
	form{width: 757px !important;margin-left: auto !important;float: none !important;}
</style>
<div id="infoquest">
    <div class="image">
        <?php echo $this->Html->image('questionnaire/' . $questionnaire['Questionnaire']['image'], array('width' => "251px", "height" => "220px")); ?>
    </div>
    <div>
        <table  style="width:48% !important;min-height:230px; float:left;">
            <tr>
                <td>Titre</td> 
                <td><?php echo $questionnaire['Questionnaire']['name']; ?></td>
            </tr>
            <tr>
                <td>Nbr Utilisateurs</td> 
                <td><?php echo $questionnaire['Questionnaire']['nombreuser']; ?></td>
            </tr>
            <tr>
                <td>Points total</td>   
                <td><?php echo $questionnaire['Questionnaire']['points']; ?></td>
            </tr>
            <tr>
                <td>Point/User</td> 
                <td><?php echo $questionnaire['Questionnaire']['pointparuser']; ?></td>
            </tr>
            <tr>
                <td>Questionnaire qui reste</td>
                <td><?php echo $questionnaire['Questionnaire']['reste']; ?></td>
            </tr>
            <tr>
                <td>Date de commencement</td>   
                <td><?php echo $questionnaire['Questionnaire']['date']; ?></td>
            </tr>
        </table>
        <table  style="width:48% !important;min-height:230px; float:right;">
            <tr>
                <td>Sexe des clients</td> 
                <td><?php
                    if ($questionnaire['Questionnaire']['sexe'] == 'tous')
                        echo 'Homme/Femme';
                    else if ($questionnaire['Questionnaire']['sexe'] == 'F')
                        echo 'Femme';
                    else
                        echo 'Homme';
                    ?>
                </td>
            </tr>
            <tr>
                <td>Tanche d'age</td> 
                <td><?php
                    $tranche = substr($questionnaire['Questionnaire']['trancheage'], 1);

                    echo "$tranche  ans";
                    ?>
                </td>
            </tr>
            <tr>
                <td>Villes</td>
                <td><?php
                    $ville = substr($questionnaire['Questionnaire']['ville'], 1);
                    $ville = str_replace(',', '<br>- ', $ville);
                    echo "- $ville";
                    ?>
                </td>
            </tr>
            <tr>
                <td>Date de creation</td> 
                <td><?php echo $questionnaire['Questionnaire']['created']; ?></td>
            </tr>
            <tr>
                <td>Etat du questionnaire</td>
                <td><?php
                    if ((strtotime($questionnaire['Questionnaire']['date']) + 600) >= time())
                        echo 'n\'ai pas encore commancer';
                    else {
                        if ($questionnaire['Questionnaire']['reste'] < 1)
                            echo 'Terminer';
                        if ($questionnaire['Questionnaire']['reste'] > 0)
                            echo 'En cour';
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <?php if ((strtotime($questionnaire['Questionnaire']['date']) + 600) >= time()):?>
    <div class="actions">
        <?php if($questionnaire['Questionnaire']['type']!=null)
                echo $this->Html->link('Modifier', array('action' => 'cedit', $questionnaire['Questionnaire']['id']), array('class' => 'btn'));
              else
                echo $this->Html->link('Modifier', array('action' => 'edit', $questionnaire['Questionnaire']['id']), array('class' => 'btn'));
             echo $this->Html->link('Ajouter des questions', array('controller' => 'questions', 'action' => 'add', $questionnaire['Questionnaire']['id']), array('class' => 'btn')); ?>
    </div>
    <?php endif;?>
</div>

<div class="users form">
    <?php echo $this->Form->create('Question', array('action' => 'edit')); ?>
    <fieldset>
        <?php
        if (!empty($questionnaire['Question'])):
            $i = 0;
            foreach ($questionnaire['Question'] as $question):
                $i++;
                $choix = $this->requestAction("/questions/getchoix/" . $question['id']);
                if ($question['type'] == 'texte'):
                    ?>
                    <div class="input required" id="text<?php echo $i; ?>">
                        <label value="<?php echo $question['question']; ?>" for="questtext" id="labeletext<?php echo $i; ?>"><?php echo $question['question']; ?></label>
                        <?php if ((strtotime($questionnaire['Questionnaire']['date']) + 600) >= time()): ?>
                            <button type="button" class="btn button<?php echo $i; ?>" onclick="text(<?php echo "$i," . $question['id']; ?>)">Modifier</button>
                            <?php echo $this->Form->postLink(__('X'), array('controller' => 'questions', 'action' => 'delete', $question['id']), array('class' => "delet deletradio$i;"), null, __('Vous les vous vraiment supprimer cette question?'));
                        endif; ?>
                        <input name="" maxlength="45" type="text" id="questtext<?php echo $i; ?>">
                    </div>
                    <?php
                endif;
                if ($question['type'] == 'image'):
                    ?>
                    <div class="input required" id="text<?php echo $i; ?>">
                        <label value="<?php echo $question['question']; ?>" for="questtext" id="labeletext<?php echo $i; ?>"><?php echo $question['question']; ?></label>
                        <?php if ((strtotime($questionnaire['Questionnaire']['date']) + 600) >= time()): ?>
                            <button type="button" class="btn button<?php echo $i; ?>" onclick="text(<?php echo "$i," . $question['id']; ?>)">Modifier</button>
                            <?php echo $this->Form->postLink(__('X'), array('controller' => 'questions', 'action' => 'delete', $question['id']), array('class' => "delet deletradio$i;"), null, __('Vous les vous vraiment supprimer cette question?'));
                        endif; ?>
                        <b >Type image</b>
                    </div>
                    <?php
                endif;
                if ($question['type'] == 'radio'):
                    ?>
                    <div class="input required" id="radio<?php echo $i; ?>">
                        <label for="questradio" value="<?php echo $question['question']; ?>" id="labeleradio<?php echo $i; ?>"><?php echo $question['question']; ?></label>
                        <?php if ((strtotime($questionnaire['Questionnaire']['date']) + 600) >= time()): ?>
                            <button type="button" class="btn buttonradio<?php echo $i; ?>" onclick="radiou(<?php echo "$i," . $question['id']; ?>)">Modifier</button>
                            <?php echo $this->Form->postLink(__('X'), array('controller' => 'questions', 'action' => 'delete', $question['id']), array('class' => "delet deletradio$i;"), null, __('Vous les vous vraiment supprimer cette question?'));  
                          endif;
                        $j = 0;
                        foreach ($choix as $value):
                            ?>
                            <div class="repenseradio<?php echo "$i-$j"; ?> repense required">
                                <input type="radio" id="questradio<?php echo "$i-$j"; ?>" name="radio1" value="<?php echo $value['Choix']['id']; ?>">
                                <b id="repradio<?php echo "$i-$j"; ?>" value="<?php echo $value['Choix']['choix']; ?>"><?php echo $value['Choix']['choix']; ?></b>	
                            </div> 
                            <?php
                            $j++;
                        endforeach;
                        ?>
                        <div class="repense repensen<?php echo "$i"; ?>">
                            <button type="button" class="close ajouterrad<?php echo "$i"; ?>" style="font-size: 16px; float: right;text-align: right;display:none;">+ Ajouter une répense</button><br>
                        </div>
                    </div>
                    <?php
                endif;
                if ($question['type'] == 'case'):
                    ?>

                    <div class="input required" id="check<?php echo $i; ?>">
                        <label for="questchekbox" value="<?php echo $question['question']; ?>" id="labelecheck<?php echo $i; ?>"><?php echo $question['question']; ?></label>
                        <?php if ((strtotime($questionnaire['Questionnaire']['date']) + 600) >= time()): ?>
                            <button type="button" class="btn buttoncheck<?php echo $i; ?>" onclick="check(<?php echo "$i," . $question['id']; ?>)">Modifier</button>
                            <?php
                            echo $this->Form->postLink(__('X'), array('controller' => 'questions', 'action' => 'delete', $question['id']), array('class' => "delet deletradio$i;"), null, __('Vous les vous vraiment supprimer cette question?'));
                        endif;
                        $j = 0;
                        foreach ($choix as $value):
                            ?>
                            <div class="repense repensecheck<?php echo "$i-$j"; ?>">
                                <input type="checkbox" id="questcheck<?php echo "$i-$j"; ?>" value="<?php echo $value['Choix']['id']; ?>">
                                <b id="repcheck<?php echo "$i-$j"; ?>" value="<?php echo $value['Choix']['choix']; ?>"> <?php echo $value['Choix']['choix']; ?></b>

                            </div>
                <?php
                $j++;
            endforeach;
            ?>
                        <div class="repense repensem<?php echo "$i"; ?>">
                            <button type="button" class="close ajoutercheck<?php echo "$i"; ?>" style="font-size: 16px; float: right;text-align: right;display:none;">+ Ajouter une répense</button><br>
                        </div>
                    </div>
        <?php endif; ?>
    <?php endforeach; ?>

<?php endif; ?>

    </fieldset>
</form>
</div>
<script>
    function text(id, question_id) {
        var labele = $('#labeletext' + id).attr('value');
        $("#labeletext" + id).remove();
        $("#questtext" + id).remove();
        //tu crées un nouveau element
        var input = "<input type='hidden' name='id' value='" + question_id + "'><input type='text' style='width:80%' name='forminput' required='required' class='" + id + "' value='" + labele + "'>";
        $('#text' + id).append(input);

        //ensuite pour ajouter un attribut à ton element:
        $('.button' + id).hide();
        $('.delettext' + id).hide();

        var submit = "<div class='submit'><input type='submit' value='enregistrer' style='float:right;margin-top:20px;margin-right:20px !important;'></div>";
        $('#text' + id).append(submit);
    }

    function radiou(id, question_id) {
        var labele = $('#labeleradio' + id).attr('value');
        $("#labeleradio" + id).remove();
        //tu crées un nouveau element
        var input = "<input type='hidden' name='id' value='" + question_id + "'><input type='text' name='forminput' style='width:80%' required='required' class='" + id + "' value='" + labele + "'>";
        $('#radio' + id).prepend(input);
        //ensuite pour ajouter un attribut à ton element:
        var rad = $('input[type="radio"]');
        for (var i = 0; i <= rad.length; i++) {

            var b = $('#repradio' + id + "-" + i).attr('value');
            var input = "<button  type='button' class='close radiou" + id + i + "' onclick='closeradio(" + id + i + ")'>x</button><input name='forminput" + i + "' type='text' style='width:80%' id='radio" + id + i + "' required='required' class='" + i + "' value='" + b + "'>";

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
            var input = "<div class='repenseradio" + id + " repense required'><button  type='button' class='close radiou" + a + 1 + "' onclick='closeradio(" + a + 1 + ")'>x</button><input type='text' style='width:80%' name='forminput" + a + "' id='radio" + a + 1 + "' placeholder='Nouvelle réponse' required='required' class='radio" + id + "-" + j + "'></div>";
            $(".repensen" + id).append(input);
        });

        var submit = "<div class='submit'><input type='submit' value='enregistrer' style='float:right;margin-top:20px;margin-right:20px !important;'></div>";
        $('#radio' + id).append(submit);
    }

    function closeradio(id) {
        $('input').remove('#radio' + id);
        $('button').remove('.radiou' + id);

    }


    function check(id, question_id) {
        var labele = $('#labelecheck' + id).attr('value');
        $("#labelecheck" + id).remove();
        //tu crées un nouveau element
        var input = "<input type='hidden' name='id' value='" + question_id + "'><input type='text' name='forminput'  style='width:80%' required='required' class='" + id + "' value='" + labele + "'>";
        $('#check' + id).prepend(input);
        //ensuite pour ajouter un attribut à ton element:
        var chec = $('input[type="checkbox"]');
        for (var i = 0; i <= chec.length; i++) {

            var b = $('#repcheck' + id + "-" + i).attr('value');
            var input = "<button  type='button' class='close checke" + id + i + "' onclick='closecheck(" + id + i + ")'>x</button><input name='forminput" + i + "' type='text' style='width:80%' id='check" + id + i + "' required='required' class='" + id + i + "' value='" + b + "'>";

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
            var input = "<div class='repensecheck" + id + " repense required'><button  type='button' class='close checke" + c + 1 + "' onclick='closecheck(" + c + 1 + ")'>x</button><input name='forminput" + c + "' type='text' style='width:80%' id='check" + c + 1 + "' placeholder='Nouvelle réponse' required='required' class='check" + id + "-" + f + "'></div>";
            $(".repensem" + id).append(input);
        });
        var submit = "<div class='submit'><input type='submit' value='enregistrer' style='float:right;margin-top:20px;margin-right:20px !important;'></div>";
        $('#check' + id).append(submit);
    }
    function closecheck(id) {
        $('input').remove('#check' + id);
        $('button').remove('.checke' + id);
    }
</script>