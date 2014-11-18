<div id="cont">
    <h3>Valider votre paiement</h3>
    <p style="font-size: 18px;  color: #FFFFFF;  font-weight: bold;padding:6px;background: #555;">
        Afin de finaliser plus facilement votre paiement, envoyez nous OBLIGATOIREMENT
        une copie de votre ordre de virement .
        Attention, le payement par versement prend 24h ouvrées pour activer une commande.
        <br>
        Domiciliation : 	Banque Populaire<br>
        Numéro de compte : 	21330 7094 254 0013
    </p>
    <?php
    echo $this->Form->create('Paiement',  array('type' => 'file'));
    echo "<fieldset>";
    echo $this->Form->input('nom');
    echo $this->Form->input('point',array('label' => 'Le nombre de points demander'));
    echo $this->Form->input('prix',array('label' => 'Le mantant envoyé'));
    ?>
    <label> Joindre le reçu</label>
    <?php
    echo $this->Form->input('avatar_file', array('type' => 'file', "label" => false, "div" => false, "class" => "colorText"));
    echo "</fieldset>";
    echo $this->Form->end('VALIDER');
    ?>
</div>