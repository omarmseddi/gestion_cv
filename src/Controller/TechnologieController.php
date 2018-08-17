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
use Symfony\Component\Serializer\Annotation\Groups;
class TechnologieController extends Controller
{
    /**
     * @Route(
     *     name="get_techno_by_status",
     *     path="/api/technologies/status",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Technologie::class,
     *         "_api_collection_operations_name"="special"
     *     }
     * )
     * @Groups({"write", "read"})
     */

    public function getTechnoAction(Request $request)
    {
        $technos = $this->get('doctrine.orm.entity_manager')
            ->getRepository('App:Technologie')
            ->findAll();
        $formatted = [];
        foreach ($technos as $techno) {

            if ($techno->getStatus()) {
                $formatted[] = [
                    'id' => $techno->getId(),
                    'nom' => $techno->getNom(),
                    'status' => $techno->getStatus(),
                ];
            }
        }

        return new JsonResponse($formatted);
    }
}