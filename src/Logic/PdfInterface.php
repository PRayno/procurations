<?php
namespace App\Logic;

use App\Entity\Procuration;

interface PdfInterface
{
    /**
     * @param Procuration $procuration
     * @return mixed
     */
    public function buildTemplate(Procuration $procuration);

    /**
     * @param string $html
     * @return mixed
     */
    public function generatePdf(string $html);
}