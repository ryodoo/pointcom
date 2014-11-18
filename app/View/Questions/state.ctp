<h3>Statistiques</h3>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<?php foreach ($questions as $value) :
    if($value['Question']['type']!='texte'):
        $choi="['info'";
        $rep="['Repense'";
        $i=0;
         foreach ($value['Choix'] as $choix) 
         {
             $choi=$choi.",'".$choix['choix']."'";
             $inc=0;
             foreach ($value['Repense'] as $repense) 
             {
                 if($repense['choix']==$choix['id'])
                     $inc++;
             }
             $rep=$rep.','.$inc;
         }
         $choi=$choi."],".$rep."]";
    ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {

  var data = google.visualization.arrayToDataTable([
    <?php echo $choi; ?>
                
  ]);

  var options = {
    title: '<?php echo $value['Question']['question']; ?>',
    backgroundColor: {
            'stroke': '#888',
            'strokeWidth': '70'    
           },
    hAxis: {title: '', titleTextStyle: {color: 'red'}}
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('<?php echo $value['Question']['id']; ?>'));

  chart.draw(data, options);

}
    </script>
    <div id="<?php echo $value['Question']['id']; ?>" style="width: 830px; height: 390px;"></div><br>
<?php endif;
    endforeach; ?>