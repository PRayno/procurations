<?php
namespace App\Logic;

use App\Entity\Procuration;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Environment;

class PDF implements PdfInterface
{
    protected $twig;
    protected $generatorUrl;

    public function __construct(ParameterBagInterface $parameterBag, Environment $twig)
    {
        $this->generatorUrl = $parameterBag->get("app_pdf_generator_url");
        $this->twig = $twig;
    }

    public function buildTemplate(Procuration $procuration)
    {
        return $this->twig->render('public/print.html.twig', [
        'procuration' => $procuration
        ]);
    }

    public function generatePdf(string $html)
    {
        $client = new Client();
        $response = $client->post($this->generatorUrl, [
            'form_params' => ["html"=>$html]
        ]);

        return $response->getBody()->read(10000000);
    }

}