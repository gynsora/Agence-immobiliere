<?php
namespace App\Controller ;

use Doctrine\ORM\EntityManagerInterface ;
use App\Entity\Property ;
use App\Repository\PropertyRepository ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController ;
use Symfony\Component\HttpFoundation\Response ;
use Symfony\Component\Routing\Annotation\Route ;

use Twig\Environment ;

class PropertyController extends AbstractController{
    public function __construct(PropertyRepository $propertyRepository,EntityManagerInterface $em){
        $this->repository = $propertyRepository ;
        $this->em = $em ;
    }
    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index():Response
    {
        /* ajouter un champ (CREATE)
        $property = new Property();
        $property->setTitle('villa premier bien')
                ->setDescription('ma premier desciption bien')
                ->setSurface(80)
                ->setRooms(4)
                ->setBedrooms(3)
                ->setFloor(4)
                ->setPrice(20000)
                ->setHeat(1)
                ->setCity('villiers sur marne')
                ->setAddress('3 allée des idiots')
                ->setPostalCode('55879');
        $em = $this->getDoctrine()->getManager();
        $em->persist($property);
        $em->flush();*/
        /*
        $repo = $this->getDoctrine()->getRepository(Property::class);
        dump($repo) ;*/
        //$this->repository->findAll(); tout les champ
        //$this->repository->find(1); tout les champ par id
        //$this->repository->findOneBy(['floor' => 4]) tout les champ dont le bien est au 4eme etage

        $properties = $this->repository->findAllVisible();
        /*
        $properties[0]->setSold(false);
        $this->em->flush();*/
        dump($properties);
        return $this->render('pages/property/index.html.twig', ['current_menu' => 'property']);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements ={"slug":"[a-z0-9\-]*"})
     * @param Property $property
     * @return Response
     */
    public function show(Property $property, string $slug):Response
    {
        //si le slug saisi en URL ne correspond pas au slug de base alors on redirige vers une autre page
        if ($property->getSlug() !== $slug){
            $this->redirectToRoute("property.show", [ 'id' => $property->getId(),'slug' => $property->getSlug()],301);
        }
        return $this->render('pages/property/show.html.twig', 
        ['current_menu' => 'property',
         'property' => $property 
        ]);
    }
}