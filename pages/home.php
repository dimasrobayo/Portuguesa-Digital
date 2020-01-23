<!-- Morris Charts CSS -->
<link href="vendor/morrisjs/morris.css" rel="stylesheet">
 <!-- jQuery -->
<script src="vendor/jquery/jquery.min.js"></script>
<!-- Morris Charts JavaScript -->
<script src="vendor/raphael/raphael.min.js"></script>
<script src="vendor/morrisjs/morris.min.js"></script>

<?php
    if(!defined('INCLUDE_CHECK')){
        echo ('<div align="center"><img  src="images/acceso.png" width="237" height="206"/> <br /> No est&aacute; autorizado para realizar esta acci&oacute;n o entrar en esta P&aacute;gina </div>');
        //die('Usted no está autorizado a ejecutar este archivo directamente');
        exit;
    }
?>

<?php
//Consulta para Estadisticas General de Ordenes
    $query="SELECT date_part('year',fecha_registro) as año, date_part('month',fecha_registro) as mes, COUNT( status_orden=1) as total_mensual, COUNT(case when status_orden=0 then 1 else null end) as total_registrada, COUNT(case when status_orden=1 then 1 else null end) as total_asignada, COUNT(case when status_orden=2 then 1 else null end) as total_concluida FROM ordenes group by date_part('year',fecha_registro), date_part('month', fecha_registro) order by 2,1 limit 12";
    $result_ordenes = pg_query($query)or die(pg_last_error()); 

    $chart_ordenes = '';

    while($row = pg_fetch_array($result_ordenes)){
        $chart_ordenes .= "{ period:'".$row["mes"]."' + '"."/"."' + '".$row["año"]."', TOTAL:".$row["total_mensual"].", REGISTRADAS:".$row["total_registrada"].", ASIGNADAS:".$row["total_asignada"].", CONCLUIDAS:".$row["total_concluida"]."}, ";
    }

    $chart_ordenes = substr($chart_ordenes, 0, -2);
    
?>

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

<script type="text/javascript">
$(function() {
    Morris.Bar({
        element: 'morris-chart-ordenes',
        data:[<?php echo $chart_ordenes; ?>],
        xkey: 'period',
        ykeys: ['TOTAL', 'REGISTRADAS', 'ASIGNADAS', 'CONCLUIDAS'],
        labels: ['TOTAL', 'REGISTRADAS', 'ASIGNADAS', 'CONCLUIDAS'],
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
                <i class="fa fa-bar-chart-o fa-fw"></i>GRAFICA DE EFICIENCIA DE GESTION GENERAL DE ATENCION
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="morris-area-chart"></div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i>GRAFICA DE EFICIENCIA GENERAL DE ORDENES
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="morris-chart-ordenes"></div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>

    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i>GRAFICA ESTADISTICA DE PUNTOS DE CUENTAS
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="morris-punto-cuenta"></div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
</div>