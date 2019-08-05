<?php
namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{


    /**

     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @Route("/", name="home")
     * @param PropertyRepository $repository
     * @return Response
     */

    public function index(PropertyRepository $repository): Response
    {
        $properties =$repository-> findLatest();
        return $this->render('pages/home.html.twig' , [
            'properties' =>$properties
        ]);




    }
}
// return new Response('<html><body>Hello</body></html>');
// return new Response($this->twig->render('pages/home.html.twig'));

?>