<?php 
    require_once("includes/fpdf.php"); // Importando la librería para crear PDFs

	if ($_GET['imgEscritura'] != "") {
		$pdf = new FPDF(); // Se puso dentro del FOREACH ya que solo habrá UNA ITERACIÓN.
        $pdf->AddPage();
        $pdf->Image($_GET['imgEscritura'],17,20,175);
        $pdf->output();
	}
?>