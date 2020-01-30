<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/create", name="product_create")
     */
    public function create(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // ajouter le produit en BDD
            $entityManager = $this->getDoctrine()->getManager();
            // on met l'objet en attente
            $entityManager->persist($product);
            // execute la requête (INSERT...)
            $entityManager->flush();

            $this->addFlash('success', 'Le produit a bien été ajouté.');
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product/{id}", name="product_show")
     */

    public function show($id) 
    {
        // 'SELECT * FROM product WHERE id= :id
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $product = $productRepository->find($id);

        if(!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas.');
        }
       
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/product", name="product_list")
     */

    public function list(ProductRepository $productRepository) 
    {
        $products = $productRepository->findAll();

        return $this->render('product/list.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/product/edit/{id}", name="product_edit")
     */

    public function edit(Request $request, Product $product) 
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            
            return $this->redirectToRoute('product_list');
        }

        $this->addFlash('success', 'Le produit a bien été modifié.');
        
        return $this->render('product/edit.html.twig', [
            'form' =>$form->createView(),
        ]);
    }

    /**
     * @Route("/product/delete/{id}", name="product_delete")
     */

    public function delete(Product $product, EntityManagerInterface $entityManager) 
    {
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('product_list');
    }
        
}
