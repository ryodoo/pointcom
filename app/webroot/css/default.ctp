<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
        <link href="/look/favicon.ico" type="image/x-icon" rel="shortcut icon"/>
        <link href="/look/favicon.ico" type="image/x-icon" rel="icon"/>

        <title>AddAnnonce</title>
        <!--style-->
        <?php
        echo $this->Html->css('jeux_1');
        echo $this->Html->css('flexslider');
        echo $this->Html->css('stylead_1');
        
        echo $this->Html->script('jquery.min');
        echo $this->Html->script('droppy');
        $name="a";
        if(AuthComponent::user('type_user')=='immo'||AuthComponent::user('type_user')=='')
            $name='immo';
        else if(AuthComponent::user('type_user')=='auto')
            $name='auto';
        else if(AuthComponent::user('type_user')=='emploi')
            $name='jobs';
        else if(AuthComponent::user('type_user')=='info')
            $name='info';
        if($name=='a')
        {
            if($this->Session->read('Name')=='immo')
                $name='immo';
            else if($this->Session->read('Name')=='auto')
                $name='auto';
            else if($this->Session->read('Name')=='jobs')
                $name='jobs';
            else if($this->Session->read('Name')=='info')
                $name='info';
        }
        echo $this->Html->script($name);
        
        ?>
    </head>
    <body>
        <!-- header -->
        <div class="header" align="center">
            <header>
                <div id="connect">
                    <?php $user=$this->requestAction("/users/getuser/"); ?>
                    <div class="connexion">
                        <?php if(empty($user))
                            echo $this->Html->link('Se Connecter', array('controller' => 'users','action' => 'login'));
                        ?>
                    </div>
                    <div class="inscription">
                        <?php if(!empty($user))
                            echo $this->Html->link('Déconnexion', array('controller' => 'users','action' => 'logout'));
                        else
                            echo $this->Html->link('S\'inscrire', array('controller' => 'users','action' => 'add'));
                        ?>
                    </div>
                </div>
                <?php if(!empty($user) ): 
                         if(AuthComponent::user('type_user')!='info' && AuthComponent::user('type_user')!='emploi'): ?>
                <div class="ca">
                    <p class="p1">Votre crédit : <?php echo $user['User']['credit']; ?></p>
                    <p class="p1">Crédit en cours : <?php echo $user['User']['creditencour'] ?></p>
                </div>
                <?php endif;endif; ?>
                <div id="logo">
                    <a href="http://addannonce.com" title="Addannonce">
                        <?php echo $this->Html->image("logo.png",array('width="100%" height="100%"')); ?>
                    </a>
                </div>
                <div id="navigation">
                    <ul>
                        <li>
                            <?= $this->Html->link('Home', array('controller' => 'pages','action' => 'home')); ?>
                        </li>
                        <li>
                            <?= $this->Html->link('Tester', array('controller' => 'users','action' => 'add')); ?>
                        </li>
                        <li>
                            <?= $this->Html->link('Prix & Plans', array('controller' => 'payements','action' => 'credit')); ?>
                        </li>
                        <li >
                            <?= $this->Html->link('Services', array('controller' => 'pages','action' => 'services')); ?>
                        </li>
                        <li >
                            <?= $this->Html->link('Contact', array('controller' => 'contacts','action' => 'add')); ?>
                        </li>
                    </ul>
                </div>
            </header>
        </div>

        <div class="main">
            <div id="content">
                    <?php if(!empty($user)):
                            if(AuthComponent::user('type_user')=='immo' || AuthComponent::user('type_user')==''): ?>
                
                    <ul class="nav droppy">
                        <li onmouseover="dropy()" onmouseout="dropy1()" >
                                <a href="#" class= 'has-subnav'>Mes annonces</a>
                            <ul id="drop" style="z-index: 1011;display:none;">
                                <li ><?php echo $this->Html->link('Ajouter', array('controller' => 'annonces','action' => 'add')); ?></li>
                                <li ><?php echo $this->Html->link('Liste', array('controller' => 'annonces','action' => 'index')); ?></li>
                            </ul>
                        </li>
                        <li onmouseover="dropy2()" onmouseout="dropy3()" >
                                <a href="#" class= 'has-subnav'>Mes comptes</a>
                            <ul id="drop1" style="z-index: 1011;display:none;">

                                <li ><?php echo $this->Html->link('Ajouter', array('controller' => 'comptes','action' => 'achat')); ?></li>
                                <li ><?php echo $this->Html->link('Liste', array('controller' => 'comptes','action' => 'index')); ?></li>
                            </ul>
                        </li>
                        <li>
                            <?php echo $this->Html->link('Publication Massive', array('controller' => 'envoies','action' => 'add')); ?>
                            <ul id="drop1" style="z-index: 1011;display:none;">
                                <li ><?php echo $this->Html->link('Publication Immo', array('controller' => 'envoies','action' => 'add')); ?></li>
                                <li ><?php echo $this->Html->link('Publication Emploi', array('controller' => 'emploienvoies','action' => 'add')); ?></li>
                                <li ><?php echo $this->Html->link('Liste', array('controller' => 'annonces','action' => 'index')); ?></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo $this->Html->url( array('controller' => 'icozims','action' => 'view')); ?>">Icozim
                                <b style="color: #FF1A1A;font-size:20px;">Beta</b>
                            </a>
                        </li>
                        <li><?php echo $this->Html->link('Mon compte', array('controller' => 'users','action' => 'view')); ?></li>
                    </ul>
                    <?php endif; ?>
                
                
                <?php if(AuthComponent::user('type_user')=='emploi'): ?>
                
                    <ul class="nav droppy">
                        <li onmouseover="dropy()" onmouseout="dropy1()" >
                                <?php echo $this->Html->link('Annonce', array('controller' => 'emploiannonces','action' => 'index'), array('class' => 'has-subnav')); ?>
                            <ul id="drop" style="z-index: 1011;display:none;">
                                <li ><?php echo $this->Html->link('Ajouter ', array('controller' => 'emploiannonces','action' => 'add')); ?></li>
                                <li ><?php echo $this->Html->link('Liste', array('controller' => 'emploiannonces','action' => 'index')); ?></li>
                            </ul>
                        </li>
                        <li>
                            <?php echo $this->Html->link('Publication Massive', array('controller' => 'emploienvoies','action' => 'add')); ?>
                        </li>
                        <li><?php echo $this->Html->link('Mon compte', array('controller' => 'users','action' => 'view')); ?></li>
                    </ul>
                    <?php endif; ?>
                
                
                
                <?php endif; ?>
                    <?php echo $this->Session->flash(); ?>
                    <?php echo $this->fetch('content'); ?>
            </div>

        </div>
        <div id="warp" ></div>
        <div id="footer">
            <div class="ft">
                <div id="logo_footer">
                    <a href="addannonce.com" title="Addannonce"></a>
                </div>
                <div class="info">

                    <div class="ferst">
                        <?php echo $this->Html->link('Conditions générales', array('controller'=>'pages','action' => 'conditions')); ?> <b>|</b>
                        <?php echo $this->Html->link('Politique de confidentialité', array('controller'=>'pages','action' => 'conditions')); ?> <b>|</b>
                        <?php echo $this->Html->link('Contactez-nous', array('controller' => 'contacts','action' => 'add')); ?>
                    </div>
                    <div class="last">
                        <strong>
                            <span>Copyright © 2013 Add Annonces</span>  , a division of
                            <a href="http://www.addannonce.com">addannonce</a></strong></div>
                </div>
            </div>
        </div>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-45166310-1', 'addannonce.com');
            ga('send', 'pageview');

        </script>
    </body>
</html>
<?php //echo $this->element('sql_dump'); ?>
