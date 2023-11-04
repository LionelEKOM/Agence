<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PropertyRepository $propertyRepository): Response
    {
        // $this->denyAccessUnlessGranted(attribute:'ROLE_USER', message: 'Hello world');
        $properties = $propertyRepository->findLastest();
        return $this->render('home/index.html.twig', [
            'properties' => $properties
        ]);
    }
}
