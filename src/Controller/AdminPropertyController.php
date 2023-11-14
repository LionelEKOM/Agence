<?php

namespace App\Controller;

use App\Entity\Property;
use App\Form\Property1Type;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/property')]
class AdminPropertyController extends AbstractController
{
    #[Route('/', name: 'app_admin_property_index', methods: ['GET'])]
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('admin_property/index.html.twig', [
            'properties' => $propertyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_property_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $property = new Property();
        $property->setCreatedAt(new \DateTimeImmutable());
        $form = $this->createForm(Property1Type::class, $property);
        $form->handleRequest($request);

        if ($property->getImageFile() instanceof UploadedFile)

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($property);
            $entityManager->flush();

            $this->addFlash('success', 'Bien crée avec succes !!');

            return $this->redirectToRoute('app_admin_property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_property/new.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_property_show', methods: ['GET'])]
    public function show(Property $property): Response
    {
        return $this->render('admin_property/show.html.twig', [
            'property' => $property,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_property_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Property $property, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Property1Type::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('info', 'Bien édite avec succes !!');
            return $this->redirectToRoute('app_admin_property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_property/edit.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_property_delete', methods: ['POST'])]
    public function delete(Request $request, Property $property, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->request->get('_token'))) {
            $entityManager->remove($property);
            $entityManager->flush();
        }
        $this->addFlash('danger', 'Bien supprime avec succes !!');
        return $this->redirectToRoute('app_admin_property_index', [], Response::HTTP_SEE_OTHER);
    }
}
