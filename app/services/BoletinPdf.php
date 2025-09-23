<?php

require_once __DIR__ . '/../lib/fpdf/fpdf.php';

class BoletinPdf extends FPDF
{
    private string ;

    public function __construct(string )
    {
        parent::__construct();
        ->logoPath = ;
        ->SetMargins(20, 25, 20);
        ->SetAutoPageBreak(true, 25);
    }
}
