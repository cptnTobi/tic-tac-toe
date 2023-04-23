<?php

declare(strict_types=1);

namespace App\Board\Query\Infrastructure\API\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GamePageController extends AbstractController
{
    public function getPage(): Response
    {
        return $this->render('pages/gamePage.html.twig');
    }
}
