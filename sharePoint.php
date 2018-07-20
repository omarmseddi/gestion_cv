<?php
use Office365\PHP\Client\Runtime\Auth\AuthenticationContext;
use Office365\PHP\Client\SharePoint\ClientContext;
$Url="a";
$UserName="b";
$Password="c";
$authCtx = new AuthenticationContext($Url);
$authCtx->acquireTokenForUser($UserName,$Password); //authenticate

$ctx = new ClientContext($Url,$authCtx); //initialize REST client
$web = $ctx->getWeb();
$list = $web->getLists()->getByTitle($listTitle); //init List resource
$items = $list->getItems();  //prepare a query to retrieve from the
$ctx->load($items);  //save a query to retrieve list items from the server
$ctx->executeQuery(); //submit query to SharePoint Online REST service
foreach( $items->getData() as $item ) {
    print "Task: '{$item->Title}'\r\n";
}
