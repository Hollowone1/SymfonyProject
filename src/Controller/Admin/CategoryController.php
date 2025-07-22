<?php 

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;
use App\Form\CategoryType;

#[Route("admin/category", name:"admin.category.")]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $repository){
        return $this->render('admin/category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $repository->findAll(),
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response{
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'Catégorie créée avec succès !');
            return $this->redirectToRoute('admin.category.index');
            }
        return $this->render('admin/category/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response{
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'Catégorie modifiée avec succès !');
            return $this->redirectToRoute('admin.category.index');
            }
        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'remove' , methods: ['DELETE'], requirements: ['id' => '\d+'])]
    public function remove(Category $category, EntityManagerInterface $entityManager): Response{
        $entityManager->remove($category);
        $entityManager->flush();
        $this->addFlash('success', 'Catégorie supprimée avec succès !');
        return $this->redirectToRoute('admin.category.index');

    }
}