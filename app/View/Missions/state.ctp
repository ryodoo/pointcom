<div id="cont" class="util">
    
    <div id="histo" style="width: 830px; height: 390px;"></div><br>
    <div id="piechart_3d" style="width: 830px; height: 390px;"></div><br>
    <div id="chart_div" style="width: 830px; height: 390px;"></div><br>
    <div id="chartdiv" ></div><br>
    <?php

    $val="Nombre de visites par heure ";

    $str="<graph caption='".$val."'
       xAxisName='Temps' yAxisMinValue='0' yAxisName='Nombre de visiteurs'
       decimalPrecision='0' formatNumberScale='0' numberPrefix=''
       showNames='1' showValues='0' showAlternateHGridColor='1'
       AlternateHGridColor='blue' divLineColor='ff5904' divLineAlpha='20'
       alternateHGridAlpha='5'>";

    if(isset($liste)) {
        $t=$liste;
        //print_r($t);
        if(!empty($t)):
            foreach($t as $k => $v):
                $str .= "<set name='" . $k ."' value='" . $v ."' />";
            endforeach;
            echo $str;
        endif;

    }

    $str.="</graph>";
    include("FusionCharts.php");
    echo renderChartHTML($this->webroot."Line.swf", "", $str, "ChartId", 830, 390);
    
    $this->set('title',"Missions");

    echo $this->Session->flash();
    if(!empty($qrs)): ?>
    <h3>Détails</h3>
    <table border="1"  cellspacing="2" cellpadding="2" bgcolor="#CCCCCC" width="95%">
        <tr>
            <th>date scan1</th>
            <th>date scan2</th>
            <th>Utilisateur</th>
            <th>Sexe</th>
            <th>Age</th>
            <th>Ville</th>
        </tr>
            <?php
            $c = 1;
            $i=1;
            $nbclient='';
            $nb=$nFemme=$nHomme=$nf13=$nh13=$nf18=$nh18=$nf25=$nh25=$nf34=$nh34=0;
            $d=explode(" ", $qrs[0]['scans']["date_scan1"]);
            $date=$d[0];
            foreach($qrs as $data1):
                $i=-$i;
                ?>
        <tr id="c<?php echo($i); ?>" onMouseOver="this.style.backgroundColor='#FFDDBB'" onMouseOut="this.style.backgroundColor='<?php if($i > 0)echo('#EBEBEB'); else echo('#D4D4D4');?>';">
            <td><?php echo $data1['scans']["date_scan1"]; ?></td>
            <td><?php echo $data1['scans']["date_scan2"]; ?></td>
            <td> <?php echo $data1['user']['nom_complet']; ?></td>
            <td> <?php if($data1['user']['sexe']=='F')
                       {
                           echo 'Femme';
                           if($data1['user']['age']<=18)
                               $nf13++;
                           if($data1['user']['age']>18 && $data1['user']['age']<25)
                               $nf18++;
                           if($data1['user']['age']>=25 && $data1['user']['age']<34)
                               $nf25++;
                           if($data1['user']['age']>=34)
                               $nf34++;
                           $nFemme++;
                       }
                       else
                       {
                           echo 'Homme';
                           if($data1['user']['age']<=18)
                               $nh13++;
                           if($data1['user']['age']>18 && $data1['user']['age']<25)
                               $nh18++;
                           if($data1['user']['age']>=25 && $data1['user']['age']<34)
                               $nh25++;
                           if($data1['user']['age']>=34)
                               $nh34++;
                           $nHomme++;
                       }
                       ?></td>
            <td> <?php echo $data1['user']['age']; ?></td>
            <td> <?php echo $data1['user']['ville']; ?></td>
        </tr>
                <?php $c++;
                $d=explode(" ", $data1['scans']["date_scan1"]);
                if($date!=$d[0])
                {
                    $nbclient="['$date',  $nb],".$nbclient;
                    $date=$d[0];
                    $nb=1;
                }
                else
                    $nb++;
            endforeach; 
            $nbclient="['$date',  $nb],".$nbclient;
                ?>
    </table>
    <?php endif; ?>
    <br/>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
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
           is3D:true,
          animation: {
            duration: 10000,
            easing: 'out',
        },
          vAxis: {
            minValue: 0,
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
          ['Homme',     <?php echo $nHomme; ?>],
          ['Femme',      <?php echo $nFemme; ?>],
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
          ['-18',  <?php echo "$nh13,$nf13],"; ?>
          ['18-25', <?php echo "$nh18,$nf18],"; ?>
          ['25-34',  <?php echo "$nh25,$nf25],"; ?>
          ['+34',  <?php echo "$nh34,$nf34],"; ?>
        ]);

        var options = {
          title: 'Tranche d\'age',
          backgroundColor: {
            'stroke': '#888',
            'strokeWidth': '70'    
           },
          vAxis: {title: 'Tranche d\'age',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('histo'));

        chart.draw(data, options);
      }
    </script>
    
</div>
