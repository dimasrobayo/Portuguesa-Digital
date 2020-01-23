<!-- Morris Charts CSS -->
<link href="vendor/morrisjs/morris.css" rel="stylesheet">
 <!-- jQuery -->
<script src="vendor/jquery/jquery.min.js"></script>
<!-- Morris Charts JavaScript -->
<script src="vendor/raphael/raphael.min.js"></script>
<script src="vendor/morrisjs/morris.min.js"></script>

<?php
//Consulta para Estadisticas de Atencion por Unidad
    $cod_unidad = $_POST['cod_unidad'];
    $query_unidad="SELECT date_part('year',ticket.fecha_registro) as año, date_part('month',ticket.fecha_registro) as mes, COUNT(ticket.cod_estado_tramite) as total_mes, COUNT(case when ticket.cod_estado_tramite=1 then 1 else null end) as total_online, COUNT(case when ticket.cod_estado_tramite=6 then 1 else null end) as total_resultados, COUNT(case when ticket.cod_estado_tramite<>1 and ticket.cod_estado_tramite<>6 and ticket.cod_estado_tramite<>7 and ticket.cod_estado_tramite<>8 then 1 else null end) as total_pendientes, COUNT(case when ticket.cod_estado_tramite=7 or ticket.cod_estado_tramite=8 then 1 else null end) as total_cancelados FROM detalles_ticket, ticket WHERE detalles_ticket.cod_ticket=ticket.cod_ticket and detalles_ticket.cod_unidad=$cod_unidad group by date_part('year',ticket.fecha_registro), date_part('month', ticket.fecha_registro) order by 2,1 limit 12";
    $result_unidad = pg_query($query_unidad)or die(pg_last_error()); 

    $chart_unidad = '';

    while($row = pg_fetch_array($result_unidad)){
        $chart_unidad .= "{ period:'".$row["mes"]."' + '"."/"."' + '".$row["año"]."', TOTAL:".$row["total_mes"].", ONLINE:".$row["total_online"].", RESUELTOS:".$row["total_resultados"].", PENDIENTES:".$row["total_pendientes"].", ANULADOS:".$row["total_cancelados"]."}, ";
    }

    $chart_unidad = substr($chart_unidad, 0, -2);
    
?>

<script type="text/javascript">
$(function() {
    Morris.Bar({
        element: 'morris-chart-unidad',
        data:[<?php echo $chart_unidad; ?>],
        xkey: 'period',
        ykeys: ['TOTAL', 'ONLINE', 'RESUELTOS', 'PENDIENTES', 'ANULADOS'],
        labels: ['TOTAL', 'ONLINE', 'RESUELTOS', 'PENDIENTES', 'ANULADOS'],
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
                <i class="fa fa-bar-chart-o fa-fw"></i>GRAFICA DE EFICIENCIA DE GESTION POR UNIDAD
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="morris-chart-unidad"></div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <!-- /.row -->
</div>