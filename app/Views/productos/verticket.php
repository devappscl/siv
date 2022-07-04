<?php

              
 
        $pdf = new FPDF('P','mm',array(80,210));
        $pdf->AddPage();
        $pdf->SetAutoPageBreak('auto',10);
        $pdf->SetTitle("Ticket");
        $pdf->SetMargins(5,5,5,5);

        $pdf->Rect(5, 3, 71, 22);
        $pdf->SetXY(5,5);
	    $pdf->SetFont('Helvetica', 'B', 10);
	    $pdf->Multicell(70, 4, utf8_decode($sucursal['nombre']) , 0,'C',0);

        $pdf->SetXY(0,15);
	    $pdf->SetFont('Helvetica', '', 8);
	    $pdf->Multicell(80, 4, utf8_decode("TOLINDOR VALDEBENITO 1092 | FREIRE 466"), 0,'C');
	    $pdf->Multicell(70, 4, utf8_decode("+56988935072 | +56930167161"), 0,'C');

        $pdf->SetXY(5,26);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(70, 4, utf8_decode(NombreProveedor($proveedor)), 0,'C', 0);
        

        $pdf->Ln(1);

         //table header
         $pdf->setFont("Arial","B",9);
         $pdf->SetXY(5,33);
         $pdf->Cell(12, 4, "CANT.", 0, 0, "L", 0);  
         $pdf->Cell(35, 4, "NOMBRE", 0, 0, "L", 0);
         $pdf->Cell(20, 4, "SOLICITAR", 0, 1, "L", 0);
         $pdf->Cell(70, 2, '======================================', 0,1,'C');
         $pdf->SetFont('Arial', '', 8);

        
        foreach($productos as $row){

           $y = $pdf->GetY(); // Guardamos la coord Y donde COMIENZA la linea
           $pdf->setFont("Arial","B",9);
            $pdf-> cell(12,6,$row['cantidad'],0,0,'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf-> Multicell(38,6,utf8_decode($row['nombre']) . " (*-" . ComprobarSalida($row["id"]) . ")",0,'L',0);
            $yFin = $pdf->GetY(); // Guardamos la coord Y donde TERMINA la linea
           
            $pdf->line(5,$yFin,75,$yFin);
            $pdf->SetY($yFin); // Pisamos la coord Y con el valor donde TERMINA la linea

            
            
            if($yFin > 185){
                $pdf->AddPage();
                //table header
                $pdf->setFont("Arial","B",9);
                $pdf->Cell(12, 4, "CANT.", 0, 0, "L", 0);  
                $pdf->Cell(35, 4, "NOMBRE", 0, 0, "L", 0);
                $pdf->Cell(20, 4, "SOLICITAR", 0, 1, "L", 0);
                $pdf->Cell(70, 2, '======================================', 0,1,'C');
                $pdf->SetFont('Arial', '', 8);
            }

            

           

        }

            

        $pdf->Ln(2);
	    $pdf->SetFont('Arial', '', 8);
      

       
       
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(70, 4, utf8_decode("RECUERDE INGRESAR EL DÍA DE LLEGADA DEL PEDIDO Y EL TOTAL."), 0,'C', 0);

        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', );
        $pdf->Multicell(70, 4, utf8_decode("(*) Cantidad de productos vendidos los últimos 7 días."), 0,'C', 0);

        
	
        $pdf->Output( $proveedor.'.pdf','I');
        exit; 

       /* $pdf = new FPDF('P','mm',array(80, 300));
        $pdf->AddPage();
        $pdf->SetAutoPageBreak('auto',10);
        $pdf->SetTitle("Ticket");
        $pdf->SetMargins(5,5,5,5);

        $pdf->Rect(5, 3, 71, 19);
        $pdf->SetXY(5,5);
	    $pdf->SetFont('Helvetica', 'B', 10);
	    $pdf->Multicell(70, 4, utf8_decode($sucursal['nombre']) , 0,'C',0);

        $pdf->SetXY(0,13);
	    $pdf->SetFont('Helvetica', '', 8);
	    $pdf->Multicell(70, 3, utf8_decode("TOLINDOR VALDEBENITO 1092 | FREIRE 466"), 0,'C', 0);
	    $pdf->Multicell(70, 3, utf8_decode("+56988935072 | +56930167161"), 0,'C', 0);

        
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(70, 4, utf8_decode(NombreProveedor($proveedor)), 0,'C', 0);
        $pdf->Cell(70, 4, '=========================================', 0,1,'C');

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 3, utf8_decode('PRODUCTO'), 0,0,'L');
        $pdf->Cell(14, 3, 'STOCK', 0,0,'L');
        $pdf->Cell(14, 3, 'SOLICITAR', 0,1,'L');

        $pdf->SetFont('Arial', '', 8);

        
	
        foreach($productos as $row){
            
            

            $y = $pdf->GetY();
            $pdf->MultiCell(40, 4, utf8_decode($row['nombre']), 0,'L');
            $y2 = $pdf->GetY();
            $pdf->SetXY(40, $y);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(21, 4, $row['cantidad'], 0,1,'C');
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetXY(62, $y);
            $pdf->Cell(14, 4, '', 0,1,'C');
            $pdf->line(5,$y,75,$y);
            $pdf->SetY($y2);
            $pdf->Ln(3); 

        }

        
        $pdf->Ln(2);
	    $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(50, 0, '------------------------------------------------------------------------', 0,1,'L');
	    

       
       
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(70, 4, utf8_decode("RECUERDE INGRESAR EL DÍA DE LLEGADA DEL PEDIDO Y EL TOTAL."), 0,'C', 0);

	
        $pdf->Output( $proveedor.'.pdf','I');
        exit; */
        
?>