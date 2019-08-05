<?php

namespace App\Controller;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */

    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    // si mieux de l appeler repository via le constructeur par ce
    //que on a bcp des methodes

    public function __construct(PropertyRepository $repository, ObjectManager $em)

    {
        $this->repository = $repository;
        $this->em = $em;
    }


    /**
     * @Route("/biens" , name="property.index")
     * @return Response
     */

//insert au niveau de la base de donnees
//recupere le title 'mon premier bien '
    public function index(): Response
    {

        return $this->render('property/index.html.twig' ,
            ['current_menu' => 'properties'
        ]);

    }
    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     * @param Property $property
     */


    public function show(Property $property,string $slug): Response
    {
//        $property= $this->repository->find($id);
        if($property->getSlug() !==$slug){
            return $this->redirectToRoute('property.show',[
                'id' =>$property->getId(),
                'slug' =>$property->getSlug()
            ],301);
        }

        return $this->render('property/show.html.twig',[
            'property' => $property,
            'current_menu' => 'properties'
        ]);

    }
}

//        $property= $this ->repository->findAllVisible();//recuperer les donnees
//     //modification d'un entity
//        $property[0]->setSold(true);
//         $this->em->flush();


//        $property= $this ->repository->findOneBy(['floor' =>4]);
//        dump($property);
        //l'utilisation de linjection

        //1) on fait appel a repository on l utilise pas directement o doit l unitialiser
//        $repository =$this->getDoctrine()->getRepository(Property::class);
//       dump($repository);

//        //interagir avec bd // creer un entity
//        $property = new Property();
//        $property->setTitle('Mon premiere bien')
//           ->setPrice(200000)
//            ->setRooms(3)
//            ->setBedrooms(4)
//            ->setDescription('une petit description')
//            ->setSurface(60)
//            ->setFloor(4)
//            ->setHeat(1)surface
//            ->setCity('Montpellier')
//            ->setAddress('15 boulvard gambetta')
//            ->setPostalCode('34000');
//        //envoie vers la base de donnees pour cela on a besoin de
//        //l'entity manager
//        $em = $this -> getDoctrine()->getManager();
//        //j'aimerai bien que tu persiste mon entity
//        $em->persist($property);
//        //permet de porter tous les changement au niveau entity manager dans la base de donnees c est a dire l envoyer a la bade de doonees en fin de l persister
//        $em->flush();


?>