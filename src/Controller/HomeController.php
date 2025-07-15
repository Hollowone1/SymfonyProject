<?php

namespace App\Controller;

use PhpParser\Node\Expr\New_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'accueil')]
    function index(Request $request):Response 
    {
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController',
            ]);
    }
}
