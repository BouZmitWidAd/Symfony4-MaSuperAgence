<?php

namespace App\Controller\Admin;


use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController ;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController {
    /**
     * @var \App\Repository\PropertyRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository= $repository;
        //initialiser l objet $em
        $this->em=$em;

    }

    /**
     * @Route("/admin", name="admin.property.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function index(){

        $properties =$this->repository->findAll();

        return $this->render('admin/property/index.html.twig', compact('properties'));

    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     */
    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            return $this->redirectToRoute('admin.property.index');

        }
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,//on passe la formulaire qui va etre vide
            'form' =>$form -> createView()//on passera la formulaire avec la methode createView
        ]);
    }

    /**
     * @Route ("/admin/property/{id}" , name="admin.property.edit" , methods="GET|POST")
     * @param Property $property
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property, Request $request){

//permet de gener le formulaire pour le editer
        $form =$this->createForm(PropertyType::class, $property);
        $form -> handleRequest($request);

        if ($form -> isSubmitted() && $form ->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('admin.property.index');

        }
        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' =>$form -> createView()
        ]);

    }

    /**
     * @Route ("/admin/property/{id}" , name="admin.property.delete" , methods="DELETE")
     *  @param Property $property
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Property $property, Request $request) {
        if($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token'))){
            $this->em->remove($property);
            $this->em->flush();
            // $this->em;//recuperer l'entity manager em
             //$this->em->flush();
             $this->addFlash('success','Bien Modifie avec succes');
        }
        return $this->redirectToRoute('admin.property.index');

    }


}

?>