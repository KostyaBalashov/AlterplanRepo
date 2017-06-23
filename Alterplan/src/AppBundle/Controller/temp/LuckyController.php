<?php
/**
 * Created by PhpStorm.
 * User: void
 * Date: 23/06/2017
 * Time: 14:30
 */

namespace AppBundle\Controller\temp;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class LuckyController extends Controller
{
    /**
     * @Route("/lucky/")
     */
    public  function  numberAction(){
        $number = mt_rand(1, 17);

        return $this->render('temp/lucky.html.twig', array('number' => $number));
    }
}
