<?php
    include("fpdf17/conectar.php");
    include("fpdf17/funciones.php");
    require ("../funciones.php"); // llamado de funciones de la pagina
       
    $pdf=new PDF('L','mm','Letter');
    $pdf->AliasNbPages();
    $pdf->Open();
    $pdf->AddPage();
        
    $pdf->SetFont('Arial','B',16);
    $pdf->Image('./logo/logo.jpg',10,10,'32','','jpg','http://www.portuguesa.gob.ve');
    $pdf->Image('./logo/logo_busportuguesa.png',200,10,'70','','png','http://busportuguesa.com.ve/');
    $pdf->Image('./logo/logo_proveduria_busportuguesa.png',210,20,'50','','png','http://busportuguesa.com.ve/');
    
    //$pdf->SetFillColor(200,220,255); //AZUL
    $pdf->SetFillColor(200,200,200);//GRIS
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.1);
    
    $pdf->SetFont('Arial','B',14);
    $pdf->SetLeftMargin(55);
    
    $pdf->SetY(20);
    $pdf->Cell(150,6,utf8_decode('LISTADO DE TICKES PENDIENTES'),0,1,'C',0);//
    
    
//    $pdf->SetY(32);
//    $pdf->SetFont('Times','B',12);
//    $pdf->MultiCell(0,6,'FECHA DESDE '.implode('/',array_reverse(explode('-',$fecha_ini))).' HASTA '.implode('/',array_reverse(explode('-',$fecha_fin))),0,'R',0);//
//    
    $pdf->SetFontSize(9);
    $pdf->Line(10,38,269,38);
    $pdf->Ln(15);
    
    $pdf->SetLeftMargin(10);
    $pdf->SetX(10);
    $pdf->SetY(40);
    
    
    $query="SELECT * FROM ticket,tramites,solicitantes,estados_tramites,unidades". 
            " WHERE ticket.cod_estado_tramite=estados_tramites.cod_estado_tramite AND ticket.cedula_rif=solicitantes.cedula_rif ".
            " AND ticket.cod_tramite=tramites.cod_tramite AND tramites.cod_unidad=unidades.cod_unidad AND ticket.cod_estado_tramite<6 order by cod_ticket";
    $result_ticket = pg_query($query);
    $total_registros_ticket=  pg_num_rows($result_ticket);
            
    
    ///////////// FORMATO Y CABEZERA DE LA LISTA DE PERSONAL ///////////////////////////
    $pdf->SetFont('Times','B',11);
    $pdf->SetLeftMargin(10);
            
    $pdf->SetFillColor(200,220,255);	
    $pdf->SetFont('Times','B',7);	
    $pdf->SetWidths(array(12,15,65,20,20,20,62,10,15,20));	//336 total ancho PAGINA HORIZONTAL
    $pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C'));    

    $fill = true;
    $pdf->fill("$fill");
    $pdf->Row(array(utf8_decode("TICKET"),utf8_decode("FECHA"),utf8_decode("NOMBRE DEL SOLICITANTE"),utf8_decode("NRO/FACT"),utf8_decode("CELULAR"),utf8_decode("TRAMITE"),utf8_decode("DESCRIPCIÓN DEL TICKET"),utf8_decode("CANT"),utf8_decode("MONTO"),utf8_decode("STATUS")));
    $fill = false;
    $pdf->fill("$fill");
    $fila=1;
            
    $num=0;
    if ($total_registros_ticket!=0){
            
        ////////////////////////////////////////////////////////////////////////////////////
            while ($row_ticket = pg_fetch_array($result_ticket)){
                $num++;
                $pdf->SetFillColor(230,235,255);
                $pdf->SetFont('Times','',6);	
                $pdf->SetWidths(array(12,15,65,20,20,20,62,10,15,20));	//196 total ancho	
                $pdf->SetAligns(array('C','C','L','C','C','C','L','C','C','C'));
                $pdf->fill("$fill");
                
                if($row_ticket['tipo_estado_tramite']=="1") {
                    $status_ticket="PENDIENTE";
                }elseif($row_ticket['tipo_estado_tramite']=="2") {
                    $status_ticket="COMPLETADO";
                }else{
                    $status_ticket="CANCELADO";
                }

                $pdf->Row(array(utf8_decode(str_pad($row_ticket['cod_ticket'],8,"0",STR_PAD_LEFT)),utf8_decode(date_format(date_create($row_ticket['fecha_registro_ticket']), 'd/m/Y')),  utf8_decode($row_ticket[cedula_rif].' - '.$row_ticket['nombre_solicitante']),str_pad($row_ticket['n_factura'],8,"0",STR_PAD_LEFT),$row_ticket[telefono_movil],utf8_decode($row_ticket['nombre_tramite']),utf8_decode($row_ticket['descripcion_ticket']),$row_ticket[cantidad_solicitud],$row_ticket[monto_solicitud],utf8_decode($row_ticket['siglas_estado_tramite'].'-'.$status_ticket)));
            }
            $pdf->Ln(2);
            $pdf->SetFont('Times','B',9);
            $pdf->Cell(0,5,utf8_decode('TOTAL DE TAC: '.$total_registros_ticket),1,1,'L',0);//
            
            $pdf->Ln(2);
    }else{
        $pdf->SetFont('Times','',9);
        $pdf->Cell(0,5,utf8_decode('NO SE ENCONTRARON REGISTROS'),1,1,'C',0);//
        $pdf->Ln();
    }
    
    pg_close();
    $pdf->Output("listado_tac_fecha.pdf","I");
?>
