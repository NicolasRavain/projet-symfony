<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(ProductRepository $productRepository)
    {
        $products = $productRepository->findAllGreatherThanPrice(700);
        $favoriteProduct = $productRepository->findOneGreaterThanPrice(800);

        dump($products);

        return $this->render('index/homepage.html.twig', [
            'products' => $products,
            'favorite_product' => $favoriteProduct,
        ]); 
    }
}
