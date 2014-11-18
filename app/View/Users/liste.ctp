<div id="cont" class="util">
<?php
$this->set('title',"Utilisateurs");
//echo $this->element('sql_dump');
//$this->layout = 'administration';

echo $this->Session->flash();


if(!empty($users)):
    echo "<h3>Liste des utilisateurs</h3>";
    ?>
<table border="1" cellspacing="2" cellpadding="2" bgcolor="#CCCCCC" width="95%">
    <tr>
        <th>Role</th>
        <th>Nom</th>
        <th>Adresse</th>
        <th>Téléphone</th>
        <th>Email</th>
        <th>Date d'inscription</th>
        <th>Points</th>
        <th>Etat</th>
        <th>
        </th>
    </tr>

        <?php
        $i=1;
        foreach($users as $data1):
            $i=-$i;
            ?>
    <tr id="c<?php echo($i); ?>" onMouseOver="this.style.backgroundColor='#FFDDBB'" onMouseOut="this.style.backgroundColor='<?php if($i > 0)echo('#EBEBEB'); else echo('#D4D4D4');?>';">
        <td>
                    <?php echo $data1['User']['role_user']; ?>
        </td>
        <td>
                    <?php echo $data1['User']['nom_complet']; ?>
        </td>
        <td>
                    <?php echo $data1['User']['adresse']; ?>
        </td>
        <td>
                    <?php echo $data1['User']['tel']; ?>
        </td>
        <td>
                    <?php echo $data1['User']['email']; ?>
        </td>
        <td>
                    <?php echo $data1['User']['created']; ?>
        </td>
        <td>
                    <?php echo $data1['User']['point']; ?>
        </td>
        <td>
                    <?php if($data1['User']['active'] == 1) echo "Active";  else echo "Non active"; ?>
        </td>
        <td>
            <a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'delete', $data1['User']['id'])); ?>" class="confirmation">
                        <?php echo $this->Html->image('delete.jpg', array('alt' => 'supprimer', 'width'=>'20px', 'height'=>'20px')); ?>
            </a>
            <a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'modifier', $data1['User']['id'])); ?>">
                        <?php echo $this->Html->image('edit.jpg', array('alt' => 'modifier', 'width'=>'20px', 'height'=>'20px')); ?>
            </a>
        </td>
    </tr>
        <?php
        endforeach;
        echo "</table>";
    endif;
    ?>

    <script type="text/javascript">
        $('.confirmation').on('click', function () {
            return confirm('Etes vous sur de bien vouloir supprimer cet enregistrement ?');
        });
    </script>
</div>