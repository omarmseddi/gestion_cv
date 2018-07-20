<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19/07/2018
 * Time: 11:33
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Technologie;

class TechnologieController extends Controller
{
    /**
     * @Route("/Technologie", name="Technologie_list")
     * @Method({"GET"})
     */
    public function getTechnologieAction(Request $request)
    {
        $Techs = $this->get('doctrine.orm.entity_manager')
            ->getRepository('App:Technologie')
            ->findAll();
        /* @var $Techs Technologie[] */

        $formatted = [];
        foreach ($Techs as $Tech) {
            $formatted[] = [
                'id' => $Tech->getId(),
                'nom' => $Tech->getNom(),
                'status'=> $Tech->getStatus()
            ];
        }
        return new JsonResponse ($formatted);
    }
}