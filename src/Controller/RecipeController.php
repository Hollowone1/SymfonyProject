<?php

namespace App\Controller;

use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use App\Entity\Recipe;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecipeController extends AbstractController
{

    #[Route('/recipe', name: 'recette')]
    public function index(Request $request, RecipeRepository $repository): Response
    {
        $recipes = $repository->findAll();

        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
            'controller_name' => 'RecipeController',
        ]);
    }

    #[Route('/recipe/{slug}-{id}', name: 'show', requirements: ['slug' => '[a-z0-9\-]+', 'id' => '\d+'])]
    public function show(Request $request, string $slug, int $id, RecipeRepository $repository): Response
    {
        $recipe = $repository->find($id);
        if (!$recipe || $recipe->getSlug() !== $slug) {
            return $this->redirectToRoute('recipe.show', ['slug' => $recipe->getSlug(), 'id' => $recipe->getId()]);
        } 
        return $this->render('recipe/show.html.twig', 
        [
            'recipe' => $recipe,
            'controller_name' => 'RecipeController',
        ]);
    }

    #[Route('/recipe/{id}/edit', name: 'edit')]
    public function edit(Request $request, int $id, Recipe $recipe, EntityManager $em): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($recipe);
            $em->flush();
            $this->addFlash('success', 'Recette mise à jour avec succès !');
            return $this->redirectToRoute('recipe_index');
        }
        return $this->render('recipe/edit.html.twig', [
            'form' => $form->createView(),
            'recipe' => $recipe,
            'id' => $id,
            'controller_name' => 'RecipeController',
        ]);
    }

    #[Route('/recipe/create', name: 'create')]
    public function create(Request $request, EntityManager $em): Response{
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($recipe);
            $em->flush();
            $this->addFlash('success', 'Recette créée avec succès !');
            return $this->redirectToRoute('recipe_index');
        }
        return $this->render('recipe/create.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'RecipeController',
        ]);
    }
}
