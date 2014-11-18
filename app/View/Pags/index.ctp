<div class="pags index">
    <h2><?php echo __('La liste des pages facebook');?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <?php if(AuthComponent::user('role_user')=='admin')
                    echo "<th>User</th>"?>
            <th>Image</th>
            <th>Titre</th>
            <th><?php echo $this->Paginator->sort('lien');?></th>
            <th><?php echo $this->Paginator->sort('date debut');?></th>
            <th><?php echo $this->Paginator->sort('N° Clients');?></th>
            <th class="actions"><?php echo __('Actions');?></th>
        </tr>
	<?php $hamza=0;
	foreach ($pags as $pag): ?>
        <tr>
            <?php if(AuthComponent::user('role_user')=='admin')
                    echo "<td><a href='/users/view/".$pag['Pag']['user_id']."'>Clic ici</a></td>"?>
            <td><div class="ribons" id="<?php
                    if ((strtotime($pag['Pag']['date']) + 600) >= time())
                        echo 'jaune';
                    else {
                        if ($pag['Pag']['reste'] > 0)
                            echo 'vert';
                        else
                            echo 'rouge';
                    }
                    ?>" ></div>
                <img src="<?php echo h($pag['Pag']['image']); ?>" /></td>
            <td><?php echo h($pag['Pag']['titre']); ?>&nbsp;</td>
            <td><a href="<?php echo $pag['Pag']['lien']; ?>" target="_blank" rel="nofollow" >Cliquer ici</a></td>
            <td><?php echo h($pag['Pag']['date']); ?>&nbsp;</td>
            <td class="nbrclient<?php echo $hamza;?>">
                       <span class="spanprogress">
                           <b class="prog<?php echo $hamza; $hamza++;?>"></b>
                       </span> 
                       <e name="<?php echo $pag['Pag']['user']-$pag['Pag']['reste'];?>"> </e> <br> <f> </f> / <d name="<?php echo $pag['Pag']['user'];?>"> </d>    
                 </td>
            <td class="actions">
			<?php if((strtotime($pag['Pag']['date'])+600) >= time())
                        {
                            echo $this->Html->link(__('Editer'), array('action' => 'edit', $pag['Pag']['id']));
                            echo $this->Form->postLink(__('Supprimer'), array('action' => 'delete', $pag['Pag']['id']), null, __('Vous les vous vraiment supprimer cette page?'));
                        }
                        else
                        {
                            echo $this->Html->link(__('Statistique'), array('action' => 'view', $pag['Pag']['id']));
                            echo $this->Html->link(__('Ajouter des crédits'), array('action' => 'credit', $pag['Pag']['id']));
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
