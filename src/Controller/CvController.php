<?php

namespace App\Controller;

use App\Entity\CV;
use App\Entity\Categorie;
use App\Entity\Technologie;
use App\Entity\User;
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
use Office365\PHP\Client\Runtime\Auth\AuthenticationContext;
use Office365\PHP\Client\SharePoint\ClientContext;
use Office365\PHP\Client\SharePoint\AttachmentCreationInformation;
use App\Form\CVFormType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class CvController extends Controller
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
    public function postCV(Request $request, TokenStorageInterface $tokenStorage)
    {


        $cv = new CV();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CVType::class, $cv);
        //$form->submit(json_decode($request->request->get("cv")));
        $form->submit(json_decode($request->request->get("cv"), true));

        if ($form->isSubmitted() && $form->isValid()) {
            //sharePoint
            //$cv=json_decode($request->request->get("cv"), true);
            $data=json_decode($request->request->get("cv"), true);
            $cv->setDateModification(new \DateTime());
            $dir = "C:\Users\ASUS\Documents\start/";

            dump($data);die;

            dump($request->files->get("file"));die;

            $documentName = $request->files->get("file")->getClientOriginalName();
            $file = $request->files->get("file");

            $file = $file->move($dir, $documentName);
            dump($file);die;
            $extension = $file->guessExtension();
            $Settings = ['UserName' => $this->container->getParameter('username'), 'Password' => $this->container->getParameter('password'), 'Url' => $this->container->getParameter('urlSp')];
            $authCtx = new AuthenticationContext($Settings['Url']);
            $authCtx->acquireTokenForUser($Settings['UserName'], $Settings['Password']);
            $ctx = new ClientContext($Settings['Url'], $authCtx);
            $localPath = $dir . $documentName;
            $list = $ctx->getWeb()->getLists()->getByTitle("liste_cv");
            $itemProperties = array('Title' => $documentName, '__metadata' => array('type' => 'SP.Data.TasksListItem'));
            $item = $list->addItem($itemProperties);
            $ctx->executeQuery();
            $attCreationInformation = new AttachmentCreationInformation();
            $attCreationInformation->FileName = basename($localPath);
            $attCreationInformation->ContentStream = file_get_contents($localPath);
            $attCreationInformation->FileName = $documentName;
            $item->getAttachmentFiles()->add($attCreationInformation);
            $id = $item->getProperty('ID');
            $cv->setIdSp($item->getProperty('ID'));



            $categorie = $em->getRepository('App:Categorie')
                ->findOneBy(["nom" => $cv->getCategorie()->getNom()]);
            if ($categorie == null) {
                $categorie = new Categorie();
                //dump($cv->getCategorie()->getNom());die;
                $categorie->setNom($cv->getCategorie()->getNom());
                $em->persist($categorie);
                $em->flush();
            }
            $technos = [];
            $technologies = $cv->getTechnologies();
            foreach ($technologies as $technologie) {
                $techno = $em->getRepository('App:Technologie')
                    ->findOneBy(["nom" => $technologie->getNom()]);
                if ($techno == null) {
                    $techno = new Technologie();
                    $techno->setNom($technologie->getNom());
                    $em->persist($techno);
                    $em->flush();
                }
                $technos = array_merge($technos, [$techno]);
            }
            $cv->setTechnologies($technos);
            $cv->setCategorie($categorie);
            $cv->setCreerPar($tokenStorage->getToken()->getUser());

            //sharePoint

            /*$cv = $form->getData();
             $cv->setDateModification(new \DateTime());
             $dir="C:\Users\ASUS\Documents\start/";
             $file = $form->get("fichier");
             dump($file);die;
             //$documentName=$file->getClientOriginalName();
             $documentName='omar_cv.pdf';
             $file = $form['fichier']->getData()->move($dir, $documentName);
             $extension = $file->guessExtension();
             $Settings=['UserName'=>'mkhanfir-stg@spark-it.fr','Password'=>'aminaAMINA2015.','Url'=>'https://sparkitcorp.sharepoint.com/sites/test2'];
             $authCtx = new AuthenticationContext($Settings['Url']);
             $authCtx->acquireTokenForUser($Settings['UserName'],$Settings['Password']);
             $ctx = new ClientContext($Settings['Url'],$authCtx);
             $localPath = $dir.$documentName;
             $list = $ctx->getWeb()->getLists()->getByTitle("liste_cv");
             $itemProperties = array('Title' => $documentName,'__metadata' => array('type' => 'SP.Data.TasksListItem'));
             $item = $list->addItem($itemProperties);
             $ctx->executeQuery();
             $attCreationInformation = new AttachmentCreationInformation();
             $attCreationInformation->FileName = basename($localPath);
             $attCreationInformation->ContentStream = file_get_contents($localPath);
             $attCreationInformation->FileName = $documentName;
             $item->getAttachmentFiles()->add($attCreationInformation);
             $id=$item->getProperty('ID');
             $cv->setIdFichier($item->getProperty('ID'));
             $ctx->executeQuery();*/
            $ctx->executeQuery();
            $em->persist($cv);
            $em->flush();
            return new JsonResponse($cv);

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
                    $techno->setNom($technologie['nom']);
                    $em->persist($techno);
                    $em->flush();
                }
                $technos = array_merge($technos, [$techno]);
            }
            $cv->setTechnologies($technos);
            $cv->setCategorie($categorie);
            $cv->setDateModification(new \DateTime());
            //sharePoint
            /*$cv = $form->getData();
            $cv->setDateModification(new \DateTime());
            $dir="C:\Users\ASUS\Documents\start/";
            $file = $form['fichier']->getData();
            $documentName=$file->getClientOriginalName();
            $file = $form['fichier']->getData()->move($dir, $documentName);
            $extension = $file->guessExtension();
            $Settings=['UserName'=>'mkhanfir-stg@spark-it.fr','Password'=>'aminaAMINA2015.','Url'=>'https://sparkitcorp.sharepoint.com/sites/test2'];
            $authCtx = new AuthenticationContext($Settings['Url']);
            $authCtx->acquireTokenForUser($Settings['UserName'],$Settings['Password']);
            $ctx = new ClientContext($Settings['Url'],$authCtx);
            $localPath = $dir.$documentName;
            $list = $ctx->getWeb()->getLists()->getByTitle("liste_cv");
            $itemProperties = array('Title' => $documentName,'__metadata' => array('type' => 'SP.Data.TasksListItem'));
            $item = $list->addItem($itemProperties);
            $ctx->executeQuery();
            $attCreationInformation = new AttachmentCreationInformation();
            $attCreationInformation->FileName = basename($localPath);
            $attCreationInformation->ContentStream = file_get_contents($localPath);
            $attCreationInformation->FileName = $documentName;
            $item->getAttachmentFiles()->add($attCreationInformation);
            $id=$item->getProperty('ID');
            $cv->setIdFichier($item->getProperty('ID'));
            $ctx->executeQuery();*/
            $em->persist($cv);
            $em->flush();
            return new Response(
                json_encode($cv)
            );
        }
        return new Response(
            '<html><body>CV non modifié!!</body></html>');
    }

    /**
     * @Route(
     *     name="get_cvs",
     *     path="/api/cv",
     *     methods={"POST"},
     *     defaults={
     *         "_api_resource_class"=CV::class,
     *         "_api_item_operations_name"="special"
     *     }
     * )
     */
    public function getCVS(Request $request)
    {
        $numItems = $this->getDoctrine()
            ->getRepository(CV::class)
            ->countItems();
        $data = json_decode($request->getContent(), true);
        if (!$data['grouping']) {
            if ($data['search'] == 'categorie') {
                $cvs = $this->getDoctrine()
                    ->getRepository(CV::class)
                    ->filterByCategorie($data['take'], $data['skip'], $data['ordre'], $data['colonne'], $data['value']);
            }
            elseif ($data['search'] == 'technologie'){
                $cvs = $this->getDoctrine()
                    ->getRepository(CV::class)
                    ->filterByTechnologie($data['take'], $data['skip'], $data['ordre'], $data['colonne'], $data['value']);
                $cvss = [];
                foreach ($cvs as $cv) {
                    $cvss[] = [
                        'id' => $cv['id'],
                        'idsp' => $cv['id_sp'],
                        'type' => $cv['type'],
                        'nom' => $cv['nom'],
                        'prenom' => $cv['prenom'],
                        'categorie' => $cv['id'],
                        'mission' => $cv['mission'],
                        'disponibilite' => $cv['disponibilite'],
                        'technologie' =>$cv['nomTech'],
                        'numItems' => $numItems
                    ];
                }
                return new JsonResponse($cvss);
            }
                else {
                $cvs = $this->getDoctrine()
                ->getRepository(CV::class)
                ->findCvByPage($data['take'], $data['skip'], $data['ordre'], $data['colonne'], $data['search'], $data['value']);
            } }else {
                $cvs = $this->getDoctrine()
                    ->getRepository(CV::class)
                    ->findCvPageGroup($data['take'], $data['skip'], $data['ordre'], $data['colonne'], $data['search'], $data['value'], $data['group']);
            }

        /*        $em = $this->getDoctrine()->getManager();
                $qb = $em->createQueryBuilder('u');
                $qb->select('u')
                    ->from('User', 'u')
                    ->where('u.id = ?1')
                    ->orderBy('u.name', 'ASC');


                $qb->orderBy('n.date', 'DESC');

                return $qb->getQuery()
                    ->getResult();*/// L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $cvs CV[] */
        $cvss = [];
        foreach ($cvs as $cv) {
            $technos = [];
            foreach ($cv->getTechnologies() as $technologie) {
                $technos = array_merge($technos, [$technologie->__toString()]);
            };
            $cvss[] = [
                'id' => $cv->getId(),
                'idsp' => $cv->getIdSp(),
                'type' => $cv->getType(),
                'nom' => $cv->getNom(),
                'prenom' => $cv->getPrenom(),
                'categorie' => ($cv->getCategorie())->__toString(),
                'mission' => $cv->getMission(),
                'disponibilite' => $cv->getDisponibilite(),
                'technologie' => $technos,
                'numItems' => $numItems
            ];
        }
        return new JsonResponse($cvss);

    }

