<div id="infoediteur" class="pags view">
    <h2 style="width:100%;" ><?php echo __('Pag'); ?></h2>
    <div class="image">
        <img src="<?php echo h($pag['Pag']['image']); ?>" width="251px" height="220px" style="box-shadow:0px 0px 5px #000;-moz-box-shadow:0px 0px 5px #000;"/>
    </div>
    <table>
        <tr>
            <td><?php echo __('Titre'); ?></td>
            <td><?php echo h($pag['Pag']['titre']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Lien'); ?></td>
            <td><a href="<?php echo $pag['Pag']['lien']; ?>" target="_blank" rel="nofollow" >Cliquer ici</a></td>
        </tr>
        <tr>
            <td><?php echo __('N° Clients'); ?></td>
            <td><?php echo h($pag['Pag']['user']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('N° de points par client'); ?></td>
            <td><?php echo h($pag['Pag']['point/user']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Reste'); ?></td>
            <td><?php echo h($pag['Pag']['reste']); ?></td>
        </tr>
        <tr>
            <td><?php echo __('Sexe des clients'); ?></td>
            <td><?php
                if ($pag['Pag']['sexe'] == 'tous')
                    echo 'Homme/Femme';
                else if ($pag['Pag']['sexe'] == 'F')
                    echo 'Femme';
                else
                    echo 'Homme';
                ?></td>
        </tr>
        <tr>
            <td>Tanche d'age</td>
            <td><?php
                $tranche = substr($pag['Pag']['tranche'], 1);
                $tranche = str_replace(',', ' ans<br>- ', $tranche);
                $tranche = str_replace('0-', 'Moin de ', $tranche);
                $tranche = str_replace('34-100', 'Plus 34 ', $tranche);
                echo "- $tranche ans";
                ?></td>
        </tr>
        <tr>
            <td>Villes</td>
            <td><?php
                $ville = substr($pag['Pag']['ville'], 1);
                $ville = str_replace(',', '<br>- ', $ville);
                echo "- $ville";
                ?></td>
        </tr>
        <tr>
            <td>Date de creation</td>
            <td><?php echo $pag['Pag']['created']; ?></td>
        </tr>
        <tr>
            <td>Etat de la page</td>
            <td><?php
                if ((strtotime($pag['Pag']['date']) + 600) >= time())
                    echo 'n\'ai pas encore commancer';
                else {
                    if ($pag['Pag']['reste'] < 1)
                        echo 'Terminer';
                    if ($pag['Pag']['reste'] > 0)
                        echo 'En cour';
                }
                ?></td>
        </tr>
    </table>
</div>

<div id="cont" class="util">
    <h3>Statistiques</h3>
    <div id="histo" style="width: 830px; height: 390px;"></div><br>
    <div id="piechart_3d" style="width: 830px; height: 390px;"></div><br>
    <div id="chart_div" style="width: 830px; height: 390px;"></div><br>

    <h3>Details</h3>
    <table border="1"  cellspacing="2" cellpadding="2" bgcolor="#CCCCCC" width="95%">
        <tr>
            <th>Date</th>
            <th>Utilisateur</th>
            <th>Sexe</th>
            <th>Age</th>
        </tr>
        <?php
        $qrs = $jaime;
        $c = 1;
        $i = 1;
        $nbclient = '';
        $nb = $nFemme = $nHomme = $nf13 = $nh13 = $nf18 = $nh18 = $nf25 = $nh25 = $nf34 = $nh34 = 0;
        $d = explode(" ", $qrs[0]['Jaime']['created']);
        $date = $d[0];

        foreach ($qrs as $data1):
            $i = -$i;
            ?>
            <tr id="c<?php echo($i); ?>" onMouseOver="this.style.backgroundColor = '#FFDDBB'" onMouseOut="this.style.backgroundColor = '<?php
                if ($i > 0)
                    echo('#EBEBEB');
                else
                    echo('#D4D4D4');
                ?>';">
                <td><?php echo $data1['Jaime']["created"]; ?></td>
                <td> <?php echo $data1['User']['nom_complet']; ?></td>
                <td> <?php
                    if ($data1['User']['sexe'] == 'F') {
                        echo 'Femme';
                        if ($data1['User']['age'] <= 18)
                            $nf13++;
                        if ($data1['User']['age'] > 18 && $data1['User']['age'] < 25)
                            $nf18++;
                        if ($data1['User']['age'] >= 25 && $data1['User']['age'] < 34)
                            $nf25++;
                        if ($data1['User']['age'] >= 34)
                            $nf34++;
                        $nFemme++;
                    }
                    else {
                        echo 'Homme';
                        if ($data1['User']['age'] <= 18)
                            $nh13++;
                        if ($data1['User']['age'] > 18 && $data1['User']['age'] < 25)
                            $nh18++;
                        if ($data1['User']['age'] >= 25 && $data1['User']['age'] < 34)
                            $nh25++;
                        if ($data1['User']['age'] >= 34)
                            $nh34++;
                        $nHomme++;
                    }
                    ?></td>
                <td> <?php echo $data1['User']['age']; ?></td>
            </tr>
            <?php
            $c++;
            $d = explode(" ", $data1['Jaime']["created"]);
            if ($date != $d[0]) {
                $nbclient = "['$date',  $nb]," . $nbclient;
                $date = $d[0];
                $nb = 1;
            } else
                $nb++;
        endforeach;
        $nbclient = "['$date',  $nb]," . $nbclient;
        ?>
    </table>
    <br/>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
                google.load("visualization", "1", {packages: ["corechart"]});
                google.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Date', 'Clients'],
<?php echo $nbclient; ?>
                    ]);

                    var options = {
                        title: 'Nombre de visite total',
                        backgroundColor: {
                            'stroke': '#888',
                            'strokeWidth': '70'
                        },
                        vAxis: {
                            minValue: 0
                        }
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }

                //Mec ou fille
                google.setOnLoadCallback(femmehomme);
                function femmehomme() {
                    var data = google.visualization.arrayToDataTable([
                        ['Task', 'Hours per Day'],
                        ['Homme', <?php echo $nHomme; ?>],
                        ['Femme', <?php echo $nFemme; ?>],
                    ]);

                    var options = {
                        title: 'Homme/Fille',
                        is3D: true,
                        backgroundColor: {
                            'stroke': '#888',
                            'strokeWidth': '70'
                        }
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                    chart.draw(data, options);
                }

                //donne historgames des ages 
                google.setOnLoadCallback(ages);
                function ages() {
                    var data = google.visualization.arrayToDataTable([
                            ['Tranche d\'age', 'Homme', 'Femme'],
                            ['-18', <?php echo "$nh13,$nf13],"; ?>
                            ['18-25', <?php echo "$nh18,$nf18],"; ?>
                            ['25-34', <?php echo "$nh25,$nf25],"; ?>
                            ['+34', <?php echo "$nh34,$nf34],"; ?>
                            ]);
                                    var options = {
                                        title: 'Tranche d\'age',
                                        backgroundColor: {
                                            'stroke': '#888',
                                            'strokeWidth': '70'
                                        },
                                        vAxis: {title: 'Tranche d\'age', titleTextStyle: {color: 'red'}}
                                    };

                            var chart = new google.visualization.BarChart(document.getElementById('histo'));

                            chart.draw(data, options);
                        }
    </script>

</div>

