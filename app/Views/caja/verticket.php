<?php

        $pdf = new FPDF('P','mm',array(80, 290));
        $pdf->AddPage();
        $pdf->SetMargins(3,3,3,3);
	    $pdf->SetTitle("Ticket");
	    $pdf->SetFont('Arial', 'B', 9);

        $pdf->SetXY(5,7);
	    $pdf->Multicell(70, 0, utf8_decode("MINIMARKET LAS POZAS") , 0,'C',0);

        $pdf->SetXY(5,8);
	
	    $pdf->Ln(1);
	    $pdf->SetFont('Arial', '', 7);
	    $pdf->Multicell(70, 4, utf8_decode("TOLINDOR VALDEBENITO 1092"), 0,'C', 0);
	    $pdf->Multicell(70, 4, utf8_decode("WWW.PANADERIALASPOZAS.CL"), 0,'C', 0);

        $pdf->SetFont('Arial', '', 8);
	    $pdf->Ln(1);
	    $pdf->Cell(60, 4, utf8_decode('COMPROBANTE N°:  '). $ticket, 0,1,'L');
        $pdf->Cell(60, 4, utf8_decode('MOVIMIENTO: '). strtoupper($mov['tipo']), 0,1,'L');

        $pdf->Cell(60, 4, '============================================', 0,1,'L');

        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Multicell(70, 5, utf8_decode("SE HA REALIZADO UN " . strtoupper($mov['tipo']) . " POR UN MONTO DE $" . $mov['cantidad'] . ", REALIZADO POR " . $mov['cajera'] . "."), 0,'C', 0);
        
        $pdf->SetFont('Arial', '', 8);
        $pdf->Multicell(70, 5, utf8_decode("COMENTARIO: " . $mov['comentario']), 0,'', 0);
       
        
        
        $pdf->Multicell(70, 6, utf8_decode($mov['created_at']), 0,'C', 0);

        
        $pdf->Ln(3);
	    $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(50, 0, '-----------------------------------------------------------------------------', 0,1,'L');
	    

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 8);
       
        $pdf->Multicell(70, 4, utf8_decode("COMPROBANTE DEBE ADJUNTARSE A LAS FACTURAS DEL DÍA"), 0,'C', 0);

	
        $pdf->Output( $ticket.'.pdf','I');
        exit;
        
?>