//   /**
//     * @Route("/api/sharePoint", name="sharePoint")
//     * @Method({"GET"})
//     */
//    public function sharePoint(){
//        $Settings=['UserName'=>'mkhanfir-stg@spark-it.fr','Password'=>'aminaAMINA2015.','Url'=>'https://sparkitcorp.sharepoint.com/sites/test2'];
//        $authCtx = new AuthenticationContext($Settings['Url']);
//        $authCtx->acquireTokenForUser($Settings['UserName'],$Settings['Password']);
//        $ctx = new ClientContext($Settings['Url'],$authCtx);
//        $list = $ctx->getWeb()->getLists()->getByTitle("liste_cv");
//        return new JsonResponse(
//            [
//            'list' => $list ,
//            'ctx '=>$ctx
//        ]
//        );
//    }

    /**
     * @Route("/api/getLogger", name="logger")
     * @Method({"GET"})
     */
    public function getLogger(Request $request, TokenStorageInterface $tokenStorage)
    {
        $data = json_decode($request->getContent(), true);
        $id = $tokenStorage->getToken()->getUser();
        $user = $this->getDoctrine()
            ->getRepository(User::class)->find($id);
        /* @var $user User */
        $userName = $user->getUsername();
        //$userName=$user[0]['username'];
        return new JsonResponse($userName);
    }

    /**
     * @Route("/api/sharePoint/{id}", name="sharePoint")
     * @Method({"GET"})
     */
    public function connectSP(Request $request)
    {
        $Settings = ['UserName' => 'mkhanfir-stg@spark-it.fr', 'Password' => 'aminaAMINA2015.', 'Url' => 'https://sparkitcorp.sharepoint.com/sites/test2'];
        $authCtx = new AuthenticationContext($Settings['Url']);
        $authCtx->acquireTokenForUser($Settings['UserName'], $Settings['Password']);
        $ctx = new ClientContext($Settings['Url'], $authCtx);
        $list = $ctx->getWeb()->getLists()->getByTitle("liste_cv");
        $routeParams = $request->attributes->get('_route_params');
        $id = $routeParams['id'];
        $listItem = $list->getItemById($id);
        $ctx->load($listItem);
        $ctx->executeQuery();
        $fileName = $listItem->getProperty('Title');
        if (strpos($listItem->getProperty('Title'), 'pdf') !== false) {
            $fileUrl = "https://sparkitcorp.sharepoint.com/sites/test2/Lists/liste_cv/Attachments/" . $id . "/" . $fileName;
        } else {
            $fileUrl = "https://sparkitcorp.sharepoint.com/:w:/r/sites/test2/_layouts/15/Doc.aspx?sourcedoc=%7BB8A9DF1A-8002-42AE-9E55-3F76300B8491%7D&file=" . $fileName . "&action=default&mobileredirect=true";
        }
        return new JsonResponse($fileUrl);
    }

}