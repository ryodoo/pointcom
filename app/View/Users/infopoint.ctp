<div id="cont" class="util">
    <?php
    echo $this->Session->flash();

    $total = 0;
    if (!empty($state)) {
        echo "<h3>Mes Points</h3>";
        ?>
        <table border="1" align="center" cellspacing="2" cellpadding="2" bgcolor="#CCCCCC" width="95%">
            <tr>
                <th>Type</th>
                <th>Nombre de points</th>
                <th>Date</th>
            </tr>

            <?php
            $i = 1;
            foreach ($state as $data1):
                $i = -$i;
                ?>
                <tr id="c<?php echo($i); ?>" onMouseOver="this.style.backgroundColor = '#FFDDBB'" onMouseOut="this.style.backgroundColor = '<?php if ($i > 0) echo('#EBEBEB');
        else echo('#D4D4D4'); ?>';">
                    <td><?php echo $data1['type']; ?></td>
                    <td><?php echo $data1['point']; ?></td>
                    <td><?php echo $data1['date'];
                              $total += $data1['point'];?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php
    } else
        echo '<h2 style="width:100%;margin-left: 0px;margin-bottom: 20px;">
                    Aucune mission n’a été scannée avec ce compte.
                </h2>';
    ?>
</div>