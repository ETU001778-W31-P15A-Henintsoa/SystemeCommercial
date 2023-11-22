<?php
require_once APPPATH . 'libraries/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
    
    // En-tête du PDF
    public function Header() {
        // Sélectionnez la police
        $this->SetFont('helvetica', 'B', 12);

        // Ajoutez votre contenu d'en-tête ici
        $this->Cell(0, 10, 'En-tête du PDF', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Pied de page du PDF
    public function Footer() {
        // Sélectionnez la police
        $this->SetFont('helvetica', 'I', 8);

        // Ajoutez votre contenu de pied de page ici
        $this->SetY(-15);
        $this->Cell(0, 10, 'Pied de page du PDF', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
?>