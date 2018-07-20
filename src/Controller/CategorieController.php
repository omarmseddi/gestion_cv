<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19/07/2018
 * Time: 11:30
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categorie;

class CategorieController extends Controller
{
    /**
     * @Route("/Categorie", name="Categorie_list")
     * @Method({"GET"})
     */
    public function getCategorieAction(Request $request)
    {
        $Cats = $this->get('doctrine.orm.entity_manager')
            ->getRepository('App:Categorie')
            ->findAll();
        /* @var $Cats Categorie[] */

        $formatted = [];
        foreach ($Cats as $Cat) {
            $formatted[] = [
                'id' => $Cat->getId(),
                'nom' => $Cat->getNom()
            ];
        }
        return new JsonResponse ($formatted);


    }
}