<?php
    include("fpdf17/conectar.php");
    include("fpdf17/funciones.php");
    require ("../funciones.php"); // llamado de funciones de la pagina
    
     //RECIBIENDO VALORES
    if (isset($_GET['id_estado_mayor'])){
        $id_estado_mayor=$_GET['id_estado_mayor'];
    }

    $pdf=new PDF('L','mm',array(200,500));
    $pdf->AliasNbPages();
    $pdf->Open();
    $pdf->AddPage();
        
    $pdf->SetFont('Arial','B',16);
    $pdf->Image('./logo/logo.jpg',10,10,'32','','jpg','http://www.portuguesa.gob.ve');
    

    //$pdf->SetFillColor(200,220,255); //AZUL
    $pdf->SetFillColor(200,200,200);//GRIS
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.1);

    $pdf->SetFont('Arial','B',14);
    $pdf->SetLeftMargin(110);
    $pdf->SetY(20);

    if ($resultados_ticket[cod_unidad]==5) {
        $pdf->Cell(110,6,utf8_decode('INFORME GENERAL DE ESTADO MAYOR'),0,0,'C',1);//
    }else{
        $pdf->Cell(110,6,utf8_decode('INFORME GENERAL DE ESTADO MAYOR'),0,0,'C',1);//
    }


    $pdf->SetFont('Times','B',9);
    $pdf->SetLeftMargin(10);
    $pdf->SetX(10);
    $pdf->SetY(38);

    $pdf->SetFillColor(7,50,164); 
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFont('Arial','B',10);  
    $pdf->SetWidths(array(40,60,60,30,40,35,30,30,30,40,40,35));  
    $pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C'));
    $fill = true;

    $pdf->Cell(160,6,utf8_decode('PLANIFICADO'),1,0,'C',1);
    $pdf->Cell(70,6,utf8_decode('POR CUMPLIR LO PLANTEADO'),1,0,'C',1);
    $pdf->Cell(125,6,utf8_decode('INDICADOR DE EFICACIA'),1,0,'C',1); 
    $pdf->Cell(115,6,utf8_decode('ESTIMACION RECURSOS FINANCIEROS'),1,1,'C',1);
    $pdf->fill("$fill");

    $pdf->SetFillColor(0,147,1);
    $pdf->Row(array(utf8_decode("ESTADO MAYOR"),utf8_decode("LO DISCUTIDO"),utf8_decode("POSIBLE SOLUCION"),utf8_decode("FECHA"),utf8_decode("RESPONSABLE"),utf8_decode("UNIDAD MEDIDA"),utf8_decode("PLANIFICADA"),utf8_decode("EJECUTADA"),utf8_decode("INDICADOR"),utf8_decode("BS ESTIMADOS"),utf8_decode("BS EJECUTADOS"),utf8_decode("INDICADOR")));

    $query="SELECT * FROM estado_mayor, em_planificacion, em_ejecutado, usuarios where estado_mayor.id_estado_mayor = em_planificacion.id_estado_mayor and em_ejecutado.id_planificacion = em_planificacion.id_planificacion and usuarios.id_estado_mayor = estado_mayor.id_estado_mayor and em_planificacion.status_planificacion = '1' and em_planificacion.id_estado_mayor = '$id_estado_mayor'  order by em_planificacion.id_planificacion DESC";
    $result_query = pg_query($query)or die(pg_last_error());
    
    $pdf->SetFillColor(255,255,255); 
    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial','B',10);  
    $pdf->SetWidths(array(40,60,60,30,40,35,30,30,30,40,40,35));  
    $pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C'));
    
    while ($row = pg_fetch_array($result_query))
    {
    //DATOS PRINCIPALES     
        $pdf->MultiCell(40,6,utf8_decode($row['nombre_estado_mayor']),1,FALSE);
        
        $pdf->MultiCell(60,6,utf8_decode($row['lo_discutido']),1,FALSE);
    };

    

    pg_close();
    $pdf->Output("ESTADO MAYOR-".$id_estado_mayor.".pdf","I");
?>
