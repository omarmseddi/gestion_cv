<?php

namespace App\Controller;
use App\Entity\CV;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Serializer\Annotation\Groups;
use Office365\PHP\Client\Runtime\Auth\AuthenticationContext;
use Office365\PHP\Client\SharePoint\ClientContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Office365\PHP\Client\SharePoint\AttachmentCreationInformation;
use App\Form\CVFormType;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class CvController extends Controller
{
    /**
     * @Groups({"write", "read","read_tech", "read_cat"})
     * @Rest\Route("/ajouteCV")
     */
    public function postCv(Request $request){
        $form = $this->createForm(CVFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cv = $form->getData();
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
            $ctx->executeQuery();
            $em = $this->getDoctrine()->getManager();
            $em->persist($cv);
            $em->flush();
            return new Response(
                '<html><body>CV ajouté!!</body></html>'
            );
        }
        return $this->render('ajouteCV.html.twig', [ 'CVForm' => $form->createView()]);
}
}