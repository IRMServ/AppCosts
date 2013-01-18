<?php
$useragent = $_SERVER['HTTP_USER_AGENT'];
include('includes/connection.php');
if (isset($_GET['fornecedor'])) {
    $fornecedorId = (int) $_GET['fornecedor'];
    $q = $conn->query("select c.*,f.*,sum(c.valor) as custo from custos as c,fornecedor as f where c.fornecedor_fk={$fornecedorId} and f.idFornecedor={$fornecedorId} group by month(c.vencimento)");
    $pagamento = array();
    $valor = array();
    $custo = array();
    $i = 0;
    while ($r = $q->fetch_object()) {
        $fornecedornome = $r->fornecedornome;
        $pagamento[] = implode('/', array_reverse(explode('-', $r->vencimento)));

        $valor[] = $r->custo;
        $i++;
    }
    $pag = array();
    foreach ($pagamento as $paga) {
        $pag[] = "'{$paga}'";
    }
    $paga = implode(',', $pag);
    $seriey = '{name:"' . $fornecedornome . '",data:[' . implode(',', $valor) . ']}';
}
if (isset($_GET['categoria'])) {
    $prop = array();
    $categoriaId = (int) $_GET['categoria'];


    if ($categoriaId == 3) {

        $fornecedor = array();
        $fornecedor[] = 'NQT';
        $fornecedor[] = 'GigaLink';

        //// nqt
        $cus = $conn->query("select c.*,f.*,sum(c.valor) as custo from custos as c,fornecedor as f where c.fornecedor_fk=
                (select idFornecedor from fornecedor where fornecedornome = 'NQT') and f.idFornecedor=(select idFornecedor from fornecedor where fornecedornome = 'NQT') group by month(c.vencimento)");
        $pagamento = array();
        $valor = array();
        $custo = array();
        $i = 0;
        while ($r = $cus->fetch_object()) {

            $pagamento[] = implode('/', array_reverse(explode('-', $r->vencimento)));

            $valornqt[] = $r->custo;
            $i++;
        }
        $pagnqt = array();
        foreach ($pagamento as $paga) {
            $pagnqt[] = "'{$paga}'";
        }

        $paganqt = implode(',', $pagnqt);
        $custonqt = implode(',', $valor);
        $propnqt = implode(',', $pagnqt);
        $propnqt = implode(',', $valor);



        ////// ipnet
        $cus = $conn->query("select c.*,f.*,sum(c.valor) as custo from custos as c,fornecedor as f where c.fornecedor_fk=
                (select idFornecedor from fornecedor where fornecedornome = 'IPNET') and f.idFornecedor=(select idFornecedor from fornecedor where fornecedornome = 'IPNET') group by month(c.vencimento)");
        $pagamento = array();
        $valor = array();
        $custo = array();
        $i = 0;
        while ($r = $cus->fetch_object()) {

            $pagamento[] = implode('/', array_reverse(explode('-', $r->vencimento)));

            $valoripnet[] = $r->custo;
            $i++;
        }
        $pagipnet = array();
        foreach ($pagamento as $paga) {
            $pagipnet[] = "'{$paga}'";
        }

        $pagaipnet = implode(',', $pagipnet);
        $custoipnet = implode(',', $valor);
        $propipnet = implode(',', $pagipnet);
        $propipnet = implode(',', $valor);


        ////// gigalink
        $cus = $conn->query("select c.*,f.*,sum(c.valor) as custo from custos as c,fornecedor as f where c.fornecedor_fk=
                (select idFornecedor from fornecedor where fornecedornome = 'GigaLink') and f.idFornecedor=(select idFornecedor from fornecedor where fornecedornome = 'GigaLink') group by month(c.vencimento)");
        $pagamento = array();
        $valor = array();
        $custo = array();
        $i = 0;
        while ($r = $cus->fetch_object()) {

            $pagamento[] = implode('/', array_reverse(explode('-', $r->vencimento)));

            $valor[] = $r->custo;
            $i++;
        }
        $paggiga = array();
        foreach ($pagamento as $paga) {
            $paggiga[] = "'{$paga}'";
        }

        $pagagiga = implode(',', $paggiga);
        $custogiga = implode(',', $valor);
        $propgiga = implode(',', $paggiga);
        $propgiga = implode(',', $valor);
        $totalgiga = array_sum($valor);





        ///////////////////////////////////////////////////////////////////////////////////




        for ($hg = 0; $hg < count($valoripnet); $hg++) {


            $valornqt[$hg] = $valornqt[$hg] + $valoripnet[$hg];
        }
        $paganqt = implode(',', $valornqt);

        $fornecedornome = implode(',', $fornecedor);
        $seriey = array();

        $totalnqt = array_sum($valornqt);


        $total = "[\n{\nname:'GigaLink',\ny:{$totalgiga}},\n{\nname:'NQT',\ny:{$totalnqt}}]";
        $seriey [] = "{\ntype:'line',\nname:'NQT',\ndata:[{$paganqt}]}\n";

        $seriey [] = "{\ntype:'line',\nname:'GigaLink',\ndata:[{$propgiga}]}\n";

        $seriey [] = "{\ntype:'pie',\nname:'Comparação',\ndata:{$total}, center: [100, 80],
                                size: 100,showInLegend: true,
                                dataLabels: {
                                    enabled: true,
                                    formatter: function() {
                                            return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage,2)+' %';
                                        }
                                }}\n";
        $seriey = implode(",\n", $seriey);
    } else {
        $total = array();
        $q = $conn->query("select cc.*,f.* from fornecedor as f,categoriacustos as cc where f.categoriacusto_fk={$categoriaId} and cc.idCategoriaCustos={$categoriaId}");
        $fornecedor = array();
        while ($c = $q->fetch_object()) {

            $fornecedor['nome'][] = "'{$c->fornecedornome}'";
            $cus = $conn->query("select c.*,f.*,sum(c.valor) as custo from custos as c,fornecedor as f where c.fornecedor_fk={$c->idFornecedor} and f.idFornecedor={$c->idFornecedor} group by month(c.vencimento)");
            $pagamento = array();
            $valor = array();
            $custo = array();
            $i = 0;
            while ($r = $cus->fetch_object()) {

                $pagamento[] = implode('/', array_reverse(explode('-', $r->vencimento)));

                $valor[] = $r->custo;
                $i++;
            }
            $pag = array();
            foreach ($pagamento as $paga) {
                $pag[] = "'{$paga}'";
            }
            $paga = array();
            $paga = implode(',', $pag);
            $custo = implode(',', $valor);
            $prop['pag'][] = implode(',', $pag);
            $prop['valor'][] = implode(',', $valor);
            $total[] = "{name:'{$c->fornecedornome}',y:" . array_sum($valor) . '}';
            $fornecedornome = implode(',', $fornecedor['nome']);
        }


        $seriey = array();
        for ($i = 0; $i < count($fornecedor['nome']); $i++) {
            $nomef = $fornecedor['nome'][$i];
            $seriey [] = "{type:'line',name:{$nomef},data:[{$prop['valor'][$i]}]}\n";
        }
        $total = '[' . implode(',', $total) . ']';
        $seriey [] = "{\ntype:'pie',allowPointSelect: true,\nname:'Comparação',\ndata:{$total}, center: [100, 80],
                                size: 100,showInLegend: true,
                                tooltip: {
                                
                                pointFormat: '{series.name}: <b>{Highcharts.numberFormat(point.percentage,2,\".\",\",\")}%</b>',
                                percentageDecimals: 1
                            },
                                dataLabels: {
                                    enabled: true,
                                     percentageDecimals: 1,
                                      pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                                    formatter: function() {
                                            return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage,2) +' %';
                                        }
                                }}\n";
        $seriey = implode(',', $seriey);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title>IRMSERV - Costs Admin</title>
        <script src="js/jquery.min.js?<?php echo date('His') ?>"></script>
        <?php
        $mobile = explode('Mobile', $useragent);

//if (count($mobile) > 1):
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=yes"> 

        <script src="js/jquery.min.js" type="text/javascript"></script>


        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="default" />
        <link rel="apple-touch-startup-image"   media="screen, mobile" href="images/splash.png" />
        <link rel="apple-touch-icon-precomposed" href="images/icon.png"/>
        <meta name="HandheldFriendly" content="true">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="MobileOptimized" content="width">
        <meta http-equiv="Pragma" content="no-cache"> 
        <meta http-equiv="cache-control" content="no-cache">
        <link rel="stylesheet" type="text/css" href="css/style.css"/>


        <?php
//  endif;
        ?>



    </head> 
    <body> 

        <div data-role="page">

            <div data-role="header">
                <h1>IRMSERV - Costs Admin</h1>

                <div data-role="navbar">
                    <ul>
                        <li><a href="index.php" data-icon="grid" data-iconpos="top">Charts</a></li>
                        <li><a href="#">Two</a></li>
                    </ul>
                </div><!-- /navbar -->

            </div><!-- /header -->

            <div id="content" data-role="content">	
                <script src="js/highcharts.js?<?php echo date('His') ?>" type="text/javascript"></script>
                <script>
                    $(function(){
                                  
                        var chart = new Highcharts.Chart({
                            chart: {
                                renderTo: 'grafico',
                              
                                marginRight: 130,
                                marginBottom: 35
                            },
                            credits:{
                                enabled:true
                            },
                            title: {
                                text: " Year costs ",
                                x: -20 //center
                            },
                                            
                            xAxis: {
                                categories: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
                                    'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                
                    
                                labels:{
                                    rotation:90
                                }
                            },
                            yAxis: {
                                title: {
                                    text: 'R$'
                                }, 
                                 
                                plotLines: [{
                                        value: 0,
                                        width: 1,
                                        color: '#808080'
                                    }]
                            },
                            tooltip: {
                                shared: true,
                                crosshairs: true
                            },
                            
                            legend: {
                                layout: 'vertical',
                                align: 'right',
                                verticalAlign: 'top',
                                x: -10,
                                y: 100,
                                borderWidth: 0
                            },
                            series: [<?php echo $seriey; ?>]
                           
                        });
                                  
                                        
                    });
                
          
          
                </script>
                <div id="grafico"></div>
            </div><!-- /content -->

            <div data-role="footer" class="ui-bar">
                <a href="index.php" data-role="button" data-icon="arrow-l">Back</a>

            </div>
        </div><!-- /page -->

        <script>
          
        </script>


    </body>
</html>