<!-- Morris Charts CSS -->
<link href="vendor/morrisjs/morris.css" rel="stylesheet">
 <!-- jQuery -->
<script src="vendor/jquery/jquery.min.js"></script>
<!-- Morris Charts JavaScript -->
<script src="vendor/raphael/raphael.min.js"></script>
<script src="vendor/morrisjs/morris.min.js"></script>

<?php
//Consulta para Estadisticas General de Ordenes
    $query_punto="SELECT date_part('year',fecha_punto) as año, date_part('month',fecha_punto) as mes, COUNT( decision=1) as total_aprobado, COUNT(case when decision=2 then 1 else null end) as total_negado, COUNT(case when decision=3 then 1 else null end) as total_diferido, COUNT(case when condicion=1 then 1 else null end) as total_pendientes FROM punto_cuenta group by date_part('year',fecha_punto), date_part('month', fecha_punto) order by 2,1 limit 12";
    $result_punto_cuenta = pg_query($query_punto)or die(pg_last_error()); 

    $chart_punto_cuenta = '';

    while($row = pg_fetch_array($result_punto_cuenta)){
        $chart_punto_cuenta .= "{ period:'".$row["mes"]."' + '"."/"."' + '".$row["año"]."', APROBADOS:".$row["total_aprobado"].", NEGADOS:".$row["total_negado"].", DIFERIDOS:".$row["total_diferido"]."}, ";
    }

    $chart_punto_cuenta = substr($chart_punto_cuenta, 0, -2);
    
?>

<script type="text/javascript">
$(function() {
    Morris.Bar({
        element: 'morris-punto-cuenta',
        data:[<?php echo $chart_punto_cuenta; ?>],
        xkey: 'period',
        ykeys: ['APROBADOS', 'NEGADOS', 'DIFERIDOS'],
        labels: ['APROBADOS', 'NEGADOS', 'DIFERIDOS'],
        barColors: ["#0b62a4", "#ffea00", "#4da74d", "#f05314", "#ff0031"],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });
});
</script>

<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i>GRAFICA DE EFICIENCIA GENERAL DE PUNTO DE CUENTAS
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="morris-punto-cuenta"></div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <!-- /.row -->
</div>