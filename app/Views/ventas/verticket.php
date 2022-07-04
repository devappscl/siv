<?php

        $pdf = new FPDF('P','mm',array(80, 290));
        $pdf->AddPage();
        $pdf->SetMargins(5,0,5);
        $pdf->Rect(5, 3, 70, 19);
	    $pdf->SetTitle("Ticket");
	    $pdf->SetFont('Helvetica', 'B', 10);

        $pdf->SetXY(5,7);
	    $pdf->Multicell(70, 4, utf8_decode($sucursal['nombre']) , 0,'C',0);

        $pdf->SetXY(5,14);
	    $pdf->Ln(1);
	    $pdf->SetFont('Arial', '', 7);
	    $pdf->Multicell(70, 3, utf8_decode($sucursal['direccion']), 0,'C', 0);
	    $pdf->Multicell(70, 3, utf8_decode($sucursal['telefono']), 0,'C', 0);

        $pdf->SetFont('Arial', '', 8);
	    $pdf->Ln(2);
	    $pdf->Cell(70, 4, utf8_decode('TICKET N°:  '). number_format($ticket, 0, '.', ','), 0,1,'L');
	    $pdf->MultiCell(60, 4, utf8_decode("CLIENTE: "), 0,'L',0);

        $pdf->Cell(60, 4, '=========================================', 0,1,'L');

        $pdf->Cell(7, 3, 'Cant.', 0,0,'L');
	    $pdf->Cell(36, 3, utf8_decode('Descripción'), 0,0,'L');
	    $pdf->Cell(14, 3, 'Precio', 0,0,'L');
	    $pdf->Cell(14, 3, 'Subtotal', 0,1,'L');
	    $pdf->Cell(70, 3, '------------------------------------------------------------------------', 0,1,'L');

        $pdf->SetFont('Arial', '', 8);

        $total = 0;
	
        foreach($ventadetalle as $row){
            
            $importe  = (number_format($row['cantidad'] * $row['pventa'], 0, '.', ','));
            $pdf->Cell(7, 3, $row['cantidad'], 0,0,'C');
            $y = $pdf->GetY();
            $pdf->MultiCell(36, 3, utf8_decode($row['descripcion']), 0,'L');
            $y2 = $pdf->GetY();
            $pdf->SetXY(48, $y);
            $pdf->Cell(14, 3, '$ '.number_format($row['pventa'], 0, '.', ','), 0,1,'C');
            $pdf->SetXY(62, $y);
            $pdf->Cell(14, 3, '$ '.$importe, 0,1,'C');
            $pdf->SetY($y2);

            $total = $total + ($row['cantidad'] * $row['pventa']);

            $total = round($total,-1);
        }

        
        $pdf->Ln(2);
	    $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(50, 0, '------------------------------------------------------------------------', 0,1,'L');
	    

        $pdf->Ln(3);
	    $pdf->SetFont('Arial', 'B', 9);
	    $pdf->Cell(50, 2, 'Total', 0,0,'R');
	    $pdf->Cell(20, 2, '$ '. number_format($total, 0, '.', ',') , 0,1,'R');

        $pdf->Ln(4);
	    $pdf->SetFont('Arial', '', 7);
	    $pdf->Cell(50, 0, 'I.V.A (19%)', 0,0,'R');
	    $pdf->Cell(20, 0, '$ '. number_format($total*0.19, 0, '.', ',') , 0,1,'R');

        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(80, 8, utf8_decode("No válido como boleta"), 0, 'L', 0);
       
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(70, 2, utf8_decode("GRACIAS POR SU COMPRA."), 0,'C', 0);

	
        $pdf->Output( $ticket.'.pdf','I');
        exit;
        
?>