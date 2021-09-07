<?php

namespace App\Exports;
use PDF;
use Illuminate\Http\Response;

class PdfExport
{
    private $view;

    private $pdf;

    public function __construct($view, $data)
    {
        $this->pdf = PDF::loadView($view, $data);
        $this->view = $view;
    }

    public function setLetterPortrait()
    {
        $this->pdf->setPaper('letter', 'portrait');
        return $this;
    }

    public function setLetterLandscape()
    {
        $this->pdf->setPaper('letter', 'landscape');
        return $this;
    }

    public function download($filename = null)
    {
        return $this->pdf->download();
    }
}