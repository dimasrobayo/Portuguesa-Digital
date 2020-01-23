<?php 
    require("../conexion/aut_config.inc.php");
    $db_conexion=pg_connect("host=$sql_host dbname=$sql_db user=$sql_usuario password=$sql_pass");
    $cod_unidad=$_SESSION['cod_unidad'];
    $cedula=$_SESSION['id'];
    
//Consulta para Estadisticas de Atencion General
    $query="SELECT date_part('year',fecha_registro) as año, date_part('month',fecha_registro) as mes, COUNT(cod_estado_tramite) as total_mes, COUNT(case when cod_estado_tramite=1 then 1 else null end) as total_online, COUNT(case when cod_estado_tramite=6 then 1 else null end) as total_resultados, COUNT(case when cod_estado_tramite<>1 and cod_estado_tramite<>6 and cod_estado_tramite<>7 and cod_estado_tramite<>8 then 1 else null end) as total_pendientes, COUNT(case when cod_estado_tramite=7 or cod_estado_tramite=8 then 1 else null end) as total_cancelados FROM  ticket group by date_part('year',fecha_registro), date_part('month', fecha_registro) order by 2,1 limit 12";
    $result_total = pg_query($query)or die(pg_last_error()); 

    $chart_data = '';

    while($row = pg_fetch_array($result_total)){
        $chart_data .= "{ period:'".$row["mes"]."' + '"."/"."' + '".$row["año"]."', TOTAL:".$row["total_mes"].", ONLINE:".$row["total_online"].", RESUELTOS:".$row["total_resultados"].", PENDIENTES:".$row["total_pendientes"].", ANULADOS:".$row["total_cancelados"]."}, ";
    }

    $chart_data = substr($chart_data, 0, -2);


    $cod_unidad = $_POST['cod_unidad'];
    $query_unidad="SELECT date_part('year',ticket.fecha_registro) as año, date_part('month',ticket.fecha_registro) as mes, COUNT(ticket.cod_estado_tramite) as total_mes, COUNT(case when ticket.cod_estado_tramite=1 then 1 else null end) as total_online, COUNT(case when ticket.cod_estado_tramite=6 then 1 else null end) as total_resultados, COUNT(case when ticket.cod_estado_tramite<>1 and ticket.cod_estado_tramite<>6 and ticket.cod_estado_tramite<>7 and ticket.cod_estado_tramite<>8 then 1 else null end) as total_pendientes, COUNT(case when ticket.cod_estado_tramite=7 or ticket.cod_estado_tramite=8 then 1 else null end) as total_cancelados FROM detalles_ticket, ticket WHERE detalles_ticket.cod_ticket=ticket.cod_ticket and detalles_ticket.cod_unidad=1 group by date_part('year',ticket.fecha_registro), date_part('month', ticket.fecha_registro) order by 1,2";
    $result_unidad = pg_query($query_unidad)or die(pg_last_error()); 

    $chart_unidad = '';

    while($row = pg_fetch_array($result_unidad)){
        $chart_unidad .= "{ period:'".$row["mes"]."' + '"."/"."' + '".$row["año"]."', TOTAL:".$row["total_mes"].", ONLINE:".$row["total_online"].", RESUELTOS:".$row["total_resultados"].", PENDIENTES:".$row["total_pendientes"].", ANULADOS:".$row["total_cancelados"]."}, ";
    }

    $chart_unidad = substr($chart_unidad, 0, -2);
?>

$(function() {
    Morris.Bar({
        element: 'morris-area-chart',
        data:[<?php echo $chart_data; ?>],
        xkey: 'period',
        ykeys: ['TOTAL', 'ONLINE', 'RESUELTOS', 'PENDIENTES', 'ANULADOS'],
        labels: ['TOTAL', 'ONLINE', 'RESUELTOS', 'PENDIENTES', 'ANULADOS'],
        barColors: ["#0b62a4", "#ffea00", "#4da74d", "#f05314", "#ff0031"],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });
});
