<!-- Morris Charts CSS -->
<link href="vendor/morrisjs/morris.css" rel="stylesheet">
 <!-- jQuery -->
<script src="vendor/jquery/jquery.min.js"></script>
<!-- Morris Charts JavaScript -->
<script src="vendor/raphael/raphael.min.js"></script>
<script src="vendor/morrisjs/morris.min.js"></script>

<?php
//Consulta para Estadisticas de Atencion por Unidad
    $cedula_usuario = $_POST['cedula_usuario'];
    $query_usuario="SELECT date_part('year',fecha_registro) as año, date_part('month',fecha_registro) as mes, COUNT( status_orden=1) as total_mensual, COUNT(case when status_orden=0 then 1 else null end) as total_registrada, COUNT(case when status_orden=1 then 1 else null end) as total_asignada, COUNT(case when status_orden=2 then 1 else null end) as total_concluida FROM ordenes WHERE cedula_usuario_orden='$cedula_usuario' group by date_part('year',fecha_registro), date_part('month', fecha_registro) order by 2,1 limit 12";
    $result_usuario = pg_query($query_usuario)or die(pg_last_error()); 

    $chart_usuario = '';

    while($row = pg_fetch_array($result_usuario)){
        $chart_usuario .= "{ period:'".$row["mes"]."' + '"."/"."' + '".$row["año"]."', TOTAL:".$row["total_mensual"].", REGISTRADAS:".$row["total_registrada"].", ASIGNADAS:".$row["total_asignada"].", CONCLUIDAS:".$row["total_concluida"]."}, ";
    }

    $chart_usuario = substr($chart_usuario, 0, -2);
    
?>

<script type="text/javascript">
$(function() {
    Morris.Bar({
        element: 'morris-chart-usuario',
        data:[<?php echo $chart_usuario; ?>],
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
                <i class="fa fa-bar-chart-o fa-fw"></i>GRAFICA DE EFICIENCIA DE ORDENES POR USUARIO
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="morris-chart-usuario"></div>
            </div>
            <!-- /.panel-body -->
        </div>
    </div>
    <!-- /.row -->
</div>