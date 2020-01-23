<?php
    include("fpdf17/conectar.php");
    include("fpdf17/funciones.php");
    require ("../funciones.php"); // llamado de funciones de la pagina

    $pdf=new PDF('P','mm','Letter');
    $pdf->AliasNbPages();
    $pdf->Open();
    $pdf->AddPage();
        
    $pdf->SetFont('Arial','B',16);
    $pdf->Image('./logo/logo.jpg',10,10,'40','','jpg','http://www.estadoportuguesa.com.ve');
    
    //$pdf->SetFillColor(200,220,255); //AZUL
    $pdf->SetFillColor(200,200,200);//GRIS
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.1);
    
    $pdf->SetFont('Arial','B',14);
    $pdf->SetLeftMargin(55);
    
    $pdf->SetY(20);
    $pdf->Cell(0,6,utf8_decode('LISTADO DE ORDENES'),0,0,'C',0);//
    
    $pdf->SetFontSize(9);
    $pdf->Line(10,38,206,38);
    $pdf->Ln(10);
    
    $pdf->SetLeftMargin(10);
    $pdf->SetX(10);
    $pdf->SetY(40);
    
    $query = "SELECT * FROM ordenes, usuarios WHERE ordenes.cedula_usuario_orden = usuarios.cedula_usuario order by ordenes.id_orden";
    $result_detalle = pg_query($query);
    $total_registros=  pg_num_rows($result_detalle);
    
    ///////////// FORMATO Y CABEZERA DE LA LISTA DE PERSONAL ///////////////////////////
    $pdf->SetFont('Times','B',12);
    $pdf->SetLeftMargin(10);

    $pdf->SetFillColor(200,220,255);	
    $pdf->SetFont('Times','B',10);	
    $pdf->SetWidths(array(12,80,40,40,25));	//196 total ancho
    $pdf->SetAligns(array('C','C','C','C','C'));    
    
    $fill = true;
    $pdf->fill("$fill");
    $pdf->Row(array(utf8_decode("COD"),utf8_decode("DESCIPCION"),utf8_decode("ASIGNADA A"),utf8_decode("CULMINACIÒN"),utf8_decode("STATUS")));
    $fill = false;
    $pdf->fill("$fill");
////////////////////////////////////////////////////////////////////////////////////
    while ($row = pg_fetch_array($result_detalle)){
        $pdf->SetFillColor(230,235,255);
        $pdf->SetFont('Times','',10);	
        $pdf->SetWidths(array(12,80,40,40,25));	//196 total ancho	
        $pdf->SetAligns(array('C','C','C','L','L'));
        $pdf->fill("$fill");
        
        if($row['status_orden']==0){
            $status="REGISTRADO";
        }
        if($row['status_orden']==1){
            $status="ASIGNADA";
        }
        if($row['status_orden']==2){
            $status="CONCLUIDA";
        }
        if($row['status_orden']==3){
            $status="SIN RESPONDER";
        }

        $pdf->Row(array(utf8_decode($row[id_orden]),utf8_decode($row[descripcion_orden]),utf8_decode($row[nombre_usuario] ." " .$row[apellido_usuario]),utf8_decode($row[fecha_culminacion]),utf8_decode($status)));

    }  
    $pdf->Ln(1);
    $pdf->SetFont('Times','B',10);
    $pdf->Cell(0,6,utf8_decode('TOTAL REGISTROS IMPRESOS: '.$total_registros),0,0,'',0);//

    pg_close();
    $pdf->Output("catalogo_comunidades.pdf","I");
?>
