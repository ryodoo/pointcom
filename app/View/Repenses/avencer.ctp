<?php
if(!empty($questions)){
     echo $this->Html->script('ajax');
     echo $this->Html->css('prevquest');
$users="";
foreach ($questions as $value)
{
        $users[]=$value['User'];
}
$users = array_map("unserialize", array_unique(array_map("serialize", $users)));
?>
<style>
    .btnuser{background:rgba(0, 135, 207, 0.44);width:98%;height:30px;clear:both;border-bottom:1px dashed #fff;border-top:1px dashed #fff;padding-top:8px;padding-bottom:2px;margin-top:5px;margin-bottom:3px;text-align:center;cursor:pointer;border-radius:8px;color:#fff;}
    .input{padding: 10px 2px;margin-top: 5px;min-height: 60px !important;}
</style>
<div class="pubs form">
    <legend>Statistiques complet</legend>
</div>
<div style="width: 768px;height: 500px;clear: both;margin: auto;margin-top: 20px;">
    <div class="lefthand" style="background:#eee;float:left;width: 236px;height:500px;overflow-y:scroll;overflow-x:hidden;margin-top: 100px;">
        <?php foreach ($users as $value) :?>
        <div class="btnuser" onclick="afficher('<?php echo $value['id'].'/'.$questionnaire_id; ?>')" id="btnuser0" >
                <span><?php echo $value['nom_complet']; ?></span>
            </div>
        <?php endforeach;?>
    </div>
    <div class="users form" id="info" style="width:525px;height: 570px;overflow-y: scroll;overflow-x: hidden;float: right;clear: none;margin-top: 100px;margin-bottom: 35px;">
       
    </div>
</div>
<?php }else {?>
    <div class="pubs form">
    <legend>Les statistiques seront bientôt disponibles</legend>
</div>
<?php }?>