<?php
$useragent = $_SERVER['HTTP_USER_AGENT'];
include('includes/connection.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>IRMSERV - Costs Admin</title>
        <?php
        $mobile = explode('Mobile', $useragent);

//        if (count($mobile) > 1):
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=yes"> 
      
        <script src="js/jquery.min.js" type="text/javascript"></script>
 
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="default" />
        <link rel="apple-touch-startup-image"  sizes="768×1024"  media="screen, mobile" href="images/splash.png" />
        <link rel="apple-touch-icon-precomposed" href="images/icon2.png"/>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <meta name="HandheldFriendly" content="true">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="MobileOptimized" content="width">

        <?php
//        endif;
        ?>


        <link rel="stylesheet" href="css/irm-main.css">
        <link rel="stylesheet" href="css/irm-login.css">
    </head> 
    <body> 

        <div data-role="page">

            <div data-role="header">
                <h1>IRMSERV - Costs Admin</h1>

                <div data-role="navbar">
                    <ul>
                        <li><a href="index.php" data-icon="grid" data-iconpos="top">Charts</a></li>
                        <li><a href="b.html" data-icon="category" data-iconpos="top">Category</a></li>
                        <li><a href="b.html" data-icon="star" data-iconpos="top">Provider</a></li>
                        <li><a href="custos-list.php" data-icon="costs" data-iconpos="top">Costs</a></li>
                    </ul>
                </div><!-- /navbar -->

            </div><!-- /header -->

            <div id="content" data-role="content">	

                <div data-role="collapsible-set">
                    <?php
                    $q = $conn->query('select * from CategoriaCustos');
                    while ($r = $q->fetch_object()):
                        ?>
                        <div data-role="collapsible">
                            <h3><?php echo $r->categorianome; ?></h3>
<div class="ui-block-b mais"> <a  href="grafico.php?categoria=<?php echo $r->idCategoriaCustos?>" data-icon="grid" data-iconpos="left" data-role="button">Chart</a></div>
                            <ol data-role="listview">
                                <?php
                                $q2 = $conn->query("select * from fornecedor where categoriacusto_fk= {$r->idCategoriaCustos}");
                                while ($r2 = $q2->fetch_object()):
                                    ?>
                                    <li><div class="ui-grid-a">
                                            <div class="ui-block-a" data-theme="a">  <?php echo $r2->fornecedornome ?></div>
                                            <div class="ui-block-b"> <a  href="grafico.php?fornecedor=<?php echo $r2->idFornecedor?>" data-icon="grid" data-iconpos="left" data-role="button">Chart</a></div>
                                        </div>
                                    </li>
                                    <?php
                                endwhile;
                                ?>
                            </ol>
                        </div>


                        <?php
                    endwhile;
                    ?>
                </div>

            </div><!-- /content -->
            <div id="content2" data-role="content">	

            </div><!-- /content -->
            <div data-role="footer" class="ui-bar">

            </div>
        </div><!-- /page -->
        <script type="text/javascript">

            var addToHomeConfig = {
                startDelay: 0,
                touchIcon: true
            };
           

        </script>

        <link rel="stylesheet" href="css/add2home.css">
        <script type="application/javascript" src="js/add2home.js" charset="utf-8"></script>

    </body>
</html>