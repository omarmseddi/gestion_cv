<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 20/07/2018
 * Time: 13:49
 */

namespace App\Controller;
use Office365\PHP\Client\Runtime\Auth\AuthenticationContext;
use Office365\PHP\Client\SharePoint\ClientContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class sharePointController
{
    /**
 * @Route("/task", name="task")
 * @Method({"GET"})
 */
    public function getTask(){

        $Url="a";
        $UserName="b";
        $Password="c";
        $listTitle='d';
        $authCtx = new AuthenticationContext($Url);
        $authCtx->acquireTokenForUser($UserName,$Password); //authenticate

        $ctx = new ClientContext($Url,$authCtx); //initialize REST client
        $web = $ctx->getWeb();
        $list = $web->getLists()->getByTitle($listTitle); //init List resource
        $items = $list->getItems();  //prepare a query to retrieve from the
        $ctx->load($items);  //save a query to retrieve list items from the server
        $ctx->executeQuery(); //submit query to SharePoint Online REST service
    }
}