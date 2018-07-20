<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DemoController
{
/**
* @Route("/number", name="app_lucky_number")
 * @Method({"GET", "POST"})
*/
public function number()
{
    return new Response('<html><body>Lucky number</body></html>');
}
}