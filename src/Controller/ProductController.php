<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/create", name="product_create")
     */
    public function create()
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
