<?php

namespace App\Controller;

use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use App\Entity\Recipe;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route("admin/recettes", name:"admin_recipe")]
final class RecipeController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(Request $request, RecipeRepository $repository, CategoryRepository $categoryRepository, EntityManagerInterface $em): Response
    {
        $recipes = $repository->findAll();
        $categories = $categoryRepository->findAll();

        return $this->render('admin/recipe/index.html.twig', [
            'recipes' => $recipes,
            'categories' => $categories,
            'controller_name' => 'RecipeController',
        ]);
    }


    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, int $id, Recipe $recipe, EntityManager $em): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('thumbnailFile')->getData();
            $filename = $recipe->getId() . '-' . $file->getClientOriginalExtension();
            $file->move($this->getParameter('kernel.project.dir') . '/public/recettes/images', $filename);
            $recipe->setThumbnail($filename);
            $em->persist($recipe);
            $em->flush();
            $this->addFlash('success', 'Recette mise à jour avec succès !');
            return $this->redirectToRoute('admin_recipe_index');
        }
        return $this->render('admin/recipe/edit.html.twig', [
            'form' => $form->createView(),
            'recipe' => $recipe,
            'id' => $id,
            'controller_name' => 'RecipeController',
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManager $em): Response{
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($recipe);
            $em->flush();
            $this->addFlash('success', 'Recette créée avec succès !');
            return $this->redirectToRoute('admin_recipe_index');
        }
        return $this->render('admin/recipe/create.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'RecipeController',
        ]);
    }

    #[Route('/{id}',name:'delete', methods:['DELETE'],  requirements: ['id' => '\d+'])]
    public function delete(Request $request, Recipe $recipe, RecipeRepository $repository, EntityManager $em): Response
    {
        $recipe = $repository->find($recipe);
        $em->remove($recipe);
        $em->flush();
        $this->addFlash('success', 'Recette supprimée avec succès !');
        return $this->redirectToRoute('admin_recipe_index');
    }
}
