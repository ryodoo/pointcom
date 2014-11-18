<div class="pubs index">
    <h2><?php echo __('Pubs'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <?php if(AuthComponent::user('role_user')=='admin')
                    echo "<th>User</th>"?>
            <th>image</th>
            <th>question</th>
            <th>date</th>
            <th>N° Clients</th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php $hamza=0;
              foreach ($pubs as $pub): ?>
            <tr>
                 <?php if(AuthComponent::user('role_user')=='admin')
                    echo "<td><a href='/users/view/".$pub['Pub']['user_id']."'>Clic ici</a></td>"?>
                <td><div class="ribons" id="<?php
                    if ((strtotime($pub['Pub']['date']) + 600) >= time())
                        echo 'jaune';
                    else {
                        if ($pub['Pub']['reste'] > 0)
                            echo 'vert';
                        else
                            echo 'rouge';
                    }
                    ?>" ></div>
                    <?php echo $this->Html->image('pub/mobile/' . $pub['Pub']['image']); ?>&nbsp;</td>
                <td><?php echo h($pub['Pub']['question']); ?>&nbsp;</td>
                <td><?php echo h($pub['Pub']['date']); ?>&nbsp;</td>
                <td class="nbrclient<?php echo $hamza;?>">
                       <span class="spanprogress">
                           <b class="prog<?php echo $hamza; $hamza++;?>"></b>
                       </span> 
                       <e name="<?php echo$pub['Pub']['user']-$pub['Pub']['reste'];?>"> </e> <br> <f> </f> / <d name="<?php echo $pub['Pub']['user'];?>"> </d>    
                 </td>
                <td class="actions">
                    <?php
                    echo $this->Html->link(__('Voir'), array('action' => 'view', $pub['Pub']['id']));
                    if ((strtotime($pub['Pub']['date']) + 600) >= time()) {
                        echo $this->Html->link(__('Editer'), array('action' => 'edit', $pub['Pub']['id']));
                        echo $this->Form->postLink(__('Supprimer'), array('action' => 'delete', $pub['Pub']['id']), null, __('Vous les vous vraiment supprimer cette mission ?'));
                    } else {
                        echo $this->Html->link(__('Statistique'), array('action' => 'state', $pub['Pub']['id']));
                        echo $this->Html->link(__('Ajouter des crédits'), array('action' => 'credit', $pub['Pub']['id']));
                    }
                    ?>
                </td>
            </tr>
<?php endforeach; ?>
    </table>
    <div class="paging">
<?php
echo $this->Paginator->prev('< ' . __('Précédent'), array(), null, array('class' => 'prev disabled'));
echo $this->Paginator->numbers(array('separator' => ''));
echo $this->Paginator->next(__('Suivant') . ' >', array(), null, array('class' => 'next disabled'));
?>
    </div>
</div>
<script type="text/javascript">
   $(window).load(function(){	
					
        var prog = $(".spanprogress");
        for(var i=0 ; i<prog.length ; i++){
                var nbr = $('.nbrclient'+i+' e').attr('name');
                var pers = $('.nbrclient'+i+' d').attr("name");
                $('.nbrclient'+i+' f').append(nbr);
                $('.nbrclient'+i+' d').append(pers);
                nbr=nbr*100/pers;
                nbr=nbr.toFixed(0);
                var wid = nbr+'%';
                if(nbr<=20){
                        $('.spanprogress .prog'+i).css({"width":wid,"background":"#47C70f","transition":"2s"});
                }
                else if(nbr>20 && nbr<=40 ){
                        $('.spanprogress .prog'+i).css({"width":wid,"background":"#7BFF09","transition":"2s"});
                }
                else if( nbr>40 && nbr<=60 ){
                        $('.spanprogress .prog'+i).css({"width":wid,"background":"#EADB0C","transition":"2s"});
                }
                else if( nbr>60 && nbr<=80 ){
                        $('.spanprogress .prog'+i).css({"width":wid,"background":"#EF6612","transition":"2s"});
                }
                else if( nbr>80 ){
                        $('.spanprogress .prog'+i).css({"width":wid,"background":"#EF0000","transition":"2s"});
                }
                $('.nbrclient'+i+' e').append(wid);
                
                };
        });
            </script>