<?php


namespace App\Controller;


use App\Entity\CV;
use App\Entity\Categorie;
use App\Entity\Technologie;
use App\Form\CVType;
use Doctrine\Common\Collections\ArrayCollection;
use Office365\PHP\Client\Runtime\Utilities\Requests;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Form\Form;

class CVController extends Controller
{
    /**
     * @Route(
     *     name="post_cv",
     *     path="/api/c_vs",
     *     methods={"POST"},
     *     defaults={
     *         "_api_resource_class"=CV::class,
     *         "_api_collection_operations_name"="special"
     *     }
     * )
     * @Groups({"write", "read"})
     */

    public function postCV(Request $request)
    {
        $cv = new CV();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CVType::class, $cv);
        $form->submit(json_decode($request->getContent(), true));
//        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $categorie = $em->getRepository('App:Categorie')
                ->findOneBy(["nom" => json_decode($request->getContent(), true)["categorie"]]);
            if ($categorie == null) {
                $categorie = new Categorie();
                $categorie->setNom(json_decode($request->getContent(), true)["categorie"]['nom']);
                $em->persist($categorie);
                $em->flush();
            }

            $technos = [];
            $technologies = json_decode($request->getContent(), true)["technologies"];
            foreach ($technologies as $technologie) {
                $techno = $em->getRepository('App:Technologie')
                    ->findOneBy(["nom" => $technologie]);
                if ($techno == null) {
                    $techno = new Technologie();
                    $techno->setNom($technologie);
                    $em->persist($techno);
                    $em->flush();
                }
                $technos = array_merge($technos, [$techno]);
            }

            $cv->setTechnologies($technos);
            $cv->setCategorie($categorie);
            $em->persist($cv);
            $em->flush();
            return new Response(
                json_encode($cv)
            );
        }
        return new Response(
            '<html><body>CV non ajouté!!</body></html>');
    }

    /**
     * @Route(
     *     name="put_cv",
     *     path="/api/c_vs/{id}",
     *     methods={"PUT"},
     *     defaults={
     *         "_api_resource_class"=CV::class,
     *         "_api_item_operations_name"="special"
     *     }
     * )
     */
    public function putCV(Request $request)
    {
        $cv = $this->get('doctrine.orm.entity_manager')
            ->getRepository('App:CV')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $cv CV */

        if (empty($cv)) {
            return new JsonResponse(['message' => 'cv not found'], Response::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CVType::class, $cv);
        $form->submit(json_decode($request->getContent(), true));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $categorie = $em->getRepository('App:Categorie')
                ->findOneBy(["nom" => json_decode($request->getContent(), true)["categorie"]]);
            if ($categorie == null) {
                $categorie = new Categorie();
                $categorie->setNom(json_decode($request->getContent(), true)["categorie"]['nom']);
                $em->persist($categorie);
                $em->flush();
            }

            /*@var $technologies Technologie[] */
            /*@var $technos Technologie[] */
            $technos = [];
            $technologies = json_decode($request->getContent(), true)["technologies"];
            foreach ($technologies as $technologie) {
                $techno = $em->getRepository('App:Technologie')
                    ->findOneBy(["nom" => $technologie]);
                if ($techno == null) {
                    $techno = new Technologie();
                    $techno->setNom($technologie);
                    $em->persist($techno);
                    $em->flush();
                }
                $technos = array_merge($technos, [$techno]);
            }

            $cv->setTechnologies($technos);
            $cv->setCategorie($categorie);
            $cv->setDateModification(new \DateTime());
            $em->persist($cv);
            $em->flush();
            return new Response(
                json_encode($cv)
            );
        }
        return new Response(
            '<html><body>CV non modifié!!</body></html>');
    }
}