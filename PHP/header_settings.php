

<!-- Navigation -->
<!-- Ce header permet d'obtenir le chapeau en haut de la page web, spécifique au paramètres. -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="padding:0px">
        <div class="container">
        
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
   <!-- Après avoir inclus les classes nav, on importe le logo de l'application -->
     <img class="logo" src="../../images/logo_PEPS_final.jpg" style="width:25%;"/>

                <ul class="nav navbar-nav navbar-right">
                    <li>
                            <!-- Inclusion des divers icones ainsi que leur liens : paramètres, accueil et déconnexion -->
                        <a href="../../PHP/Settings/Settings.php">
                            <span class="glyphicon glyphicon-cog text-center"></span>
                        </a>
                    </li>
                    <li>
                        <a href="../../PHP/Accueil_liste.php">
                            <span class="glyphicon glyphicon-home text-center"></span>
                        </a>
                    </li>
                    <li class="dropdown">
                    <li>
                        <a href="../../PHP/deconnexion.php" onclick="return confirm('Etes-vous sûr de vouloir vous déconnecter ?');">
                            <span class="glyphicon glyphicon-off text-center"></span>
                        </a>
                    </li>
                </ul>

            </div>
            <!-- /.navbar-collapse -->
        </div>

       
        <!-- /.container -->
        
    </nav>
    <br/>

