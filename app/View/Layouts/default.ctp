<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title></title>
        <link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster">
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Lato:400,700'>
        <?php
        echo $this->Html->css('index');
        if (strstr($_SERVER['REQUEST_URI'], "questions/add") || strstr($_SERVER['REQUEST_URI'], "questions/add"))
            $walo=0;
        else
        {
            echo $this->Html->css('myblan');
            echo $this->Html->css('../bootstrap/css/bootstrap.min');
        }
        ?>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Javascript -->
        <?php echo $this->Html->script('jquery-1.10.2.min'); ?>
        <script type="text/javascript">
            function hover() {
                $('.sm').show().css({'z-index': '999', 'margin-left': '-251px', 'opacity': '1.0'}).animate({'transition': '4s'});
            }
            ;
            function out() {
                $('.sm').hide().css({'z-index': '-999', 'margin-left': '0px', 'opacity': '0.0'}).animate({'transition': '4s'});

            }
            ;
        </script>


        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <?php echo $this->Html->script("Charts/FusionCharts.js"); ?>
        <?php echo($this->fetch('script')); ?>
        <style>
            .jqstooltip { position: absolute;left: 0px;
                          top: 0px;visibility: hidden;
                          background: rgb(0, 0, 0) transparent;
                          background-color: rgba(0,0,0,0.6);
                          filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style><style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}
            </style>
            <script type="text/javascript">
            function hover() {
                var i = 0;
                if (i == 0) {
                    $('.connexion .sm').show().css({'z-index': '999', 'opacity': '1.0'}).animate({'transition': '4s'});
                }
            }
            function out() {
                $('.connexion .sm').hide().css({'z-index': '-999', 'opacity': '0.0'}).animate({'transition': '4s'});
            }
            ;
            function dropy(id) {

                $('#navigation ul li').css({'height': '109px'});
                $('.p1').css({'margin-top': '-63px'});
                $('#drop' + id).show().animate({'transition': '2s'});
            }
            function dropy1(id) {
                $('.p1').css({'margin-top': '-1px'});
                $('#navigation ul li').css({'height': 'auto'});
                $('#drop' + id).hide().animate({'transition': '2s'});
            }
            </script>
        </head>
        <body  <?php if (AuthComponent::user('id') != null) echo "id='inter'"; ?>>

            <!-- header -->
            <header>
                <div id="connect">
                <div class="connexion" onmouseover="hover()" onmouseout="out()">       
                    <?php
                    if (AuthComponent::user('id') == null)
                        echo $this->Html->link('Se connecter', array('controller' => 'users', 'action' => 'login'));
                    else {
                            echo $this->Html->link('Mon compte', array('controller' => 'users', 'action' => 'index'), array("onmouseover" => "hover()"));
                        ?>
                        <ul class="sm">
                            <li>
                                <?php echo $this->Html->link('Modifier compte', array('controller' => 'users', 'action' => 'edit')); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link('Mot de passe', array('controller' => 'users', 'action' => 'modifpassword')); ?>
                            </li>
                        </ul>
                        <?php  } ?>
                </div>
                <div class="inscription">
                    <?php
                    if (AuthComponent::user('id') != null)
                        echo $this->Html->link('Déconnexion', array('controller' => 'users', 'action' => 'logout'));
                    ?>
                </div>
            </div>

            <div class ="logo">
                <a href="<?php
                if ($this->Session->check('Auth.User') == false)
                    echo $this->Html->url(array('controller' => 'users', 'action' => 'accueil'));
                else
                    echo $this->Html->url(array('controller' => 'users', 'action' => 'index'));
                ?>" title="PointCom">
                    <?php echo $this->Html->image('logo-myblan.png', array('width' => '135px', 'height' => '52px')); ?></a>
            </div>
            <div id="navigation">
                <?php if ($this->Session->read('Auth.User.role_user') == "admin") { ?>
                    <ul>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'cadeauxs', 'action' => 'liste')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "cadeauxs/view") || strstr($_SERVER['REQUEST_URI'], "cadeauxs/liste")) {
                                echo "class='current'";
                            }
                            ?>>
                                Cadeaux</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'recharges', 'action' => 'index')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "cadeauxs/view") || strstr($_SERVER['REQUEST_URI'], "cadeauxs/liste")) {
                                echo "class='current'";
                            }
                            ?>>
                                Recharges</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'usergifts', 'action' => 'liste')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "usergifts/liste") || strstr($_SERVER['REQUEST_URI'], "cadeauxs/edit")) {
                                echo "class='current'";
                            }
                            ?>>
                                Commandes</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'magasins', 'action' => 'liste')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "magasins")) {
                                echo "class='current'";
                            }
                            ?>>
                                Magasins</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'missions', 'action' => 'liste')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "missions")) {
                                echo "class='current'";
                            }
                            ?>>
                                Offres</a>
                        </li>

                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'liste')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "users/liste") || strstr($_SERVER['REQUEST_URI'], "users/modifier")) {
                                echo "class='current'";
                            }
                            ?>>
                                Utilisateurs</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'paiements', 'action' => 'index')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "users/paiement") || strstr($_SERVER['REQUEST_URI'], "users/admin")) {
                                echo "class='current'";
                            }
                            ?>>
                                Paiements</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'recharges', 'action' => 'index')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "users/paiement") || strstr($_SERVER['REQUEST_URI'], "users/admin")) {
                                echo "class='current'";
                            }
                            ?>>
                                Recharges</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'changes', 'action' => 'index')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "users/paiement") || strstr($_SERVER['REQUEST_URI'], "users/admin")) {
                                echo "class='current'";
                            }
                            ?>>
                                Changes</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'pubs', 'action' => 'index')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "users/paiement") || strstr($_SERVER['REQUEST_URI'], "users/admin")) {
                                echo "class='current'";
                            }
                            ?>>
                                évaluation publicité</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'questionnaires', 'action' => 'index',0,1)); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "users/paiement") || strstr($_SERVER['REQUEST_URI'], "users/admin")) {
                                echo "class='current'";
                            }
                            ?>>
                                Clients mystere</a>
                        </li>

                    </ul>
                    <?php
                } if
                ($this->Session->read('Auth.User.role_user') == "mobile") {
                    ?>
                    <ul>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'cadeauxs', 'action' => 'liste')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "cadeauxs")) {
                                echo "class='current'";
                            }
                            ?>>
                                Cadeaux</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'infopoint')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "mespoints")) {
                                echo "class='current'";
                            }
                            ?>>
                                Mes points</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'usergifts', 'action' => 'miens')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "usergifts")) {
                                echo "class='current'";
                            }
                            ?>>
                                Mes cadeaux</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'recharges', 'action' => 'miens')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "recharges")) {
                                echo "class='current'";
                            }
                            ?>>
                                Mes recharges</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'changes', 'action' => 'miens')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "changes")) {
                                echo "class='current'";
                            }
                            ?>>Bureau de change</a></li>
                    </ul>
                    <?php
                } if
                ($this->Session->read('Auth.User.role_user') == "vendeur") {
                    ?>
                    <ul>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'questionnaires', 'action' => 'index')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "questionnaires")) {
                                echo "class='current'";
                            }
                            ?> >Questionnaires</a>
                        </li>

                        <li><a href="<?php echo $this->Html->url(array('controller' => 'missions', 'action' => 'index')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "missions")) {
                                echo "class='current'";
                            }
                            ?> >Mes Missions</a>
                        </li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'pags', 'action' => 'index')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "pags")) {
                                echo "class='current'";
                            }
                            ?> >Mes pages</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'pubs', 'action' => 'index')); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "pubs")) {
                                echo "class='current'";
                            }
                            ?>>
                                évaluation publicité</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'questionnaires', 'action' => 'index',0,1)); ?>" <?php
                            if (strstr($_SERVER['REQUEST_URI'], "questionnaires"))
                                echo "class='current'";
                            ?>>
                                Clients mystere</a>
                        </li>
                        
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'paiements', 'action' => 'index')); ?>"  <?php
                            if (strstr($_SERVER['REQUEST_URI'], "paiements")) {
                                echo "class='current'";
                            }
                            ?> >Acheter des points</a>
                        </li>
                    </ul>
                    <?php
                } if
                ($this->Session->check('Auth.User') == false) {
                    ?>
                    <ul>
                        <li><?php echo $this->Html->link('Accueil', array('controller' => 'users', 'action' => 'accueil')); ?></li>
                        <li><?php echo $this->Html->link('Aide Utilisateur', array('controller' => 'users', 'action' => 'apropos')); ?></li>
                        <li><?php echo $this->Html->link('Cadeaux', array('controller' => 'cadeauxs', 'action' => 'liste')); ?></li>
                        <li><?php echo $this->Html->link('Communauty', array('controller' => 'users', 'action' => 'communaute')); ?></li>
                        <li><?php echo $this->Html->link('Annonceur', array('controller' => 'contacts', 'action' => 'index')); ?></li>
                        <li><?php echo $this->Html->link('Contactez nous', array('controller' => 'contacts', 'action' => 'index')); ?></li>
                    </ul>
                <?php } ?>
            </div>
            <?php if (AuthComponent::user('id') != null): ?>
                <p class="p1">Votre crédit : <?php echo AuthComponent::user('point'); ?> IC</p>
            <?php endif; ?>
        </header>




        <!-- contenu -->
        <div align="center" id="tt">
            <?php echo $this->Session->flash();
            echo $this->fetch('content'); ?>
        </div>

        <div id="footer">
            <div class="ft">
                <div id="logo_footer" style="width: 200px;float: left;margin-left: 77px;margin-top: 30px;border-right: 1px solid rgba(74,73,74,0.46);padding-bottom: 30px;">
                    <a href="#" title="MyBlan"></a>
                    <?php echo $this->Html->image('myblan-m-footer.png',array('width'=>"100px", 'height'=>"100px" ,'style'=>"float: left;margin-left: 33px;")); ?>
                </div>
                <div class="lien-nav">
                    <ul>
                        <li><?php echo $this->Html->link('Accueil', array('controller' => 'users', 'action' => 'accueil')); ?></li>
                        <li><?php echo $this->Html->link('Aide Utilisateur', array('controller' => 'users', 'action' => 'apropos')); ?></li>
                        <li><?php echo $this->Html->link('Cadeaux', array('controller' => 'cadeauxs', 'action' => 'liste')); ?></li>
                        <li><?php echo $this->Html->link('Communauté', array('controller' => 'users', 'action' => 'communaute')); ?></li>
                        <li><?php echo $this->Html->link('Annonceur', array('controller' => 'users', 'action' => 'annonceur')); ?></li>
                        <li><?php echo $this->Html->link('Contactez-nous', array('controller' => 'contacts', 'action' => 'index')); ?></li>
                    </ul>
                </div>
                <div class="telecharge">
                    <a href="https://play.google.com/store/apps/details?id=ma.icoz.MyBlan" target="_blank" rel="nofollow"><?php echo $this->Html->image('pack-android.png',array('width'=>"93px", 'height'=>"90px" ,'style'=>"float: left;margin-left: 43px;")); ?></a>
                    <a href="#"><?php echo $this->Html->image('pack-apple.png',array('width'=>"94px", 'height'=>"96px" ,'style'=>"float: left;margin-left: 43px;margin-top: 2px;")); ?></a>
                </div>
                <div class="sociaux">
                    <a href="https://www.facebook.com/MyBlan" target="_blank" rel="nofollow">
                        <?php echo $this->Html->image('fb-logo.png',array('width'=>"94px", 'height'=>"96px" ,'style'=>"float: left;margin-left: 43px;")); ?>
                    </a>
                </div>
                <div class="info">    
                    <div class="ferst">
                        <?php echo $this->Html->link('Conditions générales', array('controller' => 'users', 'action' => 'conditions')); ?><b>|</b>
                        <?php echo $this->Html->link('Politique de confidentialité', array('controller' => 'users', 'action' => 'conditions')); ?><b>|</b>
                        <?php echo $this->Html->link('Contactez nous', array('controller' => 'contacts', 'action' => 'index')); ?>
                    </div>
                    <div class="last">
                        <strong>
                            <span>Copyright © 2014 MyBlan</span> By
                            <a href="http://www.myblan.com">MyBlan.com</a>
                        </strong>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>

