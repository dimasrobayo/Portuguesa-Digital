<?php
    include("fpdf17/conectar.php");
    include("fpdf17/funciones.php");
    require ("../funciones.php"); // llamado de funciones de la pagina
    
     //RECIBIENDO VALORES
    if (isset($_GET['id_orden'])){
        $id_orden=$_GET['id_orden'];
    }

    $pdf=new PDF('P','mm','Letter');
    $pdf->AliasNbPages();
    $pdf->Open();
    $pdf->AddPage();
        
    $pdf->SetFont('Arial','B',16);
    $pdf->Image('./logo/logo.jpg',10,18,'42','','jpg','http://www.portuguesa.gob.ve');
    
    $query="SELECT * FROM ordenes, usuarios WHERE ordenes.cedula_usuario_orden = usuarios.cedula_usuario and ordenes.id_orden=$id_orden";
    $result = pg_query($query)or die(pg_last_error());
    $resultados_ticket=pg_fetch_array($result);	
    pg_free_result($result);

    $pdf->SetFillColor(255,255,255);//blanco
    $pdf->SetTextColor(0,0,0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.1);
    
    $pdf->SetFont('Arial','B',14);
    $pdf->SetLeftMargin(55);
    
    $pdf->SetY(15);
    $pdf->MultiCell(110,6,utf8_decode('ORDENES GIRADAS A CUMPLIR'),0,0,'C',1);//
    
    //$pdf->SetFillColor(200,220,255); //AZUL
    $pdf->SetFillColor(91,155,213);//GRIS
    $pdf->SetTextColor(0,0,0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.1);
    
    $pdf->SetFont('Times','B',9);
    $pdf->SetLeftMargin(175);
    $pdf->SetY(15);
    
    $pdf->Cell(0,4,utf8_decode('ORDEN NRO.'),1,1,'C',1);
    $pdf->SetFontSize(11);
    $pdf->Cell(0,5,utf8_decode(str_pad($resultados_ticket['id_orden'],10,"0",STR_PAD_LEFT)),1,1,'C',0);
    $pdf->Ln(1);
    $pdf->SetLeftMargin(112);
    $pdf->SetY(25);
    $pdf->SetFont('Times','B',9);
    $pdf->Cell(30,4,utf8_decode('FECHA REGISTRO'),1,1,'C',1);
    $pdf->SetFontSize(11);
    $pdf->Cell(30,5,utf8_decode(date_format(date_create($resultados_ticket['fecha_registro']), 'd/m/Y')),1,0,'C',0);
    $pdf->SetLeftMargin(143);
    $pdf->SetY(25);
    $pdf->SetFont('Times','B',9);
    $pdf->Cell(31,4,utf8_decode('FECHA VENC.'),1,1,'C',1);
    $pdf->SetFontSize(11);
    $pdf->Cell(31,5,utf8_decode(date_format(date_create($resultados_ticket['fecha_culminacion']), 'd/m/Y')),1,0,'C',0);
    $pdf->SetLeftMargin(175);
    $pdf->SetY(25);
    $pdf->SetFont('Times','B',9);
    $pdf->Cell(31,4,utf8_decode('FECHA EJECUCION'),1,1,'C',1);
    $pdf->SetFontSize(11);
    $pdf->Cell(31,5,utf8_decode(date_format(date_create($resultados_ticket['fecha_ejecucion']), 'd/m/Y')),1,0,'C',0); 

    $pdf->SetLeftMargin(10);
    $pdf->SetX(10);
    $pdf->SetY(38);
    
    ///////////// FORMATO Y CABEZERA DE LA LISTA DE PERSONAL ///////////////////////////
    $pdf->SetFont('Times','B',11);
    $pdf->SetLeftMargin(10);


    $pdf->SetFont('Times','B',9);
    $pdf->Cell(0,4,utf8_decode('DATOS ENCARGADO A CUMPLIR LA ORDEN'),1,1,'C',1);
    $pdf->Cell(30,4,utf8_decode('CI'),1,0,'C',0);
    $pdf->Cell(0,4,utf8_decode('NOMBRE DEL ENCARGADO'),1,0,'C',0);
    
    $pdf->Ln(1);
    $pdf->SetY(46);
    $pdf->SetFontSize(12);
    $pdf->SetFont('');
    $pdf->Cell(30,8,utf8_decode(substr_replace($resultados_ticket['cedula_usuario'],'-',1,0)),1,0,'C',0);
    $pdf->Cell(0,8,utf8_decode($resultados_ticket['nombre_usuario']." ".$resultados_ticket['apellido_usuario']),1,0,'L',0);
    
    $pdf->SetY(54);
    $pdf->Ln(1);
    $pdf->SetFontSize(10);
    $pdf->SetFont('','B');
    $pdf->Cell(0,4,utf8_decode('DESCRIPCION'),1,1,'L',1);
    $pdf->Cell(0,60,'',1,1,'C',0);
    
    $pdf->SetY(60);
    $pdf->SetFontSize(10);
    $pdf->SetFont('');
    $pdf->MultiCell(0, 4, utf8_decode($resultados_ticket['descripcion_orden']),0, 'J',0,5);

    $pdf->SetY(119);
    $pdf->Ln(1);
    $pdf->SetFontSize(10);
    $pdf->SetFont('','B');
    $pdf->Cell(0,5,utf8_decode('PRIORIDAD'),1,1,'L',1);
    if($resultados_ticket['prioridad']==1) $decision='NORMAL'; elseif($resultados_ticket['prioridad']==2) $decision='ALTA'; else $decision='URGENTE';
    $pdf->Cell(0,5,utf8_decode($decision),1,0,'C',0,5);

    $pdf->SetY(130);
    $pdf->Ln(1);
    $pdf->SetFontSize(10);
    $pdf->SetFont('','B');
    $pdf->Cell(0,5,utf8_decode('STATUS DE LA ORDEN'),1,1,'L',1);

    if($resultados_ticket['status_orden']==1) $decision='APROBADO'; elseif($resultados_ticket['status_orden']==2) $decision='NEGADO'; else $decision='DIFERIDO';
    $pdf->Cell(0,5,utf8_decode($decision),1,0,'C',0,5);
        
    $pdf->SetY(141);
    $pdf->Ln(1);
    $pdf->SetFontSize(10);
    $pdf->SetFont('','B');
    $pdf->Cell(0,4,utf8_decode('ACCION TOMADA'),1,1,'L',1);
    $pdf->Cell(0,80,'',1,1,'C',0);
    $pdf->SetFillColor(255,255,255);//blanco

    $pdf->SetY(232);
    $pdf->Ln(1);
    $pdf->SetFontSize(10);
    $pdf->SetFont('','B');
    $pdf->MultiCell(0,6,utf8_decode('Nota: El presentante será responsable que el Punto de Cuenta aprobado se ajuste a la normativa legal y reglamentaria aplicable; y que cuenta con la debida disponibilidad presupuestaria de ser el caso.'),1,1,'J',0);
    pg_close();
    $pdf->Output("PC-".$id_punto.".pdf","I");
?>
