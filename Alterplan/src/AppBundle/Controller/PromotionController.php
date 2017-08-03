<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Promotion;
use AppBundle\Filtre\PromotionFiltre;
use AppBundle\Form\Filtre\PromotionFiltreType;
use Doctrine\ORM\UnitOfWork;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Promotion controller.
 *
 * @Route("promotions")
 */
class PromotionController extends Controller
{
    /**
     * Lists all promotion entities.
     *
     * @Route("/", name="promotions_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Promotion::class);

        //Création de l'objet filtre
        $filtre = new  PromotionFiltre();

        //Création du formulaire de recherche
        $form = $this->createForm(PromotionFiltreType::class, $filtre, array(
            'action' => $this->generateUrl('promotions_index')
        ));

        $promotions = null;

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            //On recherche les utilisateurs avec les critères de filtre
            $promotions = $repo->search($filtre);

            //Réponse à la recherche
            return $this->render(':promotions:table.html.twig', array(
                'promotions' => $promotions
            ));
        }

        $promotions = $repo->search();

        if ($request->getMethod() == 'GET'){
            if ($request->isXmlHttpRequest()){
                //La réponse au GET en ajax
                //survient après la création ou la modification de l'utilisateur
                return $this->render(':promotions:table.html.twig', array(
                    'promotions' => $promotions
                ));
            }
        }

        return $this->render('promotions/index.html.twig', array(
            'promotions' => $promotions,
            'formSearch' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     *
     * @Route("/save", name="promotions_save")
     * @Method("POST")
     */
    public function savePromotions(Request $request){
        $promotions = null;
    }
}
