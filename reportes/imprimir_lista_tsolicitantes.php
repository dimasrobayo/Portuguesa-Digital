<?php
    include("fpdf17/conectar.php");
    include("fpdf17/funciones.php");
    require ("../funciones.php"); // llamado de funciones de la pagina

    $pdf=new PDF('P','mm','Letter');
    $pdf->AliasNbPages();
    $pdf->Open();
    $pdf->AddPage();
        
    $pdf->SetFont('Arial','B',16);
    $pdf->Image('./logo/logo.png',10,10,'40','','png','http://www.vpa.unellez.edu.ve');
    
    //$pdf->SetFillColor(200,220,255); //AZUL
    $pdf->SetFillColor(200,200,200);//GRIS
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.1);
    
    $pdf->SetFont('Arial','B',14);
    $pdf->SetLeftMargin(55);
    
    $pdf->SetY(20);
    $pdf->Cell(0,6,utf8_decode('LISTADO DE TIPOS DE SOLICITANTES'),0,0,'C',0);//
    
    $pdf->SetFontSize(9);
    $pdf->Line(10,38,206,38);
    $pdf->Ln(10);
    
    $pdf->SetLeftMargin(10);
    $pdf->SetX(10);
    $pdf->SetY(40);
    
    $query = "SELECT * FROM tipo_solicitantes order by cod_tipo_solicitante";
    $result_detalle = pg_query($query);
    $total_registros=  pg_num_rows($result_detalle);
    
    ///////////// FORMATO Y CABEZERA DE LA LISTA DE PERSONAL ///////////////////////////
    $pdf->SetFont('Times','B',11);
    $pdf->SetLeftMargin(10);

    $pdf->SetFillColor(200,220,255);	
    $pdf->SetFont('Times','B',10);	
    $pdf->SetWidths(array(20,176));	//196 total ancho
    $pdf->SetAligns(array('C','C'));    
    
    $fill = true;
    $pdf->fill("$fill");
    $pdf->Row(array(utf8_decode("ID"),utf8_decode("DESCRIPCIÓN")));
    $fill = false;
    $pdf->fill("$fill");
////////////////////////////////////////////////////////////////////////////////////
    while ($row = pg_fetch_array($result_detalle)){
        $pdf->SetFillColor(230,235,255);
        $pdf->SetFont('Times','',10);	
        $pdf->SetWidths(array(20,176));	//196 total ancho	
        $pdf->SetAligns(array('C','L'));
        $pdf->fill("$fill");
        
        $pdf->Row(array(utf8_decode($row[cod_tipo_solicitante]),utf8_decode($row['descripcion_tipo_solicitante'])));

    }  
    $pdf->Ln(1);
    $pdf->SetFont('Times','B',10);
    $pdf->Cell(0,6,utf8_decode('TOTAL REGISTROS IMPRESOS: '.$total_registros),0,0,'',0);//


    pg_close();
    $pdf->Output("catalogo_tsolicitantes.pdf","I");
?>
